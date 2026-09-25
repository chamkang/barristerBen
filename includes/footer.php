</main>

<?php if (empty($page['hide_cta'])): ?>
<section class="cta-band" aria-labelledby="ctaHeading">
  <div class="wrap cta-band__inner">
    <div class="cta-band__text reveal">
      <p class="eyebrow eyebrow--gold"><?= e(t('Speak to a lawyer')) ?></p>
      <h2 id="ctaHeading" class="cta-band__title"><?= t('Tell us what happened.<br>We will tell you where you stand.') ?></h2>
      <p class="cta-band__lede"><?= e(t('A first consultation gives you our view of your legal position, the realistic options with their cost and timeline, and a clear recommendation. If you do not need a lawyer, we will say so.')) ?></p>
    </div>
    <div class="cta-band__actions reveal">
      <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation"><?= e(t('Book a consultation')) ?> <?= icon('arrow', 18) ?></a>
      <a class="btn btn--ghost btn--lg" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp', 18) ?> <?= e(t('Chat on WhatsApp')) ?></a>
      <p class="cta-band__note"><?= icon('clock', 14) ?> <?= e(t('We reply to enquiries within one business day.')) ?></p>
    </div>
  </div>
</section>
<?php endif; ?>

<footer class="site-footer" role="contentinfo">
  <div class="wrap">
    <div class="site-footer__grid">

      <div class="site-footer__brand">
        <a class="brand brand--footer" href="<?= e(url('/')) ?>">
          <span class="brand__mark" aria-hidden="true"><?= brand_mark(52) ?></span>
          <span class="brand__text">
            <span class="brand__name">Fonju</span>
            <span class="brand__sub"><?= e(t('Law Firm · Douala')) ?></span>
          </span>
        </a>
        <p class="site-footer__blurb"><?= e(t('An international legal consultancy based in Douala, advising businesses and individuals across Cameroon and the wider CEMAC and OHADA region. Precision, proactive counsel and absolute confidentiality.')) ?></p>

        <p class="site-footer__sociallabel"><?= e(t('Follow the firm')) ?></p>
        <?= social_links('socials socials--footer', 18) ?>
      </div>

      <nav class="site-footer__col" aria-label="<?= e(t('Practice Areas')) ?>">
        <h2 class="site-footer__heading"><?= e(t('Practice Areas')) ?></h2>
        <ul class="site-footer__links">
          <?php foreach (array_slice(practice_areas(), 0, 9) as $area): ?>
            <li><a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>"><?= e($area['title']) ?></a></li>
          <?php endforeach; ?>
          <li><a class="is-more" href="<?= e(url('practice-areas.php')) ?>"><?= e(t('All practice areas')) ?> <?= icon('arrow', 14) ?></a></li>
        </ul>
      </nav>

      <nav class="site-footer__col" aria-label="<?= e(t('The Firm')) ?>">
        <h2 class="site-footer__heading"><?= e(t('The Firm')) ?></h2>
        <ul class="site-footer__links">
          <li><a href="<?= e(url('about.php')) ?>"><?= e(t('About Fonju Law Firm')) ?></a></li>
          <li><a href="<?= e(url('team.php')) ?>"><?= e(t('Our legal team')) ?></a></li>
          <li><a href="<?= e(url('blog.php')) ?>"><?= e(t('Insights & legal updates')) ?></a></li>
          <li><a href="<?= e(url('faq.php')) ?>"><?= e(t('Frequently asked questions')) ?></a></li>
          <li><a href="<?= e(url('contact.php')) ?>"><?= e(t('Contact & directions')) ?></a></li>
          <li><a href="<?= e(url('privacy.php')) ?>"><?= e(t('Privacy policy')) ?></a></li>
          <li><a href="<?= e(url('legal-notice.php')) ?>"><?= e(t('Legal notice & disclaimer')) ?></a></li>
        </ul>
      </nav>

      <div class="site-footer__col site-footer__contact">
        <h2 class="site-footer__heading"><?= e(t('Get in Touch')) ?></h2>
        <ul class="contact-list">
          <li>
            <?= icon('pin', 18) ?>
            <span><?= e(contact('street')) ?><br><?= e(contact('po_box')) ?><br><?= e(contact('city')) ?>, <?= e(contact('country')) ?></span>
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
              <?php foreach (opening_hours() as $slot): ?>
                <?= e($slot['days']) ?><?= is_fr() ? '&nbsp;:' : ':' ?> <?= e($slot['hours']) ?><br>
              <?php endforeach; ?>
            </span>
          </li>
        </ul>
      </div>
    </div>

    <div class="site-footer__bottom">
      <p>
        &copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. <?= e(t('All rights reserved.')) ?>
        <span class="site-footer__sep" aria-hidden="true">·</span>
        <button class="site-footer__linkbtn" type="button" data-cookie-settings><?= e(t('Cookie settings')) ?></button>
        <span class="site-footer__sep" aria-hidden="true">·</span>
        <a href="<?= e($switchHref) ?>" hreflang="<?= e($otherLang) ?>" lang="<?= e($otherLang) ?>"><?= e($switchLabel) ?></a>
      </p>
      <p class="site-footer__disclaimer"><?= e(t('The content of this website is general information about Cameroonian and OHADA law. It is not legal advice and does not create a lawyer–client relationship. Please seek advice on your specific circumstances.')) ?></p>
    </div>
  </div>
