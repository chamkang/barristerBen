<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * Shared helpers for the editor API (/admin). PHP, so it runs on the firm's
 * own hosting. Files in api/ that start with "_" are blocked from the web.
 * ---------------------------------------------------------------------------
 *
 * Every save is a commit to the GitHub repository; the "Deploy" GitHub Action
 * then uploads the site to the server, usually within two minutes. GitHub
 * stays the single source of truth, so nothing is ever lost or overwritten
 * by the next deployment.
 *
 * SETTINGS — never commit them. They are read from, in order:
 *   1. A file OUTSIDE the website folder:  <home>/fonju-admin-config.php
 *      (one level above the folder that holds index.php)
 *   2. storage/admin-config.php inside the site (blocked from the web)
 *   3. Environment variables of the same names
 * See tools/fonju-admin-config.example.php for the file format:
 *
 *   ADMIN_PASSWORD   The password the lawyer types at /admin
 *   SESSION_SECRET   A long random string used to sign the sign-in cookie
 *   GITHUB_TOKEN     Fine-grained GitHub token for this repository only:
 *                    Contents read/write (+ Actions read for build status)
 *   GITHUB_REPO      owner/name, e.g. chamkang/barristerBen
 *   GITHUB_BRANCH    Optional, defaults to main
 *
 * GITHUB_REPO = "local" makes the editor read and write the files in this
 * folder directly instead of GitHub (used by tools/dev-server.js).
 * ---------------------------------------------------------------------------
 */

const ADMIN_COOKIE   = 'fonju_admin';
const SESSION_HOURS  = 8;
const ADMIN_LANGS    = ['en', 'fr'];
const SLUG_RE        = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';
const SITE_ROOT      = __DIR__ . '/..';

// ------------------------------------------------------------------ settings
function admin_config(): array
{
    static $cfg = null;
    if ($cfg !== null) {
        return $cfg;
    }

    $file = [];
    foreach ([dirname(__DIR__, 2) . '/fonju-admin-config.php', dirname(__DIR__) . '/storage/admin-config.php'] as $path) {
        if (@is_file($path)) {
            $loaded = include $path;
            if (is_array($loaded)) {
                $file = $loaded;
                break;
            }
        }
    }

    $get = static function (string $key) use ($file): string {
        $value = $file[$key] ?? getenv($key);
        return is_string($value) ? trim($value) : '';
    };

    $cfg = [
        'password' => $get('ADMIN_PASSWORD'),
        'secret'   => $get('SESSION_SECRET'),
        'token'    => $get('GITHUB_TOKEN'),
        'repo'     => $get('GITHUB_REPO'),
        'branch'   => $get('GITHUB_BRANCH') ?: 'main',
    ];
    $cfg['local']   = $cfg['repo'] === 'local';
    $required       = $cfg['local'] ? ['ADMIN_PASSWORD' => 'password', 'SESSION_SECRET' => 'secret']
                                    : ['ADMIN_PASSWORD' => 'password', 'SESSION_SECRET' => 'secret', 'GITHUB_TOKEN' => 'token', 'GITHUB_REPO' => 'repo'];
    $cfg['missing'] = array_keys(array_filter($required, static fn(string $k): bool => $cfg[$k] === ''));

    return $cfg;
}

// ------------------------------------------------------------------ responses
function send(int $status, array $body, array $headers = []): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    header('X-Robots-Tag: noindex, nofollow');
    foreach ($headers as $h) {
        header($h, false);
    }
    echo json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function fail(int $status, string $message): never
{
    send($status, ['ok' => false, 'error' => $message]);
}

final class ApiError extends RuntimeException
{
    public function __construct(string $message, public readonly int $status = 502)
    {
        parent::__construct($message);
    }
}

function method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

// ------------------------------------------------------------------ session cookie
function b64url(string $bytes): string
{
    return rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
}

function sign_value(string $data, string $secret): string
{
    return b64url(hash_hmac('sha256', $data, $secret, true));
}

function safe_equal(string $a, string $b): bool
{
    return hash_equals(hash('sha256', $a), hash('sha256', $b));
}

