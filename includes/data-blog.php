<?php
declare(strict_types=1);

require_once __DIR__ . '/content.php';

/**
 * ---------------------------------------------------------------------------
 * INSIGHTS / BLOG
 * ---------------------------------------------------------------------------
 * Articles are Markdown files, one per article:
 *
 *   content/insights/en/<slug>.md   English, published at /insights/<slug>
 *   content/insights/fr/<slug>.md   French,  published at /fr/insights/<slug>
 *
 * The easiest way to write one is the online editor at /admin, which creates
 * these files for you (see the README). They can also be
 * written by hand; the front matter fields are:
 *
 *   title        Article title (required)
 *   seo_title    Title for Google and browser tabs, when it should differ
 *                from the headline, e.g. to match what people search (optional)
 *   date         Publication date, YYYY-MM-DD (required). A future date keeps
 *                the article off the site until that day's rebuild.
 *   updated      Date of the last substantive update (optional)
 *   category     Topic, used for filtering (required)
 *   author       Byline (defaults to the firm)
 *   excerpt      One or two sentences for cards and search results
 *   tags         List of keywords (optional)
 *   image        Cover image path, e.g. /assets/img/insights/photo.jpg (optional)
 *   featured     true to feature the article (optional)
 *   translation  Slug of the same article in the other language (optional)
 *   draft        true to keep the article unpublished (optional)
 *
 * Every article renders BlogPosting structured data, a canonical URL, hreflang
 * links to its translation, an Open Graph card and a breadcrumb trail.
 * ---------------------------------------------------------------------------
 */

/** Published articles in $lang (default: the current language), newest first. */
function blog_posts(?string $lang = null): array
{
    static $cache = [];

    $lang ??= lang();
    if (isset($cache[$lang])) {
        return $cache[$lang];
    }

    $today = date('Y-m-d');
    $posts = [];

    foreach (glob(dirname(__DIR__) . '/content/insights/' . $lang . '/*.md') ?: [] as $file) {
        [$meta, $markdown] = parse_content_file((string) file_get_contents($file));

        $slug = (string) preg_replace('/[^a-z0-9-]/', '', strtolower(basename($file, '.md')));
        $date = content_date($meta['date'] ?? '') ?: date('Y-m-d', (int) filemtime($file));

        if (!empty($meta['draft']) || $slug === '' || $date > $today) {
            continue;
        }

        $body = markdown_to_html($markdown);

        $posts[] = [
            'slug'        => $slug,
            'lang'        => $lang,
            'title'       => trim((string) ($meta['title'] ?? $slug)),
            'seo_title'   => trim((string) ($meta['seo_title'] ?? '')),
            'category'    => trim((string) ($meta['category'] ?? '')) ?: ($lang === 'fr' ? 'Actualités' : 'Insights'),
            'author'      => trim((string) ($meta['author'] ?? '')) ?: SITE_NAME,
            'date'        => $date,
            'updated'     => content_date($meta['updated'] ?? '') ?: $date,
            'featured'    => !empty($meta['featured']),
            'tags'        => array_values(array_filter(array_map(static fn($t): string => trim((string) $t), (array) ($meta['tags'] ?? [])))),
            'excerpt'     => trim((string) ($meta['excerpt'] ?? '')) ?: excerpt($body, 30),
            'image'       => trim((string) ($meta['image'] ?? '')),
            'translation' => (string) preg_replace('/[^a-z0-9-]/', '', strtolower((string) ($meta['translation'] ?? ''))),
            'body'        => $body,
        ];
    }

    usort($posts, static fn(array $a, array $b): int => [$b['date'], $a['title']] <=> [$a['date'], $b['title']]);

    return $cache[$lang] = $posts;
}

/** YYYY-MM-DD from a front-matter date (plain date or ISO date-time), or ''. */
function content_date(mixed $value): string
{
    $value = trim((string) $value);

    return preg_match('/^(\d{4}-\d{2}-\d{2})/', $value, $m) ? $m[1] : '';
}

function blog_post(string $slug, ?string $lang = null): ?array
{
    foreach (blog_posts($lang) as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }

    return null;
}

/**
 * Slug of the same article in the other language, or null. The link may be
 * recorded on either side, so both directions are checked.
 */
function post_translation(array $post): ?string
{
    $other = $post['lang'] === 'fr' ? 'en' : 'fr';

    if ($post['translation'] !== '' && blog_post($post['translation'], $other) !== null) {
        return $post['translation'];
    }

    foreach (blog_posts($other) as $candidate) {
        if ($candidate['translation'] === $post['slug']) {
            return $candidate['slug'];
        }
    }

    return null;
}

