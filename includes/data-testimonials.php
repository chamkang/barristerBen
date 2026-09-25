<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * CLIENT TESTIMONIALS
 * ---------------------------------------------------------------------------
 * Stored in content/testimonials.json and managed from the online editor
 * (/admin → Testimonials). Each entry:
 *
 *   quote_en, quote_fr   The testimonial in English and/or French. A language
 *                        with no text simply does not show that testimonial.
 *   name                 How the client is described, e.g. "Managing Director"
 *                        (clients are usually not named, for confidentiality)
 *   role_en, role_fr     Context, e.g. "Manufacturing group, Douala"
 *   permission           true only when the client has agreed in writing to
 *                        publication. Entries without it are never shown.
 *
 * The home page section is hidden entirely until at least one testimonial
 * exists for the page's language, so no placeholder is ever published.
 * ---------------------------------------------------------------------------
 */

const TESTIMONIALS_FILE = __DIR__ . '/../content/testimonials.json';

/** Published testimonials for the current language, in the saved order. */
function testimonials(): array
{
    if (!is_file(TESTIMONIALS_FILE)) {
        return [];
    }

    $data = json_decode((string) file_get_contents(TESTIMONIALS_FILE), true);
    $lang = lang();
    $out  = [];

    foreach ((array) ($data['testimonials'] ?? []) as $t) {
        if (!is_array($t) || empty($t['permission'])) {
            continue;
        }

        $quote = trim((string) ($t['quote_' . $lang] ?? ''));
        if ($quote === '') {
            continue;
        }

        $name = trim((string) ($t['name'] ?? '')) ?: (is_fr() ? 'Client du cabinet' : 'Client');
        $role = trim((string) ($t['role_' . $lang] ?? '')) ?: trim((string) ($t['role_en'] ?? $t['role_fr'] ?? ''));

        $out[] = [
            'quote'    => $quote,
            'name'     => $name,
            'role'     => $role,
            'initials' => testimonial_initials($name),
        ];
    }

    return $out;
}

/** "Managing Director" → "MD"; "Private client" → "PC". */
function testimonial_initials(string $name): string
{
    $words = preg_split('/[\s\-—,]+/u', trim($name)) ?: [];
    $letters = '';
    foreach ($words as $word) {
        if ($word !== '' && mb_strlen($letters) < 2) {
            $letters .= mb_strtoupper(mb_substr($word, 0, 1));
        }
    }

    return $letters !== '' ? $letters : '★';
}
