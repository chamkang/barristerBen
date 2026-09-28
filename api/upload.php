<?php
declare(strict_types=1);

/**
 * /api/upload  (sign-in required)
 *   POST { name, type, data } -> { ok, url }
 *
 * Stores an image for an article in assets/img/insights/<year>/. The editor
 * resizes photographs in the browser first, so uploads stay small.
 */

require_once __DIR__ . '/_lib.php';

const IMAGE_TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
const MAX_IMAGE_BYTES = 3 * 1024 * 1024;

run_api(static function (): void {
    if (method() !== 'POST') {
        fail(405, 'Method not allowed.');
    }
    $cfg   = guard(true);
    $input = read_json(5 * 1024 * 1024);

    $ext = IMAGE_TYPES[(string) ($input['type'] ?? '')] ?? null;
    if ($ext === null) {
        fail(400, 'Please upload a JPG, PNG or WebP image.');
    }

    $bytes = base64_decode((string) preg_replace('/^data:[^,]+,/', '', (string) ($input['data'] ?? '')), true);
    if ($bytes === false || $bytes === '') {
        fail(400, 'The image is empty.');
    }
    if (strlen($bytes) > MAX_IMAGE_BYTES) {
        fail(413, 'The image is too large (maximum 3 MB).');
    }
    // Check the bytes really are the image type claimed.
    $info = @getimagesizefromstring($bytes);
    if ($info === false || !isset(IMAGE_TYPES[$info['mime']])) {
        fail(400, 'That file is not a valid JPG, PNG or WebP image.');
    }
    $ext = IMAGE_TYPES[$info['mime']];

    $base = strtolower((string) preg_replace('/\.[a-z0-9]+$/i', '', (string) ($input['name'] ?? 'image')));
    $base = function_exists('transliterator_transliterate') ? (string) transliterator_transliterate('Any-Latin; Latin-ASCII', $base) : $base;
    $base = substr(trim((string) preg_replace('/[^a-z0-9]+/', '-', $base), '-'), 0, 50) ?: 'image';
    $path = 'assets/img/insights/' . gmdate('Y') . '/' . $base . '-' . bin2hex(random_bytes(3)) . '.' . $ext;

    put_file($cfg, $path, $bytes, 'Upload article image: ' . basename($path), null, 'Please try the upload again.');

    send(200, ['ok' => true, 'url' => '/' . $path]);
});
