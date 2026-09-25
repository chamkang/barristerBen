<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';

$areas  = practice_areas();
$groups = practice_groups();

$page = [
    'title'       => 'Domaines d’expertise | Avocats en droit des affaires, maritime et contentieux au Cameroun',
    'description' => 'Vingt et un domaines au Cameroun et en zone CEMAC : sociétés, banque, maritime, mines, propriété intellectuelle, travail, contentieux, arbitrage, fiscalité, immigration.',
    'canonical'   => 'practice-areas.php',
    'breadcrumbs' => [['name' => 'Domaines d’expertise', 'url' => 'practice-areas.php']],
    'body_class'  => 'page-practice',
    'schema'      => [[
        '@type'           => 'ItemList',
        'name'            => 'Domaines d’expertise du cabinet Fonju',
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

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Domaines d’expertise',
    'title'   => 'Toute l’étendue de notre<br>expertise juridique',
    'lede'    => 'Notre approche centrée sur le client nous permet de bâtir des relations solides et durables, en comprenant réellement les objectifs de nos clients et en travaillant avec eux à leur réussite. Filtrez ou recherchez ci-dessous le domaine qui correspond à votre situation.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">

    <div class="toolbar reveal">
      <div class="toolbar__search">
        <label class="visually-hidden" for="areaSearch">Rechercher un domaine d’expertise</label>
        <?= icon('search', 18) ?>
        <input id="areaSearch" type="search" data-search
               placeholder="Rechercher parmi les <?= count($areas) ?> domaines &ndash; essayez &laquo;&nbsp;foncier&nbsp;&raquo;, &laquo;&nbsp;arbitrage&nbsp;&raquo; ou &laquo;&nbsp;visa&nbsp;&raquo;" autocomplete="off">
      </div>

      <div class="filters" data-filter-bar>
        <button class="filter-chip is-active" type="button" data-filter="all" aria-pressed="true">Tous les domaines</button>
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
            En savoir plus <?= icon('arrow', 15) ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <p data-filter-empty data-search-empty hidden class="lede mt-6">
      Aucun domaine ne correspond à ce filtre. <a class="link-arrow" href="<?= e(url('contact.php')) ?>">Posez-nous directement la question <?= icon('arrow', 15) ?></a>
    </p>
  </div>
</section>

<section class="section section--bone section--tight">
  <div class="wrap">
    <div class="split">
      <div class="reveal">
        <p class="eyebrow">Vous hésitez ?</p>
        <h2>La plupart des dossiers touchent <span class="accent">plusieurs</span> domaines à la fois</h2>
        <p class="lede">
          Un achat immobilier touche au foncier, à la fiscalité, au droit des sociétés et au droit de
          la famille. Le lancement d’une fintech touche à la réglementation financière, à la protection
          des données et à la propriété intellectuelle. Décrivez la situation avec vos mots : nous vous
          dirons quels domaines sont concernés &mdash; et lesquels ne le sont pas.
        </p>
      </div>
      <div class="reveal" data-delay="2" style="display:flex;flex-wrap:wrap;gap:.85rem;align-items:center;">
        <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">Décrire votre situation <?= icon('arrow', 18) ?></a>
        <a class="btn btn--outline btn--lg" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp', 18) ?> WhatsApp</a>
      </div>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
