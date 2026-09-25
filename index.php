<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';
require_once __DIR__ . '/includes/data-blog.php';
require_once __DIR__ . '/includes/data-faq.php';

$page = [
    'title'       => 'Lawyers in Douala, Cameroon | Fonju Law Firm, Corporate & Business Law',
    'description' => 'Douala legal consultancy advising business across Cameroon and the CEMAC/OHADA zone: corporate, investment, maritime, IP, employment and litigation.',
    'canonical'   => '',
    'body_class'  => 'page-home',
];

require __DIR__ . '/includes/header.php';

$featured = featured_practice_areas();
$latest   = array_slice(blog_posts(), 0, 3);
?>

<!-- ================================================================ HERO -->
<section class="hero">
  <div class="hero__bg" aria-hidden="true"></div>
  <div class="hero__grid-lines" aria-hidden="true"></div>

  <div class="wrap hero__inner">
    <div class="hero__content">
      <p class="hero__badge"><b><?= icon('scale', 13) ?></b> Advocates &amp; Solicitors · Republic of Cameroon</p>

      <h1 class="hero__title">
        Specialised legal counsel for<br>
        business in <em>Cameroon</em>
      </h1>

      <p class="hero__lede">
        Fonju Law Firm is an international legal consultancy based in Douala, advising companies,
        investors and individuals across Cameroon and the wider CEMAC and OHADA region. We are
        defined by precision, proactive counsel and an unwavering commitment to client confidentiality.
      </p>

      <div class="hero__actions">
        <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">
          Book a consultation <?= icon('arrow', 18) ?>
        </a>
        <a class="btn btn--ghost btn--lg" href="<?= e(url('practice-areas.php')) ?>">
          Explore our practice areas
        </a>
      </div>

      <dl class="hero__trust">
        <div>
          <dt class="k"><span data-count="<?= count(practice_areas()) ?>"><?= count(practice_areas()) ?></span></dt>
          <dd class="v">Practice areas</dd>
        </div>
        <div>
          <dt class="k"><span data-count="17" data-suffix="">17</span></dt>
          <dd class="v">OHADA states covered</dd>
        </div>
        <div>
          <dt class="k">EN / FR</dt>
          <dd class="v">Bilingual practice</dd>
        </div>
        <div>
          <dt class="k">24h</dt>
          <dd class="v">Enquiry response</dd>
        </div>
      </dl>
    </div>

    <aside class="hero__card" aria-label="What a first consultation gives you">
      <h2>Your first consultation</h2>
      <p>No jargon, no hourly meter running while we get to know each other. You leave the meeting knowing exactly where you stand.</p>

      <ul class="hero__cardlist">
        <li><?= icon('check', 18) ?><span>An honest assessment of your legal position</span></li>
        <li><?= icon('check', 18) ?><span>The realistic options, with cost and timeline attached</span></li>
        <li><?= icon('check', 18) ?><span>A clear recommendation &mdash; including &ldquo;you don&rsquo;t need a lawyer&rdquo;</span></li>
        <li><?= icon('check', 18) ?><span>A written engagement letter before any work begins</span></li>
      </ul>

      <a class="btn btn--gold btn--block" href="<?= e(url('contact.php')) ?>#consultation">Request a consultation</a>

      <p class="hero__cardnote"><?= icon('shield', 15) ?> Protected by professional secrecy from your first message.</p>
    </aside>
  </div>
</section>

<!-- ============================================================= MARQUEE -->
<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
    <?php foreach (practice_areas() as $area): ?>
      <span class="marquee__item"><?= e($area['title']) ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- ========================================================= WHY THE FIRM -->
