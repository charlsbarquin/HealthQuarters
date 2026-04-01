<?php
/**
 * mailer.php — HealthQuarters shared email utility
 * Include this file wherever you need to send email.
 * Requires: vendor/autoload.php (PHPMailer via Composer)
 *
 * Usage:
 *   require_once 'mailer.php';
 *   $result = hq_send_email('to@email.com', 'Recipient Name', 'Subject', '<p>HTML body</p>');
 *   if ($result !== true) echo "Error: $result";
 */

require_once __DIR__ . '/services/mail_service.php';

/**
 * Send an HTML email via PHPMailer.
 */
function hq_send_email(string $toEmail, string $toName, string $subject, string $htmlBody): bool|string {
    return hq_send_mail_with_profile('default', $toEmail, $toName, $subject, $htmlBody);
}

/**
 * Build the OTP verification email HTML — clean & simple, HealthQuarters-branded.
 */
function hq_build_otp_email(string $name, string $otp): string {
    $safeName = htmlspecialchars($name);

    // Build individual digit boxes
    $digits = implode('', array_map(
        fn($d) => "<td style='padding:0 5px;'>
                     <div style='
                       width:44px;height:52px;line-height:52px;
                       text-align:center;
                       font-size:1.6rem;font-weight:700;
                       font-family:\"Courier New\",monospace;
                       color:#1a4d2e;
                       background:#f4faf6;
                       border:2px solid #c4e8d1;
                       border-radius:10px;
                     '>{$d}</div>
                   </td>",
        str_split($otp)
    ));

    return "<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width,initial-scale=1'>
  <title>HealthQuarters Verification</title>
</head>
<body style='margin:0;padding:0;background:#f2f7f4;font-family:Georgia,serif;'>

  <table width='100%' cellpadding='0' cellspacing='0' style='background:#f2f7f4;padding:40px 16px;'>
    <tr>
      <td align='center'>
        <table width='100%' style='max-width:480px;' cellpadding='0' cellspacing='0'>

          <!-- ── Logo / Brand bar ── -->
          <tr>
            <td align='center' style='padding-bottom:24px;'>
              <table cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='
                    background:linear-gradient(135deg,#6abf4b,#2dbfb8);
                    border-radius:12px;
                    padding:10px 22px;
                  '>
                    <span style='
                      font-family:Georgia,serif;
                      font-size:1rem;
                      font-weight:400;
                      color:#ffffff;
                      letter-spacing:0.06em;
                      text-transform:uppercase;
                    '>HealthQuarters</span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- ── Card ── -->
          <tr>
            <td style='
              background:#ffffff;
              border-radius:16px;
 