<?php
/**
 * ---------------------------------------------------------------------------
 * STATIC SITE BUILDER
 * ---------------------------------------------------------------------------
 * Renders every page of the PHP site to plain HTML in dist/, so the site can
 * be hosted on Vercel, Netlify or Cloudflare Pages — none of which run PHP.
 *
 *   php build.php
 *
 * The PHP source stays the content management system: edit the data files,
 * re-run this, redeploy. The design, SEO tags and structured data are exactly
 * what PHP would have served, with the URLs rewritten to static paths.
 *
 * URL mapping
 *   /                              -> index.html
 *   /about.php                     -> about.html
 *   /practice-area.php?area=SLUG   -> practice/SLUG.html
 *   /post.php?p=SLUG               -> insights/SLUG.html
 *   /feed.php                      -> feed.xml
 *   /sitemap.php                   -> sitemap.xml
 *
 * Hosts are configured (see vercel.json) to serve `about.html` at `/about`,
 * so visitors never see a .html extension.
 *
 * Implementation notes
 *   - Every variable here is prefixed `bld` because the included page scripts
 *     run in this same scope and would otherwise overwrite them. (feed.php has
 *     its own $built, which silently corrupted the page count before this.)
 *   - Nothing is echoed until the very end. Once PHP has written to stdout it
 *     considers headers sent, and sitemap.php/feed.php would then emit
 *     "Cannot modify header information" warnings into the generated XML.
 * ---------------------------------------------------------------------------
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("build.php must be run from the command line: php build.php\n");
}

$bldRoot = __DIR__;
$bldDist = $bldRoot . '/dist';
$bldLog  = [];

// Render as if served from the domain root, so BASE_PATH resolves to ''.
$_SERVER['SCRIPT_NAME']    = '/index.php';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST']      = 'localhost';
$_SERVER['REMOTE_ADDR']    = '127.0.0.1';

require_once $bldRoot . '/includes/config.php';
require_once $bldRoot . '/includes/functions.php';
require_once $bldRoot . '/includes/data-practice.php';
require_once $bldRoot . '/includes/data-blog.php';
require_once $bldRoot . '/includes/data-faq.php';
require_once $bldRoot . '/includes/data-team.php';

// ---------------------------------------------------------------------------
// Routes: [script, $_GET, output path]
// ---------------------------------------------------------------------------
$bldRoutes = [
    ['index.php',          [], 'index.html'],
    ['about.php',          [], 'about.html'],
    ['practice-areas.php', [], 'practice-areas.html'],
    ['team.php',           [], 'team.html'],
    ['blog.php',           [], 'blog.html'],
    ['faq.php',            [], 'faq.html'],
    ['contact.php',        [], 'contact.html'],
    ['privacy.php',        [], 'privacy.html'],
    ['legal-notice.php',   [], 'legal-notice.html'],
    ['404.php',            [], '404.html'],
    ['sitemap.php',        [], 'sitemap.xml'],
    ['feed.php',           [], 'feed.xml'],
];

foreach (practice_areas() as $bldArea) {
    $bldRoutes[] = ['practice-area.php', ['area' => $bldArea['slug']], 'practice/' . $bldArea['slug'] . '.html'];
}

foreach (blog_posts() as $bldPost) {
    $bldRoutes[] = ['post.php', ['p' => $bldPost['slug']], 'insights/' . $bldPost['slug'] . '.html'];
}

unset($bldArea, $bldPost);

// ---------------------------------------------------------------------------
// URL rewriting: dynamic PHP URLs -> static paths
// ---------------------------------------------------------------------------
$bldRewriteUrl = static function (string $url): string {
    /** Rewrite an internal path. Never called on a third-party URL. */
    $path = static function (string $u): string {
        $map = [
            'practice-area.php?area=' => 'practice/',
            'post.php?p='             => 'insights/',
            'feed.php'                => 'feed.xml',
            'sitemap.php'             => 'sitemap.xml',
        ];

        foreach ($map as $from => $to) {
            $u = str_replace($from, $to, $u);
        }

        // Category-filtered listings have no static page (they are noindex
        // anyway), so collapse them onto the main listing.
        $u = preg_replace('~blog\.php\?category=[^"&\s]*~', 'blog', $u) ?? $u;

        // Remaining top-level pages lose the .php extension; index.php -> /.
        $u = preg_replace('~\bindex\.php\b~', '', $u) ?? $u;

        return preg_replace('~\b([a-z0-9-]+)\.php\b~', '$1', $u) ?? $u;
    };

    // Our own absolute URLs — canonical, Open Graph, sitemap, share targets.
    if (str_starts_with($url, SITE_URL)) {
        return SITE_URL . $path(substr($url, strlen(SITE_URL)));
    }

    // Root-relative internal links.
    if (str_starts_with($url, '/')) {
        return $path($url);
    }

    /**
     * Third-party URLs (LinkedIn, X, Facebook, WhatsApp share endpoints).
     * These must NOT be path-rewritten — doing so turned Facebook's
     * `sharer.php` into `sharer` and broke the share button. Only the
     * percent-encoded copy of our own URL sitting in the query string is
     * rewritten, so the shared link points at the static page.
     */
    if (str_starts_with($url, 'http') || str_starts_with($url, '//')) {
        return strtr($url, [
            '%2Fpost.php%3Fp%3D'             => '%2Finsights%2F',
            '%2Fpractice-area.php%3Farea%3D' => '%2Fpractice%2F',
            '%2Fblog.php'                    => '%2Fblog',
            '%2Fcontact.php'                 => '%2Fcontact',
            '%2Findex.php'                   => '%2F',
        ]);
    }

    // mailto:, tel:, #fragments and relative asset paths are left alone.
    return $url;
};

