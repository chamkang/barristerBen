# Fonju Law Firm — Website

A complete rebuild of fonjulawfirm.com: a fast, SEO-ready, fully responsive website for a
Douala-based legal consultancy. No build step, no framework, no database — plain PHP, CSS and
JavaScript that runs on XAMPP locally and on any standard Apache/cPanel host.

---

## 1. Running it locally

The project is already in `C:\xampp\htdocs\barrister-Ben`.

1. Start **Apache** from the XAMPP Control Panel.
2. Open <http://localhost/barrister-Ben/>.

That is the whole setup. `BASE_PATH` is detected automatically, so the site works both in the
`barrister-Ben` sub-folder and at a domain root.

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
| Home page sections, testimonials | `index.php` (French: `fr/index.php`) |
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

**One-time setup (the developer does this once, in Vercel):**

1. **Root Directory must be blank** (the repository root) — otherwise the `/api` functions the
   editor uses are not deployed. See section 8.
2. Create a GitHub **fine-grained personal access token**: GitHub → Settings → Developer settings →
   Fine-grained tokens → *Generate*. Repository access: **only `chamkang/barristerBen`**.
   Permissions: **Contents: Read and write** (and optionally **Actions: Read**, so the editor can
   show build progress). Set an expiry date and put a reminder in the calendar to renew it.
3. In Vercel → Project → Settings → **Environment Variables**, add (Production):

   | Name | Value |
   |---|---|
   | `ADMIN_PASSWORD` | A long passphrase, given only to the people who write articles |
   | `SESSION_SECRET` | 40+ random characters (e.g. the output of `openssl rand -hex 32`) |
   | `GITHUB_TOKEN` | The token from step 2 |
   | `GITHUB_REPO` | `chamkang/barristerBen` |
   | `GITHUB_BRANCH` | `main` (optional, this is the default) |

4. Redeploy. Until the variables exist, `/admin` shows a setup screen listing what is missing.

Security: the password is checked on the server only; the sign-in is a signed, HttpOnly cookie
valid for 8 hours; every write needs that cookie *and* a same-origin request; `/admin` and `/api`
are `noindex` and disallowed in `robots.txt`. To lock everyone out, change `SESSION_SECRET`.

**How publishing reaches the site:** the editor commits the Markdown file → the GitHub Action in
`.github/workflows/build-site.yml` runs `php build.php` and commits the new `dist/` → Vercel
deploys that commit. The same action also runs every morning (05:15 UTC), which is what makes
articles with a future date appear on their day.

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
5. **Testimonials** — the three on the home page are illustrative. Replace them in `index.php`
   with real, permission-cleared client feedback, or remove the section.
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
  required), loaded from Unsplash's CDN. It is set in `style.css` on `.hero` (search for
  `images.unsplash.com`). To use your own photo, put a wide JPG (about 2200 px, under 400 KB) in
  `assets/img/` and change that URL to it; a photo of the firm's own office or library is better
  still.

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

There are two ways to put this online, and the right one depends on whether your host runs PHP.

| | **A. Static host** (Vercel, Netlify, Cloudflare Pages) | **B. PHP host** (cPanel, shared hosting, VPS) |
|---|---|---|
| Cost | Free, permanently | Usually paid; free tiers are slow |
| Speed | Global CDN, very fast | Single server |
| Contact form | Needs a free form service (5 minutes to set up) | Works as built, sends real e-mail |
| Publishing a change | `php build.php`, then `git push` | Upload the changed file |
| SSL, custom domain | Automatic | You configure it |

Both serve identical HTML. **A is recommended** unless you specifically need PHP-side e-mail.

---

### A. Static host — Vercel (free)

Vercel cannot run PHP, so `build.php` renders the whole site to plain HTML in `dist/` first.
The PHP source stays the content management system; `dist/` is just its output, and it is
committed to the repository so Vercel has something to serve.

**Step 1 — set the live domain.** In `includes/config.php`:

