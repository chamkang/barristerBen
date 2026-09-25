<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * CONTENT FILES — front matter + Markdown
 * ---------------------------------------------------------------------------
 * Articles live in content/insights/{en,fr}/*.md, written either by hand or
 * through the online editor at /admin (see the README). Each file is:
 *
 *   ---
 *   title: Registering a Company in Cameroon
 *   date: 2026-08-18
 *   category: Corporate
 *   tags:
 *     - OHADA
 *   ---
 *   The article body, in Markdown.
 *
 * Only the small subset of YAML and Markdown that the editor produces is
 * supported, which keeps this dependency-free.
 * ---------------------------------------------------------------------------
 */

/** Split a content file into [front matter array, Markdown body]. */
function parse_content_file(string $raw): array
{
    $raw = str_replace(["\r\n", "\r"], "\n", $raw);
    $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw) ?? $raw;

    if (!preg_match('/^---\n(.*?)\n---\n?(.*)$/s', $raw, $m)) {
        return [[], $raw];
    }

    return [parse_front_matter($m[1]), $m[2]];
}

/**
 * Minimal YAML reader: scalar keys, quoted strings, booleans, numbers,
 * block scalars (| and >), and lists written either as "- item" lines or
 * inline as [a, b].
 */
function parse_front_matter(string $yaml): array
{
    $lines = explode("\n", $yaml);
    $data  = [];
    $count = count($lines);

    for ($i = 0; $i < $count; $i++) {
        $line = $lines[$i];

        if (trim($line) === '' || str_starts_with(ltrim($line), '#')) {
            continue;
        }
        if (!preg_match('/^([A-Za-z0-9_\-]+):\s*(.*)$/', $line, $m)) {
            continue;
        }

        [$key, $value] = [$m[1], rtrim($m[2])];

        // Block scalar: | keeps line breaks, > folds them into spaces.
        if (preg_match('/^([|>])[+-]?$/', $value, $b)) {
            $block = [];
            while ($i + 1 < $count && ($lines[$i + 1] === '' || preg_match('/^\s+/', $lines[$i + 1]))) {
                $block[] = preg_replace('/^\s{2}/', '', $lines[++$i]);
            }
            $text = $b[1] === '|' ? implode("\n", $block) : preg_replace('/\s*\n\s*/', ' ', implode("\n", $block));
            $data[$key] = trim((string) $text);
            continue;
        }

        // Block list: following lines of the form "  - item".
        if ($value === '') {
            $items = [];
            while ($i + 1 < $count && preg_match('/^\s*-\s+(.*)$/', $lines[$i + 1], $li)) {
                $items[] = yaml_scalar($li[1]);
                $i++;
            }
            $data[$key] = $items;
            continue;
        }

        // Inline list: [a, "b, c", d]
        if (str_starts_with($value, '[') && str_ends_with($value, ']')) {
            $inner = trim(substr($value, 1, -1));
            $data[$key] = $inner === '' ? [] : array_map(
                'yaml_scalar',
                str_getcsv($inner, ',', '"', '\\')
            );
            continue;
        }

        $data[$key] = yaml_scalar($value);
    }

    return $data;
}

function yaml_scalar(string $v): mixed
{
    $v = trim($v);

    if ($v === '' || $v === '~' || $v === 'null') {
        return '';
    }
    if ($v === 'true' || $v === 'false') {
        return $v === 'true';
    }
    if (strlen($v) >= 2 && $v[0] === '"' && str_ends_with($v, '"')) {
        return stripcslashes(substr($v, 1, -1));
    }
    if (strlen($v) >= 2 && $v[0] === "'" && str_ends_with($v, "'")) {
        return str_replace("''", "'", substr($v, 1, -1));
    }

    return $v;
}

/**
 * Markdown to HTML. Supports headings, paragraphs, bulleted and numbered
 * lists, block quotes, horizontal rules, images, links, bold, italics,
 * strike-through, inline code and hard line breaks. Lines that start with a
 * block-level HTML tag are passed through untouched.
 */
