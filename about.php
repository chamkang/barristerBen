<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';
require_once __DIR__ . '/includes/data-team.php';

$page = [
    'title'       => 'About Fonju Law Firm | International Legal Consultancy in Douala',
    'description' => 'A Douala consortium of advocates and solicitors advising business across Cameroon and CEMAC. Our mission, expertise and how we work with clients.',
    'canonical'   => 'about.php',
    'breadcrumbs' => [['name' => 'About', 'url' => 'about.php']],
    'body_class'  => 'page-about',
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'About the firm',
    'title'   => 'Specialised legal services,<br>delivered with precision',
    'lede'    => 'Fonju Law Firm was founded on the principle that specialised legal services deliver superior results. Our mission is to be the most trusted and effective legal consultant for businesses driving innovation and growth in Cameroon.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<!-- ============================================================= MISSION -->
<section class="section">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Who we are</p>
      <h2>An international consultancy with <span class="accent">Cameroonian roots</span></h2>
      <div class="rule"></div>
      <p>
        Fonju Law Firm is an international legal consultancy comprising a team of young, dedicated
        lawyers with expertise across a wide range of legal areas. We pride ourselves on having in
        our membership a consortium of highly motivated Advocates and Solicitors of the Republic of
        Cameroon.
      </p>
      <p>
        Lawyers in our consortium are trained at both national and international law schools, which
        brings a genuinely broad range of legal expertise to every matter. The services we deliver
        are guided by the laws of the Republic of Cameroon and beyond, by the deontology and practice
        of our profession, and by international best practice.
      </p>
      <p>
        We are defined by precision, proactive counsel and an unwavering commitment to client
        confidentiality and success.
      </p>
    </div>

    <div class="reveal" data-delay="2">
      <div class="figure-panel">
        <!-- Replace with a real photograph: assets/img/firm.jpg -->
        <span class="figure-panel__mark"><?= icon('building', 92) ?></span>
        <span class="figure-panel__caption">
          <strong>Douala, Littoral Region</strong>
          The economic capital of Cameroon and the gateway to the CEMAC hinterland &mdash; Chad, the Central African Republic and beyond.
        </span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================== PILLARS -->
<section class="section section--dark">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <p class="eyebrow eyebrow--gold">What defines our advice</p>
      <h2>Four commitments we make on every matter</h2>
    </div>

    <div class="grid grid--4">
      <?php
      $pillars = [
        ['icon' => 'spark',  'h' => 'Expertise, not generalism', 'p' => 'Deep specialisation in corporate law and iGaming consultancy, supported by a full-service practice across twenty-one areas.'],
        ['icon' => 'globe',  'h' => 'Regulatory currency',        'p' => 'We track changes under OHADA and the evolving digital gaming and data legislation in Central Africa continuously.'],
        ['icon' => 'clock',  'h' => 'Timely and cost-effective',  'p' => 'Focus lets us give advice that is not only legally sound but delivered when it is still useful, at a price agreed in advance.'],
        ['icon' => 'shield', 'h' => 'Anticipation over reaction', 'p' => 'We help clients prepare for legal challenges arising from digital transformation and cross-border business before they arrive.'],
      ];
      foreach ($pillars as $i => $p): ?>
        <article class="card card--dark reveal" data-delay="<?= $i + 1 ?>">
          <span class="card__icon"><?= icon($p['icon'], 24) ?></span>
          <h3><?= $p['h'] ?></h3>
          <p><?= $p['p'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================= LOCATION -->
<section class="section">
  <div class="wrap split">
    <div class="reveal" data-delay="1">
      <div class="figure-panel">
        <span class="figure-panel__mark"><?= icon('globe', 92) ?></span>
        <span class="figure-panel__caption">
          <strong>International practice, regional depth</strong>
          Clients from Europe, Asia, the Middle East and North America establishing or expanding operations within the CEMAC zone.
        </span>
      </div>
    </div>

    <div class="reveal">
      <p class="eyebrow">Where we work</p>
      <h2>Rooted in Cameroon, working across <span class="accent">borders</span></h2>
      <div class="rule"></div>
      <p class="lede">
        Our office in Douala places us at the heart of Cameroon&rsquo;s economic capital &mdash; the
        ideal location to serve both established multinational corporations and emerging local
        entrepreneurs.
      </p>
      <p>
        While our roots are firm in Cameroonian law, our practice is international. We regularly act
        for clients from Europe, Asia, the Middle East and North America who are establishing or
        expanding operations within the CEMAC zone, frequently as local counsel alongside a
        client&rsquo;s home-country legal team.
      </p>

      <ul class="pill-row mt-6">
        <li><span class="pill pill--gold"><?= icon('pin', 14) ?> Douala &amp; nationwide</span></li>
        <li><span class="pill"><?= icon('globe', 14) ?> CEMAC region</span></li>
        <li><span class="pill"><?= icon('scale', 14) ?> 17 OHADA states</span></li>
        <li><span class="pill"><?= icon('users', 14) ?> English &amp; French</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- ========================================================== PHILOSOPHY -->
<section class="section section--bone">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Our team philosophy</p>
      <h2>Experts in law &mdash; and in the <span class="accent">business</span> the law applies to</h2>
      <p class="lede">
        Our team is composed of seasoned lawyers and consultants who are not only experts in law but
        professionals with a strong background in business and technology. We believe in being
        accessible, transparent and tenacious advocates. We take the time to truly understand your
        business model before we offer a solution.
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $philosophy = [
        ['n' => '01', 'h' => 'Accessible',   'p' => 'Named contacts, calls returned, and updates you do not have to chase. If your matter changes materially, you hear it from us first.'],
        ['n' => '02', 'h' => 'Transparent',  'p' => 'A written engagement letter before work starts, fixed fees wherever the work allows it, and no invoice that has not been trailed in advance.'],
        ['n' => '03', 'h' => 'Tenacious',    'p' => 'Direct about risk before you commit, and relentless once you have. We prepare every dispute as though it will be fought to judgment.'],
      ];
      foreach ($philosophy as $i => $p): ?>
        <article class="card value-card reveal" data-delay="<?= $i + 1 ?>">
          <span class="value-card__num" aria-hidden="true"><?= $p['n'] ?></span>
          <h3><?= $p['h'] ?></h3>
          <p><?= $p['p'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-7 reveal">
      <a class="btn btn--outline" href="<?= e(url('team.php')) ?>">Meet the legal team <?= icon('arrow', 16) ?></a>
    </div>
  </div>
</section>

<!-- =========================================================== CAPABILITY -->
<section class="section">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Capability</p>
      <h2>Twenty-one practice areas, one point of contact</h2>
      <p class="lede">
        Most matters cross several areas of law at once. A property acquisition touches land, tax,
        company and family law; a fintech launch touches financial regulation, data and IP. You get
        one lead lawyer who coordinates all of it.
      </p>
    </div>

    <ul class="practice-index reveal">
      <?php foreach (practice_areas() as $area): ?>
        <li>
          <a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>">
            <?= icon($area['icon'], 17) ?>
            <?= e($area['title']) ?>
            <?= icon('arrow', 15) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
