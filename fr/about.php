<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';
require_once dirname(__DIR__) . '/includes/data-team.php';

$page = [
    'title'       => 'Le cabinet Fonju | Conseil juridique international à Douala',
    'description' => 'Un cabinet d’avocats et de conseils à Douala au service des entreprises au Cameroun et en zone CEMAC : notre mission, nos expertises et notre méthode.',
    'canonical'   => 'about.php',
    'breadcrumbs' => [['name' => 'Le cabinet', 'url' => 'about.php']],
    'body_class'  => 'page-about',
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Le cabinet',
    'title'   => 'Des services juridiques spécialisés,<br>rendus avec précision',
    'lede'    => 'Le cabinet Fonju est né d’un principe : des services juridiques spécialisés produisent de meilleurs résultats. Notre mission est d’être le conseil juridique le plus fiable et le plus efficace des entreprises qui portent l’innovation et la croissance au Cameroun.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<!-- ============================================================= MISSION -->
<section class="section">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Qui sommes-nous</p>
      <h2>Un cabinet international aux <span class="accent">racines camerounaises</span></h2>
      <div class="rule"></div>
      <p>
        Le cabinet Fonju est un cabinet de conseil juridique international composé d’une équipe de
        jeunes avocats engagés, dont l’expertise couvre un large éventail de matières. Nous sommes fiers
        de réunir un collectif d’avocats et de conseils de la République du Cameroun particulièrement
        motivés.
      </p>
      <p>
        Les avocats de notre collectif sont formés dans des facultés de droit nationales et
        internationales, ce qui apporte à chaque dossier une expertise juridique réellement étendue.
        Nos services sont guidés par le droit de la République du Cameroun et au-delà, par la
        déontologie et les usages de notre profession, et par les meilleures pratiques
        internationales.
      </p>
      <p>
        Nous nous distinguons par notre rigueur, un conseil proactif et un attachement sans faille à
        la confidentialité et à la réussite de nos clients.
      </p>
    </div>

    <div class="reveal" data-delay="2">
      <div class="figure-panel">
        <span class="figure-panel__mark"><?= icon('building', 92) ?></span>
        <span class="figure-panel__caption">
          <strong>Douala, région du Littoral</strong>
          La capitale économique du Cameroun et la porte d’entrée de l’hinterland CEMAC &mdash; le Tchad, la République centrafricaine et au-delà.
        </span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================== PILLARS -->
<section class="section section--dark">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <p class="eyebrow eyebrow--gold">Ce qui définit nos conseils</p>
      <h2>Quatre engagements pris dans chaque dossier</h2>
    </div>

    <div class="grid grid--4">
      <?php
      $pillars = [
        ['icon' => 'spark',  'h' => 'L’expertise plutôt que la généralité', 'p' => 'Une spécialisation poussée en droit des sociétés et en conseil en jeux en ligne, appuyée par une pratique complète couvrant vingt et un domaines.'],
        ['icon' => 'globe',  'h' => 'Une veille réglementaire constante',  'p' => 'Nous suivons en continu l’évolution des règles OHADA et de la législation sur les jeux numériques et les données en Afrique centrale.'],
        ['icon' => 'clock',  'h' => 'Réactivité et maîtrise des coûts',    'p' => 'La spécialisation nous permet de donner des conseils juridiquement solides, au moment où ils sont encore utiles, à un prix convenu à l’avance.'],
        ['icon' => 'shield', 'h' => 'Anticiper plutôt que réagir',         'p' => 'Nous aidons nos clients à se préparer aux enjeux juridiques de la transformation numérique et des affaires transfrontalières avant qu’ils ne surviennent.'],
      ];
      foreach ($pillars as $i => $p): ?>
        <article class="card card--dark reveal" data-delay="<?= $i + 1 ?>">
          <span class="card__icon"><?= icon($p['icon'], 24) ?></span>
          <h3><?= $p['h'] ?></h3>
          <p><?= $p['p'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================= LOCATION -->
<section class="section">
  <div class="wrap split">
    <div class="reveal" data-delay="1">
      <div class="figure-panel">
        <span class="figure-panel__mark"><?= icon('globe', 92) ?></span>
        <span class="figure-panel__caption">
          <strong>Pratique internationale, profondeur régionale</strong>
          Des clients d’Europe, d’Asie, du Moyen-Orient et d’Amérique du Nord qui s’implantent ou se développent en zone CEMAC.
        </span>
      </div>
    </div>

    <div class="reveal">
      <p class="eyebrow">Où nous intervenons</p>
      <h2>Ancrés au Cameroun, actifs au-delà des <span class="accent">frontières</span></h2>
      <div class="rule"></div>
      <p class="lede">
        Notre bureau de Douala nous place au cœur de la capitale économique du Cameroun &mdash; le lieu
        idéal pour servir aussi bien les multinationales établies que les entrepreneurs locaux
        émergents.
      </p>
      <p>
        Si nos racines sont solidement ancrées dans le droit camerounais, notre pratique est
        internationale. Nous intervenons régulièrement pour des clients d’Europe, d’Asie, du
        Moyen-Orient et d’Amérique du Nord qui s’implantent ou se développent en zone CEMAC, souvent
        comme conseil local aux côtés des avocats du pays d’origine du client.
      </p>

      <ul class="pill-row mt-6">
        <li><span class="pill pill--gold"><?= icon('pin', 14) ?> Douala et tout le pays</span></li>
        <li><span class="pill"><?= icon('globe', 14) ?> Zone CEMAC</span></li>
        <li><span class="pill"><?= icon('scale', 14) ?> 17 États OHADA</span></li>
        <li><span class="pill"><?= icon('users', 14) ?> Français et anglais</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ========================================================== PHILOSOPHY -->
<section class="section section--bone">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Notre philosophie d’équipe</p>
      <h2>Experts du droit &mdash; et des <span class="accent">affaires</span> auxquelles il s’applique</h2>
      <p class="lede">
        Notre équipe réunit des avocats et consultants expérimentés, experts du droit mais aussi
        professionnels solidement formés aux affaires et à la technologie. Nous tenons à être des
        conseils accessibles, transparents et tenaces. Nous prenons le temps de comprendre réellement
        votre modèle d’affaires avant de proposer une solution.
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $philosophy = [
        ['n' => '01', 'h' => 'Accessibles',   'p' => 'Des interlocuteurs nommés, des appels rappelés et des points d’étape sans relance. Si votre dossier évolue de façon importante, c’est de nous que vous l’apprenez en premier.'],
        ['n' => '02', 'h' => 'Transparents', 'p' => 'Une convention d’honoraires écrite avant tout commencement, des forfaits chaque fois que le travail le permet, et aucune facture qui n’ait été annoncée.'],
        ['n' => '03', 'h' => 'Tenaces',      'p' => 'Directs sur les risques avant que vous ne vous engagiez, infatigables une fois engagés. Nous préparons chaque litige comme s’il devait aller jusqu’au jugement.'],
      ];
      foreach ($philosophy as $i => $p): ?>
        <article class="card value-card reveal" data-delay="<?= $i + 1 ?>">
          <span class="value-card__num" aria-hidden="true"><?= $p['n'] ?></span>
          <h3><?= $p['h'] ?></h3>
          <p><?= $p['p'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-7 reveal">
      <a class="btn btn--outline" href="<?= e(url('team.php')) ?>">Rencontrer l’équipe <?= icon('arrow', 16) ?></a>
    </div>
  </div>
</section>

<!-- =========================================================== CAPABILITY -->
<section class="section">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Nos compétences</p>
      <h2>Vingt et un domaines d’expertise, un seul interlocuteur</h2>
      <p class="lede">
        La plupart des dossiers relèvent de plusieurs branches du droit à la fois. Une acquisition
        immobilière touche au foncier, à la fiscalité, au droit des sociétés et au droit de la famille ;
        le lancement d’une fintech touche à la réglementation financière, aux données et à la propriété
        intellectuelle. Vous avez un avocat référent qui coordonne l’ensemble.
      </p>
    </div>

    <ul class="practice-index reveal">
      <?php foreach (practice_areas() as $area): ?>
        <li>
          <a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>">
            <?= icon($area['icon'], 17) ?>
            <?= e($area['title']) ?>
            <?= icon('arrow', 15) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