<section class="section">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <p class="eyebrow">Why choose our firm</p>
      <h2>Built on the conviction that <span class="accent">specialised</span> legal services deliver superior results</h2>
      <p class="lede">
        We are a consortium of motivated advocates and solicitors trained at national and
        international law schools. What clients notice first is not our credentials &mdash; it is
        how quickly we tell them the truth about their position.
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $values = [
        ['icon' => 'star',   'num' => '01', 'h' => 'An excellent track record',  'p' => 'We have maintained a record of excellence through the consistent delivery of quality services to our clients, across corporate, commercial and contentious work.'],
        ['icon' => 'doc',    'num' => '02', 'h' => 'Transparent fees',            'p' => 'You receive a written engagement letter setting out the fee, what it covers and what it excludes, before work begins. Advisory work is usually fixed-fee. We do not send surprise invoices.'],
        ['icon' => 'users',  'num' => '03', 'h' => 'Outstanding client care',     'p' => 'Our first priority is service. You get named contacts, calls returned, and plain answers &mdash; in English or French &mdash; not a file number and a wait.'],
        ['icon' => 'globe',  'num' => '04', 'h' => 'Regional and international',  'p' => 'Our roots are in Cameroonian law, but our practice is international. We act for clients from Europe, Asia, the Middle East and North America entering the CEMAC zone.'],
        ['icon' => 'shield', 'num' => '05', 'h' => 'Absolute confidentiality',    'p' => 'Communications with your lawyer are protected by professional secrecy. That duty is one we take seriously, and it continues long after the matter has closed.'],
        ['icon' => 'spark',  'num' => '06', 'h' => 'Ahead of the regulation',     'p' => 'We track regulatory change under OHADA, CEMAC and the evolving digital gaming and data legislation in Central Africa, so our advice reflects this quarter, not last year.'],
      ];
      foreach ($values as $i => $v): ?>
        <article class="card value-card reveal" data-delay="<?= $i % 3 + 1 ?>">
          <span class="value-card__num" aria-hidden="true"><?= $v['num'] ?></span>
          <span class="card__icon"><?= icon($v['icon'], 24) ?></span>
          <h3><?= $v['h'] ?></h3>
          <p><?= $v['p'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =============================================================== ABOUT -->
<section class="section section--bone">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">About the firm</p>
      <h2>At the heart of Cameroon&rsquo;s <span class="accent">economic capital</span></h2>
      <div class="rule"></div>
      <p class="lede">
        Our office in Douala places us where the country&rsquo;s commerce actually happens &mdash; the port,
        the banks, the regulators and the courts that decide commercial disputes. It is the right
        base from which to serve established multinationals and emerging local entrepreneurs alike.
      </p>
      <ul class="checklist mt-6">
        <li><?= icon('check', 16) ?><span><strong>Grounded in OHADA.</strong> A large part of the law governing your contracts, security, company and insolvency is regional, not national. We work in it every day.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Bijural and bilingual.</strong> Common law procedure in the North West and South West, civil law elsewhere. Our advocates plead in both traditions, in English and French.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Business-literate.</strong> Our lawyers and consultants have backgrounds in business and technology. We understand your model before we propose a solution.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Accessible and tenacious.</strong> Transparent about cost, direct about risk, and relentless once instructed.</span></li>
      </ul>
      <p class="mt-6">
        <a class="btn btn--outline" href="<?= e(url('about.php')) ?>">More about Fonju Law Firm <?= icon('arrow', 16) ?></a>
      </p>
    </div>

    <div class="reveal" data-delay="2">
      <div class="figure-panel">
        <!-- Drop a real photograph at assets/img/office-douala.jpg and uncomment:
             <img src="<?= e(asset('img/office-douala.jpg')) ?>" alt="Fonju Law Firm office in Akwa, Douala"> -->
        <span class="figure-panel__mark"><?= brand_mark(170) ?></span>
        <span class="figure-panel__caption">
          <strong>Rue Ernest Betote, Akwa</strong>
          Douala, Littoral Region &mdash; serving Cameroon, Chad, the Central African Republic and the wider CEMAC market.
        </span>
      </div>
    </div>
  </div>
</section>

<!-- ====================================================== PRACTICE AREAS -->
<section class="section" id="practice">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Areas of practice</p>
      <h2>Wide expertise, applied <span class="accent">narrowly</span> to your problem</h2>
      <p class="lede">
        With a client-centric approach we build strong, enduring relationships &mdash; understanding
        your goals and working collaboratively toward them. These are the areas clients come to us
        for most often.
      </p>
    </div>

    <div class="grid grid--3">
      <?php foreach ($featured as $i => $area): ?>
        <article class="card practice-card reveal" data-delay="<?= $i % 3 + 1 ?>">
          <span class="card__icon"><?= icon($area['icon'], 24) ?></span>
          <p class="practice-card__group"><?= e($area['group']) ?></p>
          <h3><a href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>"><?= e($area['title']) ?></a></h3>
          <p><?= e($area['short']) ?></p>
          <a class="link-arrow" href="<?= e(url('practice-area.php?area=' . $area['slug'])) ?>">
            Read more <?= icon('arrow', 15) ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-7 reveal">
      <h3 class="mb-5">Every area we practise in</h3>
      <ul class="practice-index">
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
  </div>
</section>

<!-- ============================================================ APPROACH -->
<section class="section section--dark">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow eyebrow--gold">How we work</p>
      <h2>From first call to closed file</h2>
      <p class="lede">
        Legal work goes wrong in predictable places: unclear scope, surprise costs and silence.
        Our process is designed to remove all three.
      </p>

      <div class="stats mt-7">
        <div class="stats__item">
          <span class="stats__num"><span data-count="24" data-suffix="h">24h</span></span>
          <span class="stats__label">Enquiry response</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">Fixed</span>
          <span class="stats__label">Fees where possible</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">100%</span>
          <span class="stats__label">Written scope</span>
        </div>
      </div>
    </div>

    <div class="process reveal" data-delay="2">
      <?php
      $steps = [
        ['h' => 'Tell us what happened', 'p' => 'A call, a WhatsApp message or the enquiry form. We ask questions until we understand the commercial situation, not just the legal one.'],
        ['h' => 'Get a written assessment', 'p' => 'Your position, the realistic options, the likely cost and timeline of each, and our recommendation. In writing, so you can act on it.'],
        ['h' => 'Agree scope and fee', 'p' => 'An engagement letter that says what we will do, what it costs and what is excluded. Nothing starts until you have signed it.'],
        ['h' => 'Execution and reporting', 'p' => 'A named lawyer, regular updates without chasing, and immediate escalation when something material changes.'],
      ];
      foreach ($steps as $i => $step): ?>
        <div class="process__step">
          <span class="process__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div class="process__body">
            <h3><?= $step['h'] ?></h3>
            <p><?= $step['p'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ======================================================== TESTIMONIALS -->
<section class="section section--bone">
  <div class="wrap">
    <div class="section-head section-head--center reveal">
      <p class="eyebrow">Client experience</p>
      <h2>What working with us is like</h2>
      <p class="lede">
        Client identities are confidential, so these accounts are published with permission and
        without names. <strong>Replace or extend them in <code>index.php</code> as you collect
        further testimonials.</strong>
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $quotes = [
        ['q' => 'They told us in the first meeting that our planned structure would fail at the first audit. Nobody else had said it. Rebuilding it cost a fraction of what the mistake would have.', 'n' => 'Managing Director', 'r' => 'Manufacturing group, Douala', 'a' => 'MD'],
        ['q' => 'We needed local counsel who could talk to our lawyers in Paris without translation of every concept. Fonju did that, and the deal closed on schedule.', 'n' => 'General Counsel', 'r' => 'European investor, CEMAC entry', 'a' => 'GC'],
        ['q' => 'The land we were about to buy had a title that looked perfect. The search showed the seller could not lawfully sell it. That check saved the whole investment.', 'n' => 'Private client', 'r' => 'Property acquisition, Littoral', 'a' => 'PC'],
      ];
      foreach ($quotes as $i => $q): ?>
        <figure class="quote-card reveal" data-delay="<?= $i + 1 ?>">
          <?= icon('quote', 30) ?>
          <blockquote><?= $q['q'] ?></blockquote>
          <div class="quote-card__stars" aria-label="Five out of five">
            <?= str_repeat(icon('star', 15), 5) ?>
          </div>
          <figcaption class="quote-card__by">
            <span class="quote-card__avatar" aria-hidden="true"><?= $q['a'] ?></span>
            <span>
              <span class="quote-card__name"><?= $q['n'] ?></span><br>
              <span class="quote-card__role"><?= $q['r'] ?></span>
            </span>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ INSIGHTS -->
<section class="section">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Insights</p>
      <h2>Legal updates written to be <span class="accent">used</span></h2>
      <p class="lede">
        Practical notes on Cameroonian and OHADA law for business owners, investors and in-house
        teams &mdash; not summaries of statutes you can already read.
      </p>
    </div>

    <div class="grid grid--3">
      <?php foreach ($latest as $i => $post): ?>
        <?= post_card($post, $i + 1) ?>
      <?php endforeach; ?>
    </div>

    <p class="mt-7 reveal">
      <a class="btn btn--outline" href="<?= e(url('blog.php')) ?>">All insights <?= icon('arrow', 16) ?></a>
    </p>
  </div>
</section>

<!-- ================================================================= FAQ -->
<section class="section section--bone">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Common questions</p>
      <h2>Answers before you <span class="accent">pick up the phone</span></h2>
      <p class="lede">
        The questions clients ask most often, answered properly. There are more than twenty
        on our full FAQ page, grouped by topic.
      </p>
      <p class="mt-6">
        <a class="btn btn--outline" href="<?= e(url('faq.php')) ?>">See all questions <?= icon('arrow', 16) ?></a>
      </p>
    </div>

    <div class="accordion reveal" data-delay="2">
      <?php foreach (faq_highlights(5) as $i => $item): ?>
        <div class="accordion__item">
          <h3 class="mb-0">
            <button class="accordion__trigger" type="button" aria-expanded="false" aria-controls="home-faq-<?= $i ?>" id="home-faq-t-<?= $i ?>">
              <span><?= $item['q'] ?></span>
              <span class="accordion__icon" aria-hidden="true"><?= icon('plus', 15) ?></span>
            </button>
          </h3>
          <div class="accordion__panel" id="home-faq-<?= $i ?>" role="region" aria-labelledby="home-faq-t-<?= $i ?>">
            <div class="accordion__inner"><?= $item['a'] ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
