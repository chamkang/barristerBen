<?php
declare(strict_types=1);

/**
 * /api/articles  (sign-in required)
 *   GET                         -> list of articles in both languages
 *   GET    ?lang=en&slug=x      -> one article, for editing
 *   POST   { article, sha }     -> create or update (commits the Markdown file)
 *   DELETE ?lang=en&slug=x&sha= -> delete
 *
 * Articles live in content/insights/<lang>/<slug>.md.
 */

require_once __DIR__ . '/_lib.php';

const DATE_RE = '/^\d{4}-\d{2}-\d{2}$/';

function article_dir(string $lang): string
{
    return 'content/insights/' . $lang;
}

function list_lang(array $cfg, string $lang): array
{
    $items = [];
    foreach (list_dir($cfg, article_dir($lang)) as $f) {
        if (!str_ends_with($f['name'], '.md')) {
            continue;
        }
        $file = get_file($cfg, $f['path']);
        $meta = parse_markdown($file['text'] ?? '')['meta'];
        $items[] = [
            'lang'        => $lang,
            'slug'        => substr($f['name'], 0, -3),
            'sha'         => $f['sha'],
            'title'       => (string) ($meta['title'] ?? $f['name']),
            'date'        => substr((string) ($meta['date'] ?? ''), 0, 10),
            'category'    => (string) ($meta['category'] ?? ''),
            'draft'       => ($meta['draft'] ?? false) === true,
            'translation' => (string) ($meta['translation'] ?? ''),
        ];
    }
    usort($items, static fn(array $a, array $b): int => strcmp($b['date'] . $a['title'], $a['date'] . $b['title']));
    return $items;
}

/** Validates and normalises an article sent by the editor: [article, errors]. */
function normalise(array $in): array
{
    $tags = is_array($in['tags'] ?? null) ? $in['tags'] : explode(',', (string) ($in['tags'] ?? ''));
    $a = [
        'lang'        => (string) ($in['lang'] ?? ''),
        'slug'        => strtolower((string) ($in['slug'] ?? '')),
        'title'       => clean($in['title'] ?? '', 200),
        'seoTitle'    => clean($in['seoTitle'] ?? '', 90),
        'date'        => (string) ($in['date'] ?? ''),
        'updated'     => (string) ($in['updated'] ?? ''),
        'category'    => clean($in['category'] ?? '', 60),
        'author'      => clean($in['author'] ?? '', 80),
        'excerpt'     => clean($in['excerpt'] ?? '', 320),
        'tags'        => array_slice(array_values(array_filter(array_map(static fn($t): string => clean($t, 40), $tags))), 0, 12),
        'image'       => clean($in['image'] ?? '', 300),
        'featured'    => ($in['featured'] ?? false) === true,
        'draft'       => ($in['draft'] ?? false) === true,
        'translation' => strtolower((string) ($in['translation'] ?? '')),
        'body'        => mb_substr((string) ($in['body'] ?? ''), 0, 200000),
    ];

    $errors = [];
    if (!in_array($a['lang'], ADMIN_LANGS, true)) $errors[] = 'Choose English or French.';
    if (!preg_match(SLUG_RE, $a['slug']) || strlen($a['slug']) > 90) $errors[] = 'The web address may only use lowercase letters, numbers and hyphens.';
    if (mb_strlen($a['title']) < 5) $errors[] = 'Give the article a title.';
    if (!preg_match(DATE_RE, $a['date'])) $errors[] = 'Choose a publication date.';
    if ($a['updated'] !== '' && !preg_match(DATE_RE, $a['updated'])) $errors[] = 'The "last updated" date is not valid.';
    if ($a['category'] === '') $errors[] = 'Choose a topic.';
    if (mb_strlen(trim($a['body'])) < 50) $errors[] = 'The article text is too short.';
    if ($a['translation'] !== '' && !preg_match(SLUG_RE, $a['translation'])) $errors[] = 'The linked translation is not valid.';
    if ($a['image'] !== '' && !preg_match('~^/assets/img/insights/[A-Za-z0-9/_\-.]+$~', $a['image']) && !str_starts_with($a['image'], 'https://')) $errors[] = 'The cover image address is not valid.';
    if ($a['author'] === '') $a['author'] = $a['lang'] === 'fr' ? 'Cabinet Fonju & Partners' : 'Fonju & Partners Law Firm';
    if ($a['excerpt'] === '') $errors[] = 'Write a one or two sentence summary.';

    return [$a, $errors];
}

