<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * LANGUAGES
 * ---------------------------------------------------------------------------
 * The site is published in English (at the root) and French (under /fr/).
 *
 *   - English pages are the PHP files at the root; French pages are the files
 *     in fr/, which call set_lang('fr') before anything else.
 *   - url() and abs_url() are language-aware: while a French page renders,
 *     url('about.php') returns /fr/about.php, so templates never hard-code
 *     the language prefix. Asset, feed and sitemap URLs are never prefixed.
 *   - t() translates the short interface strings shared by every page (menus,
 *     buttons, footer). Page copy lives in the page templates themselves, and
 *     long-form content in the data files and content/ folder.
 * ---------------------------------------------------------------------------
 */

const LANGS = ['en', 'fr'];

function set_lang(string $lang): void
{
    $GLOBALS['fonju_lang'] = in_array($lang, LANGS, true) ? $lang : 'en';
}

function lang(): string
{
    return $GLOBALS['fonju_lang'] ?? 'en';
}

function is_fr(): bool
{
    return lang() === 'fr';
}

/**
 * Site-relative path for $path in $lang (default: the current language).
 * Returned without a leading slash.
 */
function lang_path(string $path, ?string $lang = null): string
{
    $lang ??= lang();
    $p = ltrim($path, '/');

    if ($lang !== 'fr' || preg_match('~^(assets/|admin/|feed\.php|sitemap\.php|llms\.(php|txt)|robots\.txt)~', $p)) {
        return $p;
    }

    if ($p === '' || $p === 'index.php') {
        return 'fr';
    }
    if (str_starts_with($p, '#') || str_starts_with($p, 'index.php#')) {
        return 'fr' . substr($p, (int) strpos($p, '#'));
    }

    return 'fr/' . $p;
}

/** Translate a shared interface string. The English text is the key. */
function t(string $text): string
{
    static $fr = null;

    if (!is_fr()) {
        return $text;
    }

    $fr ??= require __DIR__ . '/lang/fr.php';

    return $fr[$text] ?? $text;
}

/** A date in the current language: 18 August 2026 / 18 août 2026. */
function fmt_date(string $ymd): string
{
    $ts = strtotime($ymd) ?: time();

    if (!is_fr()) {
        return date('j F Y', $ts);
    }

    $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet',
               'août', 'septembre', 'octobre', 'novembre', 'décembre'];
    $day = (int) date('j', $ts);

    return ($day === 1 ? '1er' : (string) $day) . ' ' . $months[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
}

/** Month and year, for "last reviewed" notes. */
function fmt_month(?int $ts = null): string
{
    $ts ??= time();

    if (!is_fr()) {
        return date('F Y', $ts);
    }

    $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet',
               'août', 'septembre', 'octobre', 'novembre', 'décembre'];

    return $months[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
}

/** A contact detail from config.php, localised where the wording differs. */
function contact(string $key): string
{
    $value = CONTACT[$key] ?? '';

    return match ($key) {
        'country' => t($value),
        'po_box'  => is_fr() ? str_replace('P.O. Box', 'B.P.', $value) : $value,
        default   => $value,
    };
}

/** URL-safe ASCII slug: "Créer une société" -> "creer-une-societe". */
function slugify(string $text): string
{
    $text = strtr(mb_strtolower($text), [
        'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ê' => 'e',
        'ë' => 'e', 'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ô' => 'o', 'ö' => 'o', 'ó' => 'o', 'ù' => 'u',
        'û' => 'u', 'ü' => 'u', 'ú' => 'u', 'ÿ' => 'y', 'ñ' => 'n', 'œ' => 'oe', 'æ' => 'ae',
        '’' => '-', "'" => '-',
    ]);

    return trim((string) preg_replace('/[^a-z0-9]+/', '-', $text), '-');
}

/** The <html lang> / hreflang code and the Open Graph locale for a language. */
function lang_meta(?string $lang = null): array
{
    return ($lang ?? lang()) === 'fr'
        ? ['code' => 'fr', 'locale' => 'fr_CM', 'name' => 'Français']
        : ['code' => 'en', 'locale' => 'en_CM', 'name' => 'English'];
}
