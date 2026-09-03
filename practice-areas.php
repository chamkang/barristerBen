<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';

$areas  = practice_areas();
$groups = practice_groups();

$page = [
    'title'       => 'Practice Areas | Corporate, Maritime & Litigation Lawyers in Cameroon',
    'description' => 'Twenty-one practice areas in Cameroon and CEMAC: corporate, banking, maritime, mining, IP, employment, litigation, arbitration, tax and immigration.',
    'canonical'   => 'practice-areas.php',
    'breadcrumbs' => [['name' => 'Practice Areas', 'url' => 'practice-areas.php']],
    'body_class'  => 'page-practice',
    'schema'      => [[
        '@type'           => 'ItemList',
        'name'            => 'Practice areas of Fonju Law Firm',
        'numberOfItems'   => count($areas),
        'itemListElement' => array_map(
            static fn(int $i, array $a): array => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $a['title'],
                'url'      => abs_url('practice-area.php?area=' . $a['slug']),
            ],
            array_keys($areas),
            $areas
        ),
    ]],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Areas of practice',
    'title'   => 'The full range of our<br>legal expertise',
    'lede'    => 'With our client-centric approach we foster strong and enduring relationships, truly understanding our clients&rsquo; goals and working collaboratively toward their success. Filter or search the areas below to find the one that fits your situation.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">

    <div class="toolbar reveal">
      <div class="toolbar__search">
        <label class="visually-hidden" for="areaSearch">Search practice areas</label>
        <?= icon('search', 18) ?>
        <input id="areaSearch" type="search" data-search
               placeholder="Search all <?= count($areas) ?> areas &ndash; try &ldquo;land&rdquo;, &ldquo;arbitration&rdquo; or &ldquo;visa&rdquo;" autocomplete="off">
      </div>

      <div class="filters" data-filter-bar>
        <button class="filter-chip is-active" type="button" data-filter="all" aria-pressed="true">All areas</button>
        <?php foreach ($groups as $group): ?>
          <button class="filter-chip" type="button" data-filter="<?= e($group) ?>" aria-pressed="false"><?= e($group) ?></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="grid grid--3">
      <?php foreach ($areas as $i => $area): ?>
        <article class="card practice-card reveal"
                 data-delay="<?= $i % 3 + 1 ?>"
                 data-group="<?= e($area['group']) ?>"
                 data-search-text="<?= e($area['title'] . ' ' . $area['group'] . ' ' . $area['short'] . ' ' . implode(' ', $area['services'])) ?>">
          <span class="card__icon"><?= icon($area['icon'], 24) ?></span>
          <p class="practice-card__group"><?= e($area['group']) ?></p>
          <h3><a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>"><?= e($area['title']) ?></a></h3>
          <p><?= e($area['short']) ?></p>
          <a class="link-arrow" href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>">
            Read more <?= icon('arrow', 15) ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <p data-filter-empty data-search-empty hidden class="lede mt-6">
      No practice area matches that filter. <a class="link-arrow" href="<?= e(url('contact.php')) ?>">Ask us directly <?= icon('arrow', 15) ?></a>
    </p>
  </div>
</section>

<section class="section section--bone section--tight">
  <div class="wrap">
    <div class="split">
      <div class="reveal">
        <p class="eyebrow">Not sure which applies?</p>
        <h2>Most matters cross <span class="accent">several</span> areas at once</h2>
        <p class="lede">
          A property purchase touches land, tax, company and family law. A fintech launch touches
          financial regulation, data protection and intellectual property. Describe the situation in
          plain language and we will tell you which areas are engaged &mdash; and which are not.
        </p>
      </div>
      <div class="reveal" data-delay="2" style="display:flex;flex-wrap:wrap;gap:.85rem;align-items:center;">
        <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">Describe your situation <?= icon('arrow', 18) ?></a>
        <a class="btn btn--outline btn--lg" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp', 18) ?> WhatsApp</a>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
