<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-blog.php';

$posts      = blog_posts();
$categories = blog_categories();

$activeCat = isset($_GET['category']) ? trim((string) $_GET['category']) : '';
if ($activeCat !== '' && !isset($categories[$activeCat])) {
    $activeCat = '';
}

$filtered = $activeCat === ''
    ? $posts
    : array_values(array_filter($posts, static fn(array $p): bool => $p['category'] === $activeCat));

$canonical = $activeCat === '' ? 'blog.php' : 'blog.php?category=' . rawurlencode($activeCat);

$page = [
    'title'       => $activeCat === ''
        ? 'Insights | Cameroon & OHADA Business Law | Fonju Law Firm'
        : $activeCat . ' Insights | Cameroon Business Law | Fonju Law Firm',
    'description' => $activeCat === ''
        ? 'Practical notes on Cameroonian and OHADA business law: company formation, land title, employment, OAPI trade marks, arbitration, tax and investment.'
        : 'Articles on ' . $activeCat . ' from Fonju Law Firm, written for business owners, investors and in-house teams operating in Cameroon and the CEMAC region.',
    'canonical'   => $canonical,
    'breadcrumbs' => array_values(array_filter([
        ['name' => 'Insights', 'url' => 'blog.php'],
        $activeCat === '' ? null : ['name' => $activeCat, 'url' => $canonical],
    ])),
    'body_class'  => 'page-blog',
    'noindex'     => $activeCat !== '',
    'schema'      => [[
        '@type'       => 'Blog',
        '@id'         => SITE_URL . '/blog.php#blog',
        'name'        => SITE_NAME . ' Insights',
        'description' => 'Practical legal insights on Cameroonian and OHADA business law.',
        'url'         => abs_url('blog.php'),
        'publisher'   => ['@id' => SITE_URL . '/#organization'],
        'blogPost'    => array_map(static fn(array $p): array => [
            '@type'         => 'BlogPosting',
            'headline'      => $p['title'],
            'url'           => abs_url('post.php?p=' . $p['slug']),
            'datePublished' => $p['date'],
            'dateModified'  => $p['updated'],
            'author'        => ['@type' => 'Person', 'name' => $p['author']],
        ], array_slice($posts, 0, 10)),
    ]],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Insights',
    'title'   => 'Legal updates written<br>to be <em style="font-style:italic;color:var(--gold-soft);">used</em>',
    'lede'    => 'Practical notes on Cameroonian and OHADA law for business owners, investors and in-house teams. Every article is written to answer a question a client actually asked us.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">

    <nav class="filters reveal" aria-label="Filter articles by category">
      <a class="filter-chip<?= $activeCat === '' ? ' is-active' : '' ?>" href="<?= e(url('blog.php')) ?>">
        All articles (<?= count($posts) ?>)
      </a>
      <?php foreach ($categories as $cat => $count): ?>
        <a class="filter-chip<?= $activeCat === $cat ? ' is-active' : '' ?>"
           href="<?= e(url('blog.php?category=' . rawurlencode($cat))) ?>"><?= e($cat) ?> (<?= $count ?>)</a>
      <?php endforeach; ?>
    </nav>

    <div class="grid grid--3">
      <?php foreach ($filtered as $i => $post): ?>
        <?= post_card($post, $i % 3 + 1, $i === 0 && $activeCat === '', 'h2') ?>
      <?php endforeach; ?>
    </div>

    <?php if ($filtered === []): ?>
      <p class="lede">No articles in this category yet. <a class="link-arrow" href="<?= e(url('blog.php')) ?>">See all articles <?= icon('arrow', 15) ?></a></p>
    <?php endif; ?>

  </div>
</section>

<section class="section section--bone section--tight">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">A word of caution</p>
      <h2>These articles are information, <span class="accent">not advice</span></h2>
      <p class="lede">
        Everything published here describes the law in general terms. It cannot account for the
        facts of your situation, and the law changes. Before you act on anything you read here,
        speak to a lawyer about your specific circumstances.
      </p>
    </div>
    <div class="reveal" data-delay="2" style="display:flex;flex-wrap:wrap;gap:.85rem;align-items:center;">
      <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">Ask about your situation <?= icon('arrow', 18) ?></a>
      <a class="btn btn--outline btn--lg" href="<?= e(url('faq.php')) ?>">Read the FAQ</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
