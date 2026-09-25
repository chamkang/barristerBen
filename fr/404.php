<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';
require_once dirname(__DIR__) . '/includes/data-blog.php';

if (http_response_code() === 200) {
    http_response_code(404);
}

$page = [
    'title'       => 'Page introuvable | Cabinet Fonju',
    'description' => 'La page demandée est introuvable. Consultez nos domaines d’expertise, nos actualités ou nos coordonnées.',
    'canonical'   => '404.php',
    'noindex'     => true,
    'body_class'  => 'page-404',
    'hide_cta'    => true,
    'alternates'  => ['en' => '', 'fr' => ''],
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Erreur 404',
    'title'   => 'Cette page est<br>introuvable',
    'lede'    => 'L’adresse a peut-être changé, ou le lien qui vous a mené ici n’est plus à jour. Voici des chemins sûrs pour revenir sur le site.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">
    <div class="grid grid--3">

      <article class="card reveal">
        <span class="card__icon"><?= icon('scale', 24) ?></span>
        <h2 style="font-size:1.22rem;">Domaines d’expertise</h2>
        <p>Vingt et un domaines du droit, du droit des sociétés et du droit maritime à la propriété intellectuelle et à l’immigration.</p>
        <a class="link-arrow" href="<?= e(url('practice-areas.php')) ?>">Voir les domaines <?= icon('arrow', 15) ?></a>
      </article>

      <article class="card reveal" data-delay="2">
        <span class="card__icon"><?= icon('doc', 24) ?></span>
        <h2 style="font-size:1.22rem;">Actualités</h2>
        <p>Des notes pratiques sur le droit des affaires camerounais et OHADA, qui répondent à de vraies questions de clients.</p>
        <a class="link-arrow" href="<?= e(url('blog.php')) ?>">Lire les actualités <?= icon('arrow', 15) ?></a>
      </article>

      <article class="card reveal" data-delay="3">
        <span class="card__icon"><?= icon('phone', 24) ?></span>
        <h2 style="font-size:1.22rem;">Nous parler</h2>
        <p>Décrivez votre situation et recevez notre analyse, les options possibles et leur coût probable.</p>
        <a class="link-arrow" href="<?= e(url('contact.php')) ?>#consultation">Contacter le cabinet <?= icon('arrow', 15) ?></a>
      </article>

    </div>

    <div class="mt-7 reveal">
      <h2 style="font-size:var(--fs-h3);">Pages les plus consultées</h2>
      <div class="rule"></div>
      <ul class="practice-index">
        <?php foreach (array_slice(practice_areas(), 0, 8) as $area): ?>
          <li>
            <a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>">
              <?= icon($area['icon'], 17) ?><?= e($area['title']) ?><?= icon('arrow', 15) ?>
            </a>
          </li>
        <?php endforeach; ?>
        <?php foreach (array_slice(blog_posts(), 0, 4) as $post): ?>
          <li>
            <a href="<?= e(url('post.php?p=' . $post['slug'])) ?>">
              <?= icon('doc', 17) ?><?= e($post['title']) ?><?= icon('arrow', 15) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
