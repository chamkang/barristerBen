<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * Local preview of the website AND the article editor, with PHP's built-in
 * server. It follows the same rules as .htaccess (clean addresses, blocked
 * folders, /api), so what you see here is what the live server does:
 *
 *     php -S localhost:8098 tools/router.php
 *
 *     http://localhost:8098/          the website (French: /fr/)
 *     http://localhost:8098/admin     the editor
 *
 * The editor runs in LOCAL mode here: saving writes straight to the files in
 * this folder (nothing goes to GitHub or the live site), and you are signed
 * in automatically. Review or undo what you saved with git.
 * ---------------------------------------------------------------------------
 */

$root = dirname(__DIR__);
$uri  = rawurldecode((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$path = ltrim($uri, '/');

// ------------------------------------------------------------------ editor: local mode
// A random secret kept in storage/ (never committed), so sign-ins survive a restart.
$secretFile = $root . '/storage/.dev-secret';
if (!is_file($secretFile)) {
    file_put_contents($secretFile, bin2hex(random_bytes(32)));
}
putenv('GITHUB_REPO=local');
putenv('SESSION_SECRET=' . trim((string) file_get_contents($secretFile)));
putenv('ADMIN_PASSWORD=' . hash('sha256', 'local:' . file_get_contents($secretFile)));

/** Runs a PHP script as if the web server had been asked for it. */
$run = static function (string $script, array $query = []) use ($root): bool {
    $file = $root . '/' . $script;
    $_SERVER['SCRIPT_NAME']     = '/' . $script;
    $_SERVER['PHP_SELF']        = '/' . $script;
    $_SERVER['SCRIPT_FILENAME'] = $file;
    $_GET = $query + $_GET;
    chdir(dirname($file));
    require $file;
    return true;
};

$notFound = static function () use ($run): bool {
    http_response_code(404);
    return $run('404.php');
};

// ------------------------------------------------------------------ blocked (as .htaccess)
if (preg_match('~^(includes|storage|tools|content|dist|node_modules|\.github|\.claude)(/|$)|^api/_|(^|/)\.(?!well-known/)~', $path)
    || preg_match('~^(README\.md|build\.php|vercel\.json)$~', $path)) {
    return $notFound();
}

// ------------------------------------------------------------------ editor page: signed in automatically
if ($path === 'admin' || $path === 'admin/' || $path === 'admin/index.html') {
    require_once $root . '/api/_lib.php';
    $cfg = admin_config();
    if (!is_authenticated($cfg['secret'])) {
        header(issue_cookie($cfg['secret']), false);
    }
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store');
    readfile($root . '/admin/index.html');
    return true;
}

// ------------------------------------------------------------------ clean addresses (as .htaccess)
$map = ['sitemap.xml' => 'sitemap.php', 'feed.xml' => 'feed.php', 'llms.txt' => 'llms.php'];
if (isset($map[$path])) {
    return $run($map[$path]);
}
if (preg_match('~^api/([a-z]+)$~', $path, $m) && is_file($root . '/api/' . $m[1] . '.php')) {
    return $run('api/' . $m[1] . '.php');
}
if (preg_match('~^(fr/)?practice/([a-z0-9-]+)/?$~', $path, $m)) {
    return $run($m[1] . 'practice-area.php', ['area' => $m[2]]);
}
if (preg_match('~^(fr/)?insights/([a-z0-9-]+)/?$~', $path, $m)) {
    return $run($m[1] . 'post.php', ['p' => $m[2]]);
}
if ($path === '' || $path === 'fr' || $path === 'fr/') {
    return $run(($path === '' ? '' : 'fr/') . 'index.php');
}
$clean = rtrim($path, '/');
if ($clean !== '' && !str_contains($clean, '.') && is_file($root . '/' . $clean . '.php')) {
    return $run($clean . '.php');
}

// ------------------------------------------------------------------ real files
if (is_file($root . '/' . $path)) {
    if (str_ends_with($path, '.php')) {
        return $run($path);
    }
    return false; // let the built-in server send the file
}

return $notFound();
