<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data-practice.php';

/**
 * Every page defines $page BEFORE including this file:
 *
 *   $page = [
 *     'title'       => 'Page title | Fonju Law Firm',
 *     'description' => 'Under 160 characters, written for a human.',
 *     'canonical'   => 'about.php',
 *     'breadcrumbs' => [['name' => 'About', 'url' => 'about.php']],
 *     'schema'      => [ ...additional JSON-LD graphs... ],
 *     'og_type'     => 'website' | 'article',
 *     'body_class'  => 'page-about',
 *   ];
 */
$page = array_merge([
    'title'       => SEO_DEFAULTS['title'],
    'description' => SEO_DEFAULTS['description'],
    'canonical'   => '',
    'breadcrumbs' => [],
    'schema'      => [],
    'og_type'     => 'website',
    'og_image'    => SEO_DEFAULTS['image'],
    'body_class'  => '',
    'noindex'     => false,
], $page ?? []);

$canonicalUrl = abs_url($page['canonical']);
$ogImageUrl   = abs_url(ltrim($page['og_image'], '/'));

// ---------------------------------------------------------------------------
// Organisation structured data — emitted on every page.
// ---------------------------------------------------------------------------
$openingSchema = [];
foreach (OPENING_HOURS as $slot) {
    if ($slot['open'] === null || $slot['schema'] === []) {
        continue;
    }
    $openingSchema[] = [
        '@type'     => 'OpeningHoursSpecification',
        'dayOfWeek' => array_map(
            static fn(string $d): string => [
                'Mo' => 'Monday', 'Tu' => 'Tuesday', 'We' => 'Wednesday',
                'Th' => 'Thursday', 'Fr' => 'Friday', 'Sa' => 'Saturday', 'Su' => 'Sunday',
            ][$d],
            $slot['schema']
        ),
        'opens'  => $slot['open'],
        'closes' => $slot['close'],
    ];
}

$organisationSchema = [
    '@type'       => ['LegalService', 'Attorney'],
    '@id'         => SITE_URL . '/#organization',
    'name'        => SITE_NAME,
    'legalName'   => SITE_LEGALNAME,
    'url'         => SITE_URL . '/',
    'description' => SEO_DEFAULTS['description'],
    'foundingDate' => SITE_FOUNDED,
    'slogan'      => SITE_TAGLINE,
    'image'       => $ogImageUrl,
    'telephone'   => [CONTACT['phone_primary'], CONTACT['phone_secondary']],
    'email'       => CONTACT['email_general'],
    'priceRange'  => '$$',
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => CONTACT['street'],
        'postOfficeBoxNumber' => CONTACT['po_box'],
        'addressLocality' => CONTACT['city'],
        'addressRegion'   => CONTACT['region'],
        'addressCountry'  => CONTACT['country_code'],
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => CONTACT['latitude'],
        'longitude' => CONTACT['longitude'],
    ],
    'areaServed' => [
        ['@type' => 'Country', 'name' => 'Cameroon'],
        ['@type' => 'Place',   'name' => 'CEMAC region'],
        ['@type' => 'Place',   'name' => 'OHADA member states'],
    ],
    'availableLanguage' => ['en', 'fr'],
    'knowsAbout' => array_map(static fn(array $a): string => $a['title'], array_slice(practice_areas(), 0, 12)),
];

if ($openingSchema !== []) {
    $organisationSchema['openingHoursSpecification'] = $openingSchema;
}

$sameAs = array_values(array_map(static fn(array $s): string => $s['url'], active_socials()));
if ($sameAs !== []) {
    $organisationSchema['sameAs'] = $sameAs;
}

$graph = [$organisationSchema, [
    '@type' => 'WebSite',
    '@id'   => SITE_URL . '/#website',
    'url'   => SITE_URL . '/',
    'name'  => SITE_NAME,
    'publisher' => ['@id' => SITE_URL . '/#organization'],
    'inLanguage' => 'en',
]];

if ($page['breadcrumbs'] !== []) {
    $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => SITE_URL . '/']];
    foreach ($page['breadcrumbs'] as $i => $crumb) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 2,
            'name'     => $crumb['name'],
            'item'     => abs_url($crumb['url']),
        ];
    }
    $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

foreach ($page['schema'] as $extra) {
    $graph[] = $extra;
}

