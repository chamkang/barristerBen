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
      toggle.setAttribute('aria-label', 'Open menu');
      mobileNav.hidden = true;
      document.body.classList.remove('is-locked');
    };

    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      if (open) {
        closeMenu();
      } else {
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Close menu');
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
        button.setAttribute('aria-label', 'Link copied');
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
})();