/** Rewrite every URL-bearing attribute and XML node in a rendered document. */
$bldRewriteDoc = static function (string $html) use ($bldRewriteUrl): string {
    $html = preg_replace_callback(
        '~\b(href|src|content|value|action|data-copy-link)="([^"]*)"~i',
        static fn(array $m): string => $m[1] . '="' . $bldRewriteUrl($m[2]) . '"',
        $html
    ) ?? $html;

    // sitemap.xml <loc>, feed.xml <link> and <guid>
    return preg_replace_callback(
        '~<(loc|link|guid)([^>]*)>([^<]+)</\1>~',
        static fn(array $m): string => '<' . $m[1] . $m[2] . '>' . $bldRewriteUrl($m[3]) . '</' . $m[1] . '>',
        $html
    ) ?? $html;
};

// ---------------------------------------------------------------------------
// Filesystem helpers
// ---------------------------------------------------------------------------
$bldRmdir = static function (string $dir) use (&$bldRmdir): void {
    if (!is_dir($dir)) {
        return;
    }
    foreach (scandir($dir) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $path = $dir . '/' . $entry;
        is_dir($path) ? $bldRmdir($path) : unlink($path);
    }
    rmdir($dir);
};

$bldCopyTree = static function (string $src, string $dst) use (&$bldCopyTree): int {
    if (!is_dir($dst)) {
        mkdir($dst, 0775, true);
    }
    $n = 0;
    foreach (scandir($src) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $from = $src . '/' . $entry;
        $to   = $dst . '/' . $entry;
        $n   += is_dir($from) ? $bldCopyTree($from, $to) : (int) copy($from, $to);
    }
    return $n;
};

// ---------------------------------------------------------------------------
// Build
// ---------------------------------------------------------------------------
$bldRmdir($bldDist);
mkdir($bldDist, 0775, true);

$bldCount = 0;

foreach ($bldRoutes as $bldRoute) {
    [$bldScript, $bldQuery, $bldTarget] = $bldRoute;

    $_GET     = $bldQuery;
    $_REQUEST = $bldQuery;

    // Each page assigns its own $page / $hero, but clear them first so a stale
    // value can never leak from the previously rendered page.
    unset($page, $hero);

    ob_start();
    include $bldRoot . '/' . $bldScript;
    $bldHtml = $bldRewriteDoc((string) ob_get_clean());

    $bldPath = $bldDist . '/' . $bldTarget;
    if (!is_dir(dirname($bldPath))) {
        mkdir(dirname($bldPath), 0775, true);
    }

    file_put_contents($bldPath, $bldHtml);
    $bldCount++;

    $bldLog[] = sprintf('  %-52s %6.1f KB', $bldTarget, strlen($bldHtml) / 1024);
}

unset($bldRoute, $bldScript, $bldQuery, $bldTarget, $bldHtml, $bldPath);

// Static assets and root files
$bldAssets = $bldCopyTree($bldRoot . '/assets', $bldDist . '/assets');
copy($bldRoot . '/robots.txt', $bldDist . '/robots.txt');

// ---------------------------------------------------------------------------
// Pre-flight warnings — things that silently break a live deployment
// ---------------------------------------------------------------------------
$bldWarnings = [];

if (FORM_ENDPOINT === '') {
    $bldWarnings[] = 'FORM_ENDPOINT is empty. Static hosts cannot run PHP, so the contact form will '
                   . 'not submit anywhere. Get a free key at web3forms.com, then set FORM_ENDPOINT '
                   . 'and FORM_ACCESS_KEY in includes/config.php.';
}

if (str_contains(SITE_URL, 'localhost')) {
    $bldWarnings[] = 'SITE_URL still points at localhost. Canonical URLs, the sitemap and the share '
                   . 'card will all be wrong. Set it to the live domain in includes/config.php.';
}

foreach (SOCIALS as $bldKey => $bldSocial) {
    if ($bldSocial['url'] === '#') {
        $bldWarnings[] = 'Social link "' . $bldKey . '" is still the "#" placeholder in includes/config.php.';
    }
}

if (array_filter(team_members(), static fn(array $m): bool => !empty($m['placeholder']))) {
    $bldWarnings[] = 'includes/data-team.php still contains placeholder team members.';
}

// ---------------------------------------------------------------------------
// Report (all output happens here, after the last header() call)
// ---------------------------------------------------------------------------
echo "Building static site into dist/\n", str_repeat('-', 64), "\n";
echo implode("\n", $bldLog), "\n";
echo str_repeat('-', 64), "\n";
echo "Pages:  {$bldCount}\n";
echo "Assets: {$bldAssets}\n";
echo "Output: {$bldDist}\n\n";

if ($bldWarnings === []) {
    echo "No warnings. Ready to deploy.\n";
    exit(0);
}

echo "Warnings (the build still succeeded):\n";
foreach ($bldWarnings as $bldI => $bldWarning) {
    echo '  ' . ($bldI + 1) . '. ' . wordwrap($bldWarning, 82, "\n     ") . "\n";
}
