<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/data-practice.php';

/* ---------------------------------------------------------------------------
   Enquiry form handling
   ---------------------------------------------------------------------------
   Submissions are e-mailed to FORM_RECIPIENT and, in every case, appended to
   storage/enquiries.log so that nothing is lost if the mail transport is not
   configured (which is the default on a fresh XAMPP install).
--------------------------------------------------------------------------- */
// Start the session before any output so the CSRF cookie can be set.
$csrf      = csrf_token();

$errors    = [];
$sent      = false;
$mailIssue = false;
$values    = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    foreach (array_keys($values) as $field) {
        $values[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    // Honeypot: a real person never fills a field they cannot see.
    $trapped = trim((string) ($_POST['website'] ?? '')) !== '';

    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $errors[] = 'Your session expired before the form was submitted. Please try again.';
    }
    if ($values['name'] === '') {
        $errors[] = 'Please tell us your name.';
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please give a valid e-mail address so we can reply.';
    }
    if (mb_strlen($values['message']) < 20) {
        $errors[] = 'Please describe your situation in a little more detail (at least 20 characters).';
    }
    if (empty($_POST['consent'])) {
        $errors[] = 'Please confirm you understand how we handle your enquiry.';
    }

    if ($errors === [] && !$trapped) {
        $subjectLine = $values['subject'] !== '' ? $values['subject'] : 'General enquiry';

        $body = "New enquiry from the website\n"
              . str_repeat('-', 46) . "\n"
              . 'Name:    ' . $values['name'] . "\n"
              . 'E-mail:  ' . $values['email'] . "\n"
              . 'Phone:   ' . ($values['phone'] !== '' ? $values['phone'] : 'not given') . "\n"
              . 'Subject: ' . $subjectLine . "\n"
              . 'Time:    ' . date('Y-m-d H:i:s') . "\n"
              . 'IP:      ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n"
              . str_repeat('-', 46) . "\n\n"
              . $values['message'] . "\n";

        // Always keep a local copy.
        $storage = __DIR__ . '/storage';
        if (!is_dir($storage)) {
            @mkdir($storage, 0775, true);
        }
        @file_put_contents($storage . '/enquiries.log', $body . "\n" . str_repeat('=', 60) . "\n\n", FILE_APPEND | LOCK_EX);

        $headers = [
            'From: ' . SITE_NAME . ' Website <' . FORM_RECIPIENT . '>',
            'Reply-To: ' . $values['name'] . ' <' . $values['email'] . '>',
            'Content-Type: text/plain; charset=UTF-8',
            'X-Mailer: PHP/' . PHP_VERSION,
        ];

        $delivered = @mail(FORM_RECIPIENT, FORM_SUBJECT . ' — ' . $subjectLine, $body, implode("\r\n", $headers));

        $sent      = true;
        $mailIssue = !$delivered;
        $values    = array_fill_keys(array_keys($values), '');
    }

    if ($trapped) {
        // Silently accept, so the bot learns nothing.
        $sent   = true;
        $values = array_fill_keys(array_keys($values), '');
    }
}

$page = [
    'title'       => 'Contact Fonju Law Firm | Lawyers in Akwa, Douala, Cameroon',
    'description' => 'Contact Fonju Law Firm, Rue Ernest Betote, Akwa, Douala. Call +237 699 96 41 77, message us on WhatsApp, or send an enquiry. We reply within a day.',
    'canonical'   => 'contact.php',
    'breadcrumbs' => [['name' => 'Contact', 'url' => 'contact.php']],
    'body_class'  => 'page-contact',
    'schema'      => [[
        '@type'      => 'ContactPage',
        'url'        => abs_url('contact.php'),
        'mainEntity' => ['@id' => SITE_URL . '/#organization'],
    ]],
];

require __DIR__ . '/includes/header.php';

$hero = [
    'eyebrow' => 'Contact',
    'title'   => 'Your problems,<br>our priority',
    'lede'    => 'Tell us what has happened. We respond to every enquiry within one business day, and urgent matters the same day.',
];
require __DIR__ . '/includes/page-hero.php';
?>

