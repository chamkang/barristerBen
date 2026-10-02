<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * FIRM PHOTOGRAPHS
 * ---------------------------------------------------------------------------
 * Every photograph used on the site, in one place. Files live in
 * assets/img/photos/ (a large copy and, where useful, a phone-sized one).
 * 'focus' is the CSS object-position that keeps faces in frame when a photo
 * is cropped to fit (x% y%).
 *
 * Page heroes pick their photograph in page_hero_photo() below; a page can
 * also choose one with $hero['photo'] = 'key' (or '' for none).
 * ---------------------------------------------------------------------------
 */

const PHOTOS = [
    'team-seated'    => ['file' => 'team-seated-1800.jpg',    'small' => 'team-seated-1000.jpg',    'w' => 1800, 'h' => 1352, 'focus' => '62% 22%',
                         'en' => 'The lawyers of Fonju & Partners Law Firm in court robes, the principal seated in front',
                         'fr' => 'Les avocats du cabinet Fonju & Partners en robe, le titulaire assis au premier rang'],
    'team-suits'     => ['file' => 'team-suits-1400.jpg',     'small' => 'team-suits-800.jpg',      'w' => 1400, 'h' => 1144, 'focus' => '50% 28%',
                         'en' => 'The team of Fonju & Partners Law Firm',
                         'fr' => 'L’équipe du cabinet Fonju & Partners'],
    'team-robes'     => ['file' => 'team-robes-1800.jpg',     'small' => 'team-robes-1000.jpg',     'w' => 1800, 'h' => 1120, 'focus' => '50% 22%',
                         'en' => 'The advocates of Fonju & Partners Law Firm in court robes',
                         'fr' => 'Les avocats du cabinet Fonju & Partners en robe'],
    'team-robes-wig' => ['file' => 'team-robes-wig-1800.jpg', 'small' => 'team-robes-wig-1000.jpg', 'w' => 1800, 'h' => 1034, 'focus' => '58% 20%',
                         'en' => 'The lawyers of Fonju & Partners Law Firm, the principal in a barrister’s wig',
                         'fr' => 'Les avocats du cabinet Fonju & Partners, le titulaire portant la perruque'],
    'team-portrait'  => ['file' => 'team-portrait-900.jpg',   'small' => '',                        'w' => 900,  'h' => 1182, 'focus' => '50% 14%',
                         'en' => 'The lawyers of Fonju & Partners Law Firm, the principal seated',
                         'fr' => 'Les avocats du cabinet Fonju & Partners, le titulaire assis'],
    'team-close'     => ['file' => 'team-portrait-top-800.jpg', 'small' => '',                      'w' => 800,  'h' => 526,  'focus' => '50% 30%',
                         'en' => 'The lawyers of Fonju & Partners Law Firm',
                         'fr' => 'Les avocats du cabinet Fonju & Partners'],
    'founder-robe'   => ['file' => 'founder-robe-720.jpg',    'small' => '',                        'w' => 720,  'h' => 1080, 'focus' => '50% 16%',
                         'en' => 'Bar. Fonju Bernard Fuelancha, founder of Fonju & Partners Law Firm, in court robes',
                         'fr' => 'Me Fonju Bernard Fuelancha, fondateur du cabinet Fonju & Partners, en robe'],
    'founder-suit'   => ['file' => 'founder-suit-720.jpg',    'small' => '',                        'w' => 720,  'h' => 1080, 'focus' => '50% 14%',
                         'en' => 'Bar. Fonju Bernard Fuelancha, founder of Fonju & Partners Law Firm',
                         'fr' => 'Me Fonju Bernard Fuelancha, fondateur du cabinet Fonju & Partners'],
    'founder-seated' => ['file' => 'founder-seated-720.jpg',  'small' => '',                        'w' => 720,  'h' => 1080, 'focus' => '50% 18%',
                         'en' => 'Bar. Fonju Bernard Fuelancha, founder of Fonju & Partners Law Firm',
                         'fr' => 'Me Fonju Bernard Fuelancha, fondateur du cabinet Fonju & Partners'],
];

/** An <img> for a photograph from the catalogue. */
function photo_img(string $key, string $sizes = '100vw', string $class = '', bool $lazy = true): string
{
    $p = PHOTOS[$key] ?? null;
    if ($p === null) {
        return '';
    }
    $src    = asset('img/photos/' . $p['file']);
    $srcset = $p['small'] !== '' ? asset('img/photos/' . $p['small']) . ' ' . (int) preg_replace('/\D+/', '', $p['small']) . 'w, ' . $src . ' ' . $p['w'] . 'w' : '';

    return '<img' . ($class !== '' ? ' class="' . e($class) . '"' : '')
        . ' src="' . e($src) . '"'
        . ($srcset !== '' ? ' srcset="' . e($srcset) . '" sizes="' . e($sizes) . '"' : '')
        . ' width="' . $p['w'] . '" height="' . $p['h'] . '"'
        . ($lazy ? ' loading="lazy"' : ' fetchpriority="high"')
        . ' style="object-position:' . e($p['focus']) . '"'
        . ' alt="' . e($p[lang()] ?? $p['en']) . '">';
}

/**
 * Which photograph a page's hero shows. Rotates through the catalogue so the
 * site never repeats the same picture on neighbouring pages.
 */
function page_hero_photo(): string
{
    $script = basename($_SERVER['SCRIPT_NAME'] ?? '');

    $byPage = [
        'about.php'                 => 'team-suits',
        'practice-areas.php'        => 'team-robes-wig',
        'team.php'                  => 'team-portrait',
        'blog.php'                  => 'founder-seated',
        'faq.php'                   => 'founder-robe',
        'contact.php'               => 'team-robes',
        'international-clients.php' => 'team-robes-wig',
        'privacy.php'               => 'team-suits',
        'legal-notice.php'          => 'team-robes',
        '404.php'                   => 'team-close',
    ];
    if (isset($byPage[$script])) {
        return $byPage[$script];
    }

    // Practice areas and articles: a stable choice per page from a rotation.
    $rotation = ['team-robes', 'founder-robe', 'team-suits', 'team-close', 'team-robes-wig', 'founder-suit', 'team-portrait'];
    $seed = (string) ($_GET['area'] ?? $_GET['p'] ?? $script);

    return $rotation[crc32($seed) % count($rotation)];
}
