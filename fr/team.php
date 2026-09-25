<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';
require_once dirname(__DIR__) . '/includes/data-team.php';

$members = team_members();

$page = [
    'title'       => 'Notre équipe | Avocats et conseils | Cabinet Fonju, Douala',
    'description' => 'L’équipe du cabinet Fonju à Douala : des avocats et consultants formés dans des facultés de droit nationales et internationales, qui travaillent en français et en anglais.',
    'canonical'   => 'team.php',
    'breadcrumbs' => [['name' => 'Notre équipe', 'url' => 'team.php']],
    'body_class'  => 'page-team',
    'schema'      => array_values(array_map(
        static function (array $m): array {
            $person = [
                '@type'       => 'Person',
                'name'        => $m['name'],
                'jobTitle'    => $m['role'],
                'description' => $m['bio'],
                'worksFor'    => ['@id' => SITE_URL . '/#organization'],
                'knowsLanguage' => ['fr', 'en'],
                'url'         => abs_url('team.php#' . $m['slug']),
            ];

            if ($m['email'] !== '') {
                $person['email'] = $m['email'];
            }
            if ($m['linkedin'] !== '') {
                $person['sameAs'] = [$m['linkedin']];
            }

            return $person;
        },
        array_filter($members, static fn(array $m): bool => empty($m['placeholder']))
    )),
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Notre équipe',
    'title'   => 'Un collectif d’avocats<br>et de conseils engagés',
    'lede'    => 'Notre équipe réunit des avocats et consultants expérimentés, experts du droit mais aussi professionnels solidement formés aux affaires et à la technologie. Nous sommes des conseils accessibles, transparents et tenaces au service de nos clients.',
];
require dirname(__DIR__) . '/includes/page-hero.php';

$hasPlaceholders = (bool) array_filter($members, static fn(array $m): bool => !empty($m['placeholder']));
?>

<section class="section">
  <div class="wrap">
    <div class="grid grid--3">
      <?php foreach ($members as $i => $member): ?>
        <article class="team-card reveal" id="<?= e($member['slug']) ?>" data-delay="<?= $i % 3 + 1 ?>">
          <div class="team-card__photo">
            <?php if (!empty($member['placeholder'])): ?>
              <span class="team-card__flag">Provisoire</span>
            <?php endif; ?>

            <?php if ($member['photo'] !== ''): ?>
              <img src="<?= e(asset('img/team/' . $member['photo'])) ?>"
                   alt="<?= e($member['name'] . ', ' . $member['role'] . ', ' . SITE_NAME) ?>"
                   width="600" height="660" loading="lazy">
            <?php else: ?>
              <span class="team-card__monogram" aria-hidden="true"><?= e(member_initials($member['name'])) ?></span>
            <?php endif; ?>
          </div>

          <div class="team-card__body">
            <h2 class="team-card__name"><?= e($member['name']) ?></h2>
            <p class="team-card__role"><?= e($member['role']) ?></p>
            <p class="team-card__bio"><?= e($member['bio']) ?></p>

            <ul class="pill-row team-card__meta">
              <?php foreach ($member['focus'] as $focus): ?>
                <li><span class="pill"><?= e($focus) ?></span></li>
              <?php endforeach; ?>
              <li><span class="pill pill--gold"><?= icon('globe', 13) ?> <?= e(implode(' / ', $member['languages'])) ?></span></li>
            </ul>

            <div class="team-card__links">
              <?php if ($member['email'] !== ''): ?>
                <a href="mailto:<?= e($member['email']) ?>" aria-label="Écrire à <?= e($member['name']) ?>"><?= icon('mail', 17) ?></a>
              <?php endif; ?>
              <?php if ($member['linkedin'] !== ''): ?>
                <a href="<?= e($member['linkedin']) ?>" target="_blank" rel="noopener" aria-label="<?= e($member['name']) ?> sur LinkedIn"><?= icon('linkedin', 16) ?></a>
              <?php endif; ?>
              <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>" aria-label="Appeler le cabinet"><?= icon('phone', 17) ?></a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($hasPlaceholders): ?>
      <div class="alert alert--err mt-7" role="note">
        <?= icon('shield', 20) ?>
        <div>
          <strong>Note pour l’administrateur du site (cet encadré disparaît une fois le point réglé).</strong>
          Les fiches marquées <em>Provisoire</em> sont des exemples de structure pour que la page
          s’affiche entièrement. Remplacez les noms, fonctions, biographies et photos dans
          <code>includes/data-team.php</code> (entrée <code>fr</code> de chaque membre pour le
          français), ou supprimez les fiches inutiles.
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--dark">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow eyebrow--gold">Notre philosophie</p>
      <h2>Nous comprenons votre activité avant de vous conseiller</h2>
      <p class="lede">
        Un conseil juridique donné sans compréhension commerciale est un risque. Nos avocats prennent
        le temps de comprendre votre modèle, vos partenaires et vos contraintes, et proposent ensuite
        une solution &mdash; qui consiste parfois à ne rien faire.
      </p>
      <ul class="checklist mt-6">
        <li><?= icon('check', 16) ?><span>Formés dans des facultés de droit nationales et internationales</span></li>
        <li><?= icon('check', 16) ?><span>Une expérience des affaires et de la technologie, pas seulement du droit</span></li>
        <li><?= icon('check', 16) ?><span>À l’aise en procédure de common law comme de droit civil</span></li>
        <li><?= icon('check', 16) ?><span>Tenus au secret professionnel dans chaque mission</span></li>
      </ul>
    </div>

    <div class="reveal" data-delay="2">
      <div class="stats">
        <div class="stats__item">
          <span class="stats__num"><span data-count="<?= count(practice_areas()) ?>"><?= count(practice_areas()) ?></span></span>
          <span class="stats__label">Domaines d’expertise</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">FR/EN</span>
          <span class="stats__label">Langues de travail</span>
        </div>
        <div class="stats__item">
          <span class="stats__num"><span data-count="17">17</span></span>
          <span class="stats__label">États OHADA</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">24 h</span>
          <span class="stats__label">Délai de réponse visé</span>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
