<?php
declare(strict_types=1);

/**
 * /api/status  (sign-in required)
 *   GET -> the latest run of the "Deploy" GitHub Action, so the editor can say
 *          whether the last change is live yet. Needs "Actions: Read" on the
 *          GitHub token; without it the editor simply shows no status.
 */

require_once __DIR__ . '/_lib.php';

run_api(static function (): void {
    if (method() !== 'GET') {
        fail(405, 'Method not allowed.');
    }
    $cfg = guard();

    if ($cfg['local']) {
        send(200, ['ok' => true, 'run' => ['status' => 'completed', 'conclusion' => 'success', 'title' => 'Local preview', 'updated' => gmdate('c'), 'url' => '']]);
    }

    $r = gh($cfg, '/actions/workflows/deploy.yml/runs?per_page=1&branch=' . rawurlencode($cfg['branch']));
    $runs = $r['data']['workflow_runs'] ?? null;
    if ($r['status'] >= 300 || !is_array($runs) || $runs === []) {
        send(200, ['ok' => true, 'run' => null]);
    }

    $run = $runs[0];
    send(200, ['ok' => true, 'run' => [
        'status'     => $run['status'] ?? null,      // queued | in_progress | completed
        'conclusion' => $run['conclusion'] ?? null,  // success | failure | cancelled | null
        'title'      => $run['display_title'] ?? '',
        'updated'    => $run['updated_at'] ?? '',
        'url'        => $run['html_url'] ?? '',
    ]]);
});