function cookie_header(string $value, int $maxAge): string
{
    return 'Set-Cookie: ' . ADMIN_COOKIE . '=' . $value . '; Path=/; HttpOnly; Secure; SameSite=Strict; Max-Age=' . $maxAge;
}

function issue_cookie(string $secret): string
{
    $payload = b64url((string) json_encode(['exp' => (int) (microtime(true) * 1000) + SESSION_HOURS * 3600 * 1000, 'n' => b64url(random_bytes(9))]));
    return cookie_header($payload . '.' . sign_value($payload, $secret), SESSION_HOURS * 3600);
}

function clear_cookie(): string
{
    return cookie_header('', 0);
}

function is_authenticated(string $secret): bool
{
    $value = (string) ($_COOKIE[ADMIN_COOKIE] ?? '');
    $parts = explode('.', $value);
    if (count($parts) !== 2 || $secret === '' || !safe_equal($parts[1], sign_value($parts[0], $secret))) {
        return false;
    }
    $data = json_decode((string) base64_decode(strtr($parts[0], '-_', '+/')), true);
    return is_array($data) && is_numeric($data['exp'] ?? null) && $data['exp'] > microtime(true) * 1000;
}

/**
 * Requests that change anything must come from the admin page itself: the
 * cookie is SameSite=Strict, and the page sends a custom header that a
 * cross-site form cannot.
 */
function same_origin(): bool
{
    if (($_SERVER['HTTP_X_FONJU_ADMIN'] ?? '') !== '1') {
        return false;
    }
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    if ($origin === '') {
        return true;
    }
    $host = parse_url($origin, PHP_URL_HOST);
    $port = parse_url($origin, PHP_URL_PORT);
    return ($host . ($port ? ':' . $port : '')) === ($_SERVER['HTTP_HOST'] ?? '');
}

/** Standard guard: configured, signed in, and (for writes) same origin. */
function guard(bool $write = false): array
{
    $cfg = admin_config();
    if ($cfg['missing'] !== []) {
        fail(500, 'The editor is not configured yet. Missing settings: ' . implode(', ', $cfg['missing']));
    }
    if (!is_authenticated($cfg['secret'])) {
        fail(401, 'Please sign in again.');
    }
    if ($write && !same_origin()) {
        fail(403, 'Request refused.');
    }
    return $cfg;
}

function read_json(int $limitBytes = 6 * 1024 * 1024): array
{
    $raw = (string) file_get_contents('php://input', false, null, 0, $limitBytes + 1);
    if (strlen($raw) > $limitBytes) {
        throw new ApiError('Request too large.', 413);
    }
    $data = json_decode($raw === '' ? '{}' : $raw, true);
    if (!is_array($data)) {
        throw new ApiError('Invalid request.', 400);
    }
    return $data;
}

// ------------------------------------------------------------------ storage: GitHub (or local files)
/** Returns ['status' => int, 'data' => mixed]. */
function gh(array $cfg, string $path, string $method = 'GET', ?array $body = null): array
{
    $ch = curl_init('https://api.github.com/repos/' . $cfg['repo'] . $path);
    $headers = [
        'Accept: application/vnd.github+json',
        'Authorization: Bearer ' . $cfg['token'],
        'X-GitHub-Api-Version: 2022-11-28',
        'User-Agent: fonju-admin',
    ];
    if ($body !== null) {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 25,
    ]);
    $text   = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error  = curl_error($ch);
    curl_close($ch);

    if ($text === false) {
        throw new ApiError('Could not reach GitHub: ' . $error);
    }
    return ['status' => $status, 'data' => json_decode((string) $text, true)];
}

function enc_path(string $p): string
{
    return implode('/', array_map('rawurlencode', explode('/', $p)));
}

/** Git's blob hash, so local files get the same kind of "sha" as GitHub. */
function blob_sha(string $bytes): string
{
    return sha1('blob ' . strlen($bytes) . "\0" . $bytes);
}

