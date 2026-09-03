<?php
declare(strict_types=1);

/** RSS 2.0 feed for the Insights section. Linked from <head> on every page. */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-blog.php';

header('Content-Type: application/rss+xml; charset=utf-8');

$posts = blog_posts();
$built = $posts === [] ? time() : strtotime($posts[0]['date']);

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><?= htmlspecialchars(SITE_NAME . ' — Insights', ENT_XML1) ?></title>
    <link><?= htmlspecialchars(abs_url('blog.php'), ENT_XML1) ?></link>
    <description>Practical legal insights on Cameroonian and OHADA business law from Fonju Law Firm, Douala.</description>
    <language>en</language>
    <lastBuildDate><?= date(DATE_RSS, $built) ?></lastBuildDate>
    <atom:link href="<?= htmlspecialchars(abs_url('feed.php'), ENT_XML1) ?>" rel="self" type="application/rss+xml"/>
<?php foreach ($posts as $post): ?>
    <item>
      <title><?= htmlspecialchars($post['title'], ENT_XML1) ?></title>
      <link><?= htmlspecialchars(abs_url('post.php?p=' . $post['slug']), ENT_XML1) ?></link>
      <guid isPermaLink="true"><?= htmlspecialchars(abs_url('post.php?p=' . $post['slug']), ENT_XML1) ?></guid>
      <pubDate><?= date(DATE_RSS, strtotime($post['date'])) ?></pubDate>
      <category><?= htmlspecialchars($post['category'], ENT_XML1) ?></category>
      <description><?= htmlspecialchars($post['excerpt'], ENT_XML1) ?></description>
    </item>
<?php endforeach; ?>
  </channel>
</rss>
