<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-blog.php';

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
        ? 'Actualités | Droit des affaires au Cameroun et OHADA | Cabinet Fonju'
        : $activeCat . ' | Actualités juridiques | Cabinet Fonju',
    'description' => $activeCat === ''
        ? 'Notes pratiques sur le droit des affaires camerounais et OHADA : création de société, foncier, droit du travail, marques OAPI, arbitrage, fiscalité et investissement.'
        : 'Articles « ' . $activeCat . ' » du cabinet Fonju, écrits pour les chefs d’entreprise, investisseurs et juristes au Cameroun et en zone CEMAC.',
    'canonical'   => $canonical,
    'breadcrumbs' => array_values(array_filter([
        ['name' => 'Actualités', 'url' => 'blog.php'],
        $activeCat === '' ? null : ['name' => $activeCat, 'url' => $canonical],
    ])),
    'body_class'  => 'page-blog',
    'noindex'     => $activeCat !== '',
    'schema'      => [[
        '@type'       => 'Blog',
        '@id'         => abs_url('blog.php') . '#blog',
        'name'        => 'Actualités du cabinet Fonju',
        'description' => 'Analyses juridiques pratiques sur le droit des affaires camerounais et OHADA.',
        'inLanguage'  => 'fr',
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

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Actualités',
    'title'   => 'Des analyses juridiques<br>écrites pour <em style="font-style:italic;color:var(--gold-soft);">servir</em>',
    'lede'    => 'Des notes pratiques sur le droit camerounais et OHADA pour les chefs d’entreprise, les investisseurs et les juristes d’entreprise. Chaque article répond à une question qu’un client nous a réellement posée.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap">

    <nav class="filters reveal" aria-label="Filtrer les articles par thème">
      <a class="filter-chip<?= $activeCat === '' ? ' is-active' : '' ?>" href="<?= e(url('blog.php')) ?>">
        Tous les articles (<?= count($posts) ?>)
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
      <p class="lede">Aucun article dans ce thème pour le moment. <a class="link-arrow" href="<?= e(url('blog.php')) ?>">Voir tous les articles <?= icon('arrow', 15) ?></a></p>
    <?php endif; ?>

  </div>
</section>

<section class="section section--bone section--tight">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Une mise en garde</p>
      <h2>Ces articles informent, ils ne <span class="accent">conseillent</span> pas</h2>
      <p class="lede">
        Tout ce qui est publié ici décrit le droit en termes généraux. Cela ne peut tenir compte des
        faits de votre situation, et le droit évolue. Avant d’agir sur la base de ce que vous lisez
        ici, parlez à un avocat de votre situation particulière.
      </p>
    </div>
    <div class="reveal" data-delay="2" style="display:flex;flex-wrap:wrap;gap:.85rem;align-items:center;">
      <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">Parler de votre situation <?= icon('arrow', 18) ?></a>
      <a class="btn btn--outline btn--lg" href="<?= e(url('faq.php')) ?>">Lire la FAQ</a>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