```php
const SITE_URL = 'https://barrister-ben.vercel.app';   // or your own domain
```

Also update the last line of `robots.txt` to match.

**Step 2 — make the contact form work.** Static hosts cannot process a form, so point it at a
free form service:

1. Go to <https://web3forms.com>, enter the firm's e-mail address, and copy the access key
   they send you. No account or card required.
2. In `includes/config.php`:

```php
const FORM_ENDPOINT   = 'https://api.web3forms.com/submit';
const FORM_ACCESS_KEY = 'paste-your-key-here';
```

Submissions then arrive as e-mail at that address. Formspree works the same way (use its
form URL as `FORM_ENDPOINT` and leave `FORM_ACCESS_KEY` empty). Leave both empty and
`build.php` will warn you that the form goes nowhere.

**Step 3 — build.**

```bash
php build.php
```

It prints every page it writes, then a list of warnings for anything still unfinished
(placeholder social links, placeholder team members, missing form endpoint).

**Step 4 — commit and push.**

```bash
git add -A && git commit -m "Rebuild static site" && git push
```

**Step 5 — connect Vercel.** Once only:

1. Sign in at <https://vercel.com> with your GitHub account.
2. **Add New → Project**, then import `chamkang/barristerBen`.
3. Leave every setting alone — `vercel.json` already tells Vercel that the site is the
   pre-built `dist/` folder, with clean URLs and caching and security headers configured.
4. **Deploy.** It takes about thirty seconds, and you get a
   `https://barrister-ben.vercel.app` address.

From then on, every `git push` redeploys automatically.

#### Root Directory: leave it blank

> **The article editor needs the blank (repository-root) setting.** Its `/api` functions live in
> the repository's `api/` folder, which Vercel only deploys when the Root Directory is the
> repository root. With `dist`, the public site still works but `/admin` cannot sign in.

For the static pages alone, both settings work:

Vercel reads `vercel.json` from **the project's root directory**, which is whatever the
dashboard's *Root Directory* setting points at. That means the file has to exist in the right
place for whichever setup you pick, so `build.php` writes a second copy into `dist/`:

| Root Directory | Config Vercel reads | Serves |
|---|---|---|
| *(blank — repository root)* | `./vercel.json` | `dist/`, via `outputDirectory` |
| `dist` | `./dist/vercel.json` | that folder directly |

The `dist/` copy is generated with the build keys (`framework`, `installCommand`,
`buildCommand`, `outputDirectory`) stripped, because `"outputDirectory": "dist"` read from
*inside* `dist/` would send Vercel looking for `dist/dist`.

