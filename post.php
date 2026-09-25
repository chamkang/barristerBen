<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-blog.php';

$slug = isset($_GET['p']) ? preg_replace('/[^a-z0-9-]/', '', strtolower((string) $_GET['p'])) : '';
$post = $slug === '' ? null : blog_post($slug);

if ($post === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$canonical   = 'post.php?p=' . $post['slug'];
$shareUrl    = abs_url($canonical);
$minutes     = reading_time($post['body']);
$translation = post_translation($post);

$page = [
    'title'       => ($post['seo_title'] ?: $post['title']) . ' | Fonju Law Firm',
    'description' => mb_substr($post['excerpt'], 0, 158),
    'canonical'   => $canonical,
    'og_type'     => 'article',
    'og_image'    => $post['image'] !== '' ? $post['image'] : SEO_DEFAULTS['image'],
    'body_class'  => 'page-post',
    'alternates'  => [
        'en' => $canonical,
        'fr' => $translation === null ? null : 'post.php?p=' . $translation,
    ],
    'breadcrumbs' => [
        ['name' => 'Insights',       'url' => 'blog.php'],
        ['name' => $post['category'], 'url' => 'blog.php?category=' . rawurlencode($post['category'])],
        ['name' => $post['title'],   'url' => $canonical],
    ],
    'schema' => [[
        '@type'            => 'BlogPosting',
        '@id'              => $shareUrl . '#article',
        'headline'         => mb_substr($post['title'], 0, 110),
        'description'      => $post['excerpt'],
        'articleSection'   => $post['category'],
        'keywords'         => implode(', ', $post['tags']),
        'inLanguage'       => 'en',
        'wordCount'        => str_word_count(strip_tags($post['body'])),
        'timeRequired'     => 'PT' . $minutes . 'M',
        'datePublished'    => $post['date'],
        'dateModified'     => $post['updated'],
        'url'              => $shareUrl,
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $shareUrl],
        'author'           => ['@type' => 'Person', 'name' => $post['author'], 'affiliation' => ['@id' => SITE_URL . '/#organization']],
        'publisher'        => ['@id' => SITE_URL . '/#organization'],
        'isAccessibleForFree' => true,
    ]],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => e($post['category']),
    'title'   => e($post['title']),
    'lede'    => e($post['excerpt']),
    'aside'   => '<p class="article-meta">'
        . '<span>' . icon('users', 15) . e($post['author']) . '</span>'
        . '<span>' . icon('clock', 15) . '<time datetime="' . e($post['date']) . '">' . e(fmt_date($post['date'])) . '</time></span>'
        . '<span>' . icon('doc', 15) . $minutes . ' min read</span>'
        . ($translation !== null ? '<span>' . icon('globe', 15) . '<a href="' . e(url_in('post.php?p=' . $translation, 'fr')) . '" hreflang="fr" lang="fr">Lire en français</a></span>' : '')
        . '</p>',
];
require __DIR__ . '/includes/page-hero.php';

$related = related_posts($post, 3);
?>

<section class="section">
  <div class="wrap detail">

    <article class="detail__main">
      <?php if ($post['image'] !== ''): ?>
        <figure class="article-cover reveal"><img src="<?= e(md_safe_url($post['image'])) ?>" alt="" width="1200" height="675"></figure>
      <?php endif; ?>
      <div class="prose reveal">
        <?= $post['body'] ?>
      </div>

      <?php if ($post['tags'] !== []): ?>
        <ul class="tag-row mt-7">
          <?php foreach ($post['tags'] as $tag): ?>
            <li><span class="tag">#<?= e($tag) ?></span></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="mt-6" style="display:flex;flex-wrap:wrap;gap:1rem;align-items:center;justify-content:space-between;padding-top:1.75rem;border-top:1px solid var(--line);">
        <p class="mb-0" style="font-size:.92rem;color:var(--muted-2);">Share this article</p>
        <div class="share-row">
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= rawurlencode($shareUrl) ?>"
             target="_blank" rel="noopener" aria-label="Share on LinkedIn"><?= icon('linkedin', 16) ?></a>
          <a href="https://twitter.com/intent/tweet?url=<?= rawurlencode($shareUrl) ?>&amp;text=<?= rawurlencode($post['title']) ?>"
             target="_blank" rel="noopener" aria-label="Share on X"><?= icon('x', 15) ?></a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode($shareUrl) ?>"
             target="_blank" rel="noopener" aria-label="Share on Facebook"><?= icon('facebook', 16) ?></a>
          <a href="<?= e(whatsapp_url($post['title'] . ' — ' . $shareUrl)) ?>"
             target="_blank" rel="noopener" aria-label="Share on WhatsApp"><?= icon('whatsapp', 16) ?></a>
          <button type="button" data-copy-link="<?= e($shareUrl) ?>" aria-label="Copy link to this article"><?= icon('doc', 16) ?></button>
        </div>
      </div>

      <div class="alert alert--ok mt-7" role="note">
        <?= icon('shield', 20) ?>
        <div>
          <strong>General information, not legal advice.</strong>
          This article describes the law in general terms and cannot account for the facts of your
          situation. Reading it does not create a lawyer&ndash;client relationship. Before acting,
          <a href="<?= e(url('contact.php')) ?>#consultation" style="text-decoration:underline;">speak to us about your circumstances</a>.
        </div>
      </div>
    </article>

    <aside class="sidebar">
      <div class="sidebar__box sidebar__box--dark">
        <h3>Have a question on this?</h3>
        <p style="font-size:.98rem;">If this article touches something you are dealing with, tell us what has happened. The first assessment costs you nothing but the conversation.</p>
        <a class="btn btn--gold btn--block mt-5" href="<?= e(url('contact.php')) ?>#consultation">Book a consultation</a>
        <a class="btn btn--ghost btn--block mt-4" href="<?= e(whatsapp_url('Hello Fonju Law Firm, I read your article: ' . $post['title'])) ?>" target="_blank" rel="noopener">
          <?= icon('whatsapp', 16) ?> WhatsApp us
        </a>
      </div>

      <?php if ($related !== []): ?>
        <div class="sidebar__box">
          <h3>Keep reading</h3>
          <ul class="sidebar__list">
            <?php foreach ($related as $rel): ?>
              <li><a href="<?= e(url('post.php?p=' . $rel['slug'])) ?>"><?= e($rel['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
          <a class="link-arrow mt-5" href="<?= e(url('blog.php')) ?>">All insights <?= icon('arrow', 15) ?></a>
        </div>
      <?php endif; ?>

      <div class="sidebar__box">
        <h3>Browse by topic</h3>
        <ul class="pill-row">
          <?php foreach (blog_categories() as $cat => $count): ?>
            <li><a class="pill<?= $cat === $post['category'] ? ' pill--gold' : '' ?>" href="<?= e(url('blog.php?category=' . rawurlencode($cat))) ?>"><?= e($cat) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