function local_path(string $rel): string
{
    if (str_contains($rel, '..') || str_starts_with($rel, '/')) {
        throw new ApiError('Invalid path.', 400);
    }
    return SITE_ROOT . '/' . $rel;
}

/** ['sha' => ..., 'text' => ...] or null when the file does not exist. */
function get_file(array $cfg, string $path): ?array
{
    if ($cfg['local']) {
        $full = local_path($path);
        if (!is_file($full)) {
            return null;
        }
        $bytes = (string) file_get_contents($full);
        return ['sha' => blob_sha($bytes), 'text' => $bytes];
    }

    $r = gh($cfg, '/contents/' . enc_path($path) . '?ref=' . rawurlencode($cfg['branch']));
    if ($r['status'] === 404) {
        return null;
    }
    if ($r['status'] >= 300) {
        throw new ApiError('GitHub error ' . $r['status'] . ' reading ' . $path);
    }
    return ['sha' => (string) $r['data']['sha'], 'text' => (string) base64_decode((string) ($r['data']['content'] ?? ''))];
}

/** Lists the files in a folder: [['name' => ..., 'path' => ..., 'sha' => ...], ...] */
function list_dir(array $cfg, string $path): array
{
    if ($cfg['local']) {
        $full = local_path($path);
        if (!is_dir($full)) {
            return [];
        }
        $out = [];
        foreach (scandir($full) ?: [] as $name) {
            if ($name[0] !== '.' && is_file($full . '/' . $name)) {
                $out[] = ['name' => $name, 'path' => $path . '/' . $name, 'sha' => blob_sha((string) file_get_contents($full . '/' . $name))];
            }
        }
        return $out;
    }

    $r = gh($cfg, '/contents/' . enc_path($path) . '?ref=' . rawurlencode($cfg['branch']));
    if ($r['status'] === 404) {
        return [];
    }
    if ($r['status'] >= 300 || !is_array($r['data'])) {
        throw new ApiError('GitHub error ' . $r['status'] . ' listing ' . $path);
    }
    return array_values(array_map(
        static fn(array $f): array => ['name' => $f['name'], 'path' => $f['path'], 'sha' => $f['sha']],
        array_filter($r['data'], static fn($f): bool => is_array($f) && ($f['type'] ?? '') === 'file')
    ));
}

/** Creates or updates a file; returns its new sha. $sha must be the current one when updating. */
function put_file(array $cfg, string $path, string $bytes, string $message, ?string $sha, string $conflict): string
{
    if ($cfg['local']) {
        $full    = local_path($path);
        $current = is_file($full) ? blob_sha((string) file_get_contents($full)) : null;
        if (($current !== null && $sha !== $current) || ($current === null && $sha)) {
            throw new ApiError($conflict, 409);
        }
        if (!is_dir(dirname($full))) {
            mkdir(dirname($full), 0755, true);
        }
        file_put_contents($full, $bytes);
        return blob_sha($bytes);
    }

    $body = ['message' => $message, 'content' => base64_encode($bytes), 'branch' => $cfg['branch']];
    if ($sha) {
        $body['sha'] = $sha;
    }
    $r = gh($cfg, '/contents/' . enc_path($path), 'PUT', $body);
    if ($r['status'] === 409 || $r['status'] === 422) {
        throw new ApiError($conflict, 409);
    }
    if ($r['status'] >= 300) {
        throw new ApiError('GitHub error ' . $r['status'] . ' saving ' . $path);
    }
    return (string) $r['data']['content']['sha'];
}

function delete_file(array $cfg, string $path, string $sha, string $message): void
{
    if ($cfg['local']) {
        $full = local_path($path);
        if (!is_file($full) || blob_sha((string) file_get_contents($full)) !== $sha) {
            throw new ApiError('This article was changed elsewhere since you opened it. Reload it and try again.', 409);
        }
        unlink($full);
        return;
    }

    $r = gh($cfg, '/contents/' . enc_path($path), 'DELETE', ['message' => $message, 'sha' => $sha, 'branch' => $cfg['branch']]);
    if ($r['status'] >= 300) {
        throw new ApiError('GitHub error ' . $r['status'] . ' deleting ' . $path);
    }
}

