<?php
/**
 * Inner-page hero. Define $hero before including:
 *   $hero = ['eyebrow' => '', 'title' => '', 'lede' => '', 'aside' => ''];
 * Optional:
 *   'photo'     => a key from includes/data-photos.php, or '' for no photograph
 *                  (default: the photograph page_hero_photo() picks for the page)
 *   'image_url' => any image URL instead (e.g. an article's cover)
 * Breadcrumb links are taken from $page['breadcrumbs'].
 */
require_once __DIR__ . '/data-photos.php';

$hero = array_merge(['eyebrow' => '', 'title' => '', 'lede' => '', 'aside' => '', 'image_url' => ''], $hero ?? []);
$heroPhoto = $hero['image_url'] !== '' ? '' : ($hero['photo'] ?? page_hero_photo());
$hasPhoto  = $hero['image_url'] !== '' || $heroPhoto !== '';
?>
<section class="page-hero<?= $hasPhoto ? ' page-hero--photo' : '' ?>">
  <?php if ($hasPhoto): ?>
    <div class="page-hero__photo">
      <?php if ($hero['image_url'] !== ''): ?>
        <img src="<?= e($hero['image_url']) ?>" alt="" fetchpriority="high">
      <?php else: ?>
        <?= photo_img($heroPhoto, '(max-width: 980px) 100vw, 46vw', '', false) ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <div class="wrap">
    <?php if (!empty($page['breadcrumbs'])): ?>
      <nav class="breadcrumbs" aria-label="<?= e(t('Breadcrumb')) ?>">
        <ol>
          <li><a href="<?= e(url('/')) ?>"><?= e(t('Home')) ?></a></li>
          <?php
          $last = count($page['breadcrumbs']) - 1;
          foreach ($page['breadcrumbs'] as $i => $crumb): ?>
            <li>
              <?php if ($i === $last): ?>
                <span aria-current="page"><?= e($crumb['name']) ?></span>
              <?php else: ?>
                <a href="<?= e(url($crumb['url'])) ?>"><?= e($crumb['name']) ?></a>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ol>
      </nav>
    <?php endif; ?>

    <div class="page-hero__inner">
      <?php if ($hero['eyebrow'] !== ''): ?>
        <p class="eyebrow eyebrow--gold"><?= $hero['eyebrow'] ?></p>
      <?php endif; ?>
      <h1><?= $hero['title'] ?></h1>
      <?php if ($hero['lede'] !== ''): ?>
        <p class="lede"><?= $hero['lede'] ?></p>
      <?php endif; ?>
      <?= $hero['aside'] ?>
    </div>
  </div>
</section>
