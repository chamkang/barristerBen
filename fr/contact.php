<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
set_lang('fr');
require_once dirname(__DIR__) . '/includes/data-practice.php';

require dirname(__DIR__) . '/includes/contact-handler.php';

$page = [
    'title'       => 'Contacter le cabinet Fonju | Avocats à Akwa, Douala, Cameroun',
    'description' => 'Contactez le cabinet Fonju, rue Ernest Betote, Akwa, Douala. Appelez le +237 699 96 41 77, écrivez-nous sur WhatsApp ou envoyez une demande. Réponse sous un jour.',
    'canonical'   => 'contact.php',
    'breadcrumbs' => [['name' => 'Contact', 'url' => 'contact.php']],
    'body_class'  => 'page-contact',
    'schema'      => [[
        '@type'      => 'ContactPage',
        'url'        => abs_url('contact.php'),
        'inLanguage' => 'fr',
        'mainEntity' => ['@id' => SITE_URL . '/#organization'],
    ]],
];

require dirname(__DIR__) . '/includes/header.php';

$hero = [
    'eyebrow' => 'Contact',
    'title'   => 'Vos problèmes,<br>notre priorité',
    'lede'    => 'Dites-nous ce qui s’est passé. Nous répondons à chaque demande sous un jour ouvré, et aux urgences le jour même.',
];
require dirname(__DIR__) . '/includes/page-hero.php';
?>

