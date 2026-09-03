<?php
declare(strict_types=1);

/**
 * Dynamic XML sitemap. Every practice area and article is included
 * automatically, so adding content never means editing this file.
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

/** @var array<int, array{loc:string, lastmod:string, freq:string, priority:string}> $urls */
$urls = [
    ['loc' => '',                   'lastmod' => $today, 'freq' => 'weekly',  'priority' => '1.0'],
    ['loc' => 'about.php',          'lastmod' => $today, 'freq' => 'monthly', 'priority' => '0.8'],
    ['loc' => 'practice-areas.php', 'lastmod' => $today, 'freq' => 'monthly', 'priority' => '0.9'],
    ['loc' => 'team.php',           'lastmod' => $today, 'freq' => 'monthly', 'priority' => '0.7'],
    ['loc' => 'blog.php',           'lastmod' => $today, 'freq' => 'weekly',  'priority' => '0.8'],
    ['loc' => 'faq.php',            'lastmod' => $today, 'freq' => 'monthly', 'priority' => '0.8'],
    ['loc' => 'contact.php',        'lastmod' => $today, 'freq' => 'yearly',  'priority' => '0.8'],
    ['loc' => 'privacy.php',        'lastmod' => $today, 'freq' => 'yearly',  'priority' => '0.3'],
    ['loc' => 'legal-notice.php',   'lastmod' => $today, 'freq' => 'yearly',  'priority' => '0.3'],
];

foreach (practice_areas() as $area) {
    $urls[] = [
        'loc'      => 'practice-area.php?area=' . $area['slug'],
        'lastmod'  => $today,
        'freq'     => 'monthly',
        'priority' => '0.7',
    ];
}

foreach (blog_posts() as $post) {
    $urls[] = [
        'loc'      => 'post.php?p=' . $post['slug'],
        'lastmod'  => $post['updated'],
        'freq'     => 'yearly',
        'priority' => '0.6',
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
  <url>
    <loc><?= htmlspecialchars(abs_url($url['loc']), ENT_XML1) ?></loc>
    <lastmod><?= $url['lastmod'] ?></lastmod>
    <changefreq><?= $url['freq'] ?></changefreq>
    <priority><?= $url['priority'] ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
