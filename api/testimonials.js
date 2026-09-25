/**
 * /api/testimonials  (sign-in required)
 *   GET                          -> { testimonials, sha }
 *   POST { testimonials, sha }   -> replaces the whole list (one commit)
 *
 * Testimonials live in content/testimonials.json and appear on the home page
 * (see includes/data-testimonials.php). Only entries marked with the client's
 * permission are ever shown on the site.
 */
'use strict';

const { send, fail, guard, getFile, putFile, readJson } = require('./_lib');

const FILE = 'content/testimonials.json';
const MAX = 24;

function clean(s, max) {
  return String(s == null ? '' : s).replace(/\s+/g, ' ').trim().slice(0, max);
}

function normalise(list) {
  const errors = [];
  const out = (Array.isArray(list) ? list : []).slice(0, MAX).map((t, i) => {
    const item = {
      quote_en: clean(t && t.quote_en, 600),
      quote_fr: clean(t && t.quote_fr, 600),
      name: clean(t && t.name, 80),
      role_en: clean(t && t.role_en, 100),
      role_fr: clean(t && t.role_fr, 100),
      permission: !!(t && t.permission === true),
    };
    if (!item.quote_en && !item.quote_fr) errors.push('Testimonial ' + (i + 1) + ' has no text in either language.');
    if (!item.name) errors.push('Testimonial ' + (i + 1) + ': describe who said it (for example "Managing Director").');
    return item;
  });
  return { list: out, errors };
}

module.exports = async (req, res) => {
  const write = req.method === 'POST';
  const cfg = guard(req, res, { write });
  if (!cfg) return;

  try {
    if (req.method === 'GET') {
      const file = await getFile(cfg, FILE);
      let list = [];
      if (file) {
        try { list = JSON.parse(file.text).testimonials || []; } catch (e) { list = []; }
      }
      return send(res, 200, { ok: true, testimonials: list, sha: file ? file.sha : '' });
    }

    if (req.method === 'POST') {
      const input = await readJson(req, 128 * 1024);
      const { list, errors } = normalise(input.testimonials);
      if (errors.length) return fail(res, 400, errors.join(' '));

      const text = JSON.stringify({ testimonials: list }, null, 2) + '\n';
      try {
        const saved = await putFile(cfg, FILE, Buffer.from(text, 'utf8'), 'Update testimonials (' + list.length + ')', input.sha || undefined);
        return send(res, 200, { ok: true, sha: saved.content.sha });
      } catch (error) {
        if (error.status === 409) return fail(res, 409, 'The testimonials were changed elsewhere since you opened them. Reload the page and make your change again.');
        throw error;
      }
    }

    return fail(res, 405, 'Method not allowed.');
  } catch (error) {
    return fail(res, error.status || 502, error.message || 'Something went wrong. Please try again.');
  }
};
