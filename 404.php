<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';
require_once __DIR__ . '/includes/data-blog.php';

if (http_response_code() === 200) {
    http_response_code(404);
}

$page = [
    'title'       => 'Page not found | Fonju Law Firm',
    'description' => 'The page you are looking for could not be found. Browse our practice areas, insights and contact details instead.',
    'canonical'   => '404.php',
    'noindex'     => true,
    'body_class'  => 'page-404',
    'hide_cta'    => true,
    'alternates'  => ['en' => '', 'fr' => ''],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Error 404',
    'title'   => 'That page could not<br>be found',
    'lede'    => 'The address may have changed, or the link that brought you here may be out of date. Everything below is a working route back into the site.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">
    <div class="grid grid--3">

      <article class="card reveal">
        <span class="card__icon"><?= icon('scale', 24) ?></span>
        <h2 style="font-size:1.22rem;">Practice areas</h2>
        <p>Twenty-one areas of law, from corporate and maritime to intellectual property and immigration.</p>
        <a class="link-arrow" href="<?= e(url('practice-areas.php')) ?>">Browse practice areas <?= icon('arrow', 15) ?></a>
      </article>

      <article class="card reveal" data-delay="2">
        <span class="card__icon"><?= icon('doc', 24) ?></span>
        <h2 style="font-size:1.22rem;">Insights</h2>
        <p>Practical notes on Cameroonian and OHADA business law, written to answer real client questions.</p>
        <a class="link-arrow" href="<?= e(url('blog.php')) ?>">Read the insights <?= icon('arrow', 15) ?></a>
      </article>

      <article class="card reveal" data-delay="3">
        <span class="card__icon"><?= icon('phone', 24) ?></span>
        <h2 style="font-size:1.22rem;">Talk to us</h2>
        <p>Describe your situation and get our view of your position, the options and the likely cost.</p>
        <a class="link-arrow" href="<?= e(url('contact.php')) ?>#consultation">Contact the firm <?= icon('arrow', 15) ?></a>
      </article>

    </div>

    <div class="mt-7 reveal">
      <h2 style="font-size:var(--fs-h3);">Popular pages</h2>
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

<?php require __DIR__ . '/includes/footer.php'; ?>
