<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => 'Privacy Policy | Fonju Law Firm',
    'description' => 'How Fonju Law Firm collects, uses, stores and protects personal data submitted through fonjulawfirm.com, and the rights available to you.',
    'canonical'   => 'privacy.php',
    'breadcrumbs' => [['name' => 'Privacy Policy', 'url' => 'privacy.php']],
    'body_class'  => 'page-legal',
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Legal',
    'title'   => 'Privacy Policy',
    'lede'    => 'How we handle the personal information you give us through this website. Last reviewed ' . date('F Y') . '.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section">
  <div class="wrap wrap--narrow">
    <div class="prose reveal">

      <div class="alert alert--err mb-6" role="note">
        <?= icon('shield', 20) ?>
        <div>
          <strong>Template &mdash; have this reviewed before launch.</strong>
          This policy is a solid starting point drafted for a Cameroonian law firm, but it must be
          checked against your actual data handling practices and the applicable Cameroonian data
          protection and cybersecurity legislation before the site goes live. Edit it in
          <code>privacy.php</code>.
        </div>
      </div>

      <h2>Who we are</h2>
      <p>
        <?= e(SITE_LEGALNAME) ?> ("we", "us", "the firm") operates this website. Our office is at
        <?= e(full_address()) ?>. You can contact us about anything in this policy at
        <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a>.
      </p>

      <h2>What we collect</h2>
      <p>We collect only what we need in order to respond to you and to run the website:</p>
      <ul>
        <li><strong>Enquiry details</strong> &mdash; the name, e-mail address, telephone number, selected area of law and message you submit through the contact form.</li>
        <li><strong>Correspondence</strong> &mdash; the content of e-mails, WhatsApp messages and calls where you contact us directly.</li>
        <li><strong>Technical data</strong> &mdash; your IP address, browser type and the pages you visited, recorded by the web server and, where enabled, by analytics.</li>
      </ul>
      <p>
        We do not ask for, and you should not send through this website, identification documents,
        bank details, payment card numbers or other sensitive information.
      </p>

      <h2>Why we use it</h2>
      <ul>
        <li>To respond to your enquiry and provide the legal services you ask for.</li>
        <li>To carry out the conflict and identity checks our professional obligations require.</li>
        <li>To keep records of advice given, as required by professional practice rules.</li>
        <li>To maintain the security and performance of the website.</li>
      </ul>
      <p>
        We rely on your consent when you submit the contact form, and on the performance of our
        engagement and our legal and professional obligations thereafter.
      </p>

      <h2>Confidentiality and professional secrecy</h2>
      <p>
        Information you give us in the course of seeking legal advice is additionally protected by
        professional secrecy under the rules governing advocates in the Republic of Cameroon. That
        protection is stronger than ordinary confidentiality, it applies from your first contact,
        and it continues after your matter has closed.
      </p>

      <h2>Who we share it with</h2>
      <p>
        We do not sell personal data and we do not share it for marketing. We disclose information
        only: to service providers who host our website or e-mail under a duty of confidentiality;
        to courts, regulators or counterparties where doing so is necessary to conduct your matter
        and you have instructed us to; and where we are required to by law.
      </p>

      <h2>How long we keep it</h2>
      <p>
        Enquiries that do not become instructions are kept for a limited period and then deleted.
        Client files are retained for the period required by professional practice rules and by the
        applicable limitation periods, after which they are securely destroyed.
      </p>

      <h2>Security</h2>
      <p>
        We apply organisational and technical measures appropriate to the sensitivity of the
        information we hold, including access restrictions and encrypted transmission. No system is
        perfectly secure, so please do not send highly sensitive material through the web form &mdash;
        contact us and we will arrange a secure channel.
      </p>

      <h2>Your rights</h2>
      <p>
        Subject to our professional obligations, you may ask us for a copy of the personal data we
        hold about you, ask us to correct it if it is inaccurate, ask us to delete it where we are
        not required to retain it, and withdraw a consent you have given. Write to
        <a href="mailto:<?= e(CONTACT['email_general']) ?>"><?= e(CONTACT['email_general']) ?></a> and we
        will respond promptly.
      </p>

      <h2>Cookies and analytics</h2>
      <p>
        This website uses no advertising or tracking cookies. If website analytics is enabled, it is
        used only to understand which pages are useful, in aggregate. Embedded content such as the
        map on our contact page is served by a third party which may set its own cookies; you can
        block those in your browser settings.
      </p>

      <h2>Changes</h2>
      <p>
        We may update this policy. The date at the top of the page shows when it was last reviewed.
      </p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