</footer>

<a class="float-wa" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" aria-label="<?= e(t('Chat with Fonju Law Firm on WhatsApp')) ?>">
  <?= icon('whatsapp', 26) ?>
  <span class="float-wa__label"><?= e(t('Chat with us')) ?></span>
</a>

<button class="to-top" id="toTop" type="button" aria-label="<?= e(t('Back to top')) ?>"><?= icon('chevron', 20) ?></button>

<?php
/*
 * Cookie consent. The site sets no cookies of its own; the optional
 * categories are Google Analytics (only when an ID is configured) and
 * embedded third-party content (the Google Map on the contact page). Nothing
 * in either category loads until the visitor agrees. The choice is stored in
 * the browser (localStorage) and can be changed from "Cookie settings" in the
 * footer. The banner is driven by the consent manager in assets/js/main.js.
 */
?>
<section class="consent" id="consent" role="dialog" aria-modal="false" aria-labelledby="consentTitle" aria-describedby="consentText" hidden>
  <div class="consent__inner">
    <div class="consent__head">
      <span class="consent__mark" aria-hidden="true"><?= brand_mark(34) ?></span>
      <h2 class="consent__title" id="consentTitle"><?= e(t('Your privacy')) ?></h2>
    </div>
    <p class="consent__text" id="consentText">
      <?= e(t('We use optional cookies to understand how the site is used and to show the map on our contact page. They load only if you agree. The site works fully without them.')) ?>
      <a href="<?= e(url('privacy.php')) ?>#cookies"><?= e(t('Privacy policy')) ?></a>
    </p>

    <div class="consent__choices" id="consentChoices" hidden>
      <label class="consent__choice">
        <input type="checkbox" checked disabled>
        <span><strong><?= e(t('Essential')) ?></strong> <?= e(t('Remembers this choice. Always on.')) ?></span>
      </label>
      <?php if (GOOGLE_ANALYTICS_ID !== ''): ?>
      <label class="consent__choice">
        <input type="checkbox" data-consent-category="analytics">
        <span><strong><?= e(t('Analytics')) ?></strong> <?= e(t('Google Analytics: anonymous statistics on which pages are read.')) ?></span>
      </label>
      <?php endif; ?>
      <label class="consent__choice">
        <input type="checkbox" data-consent-category="media">
        <span><strong><?= e(t('Maps & embedded content')) ?></strong> <?= e(t('The Google Map on our contact page.')) ?></span>
      </label>
    </div>

    <div class="consent__actions">
      <button class="btn btn--gold btn--sm" type="button" data-consent="accept"><?= e(t('Accept all')) ?></button>
      <button class="btn btn--outline btn--sm" type="button" data-consent="reject"><?= e(t('Reject all')) ?></button>
      <button class="consent__more" type="button" data-consent="customise" aria-controls="consentChoices" aria-expanded="false"><?= e(t('Customise')) ?></button>
      <button class="btn btn--outline btn--sm" type="button" data-consent="save" hidden><?= e(t('Save my choices')) ?></button>
    </div>
  </div>
</section>

<script src="<?= e(asset('js/main.js')) ?>?v=2.1.0" defer></script>
</body>
</html>
