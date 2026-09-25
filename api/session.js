/**
 * /api/session
 *   GET     -> { ok, signedIn }            is the browser signed in?
 *   POST    { password } -> sets the cookie  sign in
 *   DELETE  -> clears the cookie             sign out
 */
'use strict';

const { config, send, fail, safeEqual, issueCookie, clearCookie, isAuthenticated, sameOrigin, readJson } = require('./_lib');

module.exports = async (req, res) => {
  const cfg = config();

  if (req.method === 'GET') {
    return send(res, 200, { ok: true, signedIn: cfg.missing.length === 0 && isAuthenticated(req, cfg.secret), configured: cfg.missing.length === 0 });
  }

  if (req.method === 'DELETE') {
    return send(res, 200, { ok: true }, { 'Set-Cookie': clearCookie() });
  }

  if (req.method !== 'POST') return fail(res, 405, 'Method not allowed.');
  if (cfg.missing.length) return fail(res, 500, 'The admin is not configured yet. Missing environment variables: ' + cfg.missing.join(', '));
  if (!sameOrigin(req)) return fail(res, 403, 'Request refused.');

  let body;
  try {
    body = await readJson(req, 10 * 1024);
  } catch (e) {
    return fail(res, 400, 'Invalid request.');
  }

  if (typeof body.password !== 'string' || !safeEqual(body.password, cfg.password)) {
    // Slow every failed attempt down to make password guessing impractical.
    await new Promise((resolve) => setTimeout(resolve, 900));
    return fail(res, 401, 'That password is not correct.');
  }

  return send(res, 200, { ok: true }, { 'Set-Cookie': issueCookie(cfg.secret) });
};
