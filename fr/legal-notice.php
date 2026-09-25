<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');

$page = [
    'title'       => 'Mentions légales et avertissement | Cabinet Fonju',
    'description' => 'Mentions légales, conditions d’utilisation et avertissement du site du cabinet Fonju : limites des informations publiées et conditions dans lesquelles nous acceptons un mandat.',
    'canonical'   => 'legal-notice.php',
    'breadcrumbs' => [['name' => 'Mentions légales', 'url' => 'legal-notice.php']],
    'body_class'  => 'page-legal',
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Informations légales',
    'title'   => 'Mentions légales et avertissement',
    'lede'    => 'Le cadre dans lequel ce site est publié et les limites de ce qu’il permet. Dernière mise à jour : ' . fmt_month() . '.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap wrap--narrow">
    <div class="prose reveal">

      <div class="alert alert--err mb-6" role="note">
        <?= icon('shield', 20) ?>
        <div>
          <strong>Modèle &mdash; à faire relire avant la mise en ligne.</strong>
          Confirmez les informations d’immatriculation du cabinet, les inscriptions au barreau et la
          couverture en responsabilité civile professionnelle, puis complétez les éléments ci-dessous.
          Modifiez cette page dans <code>fr/legal-notice.php</code>.
        </div>
      </div>

      <h2>Éditeur du site</h2>
      <p>
        Ce site est édité par <?= e(SITE_LEGALNAME) ?>, cabinet de conseil juridique établi
        <?= e(full_address()) ?>.<br>
        Téléphone : <?= e(CONTACT['phone_primary']) ?> / <?= e(CONTACT['phone_secondary']) ?><br>
        E-mail : <?= e(CONTACT['email_general']) ?>
      </p>
      <p>
        <em>À compléter : numéro RCCM, numéro d’identifiant unique (NIU), barreau d’inscription des
        avocats du cabinet et nom du directeur de la publication.</em>
      </p>

      <h2>Absence de conseil juridique</h2>
      <p>
        Le contenu de ce site est une information générale sur le droit camerounais, OHADA, CEMAC et
        les matières connexes. Il ne constitue pas un conseil juridique, ne peut tenir compte de votre
        situation et peut ne pas refléter les évolutions du droit postérieures à sa publication.
        N’agissez pas, et ne vous abstenez pas d’agir, sur la base de ce qui est publié ici sans avoir
        obtenu un conseil adapté à votre situation.
      </p>

      <h2>Absence de relation avocat&ndash;client</h2>
      <p>
        La consultation de ce site, l’envoi d’une demande ou la réception d’une première réponse ne
        créent pas de relation avocat&ndash;client. Cette relation ne naît qu’après nos vérifications de
        conflit d’intérêts et d’identité, et la signature par les deux parties d’une convention écrite
        précisant le périmètre de la mission et les honoraires.
      </p>

      <h2>Informations transmises spontanément</h2>
      <p>
        Merci de ne pas nous adresser d’informations confidentielles ou couvertes par le secret avant
        que nous ayons confirmé pouvoir intervenir pour vous. Les informations transmises avant la mise
        en place d’une mission peuvent ne pas être protégées et ne nous empêchent pas nécessairement
        d’intervenir pour une autre partie dans la même affaire.
      </p>

      <h2>Honoraires</h2>
      <p>
        Nos honoraires sont convenus par écrit avant tout commencement. Le conseil et les opérations
        font normalement l’objet d’un forfait ; le contentieux est facturé selon une structure convenue,
        par étapes définies. Nous contacter pour savoir si nous pouvons vous aider n’entraîne aucun
        honoraire.
      </p>

      <h2>Liens vers d’autres sites</h2>
      <p>
        Les liens vers des sites tiers sont fournis pour votre commodité. Nous ne contrôlons pas ces
        sites et déclinons toute responsabilité quant à leur contenu ou à l’usage que vous en faites.
      </p>

      <h2>Propriété intellectuelle</h2>
      <p>
        Les textes, la conception, la structure et les éléments graphiques de ce site appartiennent au
        <?= e(SITE_NAME) ?>, sauf mention contraire. Vous pouvez les lire, les imprimer et en citer de
        courts extraits avec mention de la source et un lien. Toute reproduction systématique,
        republication ou utilisation commerciale requiert notre autorisation écrite.
      </p>

      <h2>Limitation de responsabilité</h2>
      <p>
        Nous veillons à l’exactitude et à la disponibilité de ce site, sans garantir qu’il soit complet,
        à jour ou accessible sans interruption. Dans toute la mesure permise par la loi, nous excluons
        toute responsabilité pour les pertes résultant de l’utilisation du contenu de ce site par toute
        personne qui n’est pas un client agissant dans le cadre d’une convention signée.
      </p>

      <h2>Droit applicable</h2>
      <p>
        Les présentes mentions et tout litige lié à l’utilisation de ce site sont régis par le droit de
        la République du Cameroun, et les juridictions de Douala sont compétentes.
      </p>

      <h2>Réclamations</h2>
      <p>
        Si un aspect de notre service ne vous satisfait pas, écrivez à
        <a href="mailto:<?= e(CONTACT['email_principal']) ?>"><?= e(CONTACT['email_principal']) ?></a>.
        Nous accuserons réception de votre réclamation rapidement et vous indiquerons comment elle sera
        traitée.
      </p>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
