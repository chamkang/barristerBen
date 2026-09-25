<?php
declare(strict_types=1);

/**
 * llms.txt: a plain-language summary of the firm for AI assistants and
 * answer engines (https://llmstxt.org). Generated from the same data as the
 * site, so it never goes out of date. Published at /llms.txt (the static build
 * writes dist/llms.txt; .htaccess maps /llms.txt here on a PHP host).
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';
require_once __DIR__ . '/includes/data-blog.php';
require_once __DIR__ . '/includes/data-faq.php';
require_once __DIR__ . '/includes/data-team.php';

header('Content-Type: text/plain; charset=utf-8');
header('X-Robots-Tag: noindex');

set_lang('en');

$lines   = [];
$line    = static function (string $s = '') use (&$lines): void { $lines[] = $s; };
$oneLine = static fn(string $s): string => trim((string) preg_replace('/\s+/u', ' ', strip_tags($s)));

$founder = team_members()[0] ?? null;

$line('# ' . SITE_NAME);
$line();
$line('> ' . SEO_DEFAULTS['description']);
$line();
$line('Fonju Law Firm is a law firm and legal consultancy in Douala, Cameroon. It advises companies, investors and individuals, in English and French, on Cameroonian law and on the OHADA and CEMAC regional frameworks. It acts as local counsel for foreign clients entering Cameroon and Central Africa.');
$line();
$line('## Key facts');
$line();
$line('- Name: ' . SITE_NAME . ' (' . SITE_LEGALNAME . ')');
$line('- Founded: ' . SITE_FOUNDED);
if ($founder !== null) {
    $line('- Founder and managing partner: ' . $founder['name']);
}
$line('- Office: ' . full_address());
$line('- Telephone: ' . CONTACT['phone_primary'] . ', ' . CONTACT['phone_secondary'] . ' (WhatsApp on the first number)');
$line('- E-mail: ' . CONTACT['email_general']);
$line('- Opening hours: ' . implode('; ', array_map(static fn(array $s): string => $s['days'] . ' ' . $s['hours'], OPENING_HOURS)));
$line('- Languages: English and French');
$line('- Jurisdictions: Cameroon (common law in the North West and South West regions, civil law elsewhere), the 17 OHADA member states, the CEMAC zone');
$line('- Website: ' . abs_url('') . ' (English) and ' . abs_url_in('', 'fr') . ' (French)');
$line('- Enquiries: answered within one business day; urgent matters the same day');
$line();

$line('## Practice areas');
$line();
foreach (practice_areas() as $area) {
    $line('- [' . $area['title'] . '](' . abs_url('practice-area.php?area=' . $area['slug']) . '): ' . $oneLine($area['short']));
}
$line();

$line('## Articles');
$line();
foreach (blog_posts('en') as $post) {
    $line('- [' . $post['title'] . '](' . abs_url('post.php?p=' . $post['slug']) . '): ' . $oneLine($post['excerpt']));
}
$line();

$line('## About the firm');
$line();
$line('- [About](' . abs_url('about.php') . '): mission, approach and where the firm works');
$line('- [Team](' . abs_url('team.php') . '): the firm\'s lawyers');
$line('- [Frequently asked questions](' . abs_url('faq.php') . '): fees, consultations, company formation, land, employment, disputes and foreign investment');
$line('- [Contact](' . abs_url('contact.php') . '): address, telephone, WhatsApp and enquiry form');
$line();

$line('## En français');
$line();
$line('- [Accueil](' . abs_url_in('', 'fr') . '): le cabinet Fonju, cabinet d’avocats en droit des affaires à Douala');
$line('- [Domaines d’expertise](' . abs_url_in('practice-areas.php', 'fr') . ')');
$line('- [Questions fréquentes](' . abs_url_in('faq.php', 'fr') . ')');
$line('- [Contact](' . abs_url_in('contact.php', 'fr') . ')');
foreach (blog_posts('fr') as $post) {
    $line('- [' . $post['title'] . '](' . abs_url_in('post.php?p=' . $post['slug'], 'fr') . ')');
}
$line();

$line('## Optional');
$line();
foreach (array_slice(faq_flat(), 0, 8) as $item) {
    $line('- Q: ' . $oneLine($item['q']) . ' A: ' . $oneLine($item['a']));
}
$line();
$line('Note: the content of this website is general information about Cameroonian and OHADA law, not legal advice for a particular situation.');

echo implode("\n", $lines), "\n";
