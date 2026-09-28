<?php
/**
 * ---------------------------------------------------------------------------
 * FONJU & PARTNERS LAW FIRM — SITE CONFIGURATION
 * ---------------------------------------------------------------------------
 * This is the ONLY file you need to edit for contact details, social media
 * links, office hours and site-wide SEO defaults.
 * ---------------------------------------------------------------------------
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// 1. SITE IDENTITY
// ---------------------------------------------------------------------------
const SITE_NAME      = 'Fonju & Partners Law Firm';
const SITE_TAGLINE   = 'Corporate & Commercial Law in Cameroon';
const SITE_LEGALNAME = 'Fonju & Partners Law Firm — International Legal Consultancy';
const SITE_FOUNDED   = '2014';

/**
 * IMPORTANT: change this to your live domain before going to production.
 * No trailing slash. Used for canonical URLs, sitemap.xml and Open Graph tags.
 */
const SITE_URL = 'https://fonjulawfirm.com';

/**
 * Clean addresses: /about, /practice/corporate-law, /insights/…, /fr/… instead
 * of about.php and practice-area.php?area=…. They need the rewrite rules in
 * .htaccess (Apache, LiteSpeed — including XAMPP and Namecheap) or
 * tools/dev-server.js. Set to false only on a server without URL rewriting.
 */
const CLEAN_URLS = true;

/**
 * '' when the site lives at the web root, or '/barrister-Ben' for XAMPP.
 * French pages run from fr/, so that folder is stripped to find the site root.
 */
$fonjuDir = str_replace(DIRECTORY_SEPARATOR, '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$fonjuDir = (string) preg_replace('~/fr$~', '', $fonjuDir);
define('BASE_PATH', in_array($fonjuDir, ['', '/', '.'], true) ? '' : rtrim($fonjuDir, '/'));
unset($fonjuDir);

// ---------------------------------------------------------------------------
// 2. CONTACT DETAILS
// ---------------------------------------------------------------------------
const CONTACT = [
    'phone_primary'    => '+237 699 96 41 77',
    'phone_secondary'  => '+237 676 37 11 80',
    'phone_landline'   => '+237 233 43 90 22',
    'whatsapp'         => '237699964177',              // digits only, country code first
    'email_general'    => 'info@fonjulawfirm.com',
    'email_principal'  => 'fonjubernard@fonjulawfirm.com',
    'street'           => 'Rue Pau, Akwa',
    'building'         => '1st floor, Immeuble Froid-Cam',
    'landmark'         => 'Opposite the Bureau des transports',
    'po_box'           => 'P.O. Box 15354',
    'city'             => 'Douala',
    'region'           => 'Littoral',
    'country'          => 'Cameroon',
    'country_code'     => 'CM',
    'latitude'         => '4.0480',
    'longitude'        => '9.7043',
    'map_query'        => 'Immeuble+Froid-Cam+Rue+Pau+Akwa+Douala+Cameroon',
];

// ---------------------------------------------------------------------------
// FIRM REGISTRATION — shown on the legal notice (mentions légales)
// ---------------------------------------------------------------------------
const FIRM_REGISTRATION = [
    'principal'      => 'Fonju Bernard Fuelancha',     // publication director
    'bar'            => 'Cameroon Bar',                // Barreau du Cameroun
    'bar_number'     => '00105A0029',                  // principal's bar registration (matricule)
    'niu'            => 'P066900334100G',              // taxpayer number (N° contribuable / NIU)
    'cnps'           => '351-01048854-S',              // CNPS employer number
];

const OPENING_HOURS = [
    ['days' => 'Monday – Friday', 'hours' => '8:00 AM – 7:30 PM', 'schema' => ['Mo','Tu','We','Th','Fr'], 'open' => '08:00', 'close' => '19:30'],
    ['days' => 'Saturday',        'hours' => '8:00 AM – 12:00 PM', 'schema' => ['Sa'],                    'open' => '08:00', 'close' => '12:00'],
    ['days' => 'Sunday',          'hours' => 'Closed',             'schema' => [],                        'open' => null,    'close' => null],
];

// ---------------------------------------------------------------------------
// 3. SOCIAL MEDIA LINKS
// ---------------------------------------------------------------------------
// >>> REPLACE THE '#' PLACEHOLDERS WITH YOUR REAL PROFILE URLs. <<<
// Any entry left as '#' still renders its icon, but is marked rel="nofollow"
// and is excluded from the structured-data "sameAs" list so Google is not fed
// a dead link. Delete an entry entirely to hide that icon everywhere.
// ---------------------------------------------------------------------------
const SOCIALS = [
    'linkedin'  => ['label' => 'LinkedIn',  'url' => '#', 'handle' => '@fonjulawfirm'],
    'facebook'  => ['label' => 'Facebook',  'url' => '#', 'handle' => '@fonjulawfirm'],
    'instagram' => ['label' => 'Instagram', 'url' => '#', 'handle' => '@fonjulawfirm'],
    'tiktok'    => ['label' => 'TikTok',    'url' => '#', 'handle' => '@fonjulawfirm'],
    'x'         => ['label' => 'X',         'url' => '#', 'handle' => '@fonjulawfirm'],
];

// ---------------------------------------------------------------------------
// 4. SEO DEFAULTS
// ---------------------------------------------------------------------------
const SEO_DEFAULTS = [
    'title'       => 'Fonju & Partners Law Firm | Corporate & Commercial Lawyers in Douala, Cameroon',
    'description' => 'Fonju & Partners Law Firm is a Douala-based international legal consultancy advising businesses across Cameroon and the CEMAC/OHADA zone on corporate law, investment, maritime, mining, IP, employment and litigation.',
    'image'       => '/assets/img/og-default.png',   // PNG: Facebook, LinkedIn and X do not render SVG share cards
    'locale'      => 'en_CM',
];

const GOOGLE_ANALYTICS_ID = 'G-B4JSR6T50N';   // leave empty to disable
const GOOGLE_SITE_VERIFY  = '';   // Search Console verification token

// ---------------------------------------------------------------------------
// 5. CONTACT FORM
// ---------------------------------------------------------------------------
const FORM_RECIPIENT = 'info@fonjulawfirm.com';
const FORM_SUBJECT   = 'New enquiry from fonjulawfirm.com';

/**
 * External form endpoint — REQUIRED for the static build (Vercel / Netlify /
 * Cloudflare Pages), because those hosts do not run PHP and so cannot process
 * the form themselves.
 *
 * Leave empty ('') on a PHP host: the form then posts to contact.php, which
 * mails FORM_RECIPIENT and logs to storage/enquiries.log.
 *
 * For the static build, sign up free at https://web3forms.com, paste the
 * access key below, and set:
 *   FORM_ENDPOINT    = 'https://api.web3forms.com/submit'
 * Formspree ('https://formspree.io/f/XXXXXXX', no access key) works the same way.
 */
const FORM_ENDPOINT   = '';
const FORM_ACCESS_KEY = '';
