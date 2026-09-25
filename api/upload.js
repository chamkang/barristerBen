/**
 * /api/upload  (sign-in required)
 *   POST { name, type, data } -> { ok, url }
 *
 * Stores an image for an article in assets/img/insights/<year>/. The editor
 * resizes photographs in the browser first, so uploads stay small.
 */
'use strict';

const crypto = require('crypto');
const { send, fail, guard, putFile, readJson } = require('./_lib');

const TYPES = { 'image/jpeg': 'jpg', 'image/png': 'png', 'image/webp': 'webp' };
const MAX_BYTES = 3 * 1024 * 1024;

module.exports = async (req, res) => {
  if (req.method !== 'POST') return fail(res, 405, 'Method not allowed.');
  const cfg = guard(req, res, { write: true });
  if (!cfg) return;

  try {
    const input = await readJson(req, 5 * 1024 * 1024);
    const ext = TYPES[input.type];
    if (!ext) return fail(res, 400, 'Please upload a JPG, PNG or WebP image.');

    const bytes = Buffer.from(String(input.data || '').replace(/^data:[^,]+,/, ''), 'base64');
    if (bytes.length === 0) return fail(res, 400, 'The image is empty.');
    if (bytes.length > MAX_BYTES) return fail(res, 413, 'The image is too large (maximum 3 MB).');

    const base = String(input.name || 'image').toLowerCase()
      .replace(/\.[a-z0-9]+$/, '')
      .normalize('NFD').replace(/[̀-ͯ]/g, '')
      .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '')
      .slice(0, 50) || 'image';
    const year = new Date().getUTCFullYear();
    const path = `assets/img/insights/${year}/${base}-${crypto.randomBytes(3).toString('hex')}.${ext}`;

    await putFile(cfg, path, bytes, 'Upload article image: ' + path.split('/').pop());

    return send(res, 200, { ok: true, url: '/' + path });
  } catch (e) {
    return fail(res, e.status || 502, e.message || 'The upload failed. Please try again.');
  }
};
