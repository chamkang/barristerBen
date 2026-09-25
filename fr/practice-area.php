<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';
require_once dirname(__DIR__) . '/includes/data-blog.php';

$slug = isset($_GET['area']) ? preg_replace('/[^a-z0-9-]/', '', strtolower((string) $_GET['area'])) : '';
$area = $slug === '' ? null : practice_area($slug);

if ($area === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$canonical = 'practice-area.php?area=' . $area['slug'];

$page = [
    'title'       => $area['title'] . ' au Cameroun | Cabinet Fonju',
    'description' => mb_substr($area['short'], 0, 158),
    'canonical'   => $canonical,
    'body_class'  => 'page-practice-detail',
    'breadcrumbs' => [
        ['name' => 'Domaines d’expertise', 'url' => 'practice-areas.php'],
        ['name' => $area['title'],         'url' => $canonical],
    ],
    'schema' => [[
        '@type'       => 'Service',
        'name'        => $area['title'],
        'serviceType' => $area['title'],
        'description' => $area['short'],
        'url'         => abs_url($canonical),
        'inLanguage'  => 'fr',
        'provider'    => ['@id' => SITE_URL . '/#organization'],
        'areaServed'  => [
            ['@type' => 'Country', 'name' => 'Cameroun'],
            ['@type' => 'Place',   'name' => 'Zone CEMAC'],
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name'  => $area['title'] . ' : nos services',
            'itemListElement' => array_map(
                static fn(string $s): array => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $s]],
                $area['services']
            ),
        ],
    ]],
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => e($area['group']),
    'title'   => e($area['title']),
    'lede'    => e($area['short']),
];
require dirname(__DIR__) . '/includes/page-hero.php';

$areaPosts = practice_posts($area['slug']);

$related = array_values(array_filter(
    practice_areas(),
    static fn(array $a): bool => $a['group'] === $area['group'] && $a['slug'] !== $area['slug']
));
?>

<section class="section">
  <div class="wrap detail">

    <div class="detail__main">
      <div class="prose reveal">
        <p class="lede" style="color:var(--ink-3);"><?= e($area['intro']) ?></p>

        <?php foreach ($area['sections'] as $section): ?>
          <h2><?= e($section['h']) ?></h2>
          <p><?= e($section['p']) ?></p>
        <?php endforeach; ?>
      </div>

      <div class="mt-7 reveal">
        <h2 style="font-size:var(--fs-h3);">Ce que nous faisons concrètement</h2>
        <div class="rule"></div>
        <ul class="checklist mt-5">
          <?php foreach ($area['services'] as $service): ?>
            <li><?= icon('check', 16) ?><span><?= e($service) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="card mt-7 reveal" style="background:var(--bone);border-color:transparent;">
        <h3>Vous avez un dossier dans ce domaine ?</h3>
        <p>
          Dites-nous ce qui s’est passé et le résultat que vous recherchez. Vous recevrez notre analyse
          de votre situation, les options réalistes avec leur coût et leur délai, et une recommandation.
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-top:1.25rem;">
          <a class="btn btn--gold" href="<?= e(url('contact.php')) ?>#consultation">Prendre rendez-vous <?= icon('arrow', 16) ?></a>
          <a class="btn btn--outline" href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= icon('phone', 16) ?> <?= e(CONTACT['phone_primary']) ?></a>
        </div>
      </div>
    </div>

    <aside class="sidebar">
      <div class="sidebar__box sidebar__box--dark">
        <h3>Parler à cette équipe</h3>
        <p style="font-size:.98rem;">Les urgences &mdash; saisie d’un navire, échéance imminente, client détenu &mdash; sont traitées le jour même.</p>
        <ul class="contact-list" style="margin-top:1.1rem;">
          <li><?= icon('phone', 17) ?><a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a></li>
          <li><?= icon('mail', 17) ?><a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a></li>
        </ul>
        <a class="btn btn--gold btn--block mt-5" href="<?= e(whatsapp_url('Bonjour Cabinet Fonju, j’ai une question concernant : ' . $area['title'] . '.')) ?>" target="_blank" rel="noopener">
          <?= icon('whatsapp', 17) ?> Écrire sur WhatsApp
        </a>
      </div>

      <?php if ($areaPosts !== []): ?>
        <div class="sidebar__box">
          <h3>Nos articles sur ce sujet</h3>
          <ul class="sidebar__list">
            <?php foreach ($areaPosts as $ap): ?>
              <li><a href="<?= e(url('post.php?p=' . $ap['slug'])) ?>"><?= e($ap['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($related !== []): ?>
        <div class="sidebar__box">
          <h3><?= e($area['group']) ?> : voir aussi</h3>
          <ul class="sidebar__list">
            <?php foreach ($related as $rel): ?>
              <li><a href="<?= e(url('practice-area.php?area=' . $rel['slug'])) ?>"><?= e($rel['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="sidebar__box">
        <h3>Tous les domaines</h3>
        <ul class="sidebar__list">
          <?php foreach (practice_areas() as $other): ?>
            <li>
              <a class="<?= $other['slug'] === $area['slug'] ? 'is-active' : '' ?>"
                 href="<?= e(url('practice-area.php?area=' . $other['slug'])) ?>"><?= e($other['title']) ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>

  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
