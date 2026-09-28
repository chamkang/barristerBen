# Fonju Law Firm — Website

A complete rebuild of fonjulawfirm.com: a fast, SEO-ready, fully responsive website for a
Douala-based legal consultancy, in English and French. No build step, no framework, no database —
plain PHP, CSS and JavaScript. It runs on the firm's Namecheap hosting, is deployed automatically
from GitHub, and includes a browser-based editor for articles and testimonials.

---

## 1. Running it locally

**Website and editor together (recommended)** — from the project folder:

```bash
C:/xampp/php/php.exe -S localhost:8098 tools/router.php
```

Then open <http://localhost:8098/> (French: `/fr/`) and the editor at <http://localhost:8098/admin>.
`tools/router.php` follows the same rules as `.htaccess`, so clean addresses, blocked folders and
the editor's `/api` behave exactly as on the live server. The editor runs in **local mode**: you are
signed in automatically, and saving writes straight to the files in this folder (nothing goes to
GitHub or the live site; review or undo with git).

**XAMPP** also works: start Apache and open <http://localhost/barrister-Ben/>. `BASE_PATH` is
detected automatically, so the site works in a sub-folder. (The editor needs the command above.)

---

## 2. The one file you will edit most

**`includes/config.php`** holds everything the firm changes: phone numbers, e-mail addresses,
office address, opening hours, social media links and SEO defaults.

### Social media links — action required

Open `includes/config.php` and replace each `'#'` with the real profile URL:

```php
const SOCIALS = [
    'linkedin'  => ['label' => 'LinkedIn',  'url' => 'https://www.linkedin.com/company/…', 'handle' => '@fonjulawfirm'],
    'facebook'  => ['label' => 'Facebook',  'url' => 'https://www.facebook.com/…',         'handle' => '@fonjulawfirm'],
    'instagram' => ['label' => 'Instagram', 'url' => 'https://www.instagram.com/…',        'handle' => '@fonjulawfirm'],
    'tiktok'    => ['label' => 'TikTok',    'url' => 'https://www.tiktok.com/@…',          'handle' => '@fonjulawfirm'],
    'x'         => ['label' => 'X',         'url' => 'https://x.com/…',                    'handle' => '@fonjulawfirm'],
];
```

The icons already appear in **four places** — the top bar, the mobile menu, the footer and the
contact page — and they all read from this one array. Behaviour:

- A link left as `'#'` still shows its icon, but is marked `rel="nofollow"` and is **excluded from
  the site's `sameAs` structured data**, so Google is never given a dead profile.
- Delete an entry entirely to remove that icon everywhere.
- Adding a new network only requires a matching icon path in `icon()` inside `includes/functions.php`.

Each icon has a brand-coloured hover state (LinkedIn blue, Instagram gradient, TikTok cyan/red
split, and so on).

---

## 3. Where the content lives

