<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';
require_once dirname(__DIR__) . '/includes/data-blog.php';
require_once dirname(__DIR__) . '/includes/data-faq.php';

$page = [
    'title'       => 'Avocat à Douala, Cameroun | Cabinet d’avocats Fonju, droit des affaires',
    'description' => 'Cabinet d’avocats à Douala : droit des sociétés, investissement, maritime, propriété intellectuelle, travail et contentieux au Cameroun et en zone OHADA.',
    'canonical'   => '',
    'body_class'  => 'page-home',
];

require dirname(__DIR__) . '/includes/header.php';

$featured = featured_practice_areas();
$latest   = array_slice(blog_posts(), 0, 3);
?>

<!-- ================================================================ HERO -->
<section class="hero">
  <div class="hero__bg" aria-hidden="true"></div>
  <div class="hero__grid-lines" aria-hidden="true"></div>

  <div class="wrap hero__inner">
    <div class="hero__content">
      <p class="hero__badge"><b><?= icon('scale', 13) ?></b> Avocats et conseils · République du Cameroun</p>

      <h1 class="hero__title">
        Un conseil juridique spécialisé<br>
        pour les entreprises au <em>Cameroun</em>
      </h1>

      <p class="hero__lede">
        Le cabinet Fonju est un cabinet de conseil juridique international basé à Douala, au service
        des entreprises, des investisseurs et des particuliers au Cameroun et dans toute la zone CEMAC
        et OHADA. Il se distingue par sa rigueur, un conseil proactif et un attachement sans faille
        à la confidentialité.
      </p>

      <div class="hero__actions">
        <a class="btn btn--gold btn--lg" href="<?= e(url('contact.php')) ?>#consultation">
          Prendre rendez-vous <?= icon('arrow', 18) ?>
        </a>
        <a class="btn btn--ghost btn--lg" href="<?= e(url('practice-areas.php')) ?>">
          Nos domaines d’expertise
        </a>
      </div>

      <dl class="hero__trust">
        <div>
          <dt class="k"><span data-count="<?= count(practice_areas()) ?>"><?= count(practice_areas()) ?></span></dt>
          <dd class="v">Domaines d’expertise</dd>
        </div>
        <div>
          <dt class="k"><span data-count="17" data-suffix="">17</span></dt>
          <dd class="v">États OHADA couverts</dd>
        </div>
        <div>
          <dt class="k">FR / EN</dt>
          <dd class="v">Pratique bilingue</dd>
        </div>
        <div>
          <dt class="k">24 h</dt>
          <dd class="v">Délai de réponse</dd>
        </div>
      </dl>
    </div>

    <aside class="hero__card" aria-label="Ce que vous apporte une première consultation">
      <h2>Votre première consultation</h2>
      <p>Pas de jargon, pas de compteur horaire pendant que nous faisons connaissance. Vous repartez en sachant exactement où vous en êtes.</p>

      <ul class="hero__cardlist">
        <li><?= icon('check', 18) ?><span>Une évaluation honnête de votre situation juridique</span></li>
        <li><?= icon('check', 18) ?><span>Les options réalistes, avec leur coût et leur délai</span></li>
        <li><?= icon('check', 18) ?><span>Une recommandation claire &mdash; y compris &laquo;&nbsp;vous n’avez pas besoin d’un avocat&nbsp;&raquo;</span></li>
        <li><?= icon('check', 18) ?><span>Une convention d’honoraires écrite avant tout commencement</span></li>
      </ul>

      <a class="btn btn--gold btn--block" href="<?= e(url('contact.php')) ?>#consultation">Demander une consultation</a>

      <p class="hero__cardnote"><?= icon('shield', 15) ?> Protégé par le secret professionnel dès votre premier message.</p>
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
      <p class="eyebrow">Pourquoi nous choisir</p>
      <h2>Fondé sur la conviction que des services juridiques <span class="accent">spécialisés</span> donnent de meilleurs résultats</h2>
      <p class="lede">
        Nous réunissons des avocats et conseils motivés, formés dans des facultés de droit nationales
        et internationales. Ce que nos clients remarquent d’abord, ce ne sont pas nos titres &mdash;
        c’est la rapidité avec laquelle nous leur disons la vérité sur leur situation.
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $values = [
        ['icon' => 'star',   'num' => '01', 'h' => 'Un solide historique',          'p' => 'Nous maintenons un haut niveau d’exigence grâce à la qualité constante des services rendus à nos clients, en droit des sociétés et en droit commercial, en conseil comme en contentieux.'],
        ['icon' => 'doc',    'num' => '02', 'h' => 'Des honoraires transparents',   'p' => 'Vous recevez avant tout commencement une convention d’honoraires écrite précisant le montant, ce qu’il couvre et ce qu’il exclut. Le conseil est le plus souvent facturé au forfait. Aucune facture surprise.'],
        ['icon' => 'users',  'num' => '03', 'h' => 'Un suivi client exemplaire',    'p' => 'Le service est notre priorité. Vous avez des interlocuteurs nommés, des appels rappelés et des réponses claires &mdash; en français ou en anglais &mdash; pas un numéro de dossier et une attente.'],
        ['icon' => 'globe',  'num' => '04', 'h' => 'Régional et international',     'p' => 'Nos racines sont dans le droit camerounais, mais notre pratique est internationale. Nous conseillons des clients d’Europe, d’Asie, du Moyen-Orient et d’Amérique du Nord qui s’implantent en zone CEMAC.'],
        ['icon' => 'shield', 'num' => '05', 'h' => 'Une confidentialité absolue',   'p' => 'Vos échanges avec votre avocat sont couverts par le secret professionnel. Nous prenons ce devoir au sérieux, et il se poursuit bien après la clôture du dossier.'],
        ['icon' => 'spark',  'num' => '06', 'h' => 'En avance sur la réglementation', 'p' => 'Nous suivons l’évolution des règles OHADA et CEMAC et de la législation sur les jeux numériques et les données en Afrique centrale, pour que nos conseils reflètent ce trimestre, et non l’an dernier.'],
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
      <p class="eyebrow">Le cabinet</p>
      <h2>Au cœur de la <span class="accent">capitale économique</span> du Cameroun</h2>
      <div class="rule"></div>
      <p class="lede">
        Notre bureau de Douala nous place là où se fait réellement le commerce du pays &mdash; le port,
        les banques, les régulateurs et les juridictions qui tranchent les litiges commerciaux. C’est la
        base idéale pour servir aussi bien les multinationales établies que les entrepreneurs locaux.
      </p>
      <ul class="checklist mt-6">
        <li><?= icon('check', 16) ?><span><strong>Ancré dans l’OHADA.</strong> Une grande partie du droit qui régit vos contrats, vos sûretés, votre société et les procédures collectives est régionale, et non nationale. C’est notre quotidien.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Bijuridique et bilingue.</strong> Procédure de common law dans le Nord-Ouest et le Sud-Ouest, droit civil ailleurs. Nos avocats plaident dans les deux traditions, en français et en anglais.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Au fait des affaires.</strong> Nos avocats et consultants viennent aussi du monde de l’entreprise et de la technologie. Nous comprenons votre modèle avant de proposer une solution.</span></li>
        <li><?= icon('check', 16) ?><span><strong>Accessibles et tenaces.</strong> Transparents sur les coûts, directs sur les risques, et infatigables une fois mandatés.</span></li>
      </ul>
      <p class="mt-6">
        <a class="btn btn--outline" href="<?= e(url('about.php')) ?>">Découvrir le cabinet <?= icon('arrow', 16) ?></a>
      </p>
    </div>

    <div class="reveal" data-delay="2">
      <div class="figure-panel">
        <span class="figure-panel__mark"><?= brand_mark(170) ?></span>
        <span class="figure-panel__caption">
          <strong>Rue Ernest Betote, Akwa</strong>
          Douala, région du Littoral &mdash; au service du Cameroun, du Tchad, de la République centrafricaine et de l’ensemble du marché CEMAC.
        </span>
      </div>
    </div>
  </div>
</section>

<!-- ====================================================== PRACTICE AREAS -->
<section class="section" id="practice">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Domaines d’expertise</p>
      <h2>Une expertise large, appliquée <span class="accent">précisément</span> à votre problème</h2>
      <p class="lede">
        Grâce à une approche centrée sur le client, nous bâtissons des relations solides et durables
        &mdash; en comprenant vos objectifs et en travaillant avec vous pour les atteindre. Voici les
        domaines pour lesquels nos clients nous sollicitent le plus souvent.
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
            En savoir plus <?= icon('arrow', 15) ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-7 reveal">
      <h3 class="mb-5">Tous nos domaines d’intervention</h3>
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
      <p class="eyebrow eyebrow--gold">Notre méthode</p>
      <h2>Du premier appel à la clôture du dossier</h2>
      <p class="lede">
        Le travail juridique déraille toujours aux mêmes endroits : un périmètre flou, des coûts
        imprévus et le silence. Notre méthode est conçue pour éliminer les trois.
      </p>

      <div class="stats mt-7">
        <div class="stats__item">
          <span class="stats__num"><span data-count="24" data-suffix=" h">24 h</span></span>
          <span class="stats__label">Délai de réponse</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">Forfait</span>
          <span class="stats__label">Dès que possible</span>
        </div>
        <div class="stats__item">
          <span class="stats__num">100 %</span>
          <span class="stats__label">Périmètre écrit</span>
        </div>
      </div>
    </div>

    <div class="process reveal" data-delay="2">
      <?php
      $steps = [
        ['h' => 'Racontez-nous ce qui s’est passé', 'p' => 'Un appel, un message WhatsApp ou le formulaire. Nous posons des questions jusqu’à comprendre la situation commerciale, et pas seulement juridique.'],
        ['h' => 'Recevez une analyse écrite', 'p' => 'Votre situation, les options réalistes, le coût et le délai probables de chacune, et notre recommandation. Par écrit, pour que vous puissiez agir.'],
        ['h' => 'Convenez du périmètre et des honoraires', 'p' => 'Une convention qui précise ce que nous ferons, ce que cela coûte et ce qui est exclu. Rien ne commence avant votre signature.'],
        ['h' => 'Exécution et comptes rendus', 'p' => 'Un avocat référent, des points réguliers sans avoir à relancer, et une alerte immédiate en cas de changement important.'],
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
      <p class="eyebrow">Expérience client</p>
      <h2>Travailler avec nous, concrètement</h2>
      <p class="lede">
        L’identité de nos clients est confidentielle : ces témoignages sont publiés avec leur accord
        et sans nom. <strong>Remplacez-les ou complétez-les dans <code>fr/index.php</code> à mesure
        que vous recueillez d’autres témoignages.</strong>
      </p>
    </div>

    <div class="grid grid--3">
      <?php
      $quotes = [
        ['q' => 'Dès la première réunion, ils nous ont dit que la structure envisagée ne passerait pas le premier audit. Personne d’autre ne l’avait dit. La reconstruire a coûté une fraction de ce qu’aurait coûté l’erreur.', 'n' => 'Directeur général', 'r' => 'Groupe industriel, Douala', 'a' => 'DG'],
        ['q' => 'Il nous fallait un conseil local capable d’échanger avec nos avocats parisiens sans traduire chaque notion. Le cabinet Fonju l’a fait, et l’opération a été conclue dans les délais.', 'n' => 'Directeur juridique', 'r' => 'Investisseur européen, entrée en zone CEMAC', 'a' => 'DJ'],
        ['q' => 'Le terrain que nous allions acheter avait un titre en apparence parfait. La recherche a montré que le vendeur ne pouvait pas légalement le vendre. Cette vérification a sauvé tout l’investissement.', 'n' => 'Client particulier', 'r' => 'Acquisition immobilière, Littoral', 'a' => 'CP'],
      ];
      foreach ($quotes as $i => $q): ?>
        <figure class="quote-card reveal" data-delay="<?= $i + 1 ?>">
          <?= icon('quote', 30) ?>
          <blockquote><?= $q['q'] ?></blockquote>
          <div class="quote-card__stars" aria-label="Cinq sur cinq">
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
      <p class="eyebrow">Actualités</p>
      <h2>Des analyses juridiques écrites pour <span class="accent">servir</span></h2>
      <p class="lede">
        Des notes pratiques sur le droit camerounais et OHADA pour les chefs d’entreprise, les
        investisseurs et les juristes d’entreprise &mdash; pas des résumés de textes que vous pouvez
        déjà lire.
      </p>
    </div>

    <div class="grid grid--3">
      <?php foreach ($latest as $i => $post): ?>
        <?= post_card($post, $i + 1) ?>
      <?php endforeach; ?>
    </div>

    <p class="mt-7 reveal">
      <a class="btn btn--outline" href="<?= e(url('blog.php')) ?>">Toutes les actualités <?= icon('arrow', 16) ?></a>
    </p>
  </div>
</section>

<!-- ================================================================= FAQ -->
<section class="section section--bone">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Questions fréquentes</p>
      <h2>Des réponses avant même de <span class="accent">nous appeler</span></h2>
      <p class="lede">
        Les questions que nos clients posent le plus souvent, avec de vraies réponses. Vous en
        trouverez plus de vingt sur notre page FAQ, classées par thème.
      </p>
      <p class="mt-6">
        <a class="btn btn--outline" href="<?= e(url('faq.php')) ?>">Voir toutes les questions <?= icon('arrow', 16) ?></a>
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

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