$jsonLd = json_encode(
    ['@context' => 'https://schema.org', '@graph' => $graph],
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">
<?php if ($page['noindex']): ?>
<meta name="robots" content="noindex, follow">
<?php else: ?>
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<?php endif; ?>
<meta name="author" content="<?= e(SITE_NAME) ?>">
<meta name="geo.region" content="CM-LT">
<meta name="geo.placename" content="Douala">
<meta name="theme-color" content="#0b1220">

<!-- Open Graph -->
<meta property="og:type" content="<?= e($page['og_type']) ?>">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:locale" content="<?= e(SEO_DEFAULTS['locale']) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:url" content="<?= e($canonicalUrl) ?>">
<meta property="og:image" content="<?= e($ogImageUrl) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?= e(SITE_NAME . ' — ' . SITE_TAGLINE) ?>">

<!-- X / Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($page['title']) ?>">
<meta name="twitter:description" content="<?= e($page['description']) ?>">
<meta name="twitter:image" content="<?= e($ogImageUrl) ?>">
<?php if (!empty(SOCIALS['x']['handle'])): ?>
<meta name="twitter:site" content="<?= e(SOCIALS['x']['handle']) ?>">
<?php endif; ?>
<?php if (GOOGLE_SITE_VERIFY !== ''): ?>
<meta name="google-site-verification" content="<?= e(GOOGLE_SITE_VERIFY) ?>">
<?php endif; ?>

<link rel="icon" href="<?= e(asset('img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= e(asset('img/apple-touch-icon.png')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800&display=swap">
<link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>?v=1.0.0">
<link rel="alternate" type="application/rss+xml" title="<?= e(SITE_NAME) ?> Insights" href="<?= e(url('feed.php')) ?>">

<script type="application/ld+json"><?= $jsonLd ?></script>
<script>document.documentElement.classList.replace('no-js','js');</script>
<?php if (GOOGLE_ANALYTICS_ID !== ''): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(GOOGLE_ANALYTICS_ID) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e(GOOGLE_ANALYTICS_ID) ?>');</script>
<?php endif; ?>
</head>
<body class="<?= e($page['body_class']) ?>">

<a class="skip-link" href="#main">Skip to main content</a>

<div class="topbar">
  <div class="wrap topbar__inner">
    <ul class="topbar__meta">
      <li><a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= icon('phone', 14) ?><?= e(CONTACT['phone_primary']) ?></a></li>
      <li><a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= icon('mail', 14) ?><?= e(CONTACT['email_general']) ?></a></li>
      <li class="topbar__hours"><?= icon('clock', 14) ?>Mon–Fri 8:00–19:30 · Sat 8:00–12:00</li>
    </ul>
    <?= social_links('socials socials--bar', 15) ?>
  </div>
</div>

<header class="site-header" id="siteHeader">
  <div class="wrap site-header__inner">
    <a class="brand" href="<?= e(url('/')) ?>" aria-label="<?= e(SITE_NAME) ?> — home">
      <span class="brand__mark" aria-hidden="true">
        <svg viewBox="0 0 44 44" width="44" height="44" role="presentation">
          <rect x="1" y="1" width="42" height="42" rx="9" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".45"/>
          <path d="M22 8v28M13 14h18M15 20.5h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/>
          <path d="M13 14 8.5 24h9zM31 14l-4.5 10h9z" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
          <path d="M16.5 36h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
      </span>
      <span class="brand__text">
        <span class="brand__name">Fonju<em>Law Firm</em></span>
        <span class="brand__sub">Douala · Cameroon</span>
      </span>
    </a>

    <nav class="nav" id="primaryNav" aria-label="Primary">
      <ul class="nav__list">
        <?php foreach (nav_items() as $item): ?>
          <?php
          $inSection = is_current($item['file']);
          // aria-current="page" is only correct on the exact page; a practice
          // area or article is merely inside the section, so it gets the
          // highlight without the attribute.
          $isExact = is_current(is_array($item['file']) ? $item['file'][0] : $item['file']);
          ?>
          <li>
            <a class="nav__link<?= $inSection ? ' is-active' : '' ?>"
               href="<?= e($item['href']) ?>"<?= $isExact ? ' aria-current="page"' : '' ?>>
              <?= e($item['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="site-header__actions">
      <a class="btn btn--gold btn--sm" href="<?= e(url('contact.php')) ?>#consultation">
        Book a Consultation <?= icon('arrow', 16) ?>
      </a>
      <button class="nav-toggle" id="navToggle" type="button"
              aria-expanded="false" aria-controls="mobileNav" aria-label="Open menu">
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
      </button>
    </div>
  </div>
</header>

<div class="mobile-nav" id="mobileNav" hidden>
  <div class="mobile-nav__inner">
    <ul class="mobile-nav__list">
      <?php foreach (nav_items() as $i => $item): ?>
        <li style="--i:<?= $i ?>">
          <a class="mobile-nav__link<?= is_current($item['file']) ? ' is-active' : '' ?>" href="<?= e($item['href']) ?>">
            <span class="mobile-nav__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <?= e($item['label']) ?>
            <?= icon('arrow', 18) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="mobile-nav__foot">
      <a class="btn btn--gold btn--block" href="<?= e(url('contact.php')) ?>#consultation">Book a Consultation</a>
      <a class="mobile-nav__call" href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= icon('phone', 16) ?> <?= e(CONTACT['phone_primary']) ?></a>
      <?= social_links('socials socials--mobile', 20) ?>
    </div>
  </div>
</div>

<main id="main">