function markdown_to_html(string $md): string
{
    $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", trim($md)));
    $html  = [];
    $n     = count($lines);
    $i     = 0;

    $isBlockStart = static function (string $l): bool {
        return (bool) preg_match('/^(#{1,6}\s|>|\s*[-*+]\s+|\s*\d+[.)]\s+|(\*\s*){3,}$|(-\s*){3,}$|(_\s*){3,}$|<\/?(p|div|h[1-6]|ul|ol|li|blockquote|figure|table|iframe|hr|section|aside)\b)/i', $l);
    };

    while ($i < $n) {
        $line = $lines[$i];

        if (trim($line) === '') {
            $i++;
            continue;
        }

        // Headings. A single # is demoted to h2: the page title is the h1.
        if (preg_match('/^(#{1,6})\s+(.+?)\s*#*$/', $line, $m)) {
            $level = max(2, min(6, strlen($m[1])));
            $html[] = "<h{$level}>" . md_inline($m[2]) . "</h{$level}>";
            $i++;
            continue;
        }

        // Horizontal rule
        if (preg_match('/^((\*\s*){3,}|(-\s*){3,}|(_\s*){3,})$/', trim($line))) {
            $html[] = '<hr>';
            $i++;
            continue;
        }

        // Raw HTML block
        if (preg_match('/^<\/?(p|div|h[1-6]|ul|ol|blockquote|figure|table|iframe|hr|section|aside)\b/i', $line)) {
            $block = [];
            while ($i < $n && trim($lines[$i]) !== '') {
                $block[] = $lines[$i++];
            }
            $html[] = implode("\n", $block);
            continue;
        }

        // Block quote
        if (str_starts_with($line, '>')) {
            $block = [];
            while ($i < $n && (str_starts_with($lines[$i], '>') || (trim($lines[$i]) !== '' && $block !== [] && !$isBlockStart($lines[$i])))) {
                $block[] = preg_replace('/^>\s?/', '', $lines[$i++]);
            }
            $html[] = '<blockquote>' . markdown_to_html(implode("\n", $block)) . '</blockquote>';
            continue;
        }

        // Lists
        if (preg_match('/^\s*([-*+]|\d+[.)])\s+/', $line, $m)) {
            $ordered = ctype_digit($m[1][0]);
            $pattern = $ordered ? '/^\s*\d+[.)]\s+(.*)$/' : '/^\s*[-*+]\s+(.*)$/';
            $items   = [];

            while ($i < $n) {
                if (preg_match($pattern, $lines[$i], $li)) {
                    $items[] = $li[1];
                    $i++;
                } elseif (trim($lines[$i]) !== '' && $items !== [] && preg_match('/^\s{2,}\S/', $lines[$i])) {
                    $items[count($items) - 1] .= ' ' . trim($lines[$i]);   // wrapped continuation line
                    $i++;
                } elseif (trim($lines[$i]) === '' && $i + 1 < $n && preg_match($pattern, $lines[$i + 1])) {
                    $i++;                                                 // loose list: blank line between items
                } else {
                    break;
                }
            }

            $tag = $ordered ? 'ol' : 'ul';
            $html[] = "<{$tag}>\n" . implode("\n", array_map(static fn(string $t): string => '<li>' . md_inline($t) . '</li>', $items)) . "\n</{$tag}>";
            continue;
        }

        // Paragraph: consecutive lines up to a blank line or another block.
        $para = [];
        while ($i < $n && trim($lines[$i]) !== '' && ($para === [] || !$isBlockStart($lines[$i]))) {
            $para[] = $lines[$i++];
        }

        $text = '';
        foreach ($para as $k => $p) {
            $hardBreak = preg_match('/(  |\\\\)$/', $p) === 1 && $k < count($para) - 1;
            $text .= rtrim($p, " \\") . ($hardBreak ? "\u{0}BR\u{0}" : ' ');
        }

        $inline = str_replace("\u{0}BR\u{0}", '<br>', md_inline(trim($text)));

        // A paragraph that is only an image becomes a figure.
        if (preg_match('/^<img [^>]+>$/', $inline)) {
            $html[] = '<figure class="prose__figure">' . $inline . '</figure>';
        } else {
            $html[] = '<p>' . $inline . '</p>';
        }
    }

    return implode("\n", $html);
}

