<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-team.php';

$members = team_members();

$page = [
    'title'       => 'Our Legal Team | Advocates & Solicitors | Fonju Law Firm Douala',
    'description' => 'Meet the advocates and consultants of Fonju Law Firm, Douala: lawyers trained at national and international law schools, working in English and French.',
    'canonical'   => 'team.php',
    'breadcrumbs' => [['name' => 'Our Team', 'url' => 'team.php']],
    'body_class'  => 'page-team',
    'schema'      => array_values(array_map(
        static function (array $m): array {
            $person = [
                '@type'       => 'Person',
                'name'        => $m['name'],
                'jobTitle'    => $m['role'],
                'description' => $m['bio'],
                'worksFor'    => ['@id' => SITE_URL . '/#organization'],
                'knowsLanguage' => $m['languages'],
                'url'         => abs_url('team.php#' . $m['slug']),
            ];

            if ($m['email'] !== '') {
                $person['email'] = $m['email'];
            }
            if ($m['linkedin'] !== '') {
                $person['sameAs'] = [$m['linkedin']];
            }

            return $person;
        },
        // Placeholder entries are excluded from structured data so search
        // engines are never given a fictional person.
        array_filter($members, static fn(array $m): bool => empty($m['placeholder']))
    )),
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Our legal team',
    'title'   => 'A consortium of motivated<br>advocates and solicitors',
    'lede'    => 'Our team is composed of seasoned lawyers and consultants who are not just experts in law, but professionals with a strong background in business and technology. We are accessible, transparent and tenacious advocates for our clients.',
];
require __DIR__ . '/includes/page-hero.php';

$hasPlaceholders = (bool) array_filter($members, static fn(array $m): bool => !empty($m['placeholder']));
?>

<section class="section">
  <div class="wrap">
    <div class="grid grid--3">
      <?php foreach ($members as $i => $member): ?>
        <article class="team-card reveal" id="<?= e($member['slug']) ?>" data-delay="<?= $i % 3 + 1 ?>">
          <div class="team-card__photo">
            <?php if (!empty($member['placeholder'])): ?>
              <span class="team-card__flag">Placeholder</span>
            <?php endif; ?>

            <?php if ($member['photo'] !== ''): ?>
              <img src="<?= e(asset('img/team/' . $member['photo'])) ?>"
                   alt="<?= e($member['name'] . ', ' . $member['role'] . ' at ' . SITE_NAME) ?>"
                   width="600" height="660" loading="lazy">
            <?php else: ?>
              <span class="team-card__monogram" aria-hidden="true"><?= e(member_initials($member['name'])) ?></span>
            <?php endif; ?>
          </div>

          <div class="team-card__body">
            <h2 class="team-card__name"><?= e($member['name']) ?></h2>
            <p class="team-card__role"><?= e($member['role']) ?></p>
            <p class="team-card__bio"><?= e($member['bio']) ?></p>

            <ul class="pill-row team-card__meta">
              <?php foreach ($member['focus'] as $focus): ?>
                <li><span class="pill"><?= e($focus) ?></span></li>
              <?php endforeach; ?>
              <li><span class="pill pill--gold"><?= icon('globe', 13) ?> <?= e(implode(' / ', $member['languages'])) ?></span></li>
            </ul>

            <div class="team-card__links">
              <?php if ($member['email'] !== ''): ?>
                <a href="mailto:<?= e($member['email']) ?>" aria-label="Email <?= e($member['name']) ?>"><?= icon('mail', 17) ?></a>
              <?php endif; ?>
              <?php if ($member['linkedin'] !== ''): ?>
                <a href="<?= e($member['linkedin']) ?>" target="_blank" rel="noopener" aria-label="<?= e($member['name']) ?> on LinkedIn"><?= icon('linkedin', 16) ?></a>
              <?php endif; ?>
              <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>" aria-label="Call the firm"><?= icon('phone', 17) ?></a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($hasPlaceholders): ?>
      <div class="alert alert--err mt-7" role="note">
        <?= icon('shield', 20) ?>
        <div>
          <strong>Note for the site administrator (this box is not shown once resolved).</strong>
          Cards marked <em>Placeholder</em> are structural examples so the page renders in full.
          Replace the names, roles, biographies and photographs in
          <code>includes/data-team.php</code>, or delete the entries you do not need. Placeholder
          entries are deliberately excluded from the page&rsquo;s structured data, and this notice
          disappears automatically once every placeholder is replaced.
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--dark">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow eyebrow--gold">Our philosophy</p>
      <h2>We understand your business before we advise on it</h2>
      <p class="lede">
        Legal advice given without commercial understanding is a liability. Our lawyers take the
        time to understand your model, your counterparties and your constraints, and only then
        propose a solution &mdash; which is sometimes to do nothing at all.
      </p>
      <ul class="checklist mt-6">
        <li><?= icon('check', 16) ?><span>Trained at national and international law schools</span></li>
        <li><?= icon('check', 16) ?><span>Backgrounds in business and technology, not only law</span></li>
        <li><?= icon('check', 16) ?><span>Comfortable in both common law and civil law procedure</span></li>
        <li><?= icon('check', 16) ?><span>Bound by professional secrecy in every engagement</span></li>
      </ul>
    </div>

    <div class="reveal" data-delay="2">
      <div class="stats">
        <div class="stats__item">
          <span class="stats__num"><span data-count="<?= count(practice_areas()) ?>"><?= count(practice_areas()) ?></span></span>
          <span class="stats__label">Practice areas</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">EN/FR</span>
          <span class="stats__label">Working languages</span>
        </div>
        <div class="stats__item">
          <span class="stats__num"><span data-count="17">17</span></span>
          <span class="stats__label">OHADA states</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">24h</span>
          <span class="stats__label">Response target</span>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