<section class="section" id="consultation">
  <div class="wrap contact-grid">

    <!-- ------------------------------------------------------------ FORM -->
    <div class="reveal">
      <p class="eyebrow">Send an enquiry</p>
      <h2>Describe your situation</h2>
      <p class="lede mb-6">
        The more context you give, the more useful our first reply will be. Everything you send is
        treated as confidential.
      </p>

      <?php if ($sent): ?>
        <div class="alert alert--ok mb-6" role="status">
          <?= icon('check', 20) ?>
          <div>
            <strong>Thank you &mdash; your enquiry has been received.</strong>
            A member of the team will respond within one business day. If the matter is urgent,
            call <a href="<?= e(tel_href(CONTACT['phone_primary'])) ?>"><?= e(CONTACT['phone_primary']) ?></a>
            or message us on WhatsApp.
            <?php if ($mailIssue): ?>
              <br><br><em style="font-size:.94rem;">Administrator note: PHP mail() could not deliver this
              message, so it has been saved to <code>storage/enquiries.log</code>. Configure SMTP in
              <code>php.ini</code> (or switch to an SMTP library) to receive enquiries by e-mail.</em>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if ($errors !== []): ?>
        <div class="alert alert--err mb-6" role="alert">
          <?= icon('close', 20) ?>
          <div>
            <strong>Your enquiry was not sent.</strong>
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      <?php
      // On a PHP host the form posts back to this page. In the static build
      // (Vercel/Netlify/Cloudflare Pages) there is no PHP, so it posts to the
      // external endpoint configured in includes/config.php instead.
      $formAction = FORM_ENDPOINT !== '' ? FORM_ENDPOINT : url('contact.php') . '#consultation';
      ?>
      <form class="form" method="post" action="<?= e($formAction) ?>" data-validate novalidate>
        <?php if (FORM_ENDPOINT !== ''): ?>
          <?php if (FORM_ACCESS_KEY !== ''): ?>
            <input type="hidden" name="access_key" value="<?= e(FORM_ACCESS_KEY) ?>">
          <?php endif; ?>
          <?php /* No hidden "subject" field here: the Area of law <select> below
                   already uses that name, and Web3Forms reads it as the subject. */ ?>
          <input type="hidden" name="from_name" value="<?= e(SITE_NAME) ?> website">
          <input type="hidden" name="redirect" value="<?= e(abs_url('contact.php')) ?>">
        <?php else: ?>
          <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
        <?php endif; ?>

        <div class="hp" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form__row">
          <div class="field">
            <label for="name">Full name <span class="req">*</span></label>
            <input id="name" type="text" name="name" required autocomplete="name"
                   value="<?= e($values['name']) ?>" placeholder="Your name">
          </div>
          <div class="field">
            <label for="email">E-mail address <span class="req">*</span></label>
            <input id="email" type="email" name="email" required autocomplete="email"
                   value="<?= e($values['email']) ?>" placeholder="you@company.com">
          </div>
        </div>

        <div class="form__row">
          <div class="field">
            <label for="phone">Phone or WhatsApp</label>
            <input id="phone" type="tel" name="phone" autocomplete="tel"
                   value="<?= e($values['phone']) ?>" placeholder="+237 …">
          </div>
          <div class="field">
            <label for="subject">Area of law</label>
            <select id="subject" name="subject">
              <option value="">Select an area (optional)</option>
              <?php foreach (practice_areas() as $area): ?>
                <option value="<?= e($area['title']) ?>"<?= $values['subject'] === $area['title'] ? ' selected' : '' ?>>
                  <?= e($area['title']) ?>
                </option>
              <?php endforeach; ?>
              <option value="Other / not sure"<?= $values['subject'] === 'Other / not sure' ? ' selected' : '' ?>>Other / not sure</option>
            </select>
          </div>
        </div>

        <div class="field">
          <label for="message">How can we help? <span class="req">*</span></label>
          <textarea id="message" name="message" required
                    placeholder="What has happened, who else is involved, and what outcome do you need? Include any deadlines you are working to."><?= e($values['message']) ?></textarea>
          <p class="field__hint">Please do not include sensitive identification or payment details in this form.</p>
        </div>

        <div class="field field--check">
          <input id="consent" type="checkbox" name="consent" value="1" required>
          <label for="consent">
            I understand that sending this enquiry does not create a lawyer&ndash;client relationship,
            and I consent to Fonju Law Firm holding these details in order to respond.
            <a href="<?= e(url('privacy.php')) ?>">Privacy policy</a>.
          </label>
        </div>

        <div>
          <button class="btn btn--gold btn--lg" type="submit">Send enquiry <?= icon('arrow', 18) ?></button>
        </div>
      </form>
    </div>

    <!-- --------------------------------------------------------- DETAILS -->
    <div class="reveal" data-delay="2">
      <div class="sidebar__box sidebar__box--dark">
        <h3>Get in touch directly</h3>
        <ul class="contact-list mt-5">
          <li>
            <?= icon('pin', 18) ?>
            <span>
              <strong style="color:#fff;">Office</strong><br>
              <?= e(CONTACT['street']) ?><br>
              <?= e(CONTACT['po_box']) ?><br>
              <?= e(CONTACT['city']) ?>, <?= e(CONTACT['region']) ?><br>
              <?= e(CONTACT['country']) ?>
            </span>
          </li>
          <li>
            <?= icon('phone', 18) ?>
            <span>
              <strong style="color:#fff;">Call or text</strong><br>
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
              <strong style="color:#fff;">Opening hours</strong><br>
              <?php foreach (OPENING_HOURS as $slot): ?>
                <?= e($slot['days']) ?>: <?= e($slot['hours']) ?><br>
              <?php endforeach; ?>
            </span>
          </li>
        </ul>

        <a class="btn btn--gold btn--block mt-6" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener">
          <?= icon('whatsapp', 18) ?> Chat on WhatsApp
        </a>

        <p class="site-footer__sociallabel mt-6" style="color:rgba(255,255,255,.5);">Follow the firm</p>
        <?= social_links('socials', 18) ?>
      </div>

      <div class="sidebar__box mt-5">
        <h3>Before you contact us</h3>
        <ul class="checklist" style="font-size:.99rem;">
          <li><?= icon('check', 15) ?><span>Have any relevant contracts, correspondence or court documents to hand.</span></li>
          <li><?= icon('check', 15) ?><span>Note any deadline you are working to &mdash; time limits decide many matters.</span></li>
          <li><?= icon('check', 15) ?><span>Know what outcome you actually want, not only what has gone wrong.</span></li>
        </ul>
      </div>
    </div>

  </div>
</section>

<!-- ================================================================= MAP -->
<section class="section section--bone section--tight">
  <div class="wrap">
    <div class="section-head reveal">
      <p class="eyebrow">Find us</p>
      <h2>Rue Ernest Betote, Akwa &mdash; Douala</h2>
      <p class="lede">
        We are in Akwa, Douala&rsquo;s central business district, a short distance from the port and
        the main commercial banks.
      </p>
    </div>

    <div class="map-frame reveal">
      <iframe
        title="Map showing the location of Fonju Law Firm in Akwa, Douala"
        src="https://www.google.com/maps?q=<?= e(CONTACT['map_query']) ?>&amp;output=embed"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen></iframe>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