run_api(static function (): void {
    $write = in_array(method(), ['POST', 'DELETE'], true);
    $cfg   = guard($write);
    $lang  = (string) ($_GET['lang'] ?? '');
    $slug  = strtolower((string) ($_GET['slug'] ?? ''));

    if (method() === 'GET' && $slug === '') {
        send(200, ['ok' => true, 'articles' => ['en' => list_lang($cfg, 'en'), 'fr' => list_lang($cfg, 'fr')]]);
    }

    if (method() === 'GET') {
        if (!in_array($lang, ADMIN_LANGS, true) || !preg_match(SLUG_RE, $slug)) {
            fail(400, 'Unknown article.');
        }
        $file = get_file($cfg, article_dir($lang) . '/' . $slug . '.md');
        if ($file === null) {
            fail(404, 'That article no longer exists.');
        }
        ['meta' => $meta, 'body' => $body] = parse_markdown($file['text']);
        send(200, ['ok' => true, 'article' => [
            'lang'        => $lang,
            'slug'        => $slug,
            'sha'         => $file['sha'],
            'body'        => $body,
            'title'       => (string) ($meta['title'] ?? ''),
            'seoTitle'    => (string) ($meta['seo_title'] ?? ''),
            'date'        => substr((string) ($meta['date'] ?? ''), 0, 10),
            'updated'     => substr((string) ($meta['updated'] ?? ''), 0, 10),
            'category'    => (string) ($meta['category'] ?? ''),
            'author'      => (string) ($meta['author'] ?? ''),
            'excerpt'     => (string) ($meta['excerpt'] ?? ''),
            'tags'        => array_map('strval', is_array($meta['tags'] ?? null) ? $meta['tags'] : []),
            'image'       => (string) ($meta['image'] ?? ''),
            'featured'    => ($meta['featured'] ?? false) === true,
            'draft'       => ($meta['draft'] ?? false) === true,
            'translation' => (string) ($meta['translation'] ?? ''),
        ]]);
    }

    if (method() === 'POST') {
        $input = read_json(512 * 1024);
        [$article, $errors] = normalise(is_array($input['article'] ?? null) ? $input['article'] : []);
        if ($errors !== []) {
            fail(400, implode(' ', $errors));
        }

        $path = article_dir($article['lang']) . '/' . $article['slug'] . '.md';
        $sha  = is_string($input['sha'] ?? null) && $input['sha'] !== '' ? $input['sha'] : null;
        $conflict = $sha
            ? 'This article was changed elsewhere since you opened it. Reload it and make your edit again.'
            : 'An article with this address already exists. Choose a different web address.';
        $newSha = put_file($cfg, $path, build_markdown($article), ($sha ? 'Update' : 'Publish') . " article ({$article['lang']}): {$article['title']}", $sha, $conflict);

        send(200, ['ok' => true, 'sha' => $newSha, 'path' => $path]);
    }

    if (method() === 'DELETE') {
        $sha = (string) ($_GET['sha'] ?? '');
        if (!in_array($lang, ADMIN_LANGS, true) || !preg_match(SLUG_RE, $slug) || $sha === '') {
            fail(400, 'Unknown article.');
        }
        delete_file($cfg, article_dir($lang) . '/' . $slug . '.md', $sha, "Delete article ($lang): $slug");
        send(200, ['ok' => true]);
    }

    fail(405, 'Method not allowed.');
});
