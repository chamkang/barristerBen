<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => 'Legal Notice & Disclaimer | Fonju Law Firm',
    'description' => 'Legal notice, terms of use and disclaimer for the Fonju Law Firm website, including the limits of the information published here and the basis on which we accept instructions.',
    'canonical'   => 'legal-notice.php',
    'breadcrumbs' => [['name' => 'Legal Notice', 'url' => 'legal-notice.php']],
    'body_class'  => 'page-legal',
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Legal',
    'title'   => 'Legal Notice &amp; Disclaimer',
    'lede'    => 'The basis on which this website is published and the limits of what you should rely on it for. Last reviewed ' . date('F Y') . '.',
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
          Confirm the firm&rsquo;s registration details, bar admission particulars and professional
          indemnity position, then complete the placeholders below. Edit this page in
          <code>legal-notice.php</code>.
        </div>
      </div>

      <h2>Site publisher</h2>
      <p>
        This website is published by <?= e(SITE_LEGALNAME) ?>, a legal consultancy operating from
        <?= e(full_address()) ?>.<br>
        Telephone: <?= e(CONTACT['phone_primary']) ?> / <?= e(CONTACT['phone_secondary']) ?><br>
        E-mail: <?= e(CONTACT['email_general']) ?>
      </p>
      <p>
        <em>To complete: trade register (RCCM) number, taxpayer number (NIU), the Bar at which the
        firm&rsquo;s advocates are admitted, and the name of the publication director.</em>
      </p>

      <h2>No legal advice</h2>
      <p>
        The content of this website is general information about Cameroonian, OHADA, CEMAC and
        related law. It is not legal advice, it cannot take account of your circumstances, and it
        may not reflect changes in the law after publication. Do not act, or refrain from acting, on
        the basis of anything published here without obtaining advice on your specific situation.
      </p>

      <h2>No lawyer&ndash;client relationship</h2>
      <p>
        Reading this website, sending us an enquiry, or receiving an initial response does not
        create a lawyer&ndash;client relationship. That relationship begins only when we have
        completed our conflict and identity checks and both parties have signed a written
        engagement letter setting out the scope of work and the fee.
      </p>

      <h2>Confidentiality of unsolicited information</h2>
      <p>
        Please do not send us confidential or privileged material before we have confirmed that we
        are able to act for you. Information sent before an engagement is in place may not be
        protected, and may not prevent us from acting for another party in the same matter.
      </p>

      <h2>Fees</h2>
      <p>
        Our fees are agreed in writing before work begins. Advisory and transactional work is
        normally quoted as a fixed fee; contentious work is billed on an agreed structure with
        defined stages. No fee is incurred by contacting us to ask whether we can help.
      </p>

      <h2>Links to other sites</h2>
      <p>
        Where we link to a third-party website we do so for convenience only. We do not control
        those sites and accept no responsibility for their content or for any use you make of them.
      </p>

      <h2>Intellectual property</h2>
      <p>
        The text, design, structure and graphics of this website belong to <?= e(SITE_NAME) ?> unless
        stated otherwise. You may read, print and quote short extracts with attribution and a link.
        Systematic reproduction, republication or commercial use requires our written permission.
      </p>

      <h2>Limitation of liability</h2>
      <p>
        We take care to keep this website accurate and available, but we give no warranty that it is
        complete, current or uninterrupted. To the fullest extent permitted by law we exclude
        liability for loss arising from reliance on the content of this website by anyone who is not
        a client acting under a signed engagement letter.
      </p>

      <h2>Governing law</h2>
      <p>
        This notice and any dispute arising from your use of this website are governed by the law of
        the Republic of Cameroon, and the courts of Douala have jurisdiction.
      </p>

      <h2>Complaints</h2>
      <p>
        If you are dissatisfied with any aspect of our service, write to
        <a href="mailto:<?= e(CONTACT['email_principal']) ?>"><?= e(CONTACT['email_principal']) ?></a>.
        We will acknowledge your complaint promptly and set out how it will be handled.
      </p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
