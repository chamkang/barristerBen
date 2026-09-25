<?php
declare(strict_types=1);

/* ---------------------------------------------------------------------------
   Enquiry form handling, shared by contact.php and fr/contact.php
   ---------------------------------------------------------------------------
   Submissions are e-mailed to FORM_RECIPIENT and, in every case, appended to
   storage/enquiries.log so that nothing is lost if the mail transport is not
   configured (which is the default on a fresh XAMPP install).

   On a static host (Vercel) this never runs: the form posts to FORM_ENDPOINT.

   Sets: $csrf, $errors, $sent, $mailIssue, $values
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
        $errors[] = t('Your session expired before the form was submitted. Please try again.');
    }
    if ($values['name'] === '') {
        $errors[] = t('Please tell us your name.');
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = t('Please give a valid e-mail address so we can reply.');
    }
    if (mb_strlen($values['message']) < 20) {
        $errors[] = t('Please describe your situation in a little more detail (at least 20 characters).');
    }
    if (empty($_POST['consent'])) {
        $errors[] = t('Please confirm you understand how we handle your enquiry.');
    }

    if ($errors === [] && !$trapped) {
        $subjectLine = $values['subject'] !== '' ? $values['subject'] : 'General enquiry';

        $body = "New enquiry from the website\n"
              . str_repeat('-', 46) . "\n"
              . 'Name:     ' . $values['name'] . "\n"
              . 'E-mail:   ' . $values['email'] . "\n"
              . 'Phone:    ' . ($values['phone'] !== '' ? $values['phone'] : 'not given') . "\n"
              . 'Subject:  ' . $subjectLine . "\n"
              . 'Language: ' . (is_fr() ? 'French' : 'English') . "\n"
              . 'Time:     ' . date('Y-m-d H:i:s') . "\n"
              . 'IP:       ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n"
              . str_repeat('-', 46) . "\n\n"
              . $values['message'] . "\n";

        // Always keep a local copy.
        $storage = dirname(__DIR__) . '/storage';
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
