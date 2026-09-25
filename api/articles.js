/**
 * /api/articles  (sign-in required)
 *   GET                         -> list of articles in both languages
 *   GET    ?lang=en&slug=x      -> one article, for editing
 *   POST   { article }          -> create or update (commits the Markdown file)
 *   DELETE ?lang=en&slug=x&sha= -> delete
 *
 * Articles live in content/insights/<lang>/<slug>.md. Every save is a commit
 * to the repository; the "Build static site" GitHub Action then rebuilds the
 * site and Vercel publishes it, usually within two minutes.
 */
'use strict';

const { LANGS, SLUG_RE, send, fail, guard, gh, getFile, putFile, deleteFile, buildMarkdown, parseMarkdown, readJson } = require('./_lib');

const dir = (lang) => 'content/insights/' + lang;
const DATE_RE = /^\d{4}-\d{2}-\d{2}$/;

async function listLang(cfg, lang) {
  const r = await gh(cfg, '/contents/' + dir(lang) + '?ref=' + encodeURIComponent(cfg.branch));
  if (r.status === 404) return [];
  if (!r.ok) throw new Error('GitHub error ' + r.status + ' listing articles');

  const files = r.data.filter((f) => f.type === 'file' && f.name.endsWith('.md'));
  const items = await Promise.all(files.map(async (f) => {
    const file = await getFile(cfg, f.path);
    const { meta } = parseMarkdown(file ? file.text : '');
    return {
      lang,
      slug: f.name.replace(/\.md$/, ''),
      sha: f.sha,
      title: String(meta.title || f.name),
      date: String(meta.date || '').slice(0, 10),
      category: String(meta.category || ''),
      draft: meta.draft === true,
      translation: String(meta.translation || ''),
    };
  }));

  return items.sort((a, b) => (b.date + a.title).localeCompare(a.date + b.title));
}

function clean(s, max) {
  return String(s == null ? '' : s).replace(/\s+/g, ' ').trim().slice(0, max);
}

/** Validate and normalise an article sent by the editor. */
function normalise(input) {
  const a = {
    lang: String(input.lang || ''),
    slug: String(input.slug || '').toLowerCase(),
    title: clean(input.title, 200),
    seoTitle: clean(input.seoTitle, 90),
    date: String(input.date || ''),
    updated: String(input.updated || ''),
    category: clean(input.category, 60),
    author: clean(input.author, 80),
    excerpt: clean(input.excerpt, 320),
    tags: (Array.isArray(input.tags) ? input.tags : String(input.tags || '').split(','))
      .map((t) => clean(t, 40)).filter(Boolean).slice(0, 12),
    image: clean(input.image, 300),
    featured: input.featured === true,
    draft: input.draft === true,
    translation: String(input.translation || '').toLowerCase(),
    body: String(input.body || '').slice(0, 200000),
  };

  const errors = [];
  if (!LANGS.includes(a.lang)) errors.push('Choose English or French.');
  if (!SLUG_RE.test(a.slug) || a.slug.length > 90) errors.push('The web address may only use lowercase letters, numbers and hyphens.');
  if (a.title.length < 5) errors.push('Give the article a title.');
  if (!DATE_RE.test(a.date)) errors.push('Choose a publication date.');
  if (a.updated && !DATE_RE.test(a.updated)) errors.push('The "last updated" date is not valid.');
  if (!a.category) errors.push('Choose a topic.');
  if (a.body.trim().length < 50) errors.push('The article text is too short.');
  if (a.translation && !SLUG_RE.test(a.translation)) errors.push('The linked translation is not valid.');
  if (a.image && !/^\/assets\/img\/insights\/[A-Za-z0-9/_\-.]+$/.test(a.image) && !/^https:\/\//.test(a.image)) errors.push('The cover image address is not valid.');
  if (!a.author) a.author = a.lang === 'fr' ? 'Cabinet Fonju' : 'Fonju Law Firm';
  if (!a.excerpt) errors.push('Write a one or two sentence summary.');

  return { article: a, errors };
}

module.exports = async (req, res) => {
  const write = req.method === 'POST' || req.method === 'DELETE';
  const cfg = guard(req, res, { write });
  if (!cfg) return;

  const url = new URL(req.url, 'http://localhost');
  const lang = url.searchParams.get('lang') || '';
  const slug = (url.searchParams.get('slug') || '').toLowerCase();

  try {
    if (req.method === 'GET' && !slug) {
      const [en, fr] = await Promise.all(LANGS.map((l) => listLang(cfg, l)));
      return send(res, 200, { ok: true, articles: { en, fr } });
    }

    if (req.method === 'GET') {
      if (!LANGS.includes(lang) || !SLUG_RE.test(slug)) return fail(res, 400, 'Unknown article.');
      const file = await getFile(cfg, dir(lang) + '/' + slug + '.md');
      if (!file) return fail(res, 404, 'That article no longer exists.');
      const { meta, body } = parseMarkdown(file.text);
      return send(res, 200, {
        ok: true,
        article: {
          lang, slug, sha: file.sha, body,
          title: String(meta.title || ''),
          seoTitle: String(meta.seo_title || ''),
          date: String(meta.date || '').slice(0, 10),
          updated: String(meta.updated || '').slice(0, 10),
          category: String(meta.category || ''),
          author: String(meta.author || ''),
          excerpt: String(meta.excerpt || ''),
          tags: Array.isArray(meta.tags) ? meta.tags.map(String) : [],
          image: String(meta.image || ''),
          featured: meta.featured === true,
          draft: meta.draft === true,
          translation: String(meta.translation || ''),
        },
      });
    }

    if (req.method === 'POST') {
      const input = await readJson(req, 512 * 1024);
      const { article, errors } = normalise(input.article || {});
      if (errors.length) return fail(res, 400, errors.join(' '));

      const path = dir(article.lang) + '/' + article.slug + '.md';
      const sha = typeof input.sha === 'string' && input.sha ? input.sha : undefined;
      const verb = sha ? 'Update' : 'Publish';
      const saved = await putFile(cfg, path, buildMarkdown(article), `${verb} article (${article.lang}): ${article.title}`, sha);

      return send(res, 200, { ok: true, sha: saved.content.sha, path });
    }

    if (req.method === 'DELETE') {
      const sha = url.searchParams.get('sha') || '';
      if (!LANGS.includes(lang) || !SLUG_RE.test(slug) || !sha) return fail(res, 400, 'Unknown article.');
      await deleteFile(cfg, dir(lang) + '/' + slug + '.md', sha, `Delete article (${lang}): ${slug}`);
      return send(res, 200, { ok: true });
    }

    return fail(res, 405, 'Method not allowed.');
  } catch (e) {
    return fail(res, e.status || 502, e.message || 'Something went wrong. Please try again.');
  }
};
