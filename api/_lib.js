/**
 * Shared helpers for the article admin API (Vercel serverless functions).
 * Files in api/ whose names start with "_" are not exposed as endpoints.
 *
 * Required environment variables (Vercel > Project > Settings > Environment Variables):
 *   ADMIN_PASSWORD   The password the lawyer types at /admin.
 *   SESSION_SECRET   A long random string used to sign the login cookie.
 *   GITHUB_TOKEN     A fine-grained GitHub token for this repository only,
 *                    with "Contents: Read and write" (and optionally
 *                    "Actions: Read", which lets the admin show build status).
 *   GITHUB_REPO      owner/name, e.g. chamkang/barristerBen
 *   GITHUB_BRANCH    Optional, defaults to main.
 */
'use strict';

const crypto = require('crypto');

const COOKIE = 'fonju_admin';
const SESSION_HOURS = 8;
const LANGS = ['en', 'fr'];
const SLUG_RE = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;

function config() {
  const missing = ['ADMIN_PASSWORD', 'SESSION_SECRET', 'GITHUB_TOKEN', 'GITHUB_REPO'].filter((k) => !process.env[k]);
  return {
    missing,
    password: process.env.ADMIN_PASSWORD || '',
    secret: process.env.SESSION_SECRET || '',
    token: process.env.GITHUB_TOKEN || '',
    repo: process.env.GITHUB_REPO || '',
    branch: process.env.GITHUB_BRANCH || 'main',
  };
}

// ------------------------------------------------------------------ responses
function send(res, status, body, headers = {}) {
  res.statusCode = status;
  res.setHeader('Content-Type', 'application/json; charset=utf-8');
  res.setHeader('Cache-Control', 'no-store');
  res.setHeader('X-Robots-Tag', 'noindex, nofollow');
  for (const [k, v] of Object.entries(headers)) res.setHeader(k, v);
  res.end(JSON.stringify(body));
}

const fail = (res, status, message) => send(res, status, { ok: false, error: message });