/** Inline Markdown. Text is HTML-escaped first; formatting is then applied. */
function md_inline(string $text): string
{
    // Protect backslash escapes and code spans from further processing.
    $stash = [];
    $keep  = static function (string $html) use (&$stash): string {
        $stash[] = $html;
        return "\u{1}" . (count($stash) - 1) . "\u{1}";
    };

    $text = preg_replace_callback('/\\\\([\\\\`*_{}\[\]()#+\-.!>~|])/', static fn(array $m): string => $keep(e($m[1])), $text) ?? $text;
    $text = preg_replace_callback('/`([^`]+)`/', static fn(array $m): string => $keep('<code>' . e($m[1]) . '</code>'), $text) ?? $text;

    // Images and links, before escaping so the URLs survive intact.
    $text = preg_replace_callback('/!\[([^\]]*)\]\(\s*<?([^)\s>]+)>?(?:\s+"([^"]*)")?\s*\)/', static function (array $m) use ($keep): string {
        $src = md_safe_url($m[2]);
        $title = isset($m[3]) && $m[3] !== '' ? ' title="' . e($m[3]) . '"' : '';
        return $keep('<img src="' . e($src) . '" alt="' . e($m[1]) . '"' . $title . ' loading="lazy">');
    }, $text) ?? $text;

    $text = preg_replace_callback('/\[([^\]]+)\]\(\s*<?([^)\s>]+)>?(?:\s+"([^"]*)")?\s*\)/', static function (array $m) use ($keep): string {
        $href  = md_safe_url($m[2]);
        $ext   = preg_match('~^https?://~i', $href) && !str_starts_with($href, SITE_URL);
        $attrs = $ext ? ' target="_blank" rel="noopener"' : '';
        return $keep('<a href="' . e($href) . '"' . $attrs . '>') . $m[1] . $keep('</a>');
    }, $text) ?? $text;

    // Bare URLs in angle brackets: <https://example.com>
    $text = preg_replace_callback('/<(https?:\/\/[^>\s]+)>/', static fn(array $m): string => $keep('<a href="' . e($m[1]) . '" target="_blank" rel="noopener">' . e($m[1]) . '</a>'), $text) ?? $text;

    $text = e($text);

    $text = preg_replace('/\*\*(?=\S)(.+?)(?<=\S)\*\*/s', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/__(?=\S)(.+?)(?<=\S)__/s', '<strong>$1</strong>', $text) ?? $text;
    $text = preg_replace('/(?<![*\w])\*(?=\S)(.+?)(?<=\S)\*(?![*\w])/s', '<em>$1</em>', $text) ?? $text;
    $text = preg_replace('/(?<![_\w])_(?=\S)(.+?)(?<=\S)_(?![_\w])/s', '<em>$1</em>', $text) ?? $text;
    $text = preg_replace('/~~(?=\S)(.+?)(?<=\S)~~/s', '<del>$1</del>', $text) ?? $text;

    return preg_replace_callback("/\u{1}(\d+)\u{1}/", static fn(array $m): string => $stash[(int) $m[1]], $text) ?? $text;
}

/**
 * Reject javascript: and similar URL schemes in author-supplied links, and
 * anchor site-root paths (/assets/img/…) to the install folder.
 */
function md_safe_url(string $url): string
{
    if (preg_match('~^\s*(javascript|vbscript|data):~i', $url)) {
        return '#';
    }

    return str_starts_with($url, '/') && !str_starts_with($url, '//') ? BASE_PATH . $url : $url;
}
