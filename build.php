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
// Routes: [script, $_GET, output path, language]
// French pages are the templates in fr/, published under /fr/.
// ---------------------------------------------------------------------------
$bldRoutes = [
    ['index.php',          [], 'index.html', 'en'],
    ['about.php',          [], 'about.html', 'en'],
    ['practice-areas.php', [], 'practice-areas.html', 'en'],
    ['team.php',           [], 'team.html', 'en'],
    ['blog.php',           [], 'blog.html', 'en'],
    ['faq.php',            [], 'faq.html', 'en'],
    ['contact.php',        [], 'contact.html', 'en'],
    ['privacy.php',        [], 'privacy.html', 'en'],
    ['legal-notice.php',   [], 'legal-notice.html', 'en'],
    ['404.php',            [], '404.html', 'en'],
    ['sitemap.php',        [], 'sitemap.xml', 'en'],
    ['feed.php',           [], 'feed.xml', 'en'],
    ['llms.php',           [], 'llms.txt', 'en'],

    ['fr/index.php',          [], 'fr/index.html', 'fr'],
    ['fr/about.php',          [], 'fr/about.html', 'fr'],
    ['fr/practice-areas.php', [], 'fr/practice-areas.html', 'fr'],
    ['fr/team.php',           [], 'fr/team.html', 'fr'],
    ['fr/blog.php',           [], 'fr/blog.html', 'fr'],
    ['fr/faq.php',            [], 'fr/faq.html', 'fr'],
    ['fr/contact.php',        [], 'fr/contact.html', 'fr'],
    ['fr/privacy.php',        [], 'fr/privacy.html', 'fr'],
    ['fr/legal-notice.php',   [], 'fr/legal-notice.html', 'fr'],
];

foreach (practice_areas_en() as $bldArea) {
    $bldRoutes[] = ['practice-area.php', ['area' => $bldArea['slug']], 'practice/' . $bldArea['slug'] . '.html', 'en'];
    $bldRoutes[] = ['fr/practice-area.php', ['area' => $bldArea['slug']], 'fr/practice/' . $bldArea['slug'] . '.html', 'fr'];
}

foreach (blog_posts('en') as $bldPost) {
    $bldRoutes[] = ['post.php', ['p' => $bldPost['slug']], 'insights/' . $bldPost['slug'] . '.html', 'en'];
}
foreach (blog_posts('fr') as $bldPost) {
    $bldRoutes[] = ['fr/post.php', ['p' => $bldPost['slug']], 'fr/insights/' . $bldPost['slug'] . '.html', 'fr'];
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
    [$bldScript, $bldQuery, $bldTarget, $bldLang] = $bldRoute;

    $_GET     = $bldQuery;
    $_REQUEST = $bldQuery;

    // is_current() compares against SCRIPT_NAME, so it has to change per page
    // or every rendered page marks "Home" as the active nav item. BASE_PATH was
    // already resolved from the first include and stays ''.
    $_SERVER['SCRIPT_NAME'] = '/' . $bldScript;

    // French templates switch the language themselves; English ones rely on
    // the default, so reset it between pages.
    set_lang($bldLang);

    // Each page assigns its own $page / $hero, but clear them first so a stale
    // value can never leak from the previously rendered page.
    unset($page, $hero);

    ob_start();
    include $bldRoot . '/' . $bldScript;
    $bldHtml = (string) ob_get_clean();

    // Plain-text output (llms.txt) has URLs in the text rather than in
    // attributes, so rewrite every absolute URL of our own.
    $bldHtml = str_ends_with($bldTarget, '.txt')
        ? (string) preg_replace_callback('~' . preg_quote(SITE_URL, '~') . '[^\s)]*~', static fn(array $m): string => $bldRewriteUrl($m[0]), $bldHtml)
        : $bldRewriteDoc($bldHtml);

    $bldPath = $bldDist . '/' . $bldTarget;
    if (!is_dir(dirname($bldPath))) {
        mkdir(dirname($bldPath), 0775, true);
    }

    file_put_contents($bldPath, $bldHtml);
    $bldCount++;

    $bldLog[] = sprintf('  %-52s %6.1f KB', $bldTarget, strlen($bldHtml) / 1024);
}

unset($bldRoute, $bldScript, $bldQuery, $bldTarget, $bldLang, $bldHtml, $bldPath);
set_lang('en');

// Static assets, the article admin and root files
$bldAssets  = $bldCopyTree($bldRoot . '/assets', $bldDist . '/assets');
$bldAssets += $bldCopyTree($bldRoot . '/admin', $bldDist . '/admin');
copy($bldRoot . '/robots.txt', $bldDist . '/robots.txt');

/**
 * vercel.json is copied INTO dist/ as well as living at the repository root.
 *
 * Vercel reads vercel.json from the project's root directory — which is
 * whatever the dashboard's "Root Directory" setting points at. So the file has
 * to exist in both places for both setups to work:
 *
 *   Root Directory = repository root  -> reads ./vercel.json      (outputDirectory: dist)
 *   Root Directory = dist            -> reads ./dist/vercel.json
 *
 * Without the copy, the second setup silently loses `cleanUrls`, which
 * defaults to false. Every internal link, canonical tag and sitemap entry this
 * build emits is extensionless (/about, /practice/corporate-law), so the whole
 * site would 404 while still deploying "successfully".
 *
 * The copy is served publicly at /vercel.json. That is harmless: it holds only
 * routing and header configuration, no secrets.
 *
 * The build-related keys are stripped from the copy. Inside dist/,
 * "outputDirectory": "dist" would point Vercel at dist/dist and break the
 * deployment; with no framework and no package.json, Vercel serves the
 * directory as static output anyway. Only the routing and header rules — the
 * part that actually has to survive — are kept.
 */
$bldVercel = json_decode((string) file_get_contents($bldRoot . '/vercel.json'), true);

if (is_array($bldVercel)) {
    unset(
        $bldVercel['framework'],
        $bldVercel['installCommand'],
        $bldVercel['buildCommand'],
        $bldVercel['outputDirectory'],
    );

    file_put_contents(
        $bldDist . '/vercel.json',
        json_encode($bldVercel, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
    );
}

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