| What you want to change | File |
|---|---|
| Phone, e-mail, address, hours, socials, SEO defaults | `includes/config.php` |
| Practice areas (21 of them) | `includes/data-practice.php` (French: `data-practice.fr.php`) |
| Insights articles | `content/insights/en/*.md` and `content/insights/fr/*.md`, best edited at **`/admin`** |
| FAQ questions and answers (26, grouped) | `includes/data-faq.php` (French: `data-faq.fr.php`) |
| Lawyer profiles | `includes/data-team.php` (French text in each member's `'fr'` key) |
| Interface wording in French (menus, buttons, footer…) | `includes/lang/fr.php` |
| Colours, typography, spacing | `assets/css/style.css` (tokens at the top) |
| Home page sections | `index.php` (French: `fr/index.php`) |
| Client testimonials | `content/testimonials.json`, best edited at **`/admin` → Testimonials** |
| Page for clients outside Cameroon | `includes/data-international.php` (both languages) |
| Summary for AI assistants | `llms.php` (served as `/llms.txt`) |

Each data file is an array of plain PHP arrays with comments explaining every key. Adding a new
practice area is a copy-paste of one block — the listing pages, navigation, sitemap, RSS feed and
structured data all pick it up automatically.

### Writing articles — the online editor at `/admin`

The firm writes and publishes articles from the browser, with no code and no FTP:

1. Open `https://fonjulawfirm.com/admin` and sign in with the editor password.
2. **New article** → choose English or Français, write the title, the summary and the text. The
   toolbar adds headings, bold, lists, quotes, links and images; **Preview** shows the result.
3. Optional: a cover image (resized automatically in the browser), a **search title** (the words
   clients type into Google, if they differ from the headline), and a link to the same article in
   the other language (this connects the two with the EN/FR switch and `hreflang`).
4. **Publish**. The site updates in about two minutes; the editor shows the progress.

Drafts, future publication dates, editing and deleting all work the same way. Behind the scenes
each article is a Markdown file in `content/insights/{en,fr}/` committed to GitHub, so every
change is versioned and can be undone from the repository history.

**One-time setup:** see "Deploying to Namecheap", step 4 (section 8). The editor needs a
settings file on the server with its password, a session secret and a GitHub token.

Security: the password is checked on the server only; the sign-in is a signed, HttpOnly cookie
valid for 8 hours; every write needs that cookie *and* a same-origin request; `/admin` and `/api`
are `noindex` and disallowed in `robots.txt`; the settings file lives outside the website folder.
To sign everyone out, change `SESSION_SECRET`.

**How publishing reaches the site:** the editor commits the file to GitHub → the **Deploy**
GitHub Action checks the site and uploads the change to the server → live, usually within two
minutes. GitHub stays the single source of truth, so every change is versioned and a deployment
never overwrites an article. Articles with a future date appear on their day automatically (the
PHP site checks the date on every visit).

### Testimonials

At `/admin`, press **Testimonials**. Each testimonial can be written in English, French or both
(each language's home page shows only the ones written in it), with a description of who said it
("Managing Director" rather than a name, for confidentiality) and some context. Only entries with
**"The client has agreed in writing"** ticked are published. Reorder with the arrows and press
**Save**; the home page updates in about two minutes. With no testimonials, the section is hidden.

### Writing an article by hand

Create `content/insights/en/my-article.md` (the file name is the web address):

```markdown
---
title: "Headline shown on the page"
seo_title: "What people type into Google (optional)"
date: 2026-09-25
category: "Corporate & Commercial"
excerpt: "One or two sentences for cards and Google results."
tags: ["OHADA", "Douala"]
translation: slug-of-the-french-version
---

The text, in Markdown. ## for a section heading, **bold**, - lists, > quotes, [links](https://…).
```

All fields are documented at the top of `includes/data-blog.php`.

### The French version

Every page exists in French under `/fr/` (`/fr/`, `/fr/practice/…`, `/fr/insights/…`), with an
EN/FR switch in the header and `hreflang` links so Google shows each audience the right language.

- Page templates: `fr/*.php` — same structure as the English files.
- Data: `data-practice.fr.php`, `data-faq.fr.php`, and the `'fr'` key in `data-team.php`.
- Interface wording (menus, buttons, footer, form messages): `includes/lang/fr.php`, keyed by the
  English text. A string missing there simply shows in English.
- Articles: `content/insights/fr/`. French and English articles are independent; link a pair with
  `translation:` (or the editor's "Translation" field).

### Cookie consent

A bilingual consent banner appears on the first visit. Nothing optional loads before a choice:
Google Analytics runs only after "Analytics" is accepted, and the Google Map on the contact page is
replaced by a "Show the map" button until "Maps & embedded content" is accepted (Google sets its own cookies
when the map loads). Visitors can change their mind at any time through **Cookie settings** in the
footer; withdrawing analytics consent deletes the `_ga` cookies. The choice is stored in the
browser (`fonju-consent`) and asked again if `version` in `window.FONJU_CONSENT`
(`includes/header.php`) is increased. The privacy policy has a matching "Cookies" section.

---

## 4. Things to complete before going live

These are deliberately visible in the site itself so they cannot be forgotten. Each renders a
notice that disappears automatically once resolved.

1. **Social media URLs** — `includes/config.php` (see section 2).
2. **Team members** — `includes/data-team.php`. Only the founder's entry is real; three entries are
   marked *Placeholder* on the page. Replace or delete them. Placeholders are excluded from the
   page's `Person` structured data, so no fictional lawyer is ever published to search engines.
3. **`SITE_URL`** — set it to the live domain in `includes/config.php`. It drives canonical URLs,
   the sitemap and Open Graph tags.
4. **Privacy policy and legal notice** — `privacy.php` and `legal-notice.php` are solid drafts, but
   must be checked against actual practice and completed with the firm's RCCM number, NIU and bar
   admission details.
5. **Testimonials** — add real ones at `/admin` → Testimonials, with the client's written
   permission. The home page section stays hidden until there is at least one.
6. **Photographs** — see section 6.
7. **Contact form delivery** — see section 5.
8. **`robots.txt`** — update the `Sitemap:` line to the live domain.

---

## 5. The contact form

`contact.php` handles its own submissions. It includes a CSRF token, a honeypot field, server-side
validation and a consent checkbox.

Every submission is appended to **`storage/enquiries.log`** and *also* sent by e-mail to
`FORM_RECIPIENT`. The log is the safety net: a fresh XAMPP install has no mail transport, so
without it enquiries would silently vanish during testing.

To receive enquiries by e-mail in production, either configure SMTP in your host's `php.ini`, or
swap the `mail()` call for PHPMailer with your provider's SMTP credentials. When `mail()` fails,
the success message shows an administrator note (visible to you, harmless to a visitor) explaining
exactly that.

`storage/` is blocked from the web by both `.htaccess` files.

---

## 6. Images

The site is deliberately designed to look finished **with no photographs at all** — team cards fall
back to a generated gold monogram, and feature panels use designed gradient artwork rather than a
broken image icon. Add real images whenever they are ready:

- **Team photos** — square JPGs, at least 800×800, into `assets/img/team/`, then set the `photo`
  key in `includes/data-team.php` (for example `'photo' => 'fonju-bernard.jpg'`).
- **Office / feature photos** — drop into `assets/img/` and uncomment the commented-out `<img>` tag
  inside the relevant `.figure-panel` in `index.php` or `about.php`.
- **Social share card** — `assets/img/og-default.png` (1200×630) is generated from
  `assets/img/og-default.svg`. Edit the SVG and re-export if the branding changes.
- **Home page hero photo** — a law-library photograph from Unsplash (free licence, no attribution
  required), stored as `assets/img/hero-law-library.jpg` (2200 px, desktop) and
  `hero-law-library-1100.jpg` (phones). To use a photograph of the firm's own office or library,
  replace both files and keep the names; nothing else changes.

### The logo (the Key F)

The firm's mark is an antique key whose bit forms an F, with the scales of justice inside its ring.

- **On the site** it is drawn inline by `brand_mark($height)` in `includes/functions.php`, used in the
  header, the footer and the homepage office panel. The key takes the surrounding text colour; the
  scales use the `.brand__scales` class (gold).
- **Brand files** live in `assets/img/brand/`: the key in colour, reversed, black and white
  (`fonju-key-*.svg`), the horizontal logo (`fonju-logo-horizontal*.svg`, uses the free Cinzel font),
  and `fonju-logo-512.png`, the logo Google reads from the structured data.
- **Icons**: `favicon.svg`, `favicon-32.png`, `apple-touch-icon.png`, `icon-192.png`, `icon-512.png`,
  `icon-maskable-512.png`, listed in `assets/site.webmanifest`.
- **Palette**: charcoal `#151416` for dark sections, old gold `#C39B53`, ivory `#F6F0E4`, and oxblood
  `#5C1A1F` used sparingly — the key itself and the firm's name. In the stylesheet these are the
  `--ink-*`, `--gold*`, `--bone*` and `--brand` tokens at the top of `style.css`.
- **Type**: Cinzel for the name and main titles, EB Garamond for sub-headings and quotes, Inter for body text.

---

## 7. SEO — what is already done

- Unique `<title>` and meta description on every page, written for humans and under the length limits.
- Canonical URL on every page; filtered blog listings are `noindex` to avoid duplicate content.
- Open Graph and X/Twitter card tags, with a real 1200×630 PNG (not SVG — the social networks do
  not render SVG share cards).
- **JSON-LD structured data**, emitted as a single `@graph` per page:
  - `LegalService` + `Attorney` organisation with address, geo-coordinates, phone numbers, opening
    hours, languages, areas served and `sameAs` social profiles
  - `WebSite`
  - `BreadcrumbList` on every inner page (and matching visible breadcrumbs)
  - `Service` + `OfferCatalog` on each practice area page
  - `BlogPosting` on each article, `Blog` on the listing
  - `FAQPage` on the FAQ page — this is what makes questions eligible to appear directly in Google
  - `Person` on the team page (real people only)
  - `ContactPage` and `ItemList` where relevant
- `sitemap.php`, served at `/sitemap.xml`, generated from the data files so new content is included
  automatically. Submit it in Google Search Console.
- `robots.txt` with sitemap reference and sensible disallows.
- RSS feed at `/feed.xml`, linked from `<head>`.
- English and French versions of every page, linked with `hreflang` (and `x-default`) in the pages
  and in the sitemap.
- `/llms.txt` ([llmstxt.org](https://llmstxt.org)): a plain-text summary of the firm, its practice
  areas and its articles, generated by `llms.php`, so AI assistants (ChatGPT, Perplexity, Claude,
  Gemini) can describe and cite the firm accurately. `robots.txt` welcomes their crawlers.
- Optional `seo_title` per article, so the Google title can use the exact search phrase while the
  headline keeps its editorial voice.
- Semantic HTML with one `h1` per page and a correct heading hierarchy.
- Descriptive `alt` text, `aria-label`s, skip link, visible focus rings, and full keyboard support
  for the menu and accordions.
- Performance: no framework, no jQuery, inline SVG icons instead of an icon font, two web fonts with
  `preconnect` and `display=swap`, lazy-loaded images, gzip and cache headers in `.htaccess`.
- `prefers-reduced-motion` respected throughout; a print stylesheet is included.

### After deploying

1. Set `SITE_URL` and the `robots.txt` sitemap line to the live domain.
2. Add the Search Console verification token to `GOOGLE_SITE_VERIFY` in `includes/config.php`.
3. Submit `https://yourdomain.com/sitemap.xml`.
4. Add `GOOGLE_ANALYTICS_ID` (`G-XXXXXXXXXX`) if you want analytics — leave empty and no tracking
   script is loaded at all.
5. Create or claim the **Google Business Profile** for the Douala office. For a local law firm this
   moves the needle more than anything else on this list.
6. Test the share card with Facebook's Sharing Debugger and LinkedIn's Post Inspector.

---

## 8. Deploying

The live site is **fonjulawfirm.com on Namecheap** (shared hosting, LiteSpeed web server, PHP).
The PHP source is deployed as it is — no build step — by the GitHub Action in
`.github/workflows/deploy.yml` on every push to `main`:

1. **Check** — every PHP file must parse, and the main pages plus every article must render with
   no PHP errors.
2. **Deploy** — only the changed files are uploaded over FTPS to the site's folder. Files that exist
   only on the server (the enquiry log, the editor's settings) are never touched.
3. **Smoke test** — the live home page, French home page, About page and editor API must answer.

Excluded from the upload: `.github/`, `tools/`, `dist/`, `README.md`, `build.php`, `vercel.json`.
`.htaccess` also blocks `includes/`, `content/`, `storage/`, `tools/` and hidden files from the web.

### Deploying to Namecheap — one-time setup

The site's folder on the server is **`fonjulawfirm.com`** in your home directory (it is an addon
domain, so it is *not* `public_html`).

**1. PHP version.** cPanel → **Select PHP Version** → choose **8.2** or newer and make sure the
extensions `curl`, `mbstring` and `intl` are ticked. (If the domain has its own setting under
cPanel → **MultiPHP Manager**, set it there.)

**2. An FTP account just for deployments.** cPanel → **FTP Accounts** → *Add FTP Account*:
- Log in: `deploy` (it becomes `deploy@fonjulawfirm.com`)
- Password: generate a strong one
- **Directory: `fonjulawfirm.com`** — replace what cPanel suggests with exactly the site folder,
  so this account can only ever see the website.

Note the server name under *Configure FTP Client* (usually `ftp.fonjulawfirm.com`, or your server's
host name such as `server123.web-hosting.com`).

**3. GitHub secrets.** github.com/chamkang/barristerBen → **Settings → Secrets and variables →
Actions → New repository secret**, one per line:

| Secret | Value |
|---|---|
| `FTP_SERVER` | `ftp.fonjulawfirm.com` (or the host name from step 2) |
| `FTP_USERNAME` | `deploy@fonjulawfirm.com` |
| `FTP_PASSWORD` | the password from step 2 |
| `FTP_SERVER_DIR` | *leave unset* when the FTP account's directory is the site folder (step 2). If you use the main cPanel FTP login instead, set it to `fonjulawfirm.com/` |

**4. The editor's settings file.** Create a GitHub **fine-grained token**: GitHub → Settings →
Developer settings → Fine-grained tokens → *Generate new token*. Repository access: **only
`chamkang/barristerBen`**. Permissions: **Contents: Read and write**, and **Actions: Read** (lets
the editor show "Website up to date"). Set an expiry and a calendar reminder to renew it.

Then in cPanel → **File Manager**, open your **home folder** (the one that *contains*
`fonjulawfirm.com`), create `fonju-admin-config.php`, paste in the contents of
`tools/fonju-admin-config.example.php` and fill in the password, a session secret
(`openssl rand -hex 32`) and the token. Set its permissions to 0600. Being outside the website
folder, it can never be downloaded, and deployments never touch it.

**5. First deployment.** GitHub → **Actions → Deploy → Run workflow** (or push any commit). The
first run uploads the whole site, which takes a few minutes; later runs upload only changes.
Then open <https://fonjulawfirm.com> and <https://fonjulawfirm.com/admin>.

**6. After it is live.** Submit `https://fonjulawfirm.com/sitemap.xml` in Google Search Console and
Bing Webmaster Tools, and delete the old Vercel project (Vercel → Project → Settings → Delete), so
an out-of-date copy of the site is not left online at `*.vercel.app`.

**Contact form.** On Namecheap the form sends e-mail with PHP's `mail()` from
`FORM_RECIPIENT` (`info@fonjulawfirm.com`), and every enquiry is also saved in
`storage/enquiries.log` on the server. Create the `info@fonjulawfirm.com` mailbox in cPanel →
**Email Accounts** (or point it at the firm's mail provider), then send a test enquiry. Keep
`FORM_ENDPOINT` empty.

**If a deployment fails:** open GitHub → Actions → the red run → the failed step. "Check" failures
name the page and the PHP error; FTP failures are almost always a wrong secret or server-dir.
Re-run after fixing. The site stays on the previous version until a deployment succeeds.

### Optional: static export (Vercel, Netlify, Cloudflare Pages)

`php build.php` still renders the whole site to plain HTML in `dist/` (ignored by git), with
`vercel.json` for clean URLs and headers. The contact form then needs `FORM_ENDPOINT`
(e.g. Web3Forms), and the editor, articles with future dates and the enquiry log are not available.
Use it only if the site ever has to move to a host without PHP.

---

### Publishing a content change

Articles and testimonials: use `/admin`; nothing else is needed.

Anything else:

1. Edit the file — a practice area in `includes/data-practice.php`, say.
2. Check it locally (section 1).
3. `git add -A && git commit -m "Update practice areas" && git push`

The **Deploy** action checks and uploads it; follow it under GitHub → Actions. The sitemap, RSS
feed, `llms.txt`, category filters and structured data all update on their own.

---

## 9. Page map

| URL | Purpose |
|---|---|
| `/` | Home — hero, why the firm, about, practice areas, process, testimonials, insights, FAQ |
| `/about` | The firm, its pillars, location, philosophy, full capability list |
| `/practice-areas` | All 21 areas with live search and group filtering |
| `/practice/…` | A detail page per area — intro, sections, service list, sidebar |
| `/team` | Lawyer profiles |
| `/blog` | Insights listing, filterable by category |
| `/insights/…` | Article with sharing, related posts and a disclaimer |
| `/faq` | 26 questions in 6 groups, as an accessible accordion |
| `/contact` | Enquiry form, contact details, opening hours, map |
| `/privacy`, `/legal-notice` | Legal pages |
| `/404` | Custom not-found page with useful routes back |
| `/sitemap.xml`, `/feed.xml`, `/llms.txt` | Generated automatically |
| `/fr/…` | The French version of every page above |
| `/admin` | The article editor (password-protected, not indexed) |

---

## 10. Clean addresses

The site uses clean addresses: `/about`, `/practice/corporate-law`, `/insights/…`, and `/fr/…` for
French. `url()` in `includes/functions.php` produces them (see `pretty_path()`), and `.htaccess`
maps them to the PHP scripts. Old `.php` addresses redirect permanently (301) to the clean ones,
so there is only ever one address per page. `CLEAN_URLS` in `includes/config.php` switches this
off for a server without URL rewriting.

---

## 11. Browser support & accessibility

Tested against current Chrome, Edge, Firefox and Safari, and down to 360 px wide. The site is fully
usable with JavaScript disabled: navigation, all content, the contact form and every FAQ answer
remain reachable — only the reveal animations, the accordion collapse and the live search are
progressive enhancements.