function blog_categories(): array
{
    $cats = [];

    foreach (blog_posts() as $post) {
        $cats[$post['category']] = ($cats[$post['category']] ?? 0) + 1;
    }

    ksort($cats);

    return $cats;
}

/**
 * An article card, as used on the home page, the blog listing and the French
 * equivalents. $heading is the heading element for the title.
 */
function post_card(array $post, int $delay = 1, bool $featured = false, string $heading = 'h3'): string
{
    $href  = e(url('post.php?p=' . $post['slug']));
    $cover = $post['image'] !== ''
        ? '<img class="post-card__img" src="' . e(md_safe_url($post['image'])) . '" alt="" loading="lazy">'
        : icon('doc', 46);

    return '<article class="post-card reveal' . ($featured ? ' post-card--featured' : '') . '" data-delay="' . $delay . '">'
        . '<div class="post-card__cover' . ($post['image'] !== '' ? ' post-card__cover--image' : '') . '">'
        . '<span class="post-card__cat">' . e($post['category']) . '</span>' . $cover
        . '</div>'
        . '<div class="post-card__body">'
        . '<p class="post-card__meta">'
        . '<span><time datetime="' . e($post['date']) . '">' . e(fmt_date($post['date'])) . '</time></span>'
        . '<span>' . reading_time($post['body']) . ' ' . e(t('min read')) . '</span>'
        . ($featured || $heading === 'h2' ? '<span>' . e($post['author']) . '</span>' : '')
        . '</p>'
        . '<' . $heading . ($heading === 'h2' ? ' class="post-card__title"' : '') . '><a href="' . $href . '">' . e($post['title']) . '</a></' . $heading . '>'
        . '<p>' . e($post['excerpt']) . '</p>'
        . '<a class="link-arrow" href="' . $href . '">' . e(t('Read the article')) . ' ' . icon('arrow', 15) . '</a>'
        . '</div>'
        . '</article>';
}

/**
 * Which practice areas each article topic belongs to, so practice area pages
 * can link to the articles on their subject (topics are compared in lower
 * case; add a line when the firm starts writing under a new topic).
 */
const TOPIC_PRACTICE = [
    'corporate'                => ['corporate-law', 'investments-and-securities'],
    'droit des sociétés'       => ['corporate-law', 'investments-and-securities'],
    'regulatory'               => ['corporate-law', 'arbitration-and-adr', 'litigation-and-settlements'],
    'réglementation'           => ['corporate-law', 'arbitration-and-adr', 'litigation-and-settlements'],
    'dispute resolution'       => ['arbitration-and-adr', 'litigation-and-settlements'],
    'contentieux'              => ['arbitration-and-adr', 'litigation-and-settlements'],
    'employment'               => ['labour-and-employment'],
    'droit du travail'         => ['labour-and-employment'],
    'real estate'              => ['real-estate-and-property'],
    'immobilier'               => ['real-estate-and-property'],
    'intellectual property'    => ['intellectual-property', 'media-sports-and-creative-industry'],
    'propriété intellectuelle' => ['intellectual-property', 'media-sports-and-creative-industry'],
    'investment'               => ['investments-and-securities', 'corporate-law', 'banking', 'financial-services', 'tax-and-customs', 'immigration-and-naturalisation', 'mining-and-energy'],
    'investissement'           => ['investments-and-securities', 'corporate-law', 'banking', 'financial-services', 'tax-and-customs', 'immigration-and-naturalisation', 'mining-and-energy'],
    'technology'               => ['information-technology-and-telecommunications', 'health-care', 'financial-services'],
    'technologies'             => ['information-technology-and-telecommunications', 'health-care', 'financial-services'],
    'igaming'                  => ['igaming-and-betting'],
    'jeux en ligne'            => ['igaming-and-betting'],
];

/** Articles (current language) on a practice area's subject, newest first. */
function practice_posts(string $practiceSlug, int $limit = 3): array
{
    $found = [];
    foreach (blog_posts() as $post) {
        $areas = TOPIC_PRACTICE[mb_strtolower($post['category'])] ?? [];
        if (in_array($practiceSlug, $areas, true)) {
            $found[] = $post;
        }
    }

    return array_slice($found, 0, $limit);
}

/** Up to $limit other posts, preferring the same category. */
function related_posts(array $post, int $limit = 3): array
{
    $same  = [];
    $other = [];

    foreach (blog_posts($post['lang']) as $candidate) {
        if ($candidate['slug'] === $post['slug']) {
            continue;
        }

        if ($candidate['category'] === $post['category']) {
            $same[] = $candidate;
        } else {
            $other[] = $candidate;
        }
    }

    return array_slice(array_merge($same, $other), 0, $limit);
}