// ------------------------------------------------------------------ sessions
const b64url = (buf) => Buffer.from(buf).toString('base64').replace(/=+$/, '').replace(/\+/g, '-').replace(/\//g, '_');
const sign = (data, secret) => b64url(crypto.createHmac('sha256', secret).update(data).digest());

function safeEqual(a, b) {
  const ha = crypto.createHash('sha256').update(String(a)).digest();
  const hb = crypto.createHash('sha256').update(String(b)).digest();
  return crypto.timingSafeEqual(ha, hb);
}

function issueCookie(secret) {
  const payload = b64url(JSON.stringify({ exp: Date.now() + SESSION_HOURS * 3600 * 1000, n: b64url(crypto.randomBytes(9)) }));
  const value = payload + '.' + sign(payload, secret);
  return `${COOKIE}=${value}; Path=/; HttpOnly; Secure; SameSite=Strict; Max-Age=${SESSION_HOURS * 3600}`;
}

const clearCookie = () => `${COOKIE}=; Path=/; HttpOnly; Secure; SameSite=Strict; Max-Age=0`;

function readCookie(req, name) {
  const header = req.headers.cookie || '';
  for (const part of header.split(';')) {
    const [k, ...v] = part.trim().split('=');
    if (k === name) return v.join('=');
  }
  return '';
}

function isAuthenticated(req, secret) {
  const value = readCookie(req, COOKIE);
  const [payload, sig] = value.split('.');
  if (!payload || !sig || !secret || !safeEqual(sig, sign(payload, secret))) return false;
  try {
    const data = JSON.parse(Buffer.from(payload.replace(/-/g, '+').replace(/_/g, '/'), 'base64').toString('utf8'));
    return typeof data.exp === 'number' && data.exp > Date.now();
  } catch (e) {
    return false;
  }
}

/**
 * Requests that change anything must come from the admin page itself: the
 * cookie is SameSite=Strict, and the page sends a custom header that a
 * cross-site form cannot.
 */
function sameOrigin(req) {
  if (req.headers['x-fonju-admin'] !== '1') return false;
  const origin = req.headers.origin;
  if (!origin) return true;
  try {
    return new URL(origin).host === req.headers.host;
  } catch (e) {
    return false;
  }
}

/** Standard guard: configuration present, logged in, and (for writes) same origin. */
function guard(req, res, { write = false } = {}) {
  const cfg = config();
  if (cfg.missing.length) {
    fail(res, 500, 'The admin is not configured yet. Missing environment variables: ' + cfg.missing.join(', '));
    return null;
  }
  if (!isAuthenticated(req, cfg.secret)) {
    fail(res, 401, 'Please sign in again.');
    return null;
  }
  if (write && !sameOrigin(req)) {
    fail(res, 403, 'Request refused.');
    return null;
  }
  return cfg;
}

// ------------------------------------------------------------------ GitHub
async function gh(cfg, path, options = {}) {
  const response = await fetch('https://api.github.com/repos/' + cfg.repo + path, {
    ...options,
    headers: {
      Accept: 'application/vnd.github+json',
      Authorization: 'Bearer ' + cfg.token,
      'X-GitHub-Api-Version': '2022-11-28',
      'User-Agent': 'fonju-admin',
      ...(options.body ? { 'Content-Type': 'application/json' } : {}),
      ...(options.headers || {}),
    },
  });
  const text = await response.text();
  let data = null;
  try { data = text ? JSON.parse(text) : null; } catch (e) { data = text; }
  return { status: response.status, ok: response.ok, data };
}

const enc = (p) => p.split('/').map(encodeURIComponent).join('/');

async function getFile(cfg, path) {
  const r = await gh(cfg, '/contents/' + enc(path) + '?ref=' + encodeURIComponent(cfg.branch));
  if (r.status === 404) return null;
  if (!r.ok) throw new Error('GitHub error ' + r.status + ' reading ' + path);
  return { sha: r.data.sha, text: Buffer.from(r.data.content || '', 'base64').toString('utf8') };
}

async function putFile(cfg, path, contentBuffer, message, sha) {
  const r = await gh(cfg, '/contents/' + enc(path), {
    method: 'PUT',
    body: JSON.stringify({
      message,
      content: Buffer.from(contentBuffer).toString('base64'),
      branch: cfg.branch,
      ...(sha ? { sha } : {}),
    }),
  });
  if (r.status === 409 || r.status === 422) {
    const err = new Error(sha
      ? 'This article was changed elsewhere since you opened it. Reload it and make your edit again.'
      : 'A file with this address already exists. Choose a different URL.');
    err.status = 409;
    throw err;
  }
  if (!r.ok) throw new Error('GitHub error ' + r.status + ' saving ' + path);
  return r.data;
}

async function deleteFile(cfg, path, sha, message) {
  const r = await gh(cfg, '/contents/' + enc(path), {
    method: 'DELETE',
    body: JSON.stringify({ message, sha, branch: cfg.branch }),
  });
  if (!r.ok) throw new Error('GitHub error ' + r.status + ' deleting ' + path);
}

// ------------------------------------------------------------------ front matter
/** YAML double-quoted scalar. */
const yq = (s) => '"' + String(s).replace(/\\/g, '\\\\').replace(/"/g, '\\"').replace(/\r?\n/g, ' ') + '"';

function buildMarkdown(a) {
  const lines = ['---', 'title: ' + yq(a.title)];
  if (a.seoTitle) lines.push('seo_title: ' + yq(a.seoTitle));
  lines.push('date: ' + a.date);
  if (a.updated) lines.push('updated: ' + a.updated);
  lines.push('category: ' + yq(a.category), 'author: ' + yq(a.author), 'excerpt: ' + yq(a.excerpt));
  if (a.tags.length) lines.push('tags:', ...a.tags.map((t) => '  - ' + yq(t)));
  if (a.image) lines.push('image: ' + yq(a.image));
  lines.push('featured: ' + (a.featured ? 'true' : 'false'));
  if (a.translation) lines.push('translation: ' + a.translation);
  if (a.draft) lines.push('draft: true');
  lines.push('---', '', a.body.replace(/\r\n/g, '\n').trim(), '');
  return lines.join('\n');
}

/** Reads the front matter written by buildMarkdown (and by hand-written files). */
function parseMarkdown(raw) {
  const text = raw.replace(/\r\n/g, '\n').replace(/^﻿/, '');
  const m = text.match(/^---\n([\s\S]*?)\n---\n?([\s\S]*)$/);
  const meta = {};
  if (!m) return { meta, body: text };
  const lines = m[1].split('\n');
  const scalar = (v) => {
    v = v.trim();
    if (v === 'true' || v === 'false') return v === 'true';
    if (/^".*"$/.test(v)) return v.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
    if (/^'.*'$/.test(v)) return v.slice(1, -1).replace(/''/g, "'");
    return v;
  };
  for (let i = 0; i < lines.length; i++) {
    const kv = lines[i].match(/^([A-Za-z0-9_-]+):\s*(.*)$/);
    if (!kv) continue;
    const [, key, value] = kv;
    if (value.trim() === '') {
      const items = [];
      while (i + 1 < lines.length && /^\s*-\s+/.test(lines[i + 1])) items.push(scalar(lines[++i].replace(/^\s*-\s+/, '')));
      meta[key] = items;
    } else if (/^\[.*\]$/.test(value.trim())) {
      meta[key] = value.trim().slice(1, -1).split(',').map(scalar).filter((x) => x !== '');
    } else {
      meta[key] = scalar(value);
    }
  }
  return { meta, body: m[2].replace(/^\n+/, '') };
}

// ------------------------------------------------------------------ request bodies
async function readJson(req, limitBytes = 6 * 1024 * 1024) {
  if (req.body && typeof req.body === 'object') return req.body;
  if (typeof req.body === 'string') return JSON.parse(req.body || '{}');
  const chunks = [];
  let size = 0;
  for await (const chunk of req) {
    size += chunk.length;
    if (size > limitBytes) throw Object.assign(new Error('Request too large.'), { status: 413 });
    chunks.push(chunk);
  }
  return JSON.parse(Buffer.concat(chunks).toString('utf8') || '{}');
}

module.exports = {
  LANGS, SLUG_RE, config, send, fail, safeEqual, issueCookie, clearCookie, isAuthenticated, sameOrigin, guard,
  gh, getFile, putFile, deleteFile, buildMarkdown, parseMarkdown, readJson,
};