<section class="section" id="consultation">
  <div class="wrap contact-grid">

    <!-- ------------------------------------------------------------ FORM -->
    <div class="reveal">
      <p class="eyebrow">Envoyer une demande</p>
      <h2>Décrivez votre situation</h2>
      <p class="lede mb-6">
        Plus vous donnez de contexte, plus notre première réponse sera utile. Tout ce que vous nous
        envoyez est traité de manière confidentielle.
      </p>

      <?php if ($sent): ?>
        <div class="alert alert--ok mb-6" role="status">
          <?= icon('check', 20) ?>
          <div>
            <strong>Merci &mdash; votre demande a bien été reçue.</strong>
            Un membre de l’équipe vous répondra sous un jour ouvré. En cas d’urgence, appelez le
            <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a>
            ou écrivez-nous sur WhatsApp.
            <?php if ($mailIssue): ?>
              <br><br><em style="font-size:.94rem;">Note pour l’administrateur : la fonction mail() de PHP
              n’a pas pu envoyer ce message ; il a été enregistré dans <code>storage/enquiries.log</code>.
              Configurez un serveur SMTP dans <code>php.ini</code> pour recevoir les demandes par e-mail.</em>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($errors !== []): ?>
        <div class="alert alert--err mb-6" role="alert">
          <?= icon('close', 20) ?>
          <div>
            <strong>Votre demande n’a pas été envoyée.</strong>
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <?php
      // On a PHP host the form posts back to this page; on the static build it
      // posts to the external endpoint configured in includes/config.php.
      $formAction = FORM_ENDPOINT !== '' ? FORM_ENDPOINT : url('contact.php') . '#consultation';
      ?>
      <form class="form" method="post" action="<?= e($formAction) ?>" data-validate novalidate>
        <?php if (FORM_ENDPOINT !== ''): ?>
          <?php if (FORM_ACCESS_KEY !== ''): ?>
            <input type="hidden" name="access_key" value="<?= e(FORM_ACCESS_KEY) ?>">
          <?php endif; ?>
          <input type="hidden" name="from_name" value="<?= e(SITE_NAME) ?> website (FR)">
          <input type="hidden" name="redirect" value="<?= e(abs_url('contact.php')) ?>">
        <?php else: ?>
          <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
        <?php endif; ?>

        <div class="hp" aria-hidden="true">
          <label for="website">Laissez ce champ vide</label>
          <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form__row">
          <div class="field">
            <label for="name">Nom complet <span class="req">*</span></label>
            <input id="name" type="text" name="name" required autocomplete="name"
                   value="<?= e($values['name']) ?>" placeholder="Votre nom">
          </div>
          <div class="field">
            <label for="email">Adresse e-mail <span class="req">*</span></label>
            <input id="email" type="email" name="email" required autocomplete="email"
                   value="<?= e($values['email']) ?>" placeholder="vous@entreprise.com">
          </div>
        </div>

        <div class="form__row">
          <div class="field">
            <label for="phone">Téléphone ou WhatsApp</label>
            <input id="phone" type="tel" name="phone" autocomplete="tel"
                   value="<?= e($values['phone']) ?>" placeholder="+237 …">
          </div>
          <div class="field">
            <label for="subject">Domaine du droit</label>
            <select id="subject" name="subject">
              <option value="">Choisir un domaine (facultatif)</option>
              <?php foreach (practice_areas() as $area): ?>
                <option value="<?= e($area['title']) ?>"<?= $values['subject'] === $area['title'] ? ' selected' : '' ?>>
                  <?= e($area['title']) ?>
                </option>
              <?php endforeach; ?>
              <option value="Autre / je ne sais pas"<?= $values['subject'] === 'Autre / je ne sais pas' ? ' selected' : '' ?>>Autre / je ne sais pas</option>
            </select>
          </div>
        </div>

        <div class="field">
          <label for="message">Comment pouvons-nous vous aider ? <span class="req">*</span></label>
          <textarea id="message" name="message" required
                    placeholder="Que s’est-il passé, qui d’autre est concerné et quel résultat recherchez-vous ? Indiquez les échéances éventuelles."><?= e($values['message']) ?></textarea>
          <p class="field__hint">Merci de ne pas indiquer de données d’identification sensibles ni de coordonnées bancaires dans ce formulaire.</p>
        </div>

        <div class="field field--check">
          <input id="consent" type="checkbox" name="consent" value="1" required>
          <label for="consent">
            Je comprends que l’envoi de cette demande ne crée pas de relation avocat&ndash;client, et
            j’accepte que le cabinet Fonju conserve ces informations afin de me répondre.
            <a href="<?= e(url('privacy.php')) ?>">Politique de confidentialité</a>.
          </label>
        </div>

        <div>
          <button class="btn btn--gold btn--lg" type="submit">Envoyer la demande <?= icon('arrow', 18) ?></button>
        </div>
      </form>
    </div>

    <!-- --------------------------------------------------------- DETAILS -->
    <div class="reveal" data-delay="2">
      <div class="sidebar__box sidebar__box--dark">
        <h3>Nous joindre directement</h3>
        <ul class="contact-list mt-5">
          <li>
            <?= icon('pin', 18) ?>
            <span>
              <strong style="color:#fff;">Cabinet</strong><br>
              <?= e(contact('street')) ?><br>
              <?= e(contact('po_box')) ?><br>
              <?= e(contact('city')) ?>, <?= e(contact('region')) ?><br>
              <?= e(contact('country')) ?>
            </span>
          </li>
          <li>
            <?= icon('phone', 18) ?>
            <span>
              <strong style="color:#fff;">Appel ou SMS</strong><br>
              <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a><br>
              <a href="<?= e(tel_href(CONTACT['phone_secondary'])) ?>"><?= e(CONTACT['phone_secondary']) ?></a>
            </span>
          </li>
          <li>
            <?= icon('mail', 18) ?>
            <span>
              <strong style="color:#fff;">E-mail</strong><br>
              <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a><br>
              <a href="mailto:<?= e(CONTACT['email_principal']) ?>"><?= e(CONTACT['email_principal']) ?></a>
            </span>
          </li>
          <li>
            <?= icon('clock', 18) ?>
            <span>
              <strong style="color:#fff;">Horaires</strong><br>
              <?php foreach (opening_hours() as $slot): ?>
                <?= e($slot['days']) ?>&nbsp;: <?= e($slot['hours']) ?><br>
              <?php endforeach; ?>
            </span>
          </li>
        </ul>

        <a class="btn btn--gold btn--block mt-6" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener">
          <?= icon('whatsapp', 18) ?> Écrire sur WhatsApp
        </a>

        <p class="site-footer__sociallabel mt-6" style="color:rgba(255,255,255,.5);">Suivre le cabinet</p>
        <?= social_links('socials', 18) ?>
      </div>

      <div class="sidebar__box mt-5">
        <h3>Avant de nous contacter</h3>
        <ul class="checklist" style="font-size:.99rem;">
          <li><?= icon('check', 15) ?><span>Ayez sous la main les contrats, courriers ou actes de procédure utiles.</span></li>
          <li><?= icon('check', 15) ?><span>Notez les échéances à respecter &mdash; les délais décident de nombreux dossiers.</span></li>
          <li><?= icon('check', 15) ?><span>Sachez quel résultat vous voulez réellement, pas seulement ce qui n’a pas fonctionné.</span></li>
        </ul>
      </div>
    </div>

  </div>
</section>

<!-- ================================================================= MAP -->
<section class="section section--bone section--tight">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Nous trouver</p>
      <h2>Rue Ernest Betote, Akwa &mdash; Douala</h2>
      <p class="lede">
        Nous sommes à Akwa, le quartier d’affaires de Douala, à peu de distance du port et des
        principales banques commerciales.
      </p>
    </div>

    <?php require dirname(__DIR__) . '/includes/map-embed.php'; ?>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
