/* Fonju Law Firm — article admin.
 * Talks to the serverless functions in /api (see api/_lib.js). Articles are
 * Markdown files; the preview below mirrors the site's own Markdown support
 * (includes/content.php), so what you see is what gets published. */
(function () {
  'use strict';

  var $ = function (id) { return document.getElementById(id); };
  var state = { lang: 'en', articles: { en: [], fr: [] }, current: null, dirty: false, slugTouched: false };

  var CATEGORIES = {
    en: ['Corporate', 'Dispute Resolution', 'Employment', 'Intellectual Property', 'Investment', 'Real Estate', 'Regulatory', 'Technology', 'iGaming'],
    fr: ['Droit des sociétés', 'Contentieux', 'Droit du travail', 'Propriété intellectuelle', 'Investissement', 'Immobilier', 'Réglementation', 'Technologies', 'Jeux en ligne'],
  };
  var AUTHORS = { en: 'Fonju Law Firm', fr: 'Cabinet Fonju' };

  // ------------------------------------------------------------------ API
  function api(path, options) {
    options = options || {};
    var headers = { 'X-Fonju-Admin': '1' };
    if (options.body) headers['Content-Type'] = 'application/json';
    return fetch(path, {
      method: options.method || 'GET',
      credentials: 'same-origin',
      headers: headers,
      body: options.body ? JSON.stringify(options.body) : undefined,
    }).then(function (response) {
      return response.json().catch(function () { return { ok: false, error: 'Unexpected response (' + response.status + ').' }; })
        .then(function (data) {
          if (response.status === 401 && path !== '/api/session') {
            show('login');
            throw new Error(data.error || 'Please sign in again.');
          }
          if (!response.ok || !data.ok) throw new Error(data.error || 'Something went wrong.');
          return data;
        });
    });
  }

  // ------------------------------------------------------------------ UI helpers
  function show(view) {
    ['Login', 'Setup', 'List', 'Editor'].forEach(function (v) { $('view' + v).hidden = v.toLowerCase() !== view; });
    $('barRight').hidden = view === 'login' || view === 'setup';
    window.scrollTo(0, 0);
  }

  var toastTimer;
  function toast(message, isError) {
    var el = $('toast');
    el.textContent = message;
    el.classList.toggle('is-error', !!isError);
    el.hidden = false;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { el.hidden = true; }, isError ? 7000 : 4500);
  }

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function today() { return new Date().toISOString().slice(0, 10); }

  function slugify(text) {
    return String(text).toLowerCase()
      .normalize('NFD').replace(/[̀-ͯ]/g, '')
      .replace(/œ/g, 'oe').replace(/æ/g, 'ae')
      .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '')
      .slice(0, 80).replace(/-+$/, '');
  }

  function liveUrl(lang, slug) { return (lang === 'fr' ? '/fr' : '') + '/insights/' + slug; }

  function formatDate(ymd, lang) {
    if (!ymd) return '';
    var d = new Date(ymd + 'T12:00:00');
    return d.toLocaleDateString(lang === 'fr' ? 'fr-FR' : 'en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
  }

  // ------------------------------------------------------------------ Markdown preview
  function inline(text) {
    var stash = [];
    var keep = function (html) { stash.push(html); return '\u0001' + (stash.length - 1) + '\u0001'; };
    text = text.replace(/\\([\\`*_{}\[\]()#+\-.!>~|])/g, function (m, c) { return keep(esc(c)); });
    text = text.replace(/`([^`]+)`/g, function (m, c) { return keep('<code>' + esc(c) + '</code>'); });
    text = text.replace(/!\[([^\]]*)\]\(\s*<?([^)\s>]+)>?(?:\s+"([^"]*)")?\s*\)/g, function (m, alt, src) {
      return keep('<img src="' + esc(/^\s*(javascript|data|vbscript):/i.test(src) ? '#' : src) + '" alt="' + esc(alt) + '">');
    });
    text = text.replace(/\[([^\]]+)\]\(\s*<?([^)\s>]+)>?(?:\s+"([^"]*)")?\s*\)/g, function (m, label, href) {
      return keep('<a href="' + esc(/^\s*(javascript|data|vbscript):/i.test(href) ? '#' : href) + '" target="_blank" rel="noopener">') + label + keep('</a>');
    });
    text = esc(text);
    text = text.replace(/\*\*(?=\S)([\s\S]+?)(?<=\S)\*\*/g, '<strong>$1</strong>')
      .replace(/__(?=\S)([\s\S]+?)(?<=\S)__/g, '<strong>$1</strong>')
      .replace(/(^|[^*\w])\*(?=\S)([\s\S]+?)(?<=\S)\*(?![*\w])/g, '$1<em>$2</em>')
      .replace(/(^|[^_\w])_(?=\S)([\s\S]+?)(?<=\S)_(?![_\w])/g, '$1<em>$2</em>')
      .replace(/~~(?=\S)([\s\S]+?)(?<=\S)~~/g, '<del>$1</del>');
    return text.replace(/\u0001(\d+)\u0001/g, function (m, i) { return stash[+i]; });
  }

  function markdown(md) {
    var lines = md.replace(/\r\n?/g, '\n').trim().split('\n');
    var out = [], i = 0;
    var isBlock = function (l) { return /^(#{1,6}\s|>|\s*[-*+]\s+|\s*\d+[.)]\s+|(\*\s*){3,}$|(-\s*){3,}$)/.test(l); };

    while (i < lines.length) {
      var line = lines[i], m;
      if (!line.trim()) { i++; continue; }

      if ((m = line.match(/^(#{1,6})\s+(.+?)\s*#*$/))) {
        var level = Math.max(2, Math.min(6, m[1].length));
        out.push('<h' + level + '>' + inline(m[2]) + '</h' + level + '>');
        i++; continue;
      }
      if (/^((\*\s*){3,}|(-\s*){3,}|(_\s*){3,})$/.test(line.trim())) { out.push('<hr>'); i++; continue; }

      if (line.charAt(0) === '>') {
        var quote = [];
        while (i < lines.length && (lines[i].charAt(0) === '>' || (lines[i].trim() && quote.length && !isBlock(lines[i])))) {
          quote.push(lines[i++].replace(/^>\s?/, ''));
        }
        out.push('<blockquote>' + markdown(quote.join('\n')) + '</blockquote>');
        continue;
      }

      if ((m = line.match(/^\s*([-*+]|\d+[.)])\s+/))) {
        var ordered = /\d/.test(m[1].charAt(0));
        var re = ordered ? /^\s*\d+[.)]\s+(.*)$/ : /^\s*[-*+]\s+(.*)$/;
        var items = [];
        while (i < lines.length) {
          var lm = lines[i].match(re);
          if (lm) { items.push(lm[1]); i++; }
          else if (lines[i].trim() && items.length && /^\s{2,}\S/.test(lines[i])) { items[items.length - 1] += ' ' + lines[i].trim(); i++; }
          else if (!lines[i].trim() && i + 1 < lines.length && re.test(lines[i + 1])) { i++; }
          else break;
        }
        var tag = ordered ? 'ol' : 'ul';
        out.push('<' + tag + '>' + items.map(function (t) { return '<li>' + inline(t) + '</li>'; }).join('') + '</' + tag + '>');
        continue;
      }

      var para = [];
      while (i < lines.length && lines[i].trim() && (!para.length || !isBlock(lines[i]))) para.push(lines[i++]);
      var html = inline(para.join(' ').replace(/\s+/g, ' ').trim());
      out.push(/^<img [^>]+>$/.test(html) ? '<figure>' + html + '</figure>' : '<p>' + html + '</p>');
    }
    return out.join('\n');
  }

  // ------------------------------------------------------------------ sign in
  function start() {
    fetch('/api/session', { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.configured) {
          $('setupError').textContent = 'The server settings (password, session secret and GitHub access) have not been added yet.';
          show('setup');
        } else if (data.signedIn) {
          openList();
        } else {
          show('login');
          $('password').focus();
        }
      })
      .catch(function () {
        $('setupError').textContent = 'The admin service could not be reached. It only runs on the live (Vercel) website, not on a local copy.';
        show('setup');
      });
  }

  $('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var button = $('loginBtn');
    button.disabled = true;
    $('loginError').hidden = true;
    api('/api/session', { method: 'POST', body: { password: $('password').value } })
      .then(function () { $('password').value = ''; openList(); })
      .catch(function (error) { $('loginError').textContent = error.message; $('loginError').hidden = false; })
      .then(function () { button.disabled = false; });
  });

  $('signOut').addEventListener('click', function () {
    if (!confirmLeave()) return;
    api('/api/session', { method: 'DELETE' }).catch(function () {}).then(function () { state.dirty = false; show('login'); });
  });

  // ------------------------------------------------------------------ list
  function openList() {
    show('list');
    refreshStatus();
    $('articleList').innerHTML = '<p class="muted list__empty">Loading articles…</p>';
    return api('/api/articles').then(function (data) {
      state.articles = data.articles;
      renderList();
    }).catch(function (error) {
      $('articleList').innerHTML = '<p class="error" style="margin:1rem">' + esc(error.message) + '</p>';
    });
  }

  function renderList() {
    $('countEn').textContent = state.articles.en.length;
    $('countFr').textContent = state.articles.fr.length;
    document.querySelectorAll('.tab').forEach(function (tab) {
      var active = tab.getAttribute('data-lang') === state.lang;
      tab.classList.toggle('is-active', active);
      tab.setAttribute('aria-selected', active ? 'true' : 'false');
    });

    var list = state.articles[state.lang];
    var other = state.articles[state.lang === 'fr' ? 'en' : 'fr'];
    if (!list.length) {
      $('articleList').innerHTML = '<p class="muted list__empty">No articles yet. Press “New article” to write the first one.</p>';
      return;
    }

    $('articleList').innerHTML = list.map(function (a) {
      var linked = a.translation || other.some(function (o) { return o.translation === a.slug; });
      var future = a.date > today();
      return '<div class="row">'
        + '<div><h2 class="row__title"><button type="button" data-edit="' + esc(a.slug) + '">' + esc(a.title) + '</button></h2>'
        + '<div class="row__meta"><span>' + esc(formatDate(a.date, state.lang)) + '</span><span>' + esc(a.category) + '</span>'
        + (a.draft ? '<span class="badge badge--draft">Draft</span>' : '')
        + (future && !a.draft ? '<span class="badge badge--future">Scheduled</span>' : '')
        + (linked ? '<span class="badge badge--linked">' + (state.lang === 'fr' ? 'EN' : 'FR') + ' version</span>' : '')
        + '</div></div>'
        + '<div class="row__actions">'
        + (a.draft || future ? '' : '<a class="btn btn--ghost btn--sm" href="' + liveUrl(state.lang, a.slug) + '" target="_blank" rel="noopener">View</a>')
        + '<button class="btn btn--ghost btn--sm" type="button" data-edit="' + esc(a.slug) + '">Edit</button>'
        + '</div></div>';
    }).join('');
  }

  document.querySelectorAll('.tab').forEach(function (tab) {
    tab.addEventListener('click', function () { state.lang = tab.getAttribute('data-lang'); renderList(); });
  });

  $('articleList').addEventListener('click', function (event) {
    var button = event.target.closest('[data-edit]');
    if (button) openEditor(state.lang, button.getAttribute('data-edit'));
  });

  $('newArticle').addEventListener('click', function () { openEditor(state.lang, null); });

  // ------------------------------------------------------------------ editor
  var fields = ['fTitle', 'fSlug', 'fLang', 'fDate', 'fUpdated', 'fCategory', 'fAuthor', 'fSeoTitle', 'fExcerpt', 'fTags', 'fDraft', 'fFeatured', 'fTranslation', 'fBody'];

  function fillTranslationOptions(lang, selected) {
    var other = lang === 'fr' ? 'en' : 'fr';
    $('translationLabel').textContent = lang === 'fr' ? 'Same article in English' : 'Same article in French';
    $('fTranslation').innerHTML = '<option value="">Not translated</option>' + state.articles[other].map(function (a) {
      return '<option value="' + esc(a.slug) + '"' + (a.slug === selected ? ' selected' : '') + '>' + esc(a.title) + '</option>';
    }).join('');
  }

  function fillCategories(lang) {
    var used = state.articles[lang].map(function (a) { return a.category; });
    var all = CATEGORIES[lang].concat(used).filter(function (c, i, arr) { return c && arr.indexOf(c) === i; }).sort();
    $('categoryList').innerHTML = all.map(function (c) { return '<option value="' + esc(c) + '">'; }).join('');
  }

  function setLangUi(lang) {
    $('slugPrefix').textContent = (lang === 'fr' ? '/fr' : '') + '/insights/';
    fillCategories(lang);
  }

  function setCover(url) {
    $('coverImg').src = url || '';
    $('coverImg').hidden = !url;
    $('coverEmpty').hidden = !!url;
    $('coverRemove').hidden = !url;
    $('coverImg').dataset.url = url || '';
  }

  function updateStats() {
    var words = ($('fBody').value.match(/\S+/g) || []).length;
    $('bodyStats').textContent = words + ' words · about ' + Math.max(1, Math.ceil(words / 200)) + ' min read';
    var n = $('fExcerpt').value.trim().length;
    $('excerptCount').textContent = n + ' characters' + (n > 160 ? ' — Google shows about 155, so the end may be cut off' : '');
  }

  function openEditor(lang, slug) {
    if (!confirmLeave()) return;
    state.dirty = false;
    state.slugTouched = !!slug;
    setMode('write');

    var load = slug
      ? api('/api/articles?lang=' + encodeURIComponent(lang) + '&slug=' + encodeURIComponent(slug)).then(function (d) { return d.article; })
      : Promise.resolve({ lang: lang, slug: '', title: '', date: today(), updated: '', category: '', author: AUTHORS[lang], seoTitle: '', excerpt: '', tags: [], image: '', featured: false, draft: false, translation: '', body: '', sha: '' });

    load.then(function (a) {
      state.current = { lang: a.lang, slug: a.slug, sha: a.sha || '' };
      $('fTitle').value = a.title;
      $('fSlug').value = a.slug;
      $('fSlug').disabled = !!a.sha;
      $('slugHint').textContent = a.sha ? 'The web address is fixed once an article is published.' : 'Created from the title. It cannot be changed after publishing.';
      $('fLang').value = a.lang;
      $('fLang').disabled = !!a.sha;
      $('fDate').value = a.date || today();
      $('fUpdated').value = a.updated || '';
      $('fCategory').value = a.category;
      $('fAuthor').value = a.author || AUTHORS[a.lang];
      $('fExcerpt').value = a.excerpt;
      $('fSeoTitle').value = a.seoTitle || '';
      $('fTags').value = (a.tags || []).join(', ');
      $('fDraft').checked = !!a.draft;
      $('fFeatured').checked = !!a.featured;
      $('fBody').value = a.body;
      setCover(a.image);
      setLangUi(a.lang);
      // The link may have been recorded on the other language's article.
      var reverse = a.slug && state.articles[a.lang === 'fr' ? 'en' : 'fr'].filter(function (o) { return o.translation === a.slug; })[0];
      fillTranslationOptions(a.lang, a.translation || (reverse ? reverse.slug : ''));
      $('deleteBtn').hidden = !a.sha;
      $('viewLive').hidden = !a.sha || a.draft;
      $('viewLive').href = liveUrl(a.lang, a.slug);
      $('saveBtn').textContent = a.sha ? 'Save changes' : 'Publish';
      updateSaveLabel();
      updateStats();
      show('editor');
      if (!a.sha) $('fTitle').focus();
    }).catch(function (error) { toast(error.message, true); });
  }

  function updateSaveLabel() {
    if (!state.current) return;
    var isNew = !state.current.sha;
    $('saveBtn').textContent = $('fDraft').checked ? 'Save draft' : (isNew ? 'Publish' : 'Save changes');
  }

  fields.forEach(function (id) {
    $(id).addEventListener('input', function () { state.dirty = true; });
    $(id).addEventListener('change', function () { state.dirty = true; });
  });

  $('fTitle').addEventListener('input', function () {
    if (!state.slugTouched && !$('fSlug').disabled) $('fSlug').value = slugify($('fTitle').value);
  });
  $('fSlug').addEventListener('input', function () {
    state.slugTouched = true;
    $('fSlug').value = $('fSlug').value.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-{2,}/g, '-');
  });
  $('fLang').addEventListener('change', function () {
    var lang = $('fLang').value;
    if (!$('fAuthor').value || $('fAuthor').value === AUTHORS[lang === 'fr' ? 'en' : 'fr']) $('fAuthor').value = AUTHORS[lang];
    setLangUi(lang);
    fillTranslationOptions(lang, '');
  });
  $('fDraft').addEventListener('change', updateSaveLabel);
  $('fBody').addEventListener('input', updateStats);
  $('fExcerpt').addEventListener('input', updateStats);

  function confirmLeave() {
    return !state.dirty || window.confirm('You have unsaved changes. Leave without saving?');
  }
  window.addEventListener('beforeunload', function (event) {
    if (state.dirty && !$('viewEditor').hidden) { event.preventDefault(); event.returnValue = ''; }
  });

  $('backToList').addEventListener('click', function () {
    if (!confirmLeave()) return;
    state.dirty = false;
    openList();
  });

  $('editorForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var article = {
      lang: $('fLang').value,
      slug: $('fSlug').value.replace(/^-+|-+$/g, ''),
      title: $('fTitle').value,
      date: $('fDate').value,
      updated: $('fUpdated').value,
      category: $('fCategory').value,
      author: $('fAuthor').value,
      seoTitle: $('fSeoTitle').value,
      excerpt: $('fExcerpt').value,
      tags: $('fTags').value.split(','),
      image: $('coverImg').dataset.url || '',
      featured: $('fFeatured').checked,
      draft: $('fDraft').checked,
      translation: $('fTranslation').value,
      body: $('fBody').value,
    };

    var button = $('saveBtn');
    var label = button.textContent;
    button.disabled = true;
    button.textContent = 'Saving…';

    api('/api/articles', { method: 'POST', body: { article: article, sha: state.current.sha } })
      .then(function (data) {
        var wasNew = !state.current.sha;
        state.current = { lang: article.lang, slug: article.slug, sha: data.sha };
        state.dirty = false;
        $('fSlug').disabled = true;
        $('fLang').disabled = true;
        $('deleteBtn').hidden = false;
        $('viewLive').hidden = article.draft;
        $('viewLive').href = liveUrl(article.lang, article.slug);
        toast(article.draft
          ? 'Draft saved. It will not appear on the site until you untick “Save as draft”.'
          : (wasNew ? 'Published. ' : 'Saved. ') + 'The website will show it in about two minutes.');
        setTimeout(refreshStatus, 4000);
      })
      .catch(function (error) { toast(error.message, true); })
      .then(function () { button.disabled = false; button.textContent = label; updateSaveLabel(); });
  });

  $('deleteBtn').addEventListener('click', function () {
    var c = state.current;
    if (!c || !c.sha) return;
    if (!window.confirm('Delete “' + $('fTitle').value + '”? It will be removed from the website.')) return;
    api('/api/articles?lang=' + c.lang + '&slug=' + encodeURIComponent(c.slug) + '&sha=' + encodeURIComponent(c.sha), { method: 'DELETE' })
      .then(function () { state.dirty = false; toast('Article deleted.'); openList(); })
      .catch(function (error) { toast(error.message, true); });
  });

  // ------------------------------------------------------------------ Markdown toolbar
  var body = $('fBody');

  function surround(before, after, placeholder) {
    var start = body.selectionStart, end = body.selectionEnd;
    var selected = body.value.slice(start, end) || placeholder;
    body.setRangeText(before + selected + after, start, end, 'end');
    body.setSelectionRange(start + before.length, start + before.length + selected.length);
    body.focus();
    body.dispatchEvent(new Event('input'));
  }

  function prefixLines(prefix, numbered) {
    var value = body.value;
    var start = value.lastIndexOf('\n', body.selectionStart - 1) + 1;
    var end = value.indexOf('\n', body.selectionEnd);
    if (end === -1) end = value.length;
    var lines = value.slice(start, end).split('\n');
    var text = lines.map(function (l, i) {
      var clean = l.replace(/^(#{1,6}\s+|>\s?|\s*[-*+]\s+|\s*\d+[.)]\s+)/, '');
      return (numbered ? (i + 1) + '. ' : prefix) + clean;
    }).join('\n');
    body.setRangeText(text, start, end, 'end');
    body.focus();
    body.dispatchEvent(new Event('input'));
  }

  document.querySelector('.md__bar').addEventListener('click', function (event) {
    var button = event.target.closest('[data-md]');
    if (!button) return;
    switch (button.getAttribute('data-md')) {
      case 'h2': prefixLines('## '); break;
      case 'h3': prefixLines('### '); break;
      case 'bold': surround('**', '**', 'bold text'); break;
      case 'italic': surround('*', '*', 'italic text'); break;
      case 'ul': prefixLines('- '); break;
      case 'ol': prefixLines('', true); break;
      case 'quote': prefixLines('> '); break;
      case 'link':
        var url = window.prompt('Link address (for example https://www.ohada.org):', 'https://');
        if (url && url !== 'https://') surround('[', '](' + url.trim() + ')', 'link text');
        break;
      case 'image': $('inlineImageFile').click(); break;
    }
  });

  function setMode(mode) {
    var preview = mode === 'preview';
    if (preview) $('preview').innerHTML = markdown(body.value) || '<p class="muted">Nothing to preview yet.</p>';
    $('preview').hidden = !preview;
    body.hidden = preview;
    document.querySelectorAll('.md__modes button').forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-mode') === mode); });
  }
  document.querySelector('.md__modes').addEventListener('click', function (event) {
    var button = event.target.closest('[data-mode]');
    if (button) setMode(button.getAttribute('data-mode'));
  });

  // ------------------------------------------------------------------ images
  /** Resize in the browser (max 1800px wide) so uploads are fast and small. */
  function prepareImage(file) {
    return new Promise(function (resolve, reject) {
      if (!/^image\/(jpeg|png|webp)$/.test(file.type)) return reject(new Error('Please choose a JPG, PNG or WebP image.'));
      var img = new Image();
      var reader = new FileReader();
      reader.onerror = function () { reject(new Error('The image could not be read.')); };
      reader.onload = function () { img.src = reader.result; };
      img.onerror = function () { reject(new Error('The image could not be read.')); };
      img.onload = function () {
        var max = 1800;
        var scale = Math.min(1, max / img.naturalWidth);
        var keepPng = file.type === 'image/png' && file.size < 700 * 1024 && scale === 1;
        if (keepPng) return resolve({ type: 'image/png', data: reader.result, name: file.name });
        var canvas = document.createElement('canvas');
        canvas.width = Math.round(img.naturalWidth * scale);
        canvas.height = Math.round(img.naturalHeight * scale);
        var ctx = canvas.getContext('2d');
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        resolve({ type: 'image/jpeg', data: canvas.toDataURL('image/jpeg', 0.84), name: file.name });
      };
      reader.readAsDataURL(file);
    });
  }

  function upload(file) {
    toast('Uploading image…');
    return prepareImage(file).then(function (image) {
      return api('/api/upload', { method: 'POST', body: image });
    }).then(function (data) {
      toast('Image uploaded.');
      return data.url;
    });
  }

  $('coverFile').addEventListener('change', function () {
    var file = this.files[0];
    this.value = '';
    if (!file) return;
    upload(file).then(function (url) { setCover(url); state.dirty = true; }).catch(function (error) { toast(error.message, true); });
  });
  $('coverRemove').addEventListener('click', function () { setCover(''); state.dirty = true; });

  $('inlineImageFile').addEventListener('change', function () {
    var file = this.files[0];
    this.value = '';
    if (!file) return;
    upload(file).then(function (url) {
      var alt = window.prompt('Describe the image in a few words (read aloud by screen readers):', '') || '';
      surround('\n![' + alt.replace(/[\[\]]/g, '') + '](' + url + ')\n', '', '');
    }).catch(function (error) { toast(error.message, true); });
  });

  // ------------------------------------------------------------------ build status
  var statusTimer;
  function refreshStatus() {
    clearTimeout(statusTimer);
    api('/api/status').then(function (data) {
      var el = $('buildStatus');
      if (!data.run) { el.hidden = true; return; }
      var run = data.run;
      el.hidden = false;
      el.className = 'build';
      if (run.status !== 'completed') {
        el.classList.add('is-busy');
        el.textContent = 'Updating the website…';
        statusTimer = setTimeout(refreshStatus, 15000);
      } else if (run.conclusion === 'success') {
        el.classList.add('is-ok');
        el.textContent = 'Website up to date';
      } else {
        el.classList.add('is-fail');
        el.textContent = 'Last update failed';
        el.title = 'Open the GitHub Actions log: ' + run.url;
      }
    }).catch(function () { $('buildStatus').hidden = true; });
  }

  start();
})();
