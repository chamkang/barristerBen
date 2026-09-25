<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-faq.php';

$groups = faq_groups();

$page = [
    'title'       => 'Questions fréquentes | Conseil juridique au Cameroun | Cabinet Fonju',
    'description' => 'Honoraires, consultation, création de société, vérification des titres fonciers, licenciement, arbitrage et investissement au Cameroun : des réponses claires.',
    'canonical'   => 'faq.php',
    'breadcrumbs' => [['name' => 'FAQ', 'url' => 'faq.php']],
    'body_class'  => 'page-faq',
    'schema'      => [[
        '@type'      => 'FAQPage',
        '@id'        => abs_url('faq.php') . '#faq',
        'inLanguage' => 'fr',
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

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Questions fréquentes',
    'title'   => 'Des réponses claires aux<br>questions les plus posées',
    'lede'    => 'Honoraires, délais, procédure et ce qui tourne le plus souvent mal. Si votre question n’y figure pas, posez-la directement &mdash; nous répondons à chaque demande sous un jour ouvré.',
];
require dirname(__DIR__) . '/includes/page-hero.php';

$groupIcons = [
    'Travailler avec le cabinet'        => 'users',
    'Créer et gérer une entreprise'     => 'building',
    'Immobilier et foncier'             => 'pin',
    'Travail et personnel'              => 'doc',
    'Litiges et contentieux'            => 'gavel',
    'Clients et investisseurs étrangers' => 'globe',
];

$anchor = static fn(string $name): string => slugify($name);

$counter = 0;
?>

<section class="section">
  <div class="wrap detail">

    <div class="detail__main">
      <?php foreach ($groups as $groupName => $questions): ?>
        <section class="faq-group reveal" id="<?= e($anchor($groupName)) ?>">
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
        <h3>Aller à un thème</h3>
        <ul class="sidebar__list">
          <?php foreach (array_keys($groups) as $groupName): ?>
            <li><a href="#<?= e($anchor($groupName)) ?>"><?= e($groupName) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="sidebar__box sidebar__box--dark">
        <h3>Votre question n’y est pas ?</h3>
        <p style="font-size:.98rem;">Posez-la directement. Savoir si vous avez un problème qui mérite d’être traité ne vous coûte rien.</p>
        <ul class="contact-list" style="margin-top:1.1rem;">
          <li><?= icon('phone', 17) ?><a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a></li>
          <li><?= icon('mail', 17) ?><a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a></li>
        </ul>
        <a class="btn btn--gold btn--block mt-5" href="<?= e(url('contact.php')) ?>#consultation">Poser votre question</a>
      </div>

      <div class="sidebar__box">
        <h3>À lire aussi</h3>
        <ul class="sidebar__list">
          <li><a href="<?= e(url('blog.php')) ?>">Actualités juridiques</a></li>
          <li><a href="<?= e(url('practice-areas.php')) ?>">Tous les domaines d’expertise</a></li>
          <li><a href="<?= e(url('about.php')) ?>">Présentation du cabinet</a></li>
          <li><a href="<?= e(url('legal-notice.php')) ?>">Mentions légales</a></li>
        </ul>
      </div>
    </aside>

  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
