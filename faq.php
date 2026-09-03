<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-faq.php';

$groups = faq_groups();

$page = [
    'title'       => 'Frequently Asked Questions | Cameroon Legal Advice | Fonju Law Firm',
    'description' => 'Answers on fees, consultations, company registration, land title checks, dismissals, arbitration and investing in Cameroon. Asked and answered plainly.',
    'canonical'   => 'faq.php',
    'breadcrumbs' => [['name' => 'FAQ', 'url' => 'faq.php']],
    'body_class'  => 'page-faq',
    'schema'      => [[
        '@type'      => 'FAQPage',
        '@id'        => SITE_URL . '/faq.php#faq',
        'mainEntity' => array_map(static fn(array $item): array => [
            '@type'          => 'Question',
            'name'           => strip_tags($item['q']),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => strip_tags($item['a']),
            ],
        ], faq_flat()),
    ]],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Frequently asked questions',
    'title'   => 'Straight answers to<br>the questions we hear most',
    'lede'    => 'Fees, timelines, procedure and the things that most often go wrong. If your question is not here, ask it directly &mdash; we answer every enquiry within one business day.',
];
require __DIR__ . '/includes/page-hero.php';

$groupIcons = [
    'Working with the firm'          => 'users',
    'Starting and running a business' => 'building',
    'Property and land'              => 'pin',
    'Employment and staff'           => 'doc',
    'Disputes and litigation'        => 'gavel',
    'Foreign clients and investors'  => 'globe',
];

$counter = 0;
?>

<section class="section">
  <div class="wrap detail">

    <div class="detail__main">
      <?php foreach ($groups as $groupName => $questions): ?>
        <section class="faq-group reveal" id="<?= e(strtolower(str_replace(' ', '-', $groupName))) ?>">
          <h2 class="faq-group__title">
            <?= icon($groupIcons[$groupName] ?? 'scale', 22) ?>
            <?= e($groupName) ?>
          </h2>

          <div class="accordion">
            <?php foreach ($questions as $item): $counter++; ?>
              <div class="accordion__item" id="q-<?= $counter ?>">
                <h3 class="mb-0">
                  <button class="accordion__trigger" type="button"
                          aria-expanded="false"
                          aria-controls="faq-panel-<?= $counter ?>"
                          id="faq-trigger-<?= $counter ?>">
                    <span><?= $item['q'] ?></span>
                    <span class="accordion__icon" aria-hidden="true"><?= icon('plus', 15) ?></span>
                  </button>
                </h3>
                <div class="accordion__panel" id="faq-panel-<?= $counter ?>" role="region" aria-labelledby="faq-trigger-<?= $counter ?>">
                  <div class="accordion__inner"><?= $item['a'] ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>
    </div>

    <aside class="sidebar">
      <div class="sidebar__box">
        <h3>Jump to a topic</h3>
        <ul class="sidebar__list">
          <?php foreach (array_keys($groups) as $groupName): ?>
            <li><a href="#<?= e(strtolower(str_replace(' ', '-', $groupName))) ?>"><?= e($groupName) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="sidebar__box sidebar__box--dark">
        <h3>Question not answered?</h3>
        <p style="font-size:.98rem;">Ask it directly. There is no charge for finding out whether you have a problem worth solving.</p>
        <ul class="contact-list" style="margin-top:1.1rem;">
          <li><?= icon('phone', 17) ?><a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a></li>
          <li><?= icon('mail', 17) ?><a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a></li>
        </ul>
        <a class="btn btn--gold btn--block mt-5" href="<?= e(url('contact.php')) ?>#consultation">Ask your question</a>
      </div>

      <div class="sidebar__box">
        <h3>Related reading</h3>
        <ul class="sidebar__list">
          <li><a href="<?= e(url('blog.php')) ?>">Insights &amp; legal updates</a></li>
          <li><a href="<?= e(url('practice-areas.php')) ?>">All practice areas</a></li>
          <li><a href="<?= e(url('about.php')) ?>">About the firm</a></li>
          <li><a href="<?= e(url('legal-notice.php')) ?>">Legal notice &amp; disclaimer</a></li>
        </ul>
      </div>
    </aside>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
