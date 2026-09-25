/* ==========================================================================
   FONJU LAW FIRM — INTERACTION LAYER
   No dependencies. Everything degrades gracefully without JavaScript.
   ========================================================================== */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------------------------------------------------------------- Header */
  var header = document.getElementById('siteHeader');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('is-stuck', window.scrollY > 20);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ----------------------------------------------------------- Mobile menu */
  var toggle = document.getElementById('navToggle');
  var mobileNav = document.getElementById('mobileNav');

  if (toggle && mobileNav) {
    var closeMenu = function () {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', toggle.getAttribute('data-label-open') || 'Open menu');
      mobileNav.hidden = true;
      document.body.classList.remove('is-locked');
    };

    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      if (open) {
        closeMenu();
      } else {
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', toggle.getAttribute('data-label-close') || 'Close menu');
        mobileNav.hidden = false;
        document.body.classList.add('is-locked');
      }
    });

    mobileNav.addEventListener('click', function (event) {
      if (event.target.closest('a')) closeMenu();
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
        closeMenu();
        toggle.focus();
      }
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 980 && toggle.getAttribute('aria-expanded') === 'true') closeMenu();
    });
  }

  /* ------------------------------------------------------ Scroll reveal */
  var revealables = document.querySelectorAll('.reveal');

  if (revealables.length) {
    if (reduceMotion || !('IntersectionObserver' in window)) {
      revealables.forEach(function (el) { el.classList.add('is-in'); });
    } else {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-in');
            revealObserver.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

      revealables.forEach(function (el) { revealObserver.observe(el); });
    }
  }

  /* -------------------------------------------------------- Count-up stats */
  var counters = document.querySelectorAll('[data-count]');

  if (counters.length && !reduceMotion && 'IntersectionObserver' in window) {
    var countObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;

        var el = entry.target;
        var target = parseFloat(el.getAttribute('data-count'));
        var suffix = el.getAttribute('data-suffix') || '';
        var started = null;

        var step = function (timestamp) {
          if (started === null) started = timestamp;
          var progress = Math.min((timestamp - started) / 1600, 1);
          var eased = 1 - Math.pow(1 - progress, 3);
          el.textContent = Math.round(target * eased) + suffix;
          if (progress < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
        countObserver.unobserve(el);
      });
    }, { threshold: 0.5 });

    counters.forEach(function (el) { countObserver.observe(el); });
  }

  /* ------------------------------------------------------------- Accordion */
  document.querySelectorAll('.accordion').forEach(function (accordion) {
    var triggers = accordion.querySelectorAll('.accordion__trigger');

    triggers.forEach(function (trigger) {
      var panel = document.getElementById(trigger.getAttribute('aria-controls'));
      if (!panel) return;

      // Restore height on resize for any panel left open.
      var setOpenHeight = function () {
        if (trigger.getAttribute('aria-expanded') === 'true') {
          panel.style.height = panel.firstElementChild.offsetHeight + 'px';
        }
      };
      window.addEventListener('resize', setOpenHeight);

      trigger.addEventListener('click', function () {
        var isOpen = trigger.getAttribute('aria-expanded') === 'true';

        if (isOpen) {
          panel.style.height = panel.firstElementChild.offsetHeight + 'px';
          requestAnimationFrame(function () { panel.style.height = '0px'; });
          trigger.setAttribute('aria-expanded', 'false');
          return;
        }

        // Close siblings within the same accordion (single-open behaviour).
        triggers.forEach(function (other) {
          if (other === trigger || other.getAttribute('aria-expanded') !== 'true') return;
          var otherPanel = document.getElementById(other.getAttribute('aria-controls'));
          other.setAttribute('aria-expanded', 'false');
          if (otherPanel) {
            otherPanel.style.height = otherPanel.firstElementChild.offsetHeight + 'px';
            requestAnimationFrame(function () { otherPanel.style.height = '0px'; });
          }
        });

        trigger.setAttribute('aria-expanded', 'true');
        panel.style.height = panel.firstElementChild.offsetHeight + 'px';

        panel.addEventListener('transitionend', function once(event) {
          if (event.propertyName !== 'height') return;
          if (trigger.getAttribute('aria-expanded') === 'true') panel.style.height = 'auto';
          panel.removeEventListener('transitionend', once);
        });
      });
    });
  });

  // Deep-link support: /faq.php#q-3 opens that question.
  if (window.location.hash) {
    var target = document.querySelector(window.location.hash + ' .accordion__trigger, ' + window.location.hash);
    if (target && target.classList.contains('accordion__trigger')) {
      target.click();
      target.scrollIntoView({ block: 'center' });
    }
  }

  /* ------------------------------------------ Filter chips + text search
     Both criteria are applied together, so filtering by group and then
     typing a query narrows the list instead of the two fighting each other. */
  var filterBar = document.querySelector('[data-filter-bar]');
  var searchInput = document.querySelector('[data-search]');

  if (filterBar || searchInput) {
    var items = document.querySelectorAll('[data-group], [data-search-text]');
    var emptyState = document.querySelector('[data-filter-empty], [data-search-empty]');
    var activeGroup = 'all';

    var applyFilters = function () {
      var query = searchInput ? searchInput.value.trim().toLowerCase() : '';
      var shown = 0;

      items.forEach(function (item) {
        var groupOk = activeGroup === 'all' || item.getAttribute('data-group') === activeGroup;
        var text = item.getAttribute('data-search-text') || '';
        var queryOk = query === '' || text.toLowerCase().indexOf(query) !== -1;
        var match = groupOk && queryOk;

        item.hidden = !match;
        if (match) shown++;
      });

      if (emptyState) emptyState.hidden = shown !== 0;
    };

    if (filterBar) {
      filterBar.addEventListener('click', function (event) {
        var chip = event.target.closest('.filter-chip');
        if (!chip) return;

        activeGroup = chip.getAttribute('data-filter');

        filterBar.querySelectorAll('.filter-chip').forEach(function (c) {
          c.classList.toggle('is-active', c === chip);
          c.setAttribute('aria-pressed', c === chip ? 'true' : 'false');
        });

        applyFilters();
      });
    }

    if (searchInput) {
      searchInput.addEventListener('input', applyFilters);
    }
  }

  /* ------------------------------------------------------------- Back to top */
  var toTop = document.getElementById('toTop');

  if (toTop) {
    window.addEventListener('scroll', function () {
      toTop.classList.toggle('is-visible', window.scrollY > 700);
    }, { passive: true });

    toTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
    });
  }

  /* --------------------------------------------------------- Copy link button */
  document.querySelectorAll('[data-copy-link]').forEach(function (button) {
    button.addEventListener('click', function () {
      var url = button.getAttribute('data-copy-link') || window.location.href;
      var done = function () {
        var original = button.getAttribute('aria-label');
        button.setAttribute('aria-label', button.getAttribute('data-copied-label') || 'Link copied');
        button.classList.add('is-copied');
        setTimeout(function () {
          button.setAttribute('aria-label', original);
          button.classList.remove('is-copied');
        }, 2000);
      };

      if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(done, function () {});
      }
    });
  });

  /* ------------------------------------------- Client-side form validation */
  document.querySelectorAll('form[data-validate]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      var firstInvalid = null;

      form.querySelectorAll('[required]').forEach(function (field) {
        var valid = field.type === 'checkbox' ? field.checked : field.value.trim() !== '';
        if (field.type === 'email' && valid) {
          valid = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(field.value.trim());
        }
        field.setAttribute('aria-invalid', valid ? 'false' : 'true');
        if (!valid && !firstInvalid) firstInvalid = field;
      });

      if (firstInvalid) {
        event.preventDefault();
        firstInvalid.focus();
        firstInvalid.scrollIntoView({ block: 'center', behavior: reduceMotion ? 'auto' : 'smooth' });
      }
    });
  });

  /* ----------------------------------------- Duplicate marquee for seamless loop */
  document.querySelectorAll('.marquee__track').forEach(function (track) {
    track.innerHTML += track.innerHTML;
  });

  /* ---------------------------------------------------------- Cookie consent
     Optional categories: "analytics" (Google Analytics, only when an ID is
     configured in includes/config.php) and "media" (the Google Map). Nothing
     in either category loads until the visitor agrees. The choice is kept in
     localStorage under "fonju-consent"; bumping `version` in header.php asks
     every visitor again. */
  var CONSENT_KEY = 'fonju-consent';
  var consentCfg = window.FONJU_CONSENT || { ga: '', version: 1 };
  var banner = document.getElementById('consent');

  var readConsent = function () {
    try {
      var data = JSON.parse(localStorage.getItem(CONSENT_KEY) || 'null');
      return data && data.version === consentCfg.version ? data : null;
    } catch (e) {
      return null;
    }
  };

  var writeConsent = function (choice) {
    choice.version = consentCfg.version;
    choice.date = new Date().toISOString();
    try { localStorage.setItem(CONSENT_KEY, JSON.stringify(choice)); } catch (e) { /* private mode: applies to this page only */ }
    return choice;
  };

  var gaLoaded = false;
  var loadAnalytics = function () {
    if (gaLoaded || !consentCfg.ga) return;
    gaLoaded = true;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', consentCfg.ga);
    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(consentCfg.ga);
    document.head.appendChild(script);
  };

  var loadEmbeds = function () {
    document.querySelectorAll('[data-consent-embed="media"]:not(.is-loaded)').forEach(function (box) {
      var frame = document.createElement('iframe');
      frame.src = box.getAttribute('data-embed-src');
      frame.title = box.getAttribute('data-embed-title') || '';
      frame.loading = 'lazy';
      frame.referrerPolicy = 'no-referrer-when-downgrade';
      frame.allowFullscreen = true;
      box.innerHTML = '';
      box.appendChild(frame);
      box.classList.add('is-loaded');
    });
  };

  var applyConsent = function (choice) {
    if (choice && choice.analytics) loadAnalytics();
    if (choice && choice.media) loadEmbeds();
  };

  if (banner) {
    var choicesBox = document.getElementById('consentChoices');
    var saveBtn = banner.querySelector('[data-consent="save"]');
    var moreBtn = banner.querySelector('[data-consent="customise"]');
    var boxes = banner.querySelectorAll('[data-consent-category]');

    var setCustomise = function (open) {
      choicesBox.hidden = !open;
      saveBtn.hidden = !open;
      moreBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    var showBanner = function (current) {
      boxes.forEach(function (box) {
        box.checked = !!(current && current[box.getAttribute('data-consent-category')]);
      });
      banner.hidden = false;
    };

    var decide = function (choice) {
      var previous = readConsent();
      var saved = writeConsent(choice);
      banner.hidden = true;

      // Withdrawing analytics after it has run: clear its cookies and reload,
      // which is the only way to stop a script that has already started.
      if (previous && previous.analytics && !saved.analytics && gaLoaded) {
        document.cookie.split(';').forEach(function (cookie) {
          var name = cookie.split('=')[0].trim();
          if (/^_ga/.test(name)) {
            document.cookie = name + '=; Max-Age=0; path=/';
            document.cookie = name + '=; Max-Age=0; path=/; domain=.' + location.hostname.replace(/^www\./, '');
          }
        });
        location.reload();
        return;
      }

      applyConsent(saved);
    };

    banner.addEventListener('click', function (event) {
      var button = event.target.closest('[data-consent]');
      if (!button) return;

      switch (button.getAttribute('data-consent')) {
        case 'accept':
          decide({ analytics: true, media: true });
          break;
        case 'reject':
          decide({ analytics: false, media: false });
          break;
        case 'customise':
          setCustomise(choicesBox.hidden);
          break;
        case 'save':
          var choice = { analytics: false, media: false };
          boxes.forEach(function (box) { choice[box.getAttribute('data-consent-category')] = box.checked; });
          decide(choice);
          break;
      }
    });

    // "Cookie settings" in the footer reopens the banner with the choices shown.
    document.querySelectorAll('[data-cookie-settings]').forEach(function (link) {
      link.addEventListener('click', function () {
        setCustomise(true);
        showBanner(readConsent());
        banner.querySelector('button').focus();
      });
    });

    // "Show the map" records consent for that category only.
    document.querySelectorAll('[data-consent-load]').forEach(function (button) {
      button.addEventListener('click', function () {
        var current = readConsent() || { analytics: false, media: false };
        current[button.getAttribute('data-consent-load')] = true;
        decide(current);
      });
    });

    var stored = readConsent();
    if (stored) {
      applyConsent(stored);
    } else {
      showBanner(null);
    }
  }
})();
