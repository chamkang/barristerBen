<?php
declare(strict_types=1);

/** Escape for HTML output. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

require_once __DIR__ . '/i18n.php';

/**
 * Build a site-root-relative URL that also works inside an XAMPP sub-folder.
 * Page URLs follow the current language (see includes/i18n.php).
 */
function url(string $path = '/'): string
{
    return BASE_PATH . '/' . lang_path($path);
}

/** url() for a specific language — language switcher and hreflang links. */
function url_in(string $path, string $lang): string
{
    return BASE_PATH . '/' . lang_path($path, $lang);
}

/** Absolute URL — canonical tags, sitemap, structured data. */
function abs_url(string $path = '/'): string
{
    return SITE_URL . '/' . lang_path($path);
}

function abs_url_in(string $path, string $lang): string
{
    return SITE_URL . '/' . lang_path($path, $lang);
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

/**
 * True when the currently executing script belongs to this nav item.
 * $file may be a single script or a list, so that a detail page highlights
 * its section — a practice area lights up "Practice Areas", an article
 * lights up "Insights".
 */
function is_current(string|array $file): bool
{
    $current = basename($_SERVER['SCRIPT_NAME'] ?? '');

    return in_array($current, (array) $file, true);
}

/** Primary navigation. */
function nav_items(): array
{
    return [
        ['label' => t('Home'),           'file' => 'index.php',                                  'href' => url('/')],
        ['label' => t('About'),          'file' => 'about.php',                                  'href' => url('about.php')],
        ['label' => t('Practice Areas'), 'file' => ['practice-areas.php', 'practice-area.php'],  'href' => url('practice-areas.php')],
        ['label' => t('Our Team'),       'file' => 'team.php',                                   'href' => url('team.php')],
        ['label' => t('Insights'),       'file' => ['blog.php', 'post.php'],                     'href' => url('blog.php')],
        ['label' => t('FAQ'),            'file' => 'faq.php',                                    'href' => url('faq.php')],
        ['label' => t('Contact'),        'file' => 'contact.php',                                'href' => url('contact.php')],
    ];
}

/** Social profiles that have a real URL configured (used for schema sameAs). */
function active_socials(): array
{
    return array_filter(SOCIALS, static fn(array $s): bool => $s['url'] !== '' && $s['url'] !== '#');
}

/**
 * Inline SVG icon set — inline rather than an icon font so the icons inherit
 * colour, cost no extra requests and stay crisp at any size.
 */
function icon(string $name, int $size = 20): string
{
    static $paths = null;

    if ($paths === null) {
        $paths = [
            'linkedin'  => '<path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.42v1.56h.05a3.75 3.75 0 0 1 3.37-1.85c3.6 0 4.27 2.37 4.27 5.46zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13M7.12 20.45H3.55V9h3.57zM22.22 0H1.77C.79 0 0 .77 0 1.72v20.55C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.72C24 .77 23.2 0 22.22 0"/>',
            'facebook'  => '<path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07"/>',
            'instagram' => '<path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.64.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85C2.38 3.92 3.89 2.38 7.15 2.23 8.42 2.18 8.8 2.16 12 2.16M12 0C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0m0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32M12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8m6.4-11.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88"/>',
            'tiktok'    => '<path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97a10 10 0 0 1-1.62-.93c-.01 2.92.01 5.84-.02 8.75a7.6 7.6 0 0 1-1.35 3.93 7.44 7.44 0 0 1-5.9 3.2 7.3 7.3 0 0 1-4.08-1.03A7.55 7.55 0 0 1 .5 17.24c-.02-.5-.03-1-.01-1.49a7.53 7.53 0 0 1 8.73-6.68c.02 1.48-.04 2.96-.04 4.44a3.43 3.43 0 0 0-4.38 2.12 3.97 3.97 0 0 0-.14 1.61 3.4 3.4 0 0 0 3.5 2.87 3.36 3.36 0 0 0 2.77-1.61c.22-.31.46-.94.47-1.32.1-1.72.06-3.43.07-5.15.01-3.87-.01-7.73.02-11.6z"/>',
            'x'         => '<path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.41l-5.8-7.58-6.64 7.58H.46l8.6-9.83L0 1.15h7.59l5.24 6.93zm-1.29 19.5h2.04L6.49 3.24H4.3z"/>',
            'whatsapp'  => '<path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96s-.47-.15-.67.15-.77.96-.94 1.16-.35.22-.64.08a8 8 0 0 1-2.38-1.47 9 9 0 0 1-1.65-2.05c-.17-.3-.02-.46.13-.6.14-.14.3-.35.45-.53s.2-.3.3-.5.05-.38-.03-.53-.67-1.61-.92-2.2c-.24-.58-.48-.5-.67-.51h-.56c-.2 0-.52.07-.79.37s-1.03 1-1.03 2.46 1.06 2.85 1.2 3.05 2.08 3.18 5.04 4.46c.7.3 1.25.49 1.68.62.71.23 1.35.2 1.86.12.57-.09 1.75-.72 2-1.41s.25-1.28.17-1.41-.27-.2-.56-.35M12.05 21.8h-.01a9.9 9.9 0 0 1-5.03-1.38l-.36-.21-3.74.98 1-3.65-.24-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.89 9.9-9.89a9.86 9.86 0 0 1 9.88 9.9c0 5.45-4.44 9.88-9.89 9.88M20.52 3.45A11.8 11.8 0 0 0 12.05 0C5.5 0 .17 5.33.17 11.88c0 2.1.55 4.14 1.6 5.95L.07 24l6.33-1.66a11.9 11.9 0 0 0 5.65 1.44h.01c6.55 0 11.88-5.33 11.88-11.88a11.8 11.8 0 0 0-3.47-8.4"/>',
            'phone'     => '<path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.2 1z"/>',
            'mail'      => '<path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2m0 4-8 5-8-5V6l8 5 8-5z"/>',
            'pin'       => '<path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7m0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5"/>',
            'clock'     => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20m4.2 14.2-5.2-3.2V7h1.5v5.2l4.5 2.7z"/>',
            'arrow'     => '<path d="M13.2 5.2 11.8 6.6l4.4 4.4H3v2h13.2l-4.4 4.4 1.4 1.4L20 12z"/>',
            'check'     => '<path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/>',
            'plus'      => '<path d="M11 5h2v6h6v2h-6v6h-2v-6H5v-2h6z"/>',
            'quote'     => '<path d="M7.2 6C4.9 7.5 3.5 10 3.5 13v5h6.6v-6.6H7.3c0-1.6.7-2.8 2.2-3.7zm10.5 0c-2.3 1.5-3.7 4-3.7 7v5h6.6v-6.6h-2.8c0-1.6.7-2.8 2.2-3.7z"/>',
            'scale'     => '<path d="M12 2a1 1 0 0 1 1 1v1.2l6.3 1.6-.5 1.9-1.6-.4L20 13a4 4 0 0 1-8 0l2.8-5.7-1.8-.5V19h4v2H7v-2h4V6.8l-1.8.5L12 13a4 4 0 0 1-8 0l2.8-5.7-1.6.4-.5-1.9L11 4.2V3a1 1 0 0 1 1-1M8 8.9 6.1 12.8h3.8zm8 0-1.9 3.9h3.8z"/>',
            'shield'    => '<path d="M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5zm-1 14-4-4 1.4-1.4L11 13.2l4.6-4.6L17 10z"/>',
            'globe'     => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20m6.9 6h-2.95a15.6 15.6 0 0 0-1.38-3.56A8.03 8.03 0 0 1 18.92 8M12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96M4.26 14a7.8 7.8 0 0 1 0-4h3.38a16.5 16.5 0 0 0 0 4zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.99 7.99 0 0 1 5.08 16m2.95-8H5.08a7.99 7.99 0 0 1 4.33-3.56A15.6 15.6 0 0 0 8.03 8M12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82A13.7 13.7 0 0 1 12 19.96M14.34 14H9.66a14.7 14.7 0 0 1 0-4h4.68a14.7 14.7 0 0 1 0 4m.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 0 1-4.33 3.56M16.36 14a16.5 16.5 0 0 0 0-4h3.38a7.8 7.8 0 0 1 0 4z"/>',
            'users'     => '<path d="M16 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8m-8 0a4 4 0 1 0 0-8 4 4 0 0 0 0 8m0 2c-2.67 0-8 1.34-8 4v3h10v-3c0-1.1.55-2.05 1.4-2.76A14 14 0 0 0 8 13m8 0c-.35 0-.74.02-1.16.06A5.1 5.1 0 0 1 17 17v3h7v-3c0-2.66-5.33-4-8-4"/>',
            'doc'       => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm2 16H8v-2h8zm0-4H8v-2h8zm-3-5V3.5L18.5 9z"/>',
            'chevron'   => '<path d="m8.6 5.6 6.4 6.4-6.4 6.4L7.2 17l5-5-5-5z"/>',
            'menu'      => '<path d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z"/>',
            'close'     => '<path d="M19 6.4 17.6 5 12 10.6 6.4 5 5 6.4 10.6 12 5 17.6 6.4 19 12 13.4 17.6 19 19 17.6 13.4 12z"/>',
            'star'      => '<path d="m12 17.3-6.2 3.7 1.6-7L2 9.2l7.2-.6L12 2l2.8 6.6 7.2.6-5.4 4.8 1.6 7z"/>',
            'search'    => '<path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14"/>',
            'gavel'     => '<path d="M1 21h12v2H1zM5.24 8.07l2.83-2.83 14.14 14.14-2.83 2.83zM12.32 1l5.66 5.66-2.83 2.83-5.66-5.66zM3.83 9.49l5.66 5.65-2.83 2.83-5.66-5.66z"/>',
            'building'  => '<path d="M3 21V7l7-4 7 4v3h4v11h-7v-4h-4v4zm5-6h2v-2H8zm0-4h2V9H8zm4 4h2v-2h-2zm0-4h2V9h-2z"/>',
            'spark'     => '<path d="M12 2l1.8 5.4L19 9l-5.2 1.6L12 16l-1.8-5.4L5 9l5.2-1.6zM19 14l.9 2.6L22 17.5l-2.1.9L19 21l-.9-2.6-2.1-.9 2.1-.9z"/>',
        ];
    }

    $d = $paths[$name] ?? '';

    return '<svg class="ico ico--' . e($name) . '" width="' . $size . '" height="' . $size
         . '" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">' . $d . '</svg>';
}

/**
 * The firm's mark: an antique key whose bit forms an F, with the scales of
 * justice inside its ring. The key takes the surrounding text colour; the
 * scales use .brand__scales (gold). This is the simplified master, drawn for
 * screen sizes; the detailed artwork lives in assets/img/brand/.
 */
function brand_mark(int $height = 46): string
{
    $width = (int) round($height * 104 / 182);

    return '<svg class="brand-key" width="' . $width . '" height="' . $height . '" viewBox="52 14 104 182"'
         . ' fill="currentColor" aria-hidden="true" focusable="false">'
         . '<path d="M80 20H150V42H138V34H130V42H96V66H132V86H96V132H80Z"/>'
         . '<rect x="74" y="98" width="28" height="7" rx="2"/><rect x="74" y="124" width="28" height="7" rx="2"/>'
         . '<path d="M80 131H96L94 136H82Z"/>'
         . '<circle cx="88" cy="160" r="26" fill="none" stroke="currentColor" stroke-width="10"/>'
         . '<g class="brand__scales">'
         . '<path d="M88 146V172M80 174H96M74 150H102" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>'
         . '<path d="M76 150 72 160M76 150 80 160M100 150 96 160M100 150 104 160" fill="none" stroke="currentColor" stroke-width="1.8"/>'
         . '<path d="M70 160H82Q80 165 76 165Q72 165 70 160ZM94 160H106Q104 165 100 165Q96 165 94 160Z"/>'
         . '</g></svg>';
}

/** Render the social icon row used in the header, footer and contact page. */
function social_links(string $class = 'socials', int $size = 18): string
{
    $out = '<ul class="' . e($class) . '" aria-label="' . e(SITE_NAME . ' ' . t('on social media')) . '">';

    foreach (SOCIALS as $key => $s) {
        $live = $s['url'] !== '' && $s['url'] !== '#';
        $out .= '<li><a class="socials__link" href="' . e($s['url']) . '"'
              . ($live ? ' target="_blank"' : '')
              . ' rel="' . ($live ? 'noopener' : 'nofollow noopener') . '"'
              . ' data-network="' . e($key) . '"'
              . ' aria-label="' . e(SITE_NAME . ' ' . t('on') . ' ' . $s['label']) . '">'
              . icon($key, $size)
              . '<span class="socials__name">' . e($s['label']) . '</span></a></li>';
    }

    return $out . '</ul>';
}

function whatsapp_url(?string $text = null): string
{
    $text ??= t('Hello Fonju Law Firm, I would like to request a consultation.');

    return 'https://wa.me/' . CONTACT['whatsapp'] . '?text=' . rawurlencode($text);
}

function tel_href(string $number): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', $number);
}

function full_address(string $sep = ', '): string
{
    return implode($sep, [contact('street'), contact('po_box'), contact('city'), contact('country')]);
}

/** Opening hours with the day and time wording in the current language. */
function opening_hours(): array
{
    return array_map(static fn(array $slot): array => ['days' => t($slot['days']), 'hours' => t($slot['hours'])] + $slot, OPENING_HOURS);
}

/** Rough reading time for an article body. */
function reading_time(string $html): int
{
    return max(1, (int) ceil(str_word_count(strip_tags($html)) / 200));
}

function excerpt(string $text, int $words = 28): string
{
    $parts = preg_split('/\s+/u', trim(strip_tags($text))) ?: [];

    if (count($parts) <= $words) {
        return implode(' ', $parts);
    }

    return implode(' ', array_slice($parts, 0, $words)) . '…';
}

/** CSRF token for the contact form. */
function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function csrf_valid(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    return is_string($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}
