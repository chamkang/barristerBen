<?php
declare(strict_types=1);

/**
 * The International clients page, shared by /international-clients.php and
 * /fr/international-clients.php. The language is set by the calling file;
 * the text lives in includes/data-international.php.
 */

require_once __DIR__ . '/data-international.php';

$c = international_content();

$page = [
    'title'       => $c['title'],
    'description' => $c['description'],
    'canonical'   => 'international-clients.php',
    'breadcrumbs' => [['name' => $c['crumb'], 'url' => 'international-clients.php']],
    'body_class'  => 'page-international',
    'cta'         => ['title' => $c['cta_h2'], 'lede' => $c['cta_p'], 'wa_text' => $c['wa_text']],
    'schema'      => [[
        '@type'      => 'FAQPage',
        '@id'        => abs_url('international-clients.php') . '#faq',
        'mainEntity' => array_map(static fn(array $item): array => [
            '@type'          => 'Question',
            'name'           => $item['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
        ], $c['faq']),
    ]],
];

require __DIR__ . '/header.php';

$hero = [
    'eyebrow' => $c['eyebrow'],
    'title'   => $c['h1'],
    'lede'    => e($c['lede']),
];
require __DIR__ . '/page-hero.php';
?>

<!-- ============================================================ WHO -->
<section class="section">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow"><?= e($c['who_eyebrow']) ?></p>
      <h2><?= $c['who_h2'] ?></h2>
    </div>

    <div class="grid grid--4">
      <?php foreach ($c['who'] as $i => $w): ?>
        <article class="card reveal" data-delay="<?= $i + 1 ?>">
          <span class="card__icon"><?= icon($w['icon'], 24) ?></span>
          <h3><?= e($w['h']) ?></h3>
          <p><?= e($w['p']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ QUESTIONS -->
<section class="section section--bone">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow"><?= e($c['ask_eyebrow']) ?></p>
      <h2><?= e($c['ask_h2']) ?></h2>
    </div>

    <ul class="ask-list reveal">
      <?php foreach ($c['ask'] as $a): ?>
        <li class="ask-list__item">
          <a class="ask-list__q" href="<?= e(url($a['href'])) ?>"><?= e($a['q']) ?> <?= icon('arrow', 15) ?></a>
          <?php if (!empty($a['more'])): ?>
            <a class="ask-list__more" href="<?= e(url($a['more'])) ?>"><?= icon('doc', 14) ?> <?= e($c['ask_more']) ?></a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============================================================ HOW -->
<section class="section">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow"><?= e($c['how_eyebrow']) ?></p>
      <h2><?= e($c['how_h2']) ?></h2>
      <div class="rule"></div>
      <figure class="intl-portrait">
        <img src="<?= e(asset('img/photos/founder-suit-720.jpg')) ?>" width="720" height="1080" loading="lazy"
             alt="<?= e(is_fr() ? 'Me Fonju Bernard Fuelancha, fondateur du cabinet' : 'Bar. Fonju Bernard Fuelancha, founder of the firm') ?>">
        <figcaption>
          <strong><?= e(is_fr() ? 'Me Fonju Bernard Fuelancha' : 'Bar. Fonju Bernard Fuelancha') ?></strong>
          <?= e(is_fr() ? 'Fondateur et associé gérant · ancien assistant juridique au TPIR (ONU)' : 'Founder & Managing Partner · former legal assistant, ICTR (United Nations)') ?>
        </figcaption>
      </figure>
      <ul class="pill-row mt-6">
        <li><span class="pill pill--gold"><?= icon('users', 14) ?> English &amp; Français</span></li>
        <li><span class="pill"><?= icon('clock', 14) ?> <?= e(t('We reply to enquiries within one business day.')) ?></span></li>
        <li><span class="pill"><?= icon('pin', 14) ?> Douala, <?= e(contact('country')) ?></span></li>
      </ul>
    </div>

    <div class="process reveal" data-delay="2">
      <?php foreach ($c['how'] as $i => $step): ?>
        <div class="process__step">
          <span class="process__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div class="process__body">
            <h3><?= e($step['h']) ?></h3>
            <p><?= e($step['p']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ FRAUD -->
<section class="section section--bone">
  <div class="wrap">
    <div class="caution reveal">
      <span class="caution__icon" aria-hidden="true"><?= icon('shield', 26) ?></span>
      <div>
        <h2 class="caution__title"><?= e($c['fraud_h2']) ?></h2>
        <?php foreach ($c['fraud'] as $p): ?>
          <p><?= e($p) ?></p>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ FAQ -->
<section class="section">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow"><?= e($c['faq_eyebrow']) ?></p>
      <h2><?= e($c['faq_h2']) ?></h2>
    </div>

    <div class="accordion reveal intl-faq">
      <?php foreach ($c['faq'] as $n => $item): ?>
        <div class="accordion__item" id="q-<?= $n + 1 ?>">
          <h3 class="mb-0">
            <button class="accordion__trigger" type="button" aria-expanded="false"
                    aria-controls="intl-panel-<?= $n + 1 ?>" id="intl-trigger-<?= $n + 1 ?>">
              <span><?= e($item['q']) ?></span>
              <span class="accordion__icon" aria-hidden="true"><?= icon('plus', 15) ?></span>
            </button>
          </h3>
          <div class="accordion__panel" id="intl-panel-<?= $n + 1 ?>" role="region" aria-labelledby="intl-trigger-<?= $n + 1 ?>">
            <div class="accordion__inner"><p><?= e($item['a']) ?></p></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/footer.php'; ?>