// ------------------------------------------------------------------ front matter
/** YAML double-quoted scalar. */
function yq(string $s): string
{
    return '"' . str_replace(["\\", '"', "\r\n", "\n", "\r"], ["\\\\", '\\"', ' ', ' ', ' '], $s) . '"';
}

function build_markdown(array $a): string
{
    $lines = ['---', 'title: ' . yq($a['title'])];
    if ($a['seoTitle'] !== '') {
        $lines[] = 'seo_title: ' . yq($a['seoTitle']);
    }
    $lines[] = 'date: ' . $a['date'];
    if ($a['updated'] !== '') {
        $lines[] = 'updated: ' . $a['updated'];
    }
    array_push($lines, 'category: ' . yq($a['category']), 'author: ' . yq($a['author']), 'excerpt: ' . yq($a['excerpt']));
    if ($a['tags'] !== []) {
        $lines[] = 'tags:';
        foreach ($a['tags'] as $t) {
            $lines[] = '  - ' . yq($t);
        }
    }
    if ($a['image'] !== '') {
        $lines[] = 'image: ' . yq($a['image']);
    }
    $lines[] = 'featured: ' . ($a['featured'] ? 'true' : 'false');
    if ($a['translation'] !== '') {
        $lines[] = 'translation: ' . $a['translation'];
    }
    if ($a['draft']) {
        $lines[] = 'draft: true';
    }
    array_push($lines, '---', '', trim(str_replace("\r\n", "\n", $a['body'])), '');
    return implode("\n", $lines);
}

/** Front matter written by build_markdown (and by hand), as ['meta' => [], 'body' => '']. */
function parse_markdown(string $raw): array
{
    $text = preg_replace('/^\xEF\xBB\xBF/', '', str_replace("\r\n", "\n", $raw));
    if (!preg_match('/^---\n(.*?)\n---\n?(.*)$/s', (string) $text, $m)) {
        return ['meta' => [], 'body' => (string) $text];
    }

    $scalar = static function (string $v) {
        $v = trim($v);
        if ($v === 'true' || $v === 'false') {
            return $v === 'true';
        }
        if (preg_match('/^"(.*)"$/s', $v, $q)) {
            return str_replace(['\\"', '\\\\'], ['"', '\\'], $q[1]);
        }
        if (preg_match("/^'(.*)'$/s", $v, $q)) {
            return str_replace("''", "'", $q[1]);
        }
        return $v;
    };

    $meta  = [];
    $lines = explode("\n", $m[1]);
    for ($i = 0, $n = count($lines); $i < $n; $i++) {
        if (!preg_match('/^([A-Za-z0-9_-]+):\s*(.*)$/', $lines[$i], $kv)) {
            continue;
        }
        [, $key, $value] = $kv;
        if (trim($value) === '') {
            $items = [];
            while ($i + 1 < $n && preg_match('/^\s*-\s+(.*)$/', $lines[$i + 1], $item)) {
                $items[] = $scalar($item[1]);
                $i++;
            }
            $meta[$key] = $items;
        } elseif (preg_match('/^\[(.*)\]$/', trim($value), $list)) {
            $meta[$key] = array_values(array_filter(array_map($scalar, explode(',', $list[1])), static fn($x): bool => $x !== ''));
        } else {
            $meta[$key] = $scalar($value);
        }
    }

    return ['meta' => $meta, 'body' => ltrim($m[2], "\n")];
}

/** Collapses whitespace and trims to a maximum length (in characters). */
function clean(mixed $s, int $max): string
{
    return mb_substr(trim((string) preg_replace('/\s+/u', ' ', is_scalar($s) ? (string) $s : '')), 0, $max);
}

/** Runs an endpoint, turning ApiError and unexpected errors into JSON. */
function run_api(callable $handler): void
{
    try {
        $handler();
    } catch (ApiError $e) {
        fail($e->status, $e->getMessage());
    } catch (Throwable $e) {
        error_log('fonju admin: ' . $e->getMessage());
        fail(502, 'Something went wrong. Please try again.');
    }
}
