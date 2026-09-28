<?php
declare(strict_types=1);

/**
 * /api/session
 *   GET     -> { ok, signedIn, configured }   is the browser signed in?
 *   POST    { password } -> sets the cookie     sign in
 *   DELETE  -> clears the cookie                sign out
 */

require_once __DIR__ . '/_lib.php';

run_api(static function (): void {
    $cfg = admin_config();

    if (method() === 'GET') {
        send(200, ['ok' => true, 'signedIn' => $cfg['missing'] === [] && is_authenticated($cfg['secret']), 'configured' => $cfg['missing'] === []]);
    }

    if (method() === 'DELETE') {
        send(200, ['ok' => true], [clear_cookie()]);
    }

    if (method() !== 'POST') {
        fail(405, 'Method not allowed.');
    }
    if ($cfg['missing'] !== []) {
        fail(500, 'The editor is not configured yet. Missing settings: ' . implode(', ', $cfg['missing']));
    }
    if (!same_origin()) {
        fail(403, 'Request refused.');
    }

    $body = read_json(10 * 1024);
    if (!is_string($body['password'] ?? null) || !safe_equal($body['password'], $cfg['password'])) {
        // Slow every failed attempt down to make password guessing impractical.
        usleep(900000);
        fail(401, 'That password is not correct.');
    }

    send(200, ['ok' => true], [issue_cookie($cfg['secret'])]);
});
