/**
 * /api/status  (sign-in required)
 *   GET -> the latest run of the "Build static site" workflow, so the admin can
 *          say whether the last change is live yet. Needs "Actions: Read" on the
 *          GitHub token; without it the admin simply shows no status.
 */
'use strict';

const { send, fail, guard, gh } = require('./_lib');

module.exports = async (req, res) => {
  if (req.method !== 'GET') return fail(res, 405, 'Method not allowed.');
  const cfg = guard(req, res);
  if (!cfg) return;

  const r = await gh(cfg, '/actions/workflows/build-site.yml/runs?per_page=1&branch=' + encodeURIComponent(cfg.branch));
  if (!r.ok || !r.data || !Array.isArray(r.data.workflow_runs) || r.data.workflow_runs.length === 0) {
    return send(res, 200, { ok: true, run: null });
  }

  const run = r.data.workflow_runs[0];
  return send(res, 200, {
    ok: true,
    run: {
      status: run.status,          // queued | in_progress | completed
      conclusion: run.conclusion,  // success | failure | cancelled | null
      title: run.display_title,
      updated: run.updated_at,
      url: run.html_url,
    },
  });
};
