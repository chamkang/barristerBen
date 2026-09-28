<?php
declare(strict_types=1);

/**
 * /api/testimonials  (sign-in required)
 *   GET                          -> { testimonials, sha }
 *   POST { testimonials, sha }   -> replaces the whole list (one commit)
 *
 * Testimonials live in content/testimonials.json and appear on the home page
 * (see includes/data-testimonials.php). Only entries marked with the client's
 * permission are ever shown on the site.
 */

require_once __DIR__ . '/_lib.php';

const TESTIMONIALS_PATH = 'content/testimonials.json';
const MAX_TESTIMONIALS  = 24;

run_api(static function (): void {
    $cfg = guard(method() === 'POST');

    if (method() === 'GET') {
        $file = get_file($cfg, TESTIMONIALS_PATH);
        $data = $file ? json_decode($file['text'], true) : null;
        send(200, ['ok' => true, 'testimonials' => is_array($data['testimonials'] ?? null) ? $data['testimonials'] : [], 'sha' => $file['sha'] ?? '']);
    }

    if (method() !== 'POST') {
        fail(405, 'Method not allowed.');
    }

    $input  = read_json(128 * 1024);
    $list   = [];
    $errors = [];
    foreach (array_slice(is_array($input['testimonials'] ?? null) ? $input['testimonials'] : [], 0, MAX_TESTIMONIALS) as $i => $t) {
        $t = is_array($t) ? $t : [];
        $item = [
            'quote_en'   => clean($t['quote_en'] ?? '', 600),
            'quote_fr'   => clean($t['quote_fr'] ?? '', 600),
            'name'       => clean($t['name'] ?? '', 80),
            'role_en'    => clean($t['role_en'] ?? '', 100),
            'role_fr'    => clean($t['role_fr'] ?? '', 100),
            'permission' => ($t['permission'] ?? false) === true,
        ];
        if ($item['quote_en'] === '' && $item['quote_fr'] === '') $errors[] = 'Testimonial ' . ($i + 1) . ' has no text in either language.';
        if ($item['name'] === '') $errors[] = 'Testimonial ' . ($i + 1) . ': describe who said it (for example "Managing Director").';
        $list[] = $item;
    }
    if ($errors !== []) {
        fail(400, implode(' ', $errors));
    }

    $text = json_encode(['testimonials' => $list], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
    $sha  = is_string($input['sha'] ?? null) && $input['sha'] !== '' ? $input['sha'] : null;
    $new  = put_file($cfg, TESTIMONIALS_PATH, $text, 'Update testimonials (' . count($list) . ')', $sha,
        'The testimonials were changed elsewhere since you opened them. Reload the page and make your change again.');

    send(200, ['ok' => true, 'sha' => $new]);
});
