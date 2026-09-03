</main>

<?php if (empty($page['hide_cta'])): ?>
<section class="cta-band" aria-labelledby="ctaHeading">
  <div class="wrap cta-band__inner">
    <div class="cta-band__text reveal">
      <p class="eyebrow eyebrow--gold">Speak to a lawyer</p>
      <h2 id="ctaHeading" class="cta-band__title">Tell us what happened.<br>We will tell you where you stand.</h2>
      <p class="cta-band__lede">A first consultation gives you our view of your legal position, the realistic options with their cost and timeline, and a clear recommendation. If you do not need a lawyer, we will say so.</p>
    </div>
    <div class="cta-band__actions reveal">
      <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">Book a consultation <?= icon('arrow', 18) ?></a>
      <a class="btn btn--ghost btn--lg" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp', 18) ?> Chat on WhatsApp</a>
      <p class="cta-band__note"><?= icon('clock', 14) ?> We reply to enquiries within one business day.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<footer class="site-footer" role="contentinfo">
  <div class="wrap">
    <div class="site-footer__grid">

      <div class="site-footer__brand">
        <a class="brand brand--footer" href="<?= e(url('/')) ?>">
          <span class="brand__mark" aria-hidden="true">
            <svg viewBox="0 0 44 44" width="40" height="40" role="presentation">
              <rect x="1" y="1" width="42" height="42" rx="9" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".45"/>
              <path d="M22 8v28M13 14h18M15 20.5h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" fill="none"/>
              <path d="M13 14 8.5 24h9zM31 14l-4.5 10h9z" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
              <path d="M16.5 36h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="brand__text">
            <span class="brand__name">Fonju<em>Law Firm</em></span>
          </span>
        </a>
        <p class="site-footer__blurb">
          An international legal consultancy based in Douala, advising businesses and individuals
          across Cameroon and the wider CEMAC and OHADA region. Precision, proactive counsel and
          absolute confidentiality.
        </p>

        <p class="site-footer__sociallabel">Follow the firm</p>
        <?= social_links('socials socials--footer', 18) ?>
      </div>

      <nav class="site-footer__col" aria-label="Practice areas">
        <h2 class="site-footer__heading">Practice Areas</h2>
        <ul class="site-footer__links">
          <?php foreach (array_slice(practice_areas(), 0, 9) as $area): ?>
            <li><a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>"><?= e($area['title']) ?></a></li>
          <?php endforeach; ?>
          <li><a class="is-more" href="<?= e(url('practice-areas.php')) ?>">All practice areas <?= icon('arrow', 14) ?></a></li>
        </ul>
      </nav>

      <nav class="site-footer__col" aria-label="Firm">
        <h2 class="site-footer__heading">The Firm</h2>
        <ul class="site-footer__links">
          <li><a href="<?= e(url('about.php')) ?>">About Fonju Law Firm</a></li>
          <li><a href="<?= e(url('team.php')) ?>">Our legal team</a></li>
          <li><a href="<?= e(url('blog.php')) ?>">Insights &amp; legal updates</a></li>
          <li><a href="<?= e(url('faq.php')) ?>">Frequently asked questions</a></li>
          <li><a href="<?= e(url('contact.php')) ?>">Contact &amp; directions</a></li>
          <li><a href="<?= e(url('privacy.php')) ?>">Privacy policy</a></li>
          <li><a href="<?= e(url('legal-notice.php')) ?>">Legal notice &amp; disclaimer</a></li>
        </ul>
      </nav>

      <div class="site-footer__col site-footer__contact">
        <h2 class="site-footer__heading">Get in Touch</h2>
        <ul class="contact-list">
          <li>
            <?= icon('pin', 18) ?>
            <span><?= e(CONTACT['street']) ?><br><?= e(CONTACT['po_box']) ?><br><?= e(CONTACT['city']) ?>, <?= e(CONTACT['country']) ?></span>
          </li>
          <li>
            <?= icon('phone', 18) ?>
            <span>
              <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a><br>
              <a href="<?= e(tel_href(CONTACT['phone_secondary'])) ?>"><?= e(CONTACT['phone_secondary']) ?></a>
            </span>
          </li>
          <li>
            <?= icon('mail', 18) ?>
            <span>
              <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a><br>
              <a href="mailto:<?= e(CONTACT['email_principal']) ?>"><?= e(CONTACT['email_principal']) ?></a>
            </span>
          </li>
          <li>
            <?= icon('clock', 18) ?>
            <span>
              <?php foreach (OPENING_HOURS as $slot): ?>
                <?= e($slot['days']) ?>: <?= e($slot['hours']) ?><br>
              <?php endforeach; ?>
            </span>
          </li>
        </ul>
      </div>
    </div>

    <div class="site-footer__bottom">
      <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
      <p class="site-footer__disclaimer">
        The content of this website is general information about Cameroonian and OHADA law. It is not legal
        advice and does not create a lawyer–client relationship. Please seek advice on your specific circumstances.
      </p>
    </div>
  </div>
</footer>

<a class="float-wa" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" aria-label="Chat with Fonju Law Firm on WhatsApp">
  <?= icon('whatsapp', 26) ?>
  <span class="float-wa__label">Chat with us</span>
</a>

<button class="to-top" id="toTop" type="button" aria-label="Back to top"><?= icon('chevron', 20) ?></button>

<script src="<?= e(asset('js/main.js')) ?>?v=1.0.0" defer></script>
</body>
</html>
