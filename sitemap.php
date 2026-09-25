<?php
declare(strict_types=1);

/**
 * Dynamic XML sitemap, in both languages. Every page, practice area and
 * article is included automatically, with hreflang links between each page
 * and its translation, so adding content never means editing this file.
 *
 * Submit https://yourdomain.com/sitemap.xml to Google Search Console.
 * The .htaccess rewrite maps /sitemap.xml to this script.
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';
require_once __DIR__ . '/includes/data-blog.php';

header('Content-Type: application/xml; charset=utf-8');

$today = date('Y-m-d');

/**
 * Each entry names the page in each language (null = not translated).
 * @var array<int, array{paths: array<string, ?string>, lastmod: string, freq: string, priority: string}> $entries
 */
$entries = [];
$both = static fn(string $path, string $freq, string $priority) => [
    'paths' => ['en' => $path, 'fr' => $path], 'lastmod' => $today, 'freq' => $freq, 'priority' => $priority,
];

$entries[] = $both('',                   'weekly',  '1.0');
$entries[] = $both('about.php',          'monthly', '0.8');
$entries[] = $both('practice-areas.php', 'monthly', '0.9');
$entries[] = $both('team.php',           'monthly', '0.7');
$entries[] = $both('blog.php',           'weekly',  '0.8');
$entries[] = $both('faq.php',            'monthly', '0.8');
$entries[] = $both('contact.php',        'yearly',  '0.8');
$entries[] = $both('privacy.php',        'yearly',  '0.3');
$entries[] = $both('legal-notice.php',   'yearly',  '0.3');

foreach (practice_areas_en() as $area) {
    $entries[] = $both('practice-area.php?area=' . $area['slug'], 'monthly', '0.7');
}

// Articles: pair each English article with its French translation, then add
// French articles that have no English counterpart.
$pairedFr = [];
foreach (blog_posts('en') as $post) {
    $fr = post_translation($post);
    if ($fr !== null) {
        $pairedFr[$fr] = true;
    }
    $entries[] = [
        'paths'    => ['en' => 'post.php?p=' . $post['slug'], 'fr' => $fr === null ? null : 'post.php?p=' . $fr],
        'lastmod'  => $post['updated'],
        'freq'     => 'yearly',
        'priority' => '0.6',
    ];
}
foreach (blog_posts('fr') as $post) {
    if (!isset($pairedFr[$post['slug']])) {
        $entries[] = [
            'paths'    => ['en' => null, 'fr' => 'post.php?p=' . $post['slug']],
            'lastmod'  => $post['updated'],
            'freq'     => 'yearly',
            'priority' => '0.6',
        ];
    }
}

$x = static fn(string $s): string => htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($entries as $entry): ?>
<?php foreach ($entry['paths'] as $lang => $path): if ($path === null) continue; ?>
  <url>
    <loc><?= $x(abs_url_in($path, $lang)) ?></loc>
<?php foreach ($entry['paths'] as $altLang => $altPath): if ($altPath === null) continue; ?>
    <xhtml:link rel="alternate" hreflang="<?= $altLang ?>" href="<?= $x(abs_url_in($altPath, $altLang)) ?>"/>
<?php endforeach; ?>
<?php if ($entry['paths']['en'] !== null): ?>
    <xhtml:link rel="alternate" hreflang="x-default" href="<?= $x(abs_url_in($entry['paths']['en'], 'en')) ?>"/>
<?php endif; ?>
    <lastmod><?= $entry['lastmod'] ?></lastmod>
    <changefreq><?= $entry['freq'] ?></changefreq>
    <priority><?= $entry['priority'] ?></priority>
  </url>
<?php endforeach; ?>
<?php endforeach; ?>
</urlset>
