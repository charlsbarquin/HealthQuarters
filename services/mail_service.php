<?php

require_once __DIR__ . '/../includes/bootstrap.php';

if (!function_exists('hq_mail_profile_config')) {
    function hq_mail_profile_config(string $profile = 'default'): array
    {
        $mailConfig = hq_config('mail');
        return $mailConfig[$profile] ?? $mailConfig['default'] ?? [];
    }
}

if (!function_exists('hq_load_phpmailer')) {
    function hq_load_phpmailer(): bool
    {
        $composerAutoload = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($composerAutoload)) {
            require_once $composerAutoload;
            return true;
        }

        $manualBase = __DIR__ . '/../PHPMailer/src/';
        if (file_exists($manualBase . 'PHPMailer.php')) {
            require_once $manualBase . 'Exception.php';
            require_once $manualBase . 'PHPMailer.php';
            require_once $manualBase . 'SMTP.php';
            return true;
        }

        return false;
    }
}

if (!function_exists('hq_send_mail_with_profile')) {
    function hq_send_mail_with_profile(
        string $profile,
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlBody,
        ?string $altBody = null,
        int $timeout = 15
    ): bool|string {
        if (!hq_load_phpmailer()) {
            return 'PHPMailer not found. Run: composer require phpmailer/phpmailer';
        }

        $config = hq_mail_profile_config($profile);
        $fromEmail = $config['from_email'] ?? ($config['username'] ?? '');
        $fromName = $config['from_name'] ?? 'HealthQuarters';
        $altBody ??= strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $config['host'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $config['tls_port'] ?? 587;
            $mail->SMTPDebug = 0;
            $mail->Timeout = $timeout;
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $altBody;
            $mail->send();
            return true;
        } catch (\Exception $e) {
            $firstError = $e->getMessage();
        }

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $config['host'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $config['ssl_port'] ?? 465;
            $mail->SMTPDebug = 0;
            $mail->Timeout = $timeout;
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $altBody;
            $mail->send();
            return true;
        } catch (\Exception $e) {
            $secondError = $e->getMessage();
            error_log("[HealthQuarters] Email failed (TLS): $firstError | (SSL): $secondError");
            return "Email could not be sent. Error: $secondError";
        }
    }
}
