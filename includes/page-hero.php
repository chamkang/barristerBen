<?php
/**
 * Inner-page hero. Define $hero before including:
 *   $hero = ['eyebrow' => '', 'title' => '', 'lede' => '', 'aside' => ''];
 * Breadcrumb links are taken from $page['breadcrumbs'].
 */
$hero = array_merge(['eyebrow' => '', 'title' => '', 'lede' => '', 'aside' => ''], $hero ?? []);
?>
<section class="page-hero">
  <div class="wrap">
    <?php if (!empty($page['breadcrumbs'])): ?>
      <nav class="breadcrumbs" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= e(url('/')) ?>">Home</a></li>
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
