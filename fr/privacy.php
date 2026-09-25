<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');

$page = [
    'title'       => 'Politique de confidentialité | Cabinet Fonju',
    'description' => 'Comment le cabinet Fonju collecte, utilise, conserve et protège les données personnelles transmises via fonjulawfirm.com, et les droits dont vous disposez.',
    'canonical'   => 'privacy.php',
    'breadcrumbs' => [['name' => 'Politique de confidentialité', 'url' => 'privacy.php']],
    'body_class'  => 'page-legal',
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Informations légales',
    'title'   => 'Politique de confidentialité',
    'lede'    => 'Comment nous traitons les informations personnelles que vous nous confiez via ce site. Dernière mise à jour : ' . fmt_month() . '.',
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
          Cette politique est une base solide rédigée pour un cabinet d’avocats camerounais, mais elle
          doit être confrontée à vos pratiques réelles de traitement des données et à la législation
          camerounaise applicable en matière de protection des données personnelles et de
          cybersécurité avant la mise en ligne. Modifiez-la dans <code>fr/privacy.php</code>.
        </div>
      </div>

      <h2>Qui sommes-nous</h2>
      <p>
        Ce site est exploité par <?= e(SITE_LEGALNAME) ?> (« nous », « le cabinet »). Nos bureaux sont
        situés <?= e(full_address()) ?>. Pour toute question relative à cette politique, écrivez-nous à
        <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a>.
      </p>

      <h2>Ce que nous collectons</h2>
      <p>Nous ne collectons que ce qui est nécessaire pour vous répondre et faire fonctionner le site :</p>
      <ul>
        <li><strong>Les informations de votre demande</strong> &mdash; nom, adresse e-mail, téléphone, domaine du droit choisi et message envoyés via le formulaire de contact.</li>
        <li><strong>Nos échanges</strong> &mdash; le contenu des e-mails, messages WhatsApp et appels lorsque vous nous contactez directement.</li>
        <li><strong>Les données techniques</strong> &mdash; votre adresse IP, le type de navigateur et les pages consultées, enregistrés par le serveur web et, si elle est activée et acceptée, par la mesure d’audience.</li>
      </ul>
      <p>
        Nous ne demandons pas, et vous ne devez pas transmettre via ce site, de pièces d’identité, de
        coordonnées bancaires, de numéros de carte ou d’autres informations sensibles.
      </p>

      <h2>Pourquoi nous les utilisons</h2>
      <ul>
        <li>Pour répondre à votre demande et fournir les services juridiques que vous sollicitez.</li>
        <li>Pour effectuer les vérifications de conflit d’intérêts et d’identité qu’imposent nos obligations professionnelles.</li>
        <li>Pour conserver la trace des conseils donnés, conformément aux règles professionnelles.</li>
        <li>Pour assurer la sécurité et le bon fonctionnement du site.</li>
      </ul>
      <p>
        Nous nous fondons sur votre consentement lorsque vous envoyez le formulaire de contact, puis
        sur l’exécution de notre mission et sur nos obligations légales et professionnelles.
      </p>

      <h2>Confidentialité et secret professionnel</h2>
      <p>
        Les informations que vous nous communiquez pour obtenir un conseil juridique sont en outre
        protégées par le secret professionnel, en vertu des règles régissant la profession d’avocat en
        République du Cameroun. Cette protection, plus forte qu’une simple obligation de
        confidentialité, s’applique dès votre premier contact et se poursuit après la clôture de votre
        dossier.
      </p>

      <h2>Avec qui nous les partageons</h2>
      <p>
        Nous ne vendons pas de données personnelles et ne les partageons pas à des fins commerciales.
        Nous ne communiquons des informations qu’aux prestataires qui hébergent notre site ou notre
        messagerie, tenus à la confidentialité ; aux juridictions, régulateurs ou parties adverses
        lorsque c’est nécessaire à la conduite de votre dossier et que vous nous en avez donné
        instruction ; et lorsque la loi nous y oblige.
      </p>

      <h2>Durée de conservation</h2>
      <p>
        Les demandes qui n’aboutissent pas à un mandat sont conservées pendant une durée limitée, puis
        supprimées. Les dossiers clients sont conservés pendant la durée requise par les règles
        professionnelles et les délais de prescription applicables, puis détruits de manière sécurisée.
      </p>

      <h2>Sécurité</h2>
      <p>
        Nous appliquons des mesures organisationnelles et techniques adaptées à la sensibilité des
        informations que nous détenons, notamment des restrictions d’accès et des transmissions
        chiffrées. Aucun système n’est parfaitement sûr : n’envoyez donc pas de documents très
        sensibles via le formulaire &mdash; contactez-nous et nous mettrons en place un canal sécurisé.
      </p>

      <h2>Vos droits</h2>
      <p>
        Sous réserve de nos obligations professionnelles, vous pouvez nous demander une copie des
        données personnelles que nous détenons à votre sujet, leur rectification si elles sont
        inexactes, leur suppression lorsque nous ne sommes pas tenus de les conserver, et retirer un
        consentement donné. Écrivez à
        <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a> : nous
        vous répondrons rapidement.
      </p>

      <h2 id="cookies">Cookies et mesure d’audience</h2>
      <p>
        Ce site ne dépose aucun cookie publicitaire. En dehors d’un cookie de sécurité strictement
        nécessaire qui peut être utilisé lors de l’envoi du formulaire de contact, il ne dépose aucun
        cookie qui lui soit propre. Deux fonctions facultatives peuvent impliquer des cookies de tiers,
        et aucune ne se charge sans votre accord donné dans le bandeau cookies :
      </p>
      <ul>
        <li><strong>Mesure d’audience</strong> &mdash; lorsqu’elle est activée, Google Analytics nous
          indique, de manière agrégée, quelles pages sont lues, afin d’améliorer le site. Elle n’est pas
          utilisée à des fins publicitaires.</li>
        <li><strong>Cartes et contenus intégrés</strong> &mdash; la carte Google de notre page contact,
          servie par Google depuis ses propres serveurs, qui peut déposer des cookies Google.</li>
      </ul>
      <p>
        Votre choix est enregistré dans votre navigateur, et non sur nos serveurs. Vous pouvez le
        modifier à tout moment grâce au lien « Paramètres des cookies » en bas de chaque page.
      </p>

      <h2>Modifications</h2>
      <p>
        Nous pouvons mettre à jour cette politique. La date indiquée en haut de la page correspond à sa
        dernière révision.
      </p>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