This matters more than it looks. [`cleanUrls` defaults to
`false`](https://vercel.com/docs/project-configuration/vercel-json#cleanurls), and every
internal link, canonical tag and sitemap entry the build emits is extensionless
(`/about`, `/practice/corporate-law`). If Vercel never sees a `vercel.json` with
`cleanUrls: true`, only the `.html` paths resolve — the deployment succeeds and the site is
broken. Keeping both copies in sync removes that failure mode entirely.

Blank is still the better default: it is the setting a fresh import already has, so nobody
has to remember it.

**Step 6 — custom domain.** In Vercel: **Project → Settings → Domains → Add**, enter
`fonjulawfirm.com`, and set the DNS records Vercel shows you at your registrar. SSL is issued
automatically and free. Then set `SITE_URL` to the real domain, rebuild, and push.

> **Netlify or Cloudflare Pages** work identically. Netlify: drag the `dist/` folder onto
> <https://app.netlify.com/drop> for an instant deploy, or connect the repository and set the
> publish directory to `dist` with an empty build command. Cloudflare Pages: connect the
> repository, framework preset **None**, build output directory `dist`.

---

### B. PHP host (cPanel, shared hosting, VPS)

Use this when you want the contact form to send mail from your own domain with no third party.

1. Upload everything **except** `dist/`, `build.php` and `vercel.json` to `public_html`.
2. In `includes/config.php`, set `SITE_URL` to the live domain and leave `FORM_ENDPOINT` empty
   so the form posts back to `contact.php`.
3. Update the `Sitemap:` line in `robots.txt`.
4. Install the SSL certificate, then uncomment the HTTPS redirect block in `.htaccess`.
5. Uncomment the `Strict-Transport-Security` header in `.htaccess`.
6. Pick `www` or non-`www` and uncomment the matching canonical-host rule in `.htaccess`.
7. Make `storage/` writable by PHP (0755 is normally enough).
8. Configure SMTP in the host's PHP settings so `mail()` actually delivers.

`.htaccess` already provides gzip compression, long-lived asset caching, security headers,
directory-listing suppression, a custom 404 page, and clean `/sitemap.xml` and `/feed.xml`
addresses. Every block is wrapped in `<IfModule>`, so a host missing a module will not throw
a 500.

**Free PHP hosting** exists (InfinityFree, AwardSpace) but is slow, ad-supported and
unreliable for a professional firm. If the budget is tight, option A plus Web3Forms is the
better free route.

---

### Publishing a content change

Articles: use `/admin` (section 3); nothing else is needed.

Anything else:

1. Edit the file — a practice area in `includes/data-practice.php`, say.
2. Check it locally at <http://localhost/barrister-Ben/>.
3. `git add -A && git commit -m "Update practice areas" && git push`

The GitHub Action (`.github/workflows/build-site.yml`) runs `php build.php`, commits the new
`dist/`, and Vercel deploys it, usually within two minutes. You can still run `php build.php`
yourself before pushing; the action simply finds nothing to change. The sitemap, RSS feed,
`llms.txt`, category filters and structured data all update on their own.

In the repository's **Settings → Actions → General → Workflow permissions**, "Read and write
permissions" must be allowed (the workflow also requests `contents: write` itself).

---

## 9. Page map

| URL | Purpose |
|---|---|
| `/` | Home — hero, why the firm, about, practice areas, process, testimonials, insights, FAQ |
| `/about.php` | The firm, its pillars, location, philosophy, full capability list |
| `/practice-areas.php` | All 21 areas with live search and group filtering |
| `/practice-area.php?area=…` | A detail page per area — intro, sections, service list, sidebar |
| `/team.php` | Lawyer profiles |
| `/blog.php` | Insights listing, filterable by category |
| `/post.php?p=…` | Article with sharing, related posts and a disclaimer |
| `/faq.php` | 26 questions in 6 groups, as an accessible accordion |
| `/contact.php` | Enquiry form, contact details, opening hours, map |
| `/privacy.php`, `/legal-notice.php` | Legal pages |
| `/404.php` | Custom not-found page with useful routes back |
| `/sitemap.xml`, `/feed.xml`, `/llms.txt` | Generated automatically |
| `/fr/…` | The French version of every page above |
| `/admin` | The article editor (password-protected, not indexed) |

---

## 10. Optional: clean URLs

The site uses query-string URLs (`/practice-area.php?area=corporate-law`), which are fully
indexable and canonicalised. If you later want `/practice/corporate-law` instead, add to `.htaccess`:

```apache
RewriteRule ^practice/([a-z0-9-]+)/?$ practice-area.php?area=$1 [L,QSA]
RewriteRule ^insights/([a-z0-9-]+)/?$ post.php?p=$1 [L,QSA]
```

Then update `url('practice-area.php?area=' . $slug)` to `url('practice/' . $slug)` throughout, so
the canonical tags and sitemap point at the new form. Do both together — never leave two live URLs
for the same page.

---

## 11. Browser support & accessibility

Tested against current Chrome, Edge, Firefox and Safari, and down to 360 px wide. The site is fully
usable with JavaScript disabled: navigation, all content, the contact form and every FAQ answer
remain reachable — only the reveal animations, the accordion collapse and the live search are
progressive enhancements.
