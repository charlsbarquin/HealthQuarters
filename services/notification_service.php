<?php

require_once __DIR__ . '/../includes/runtime_schema.php';
require_once __DIR__ . '/mail_service.php';

function hq_notification_meta(string $type): array
{
    return match ($type) {
        'today' => ['icon' => 'TD', 'label' => 'Today', 'category' => 'appointments'],
        'tomorrow' => ['icon' => 'TM', 'label' => 'Tomorrow', 'category' => 'appointments'],
        'fasting' => ['icon' => 'PR', 'label' => 'Preparation', 'category' => 'appointments'],
        '3day' => ['icon' => 'UP', 'label' => 'Upcoming', 'category' => 'appointments'],
        'confirmed' => ['icon' => 'OK', 'label' => 'Confirmed', 'category' => 'appointments'],
        'pending' => ['icon' => '⏳', 'label' => 'Pending', 'category' => 'appointments'],
        'reschedule_requested' => ['icon' => 'RS', 'label' => 'Reschedule', 'category' => 'appointments'],
        'reschedule_update' => ['icon' => 'RE', 'label' => 'Reschedule', 'category' => 'appointments'],
        'corp_pending' => ['icon' => '⏳', 'label' => 'Corporate', 'category' => 'corporate'],
        'corp_in_progress' => ['icon' => 'CI', 'label' => 'Corporate', 'category' => 'corporate'],
        'corp_contacted' => ['icon' => 'CU', 'label' => 'Corporate', 'category' => 'corporate'],
        'corp_completed' => ['icon' => 'OK', 'label' => 'Corporate', 'category' => 'corporate'],
        'result_ready' => ['icon' => 'RD', 'label' => 'Results', 'category' => 'results'],
        default => ['icon' => 'IN', 'label' => 'General', 'category' => 'general'],
    };
}

function hq_time_ago(string $dt): string
{
    $diff = time() - strtotime($dt);
    if ($diff < 60) {
        return 'just now';
    }
    if ($diff < 3600) {
        return floor($diff / 60) . ' min ago';
    }
    if ($diff < 86400) {
        return floor($diff / 3600) . ' hr ago';
    }
    if ($diff < 604800) {
        return floor($diff / 86400) . ' day' . (floor($diff / 86400) > 1 ? 's' : '') . ' ago';
    }
    return date('M j', strtotime($dt));
}

function hq_create_notification(PDO $conn, array $data): int
{
    hq_ensure_runtime_schema($conn);

    $userId = (int) ($data['user_id'] ?? 0);
    $type = $data['type'] ?? 'general';
    $sourceType = $data['source_type'] ?? null;
    $sourceId = $data['source_id'] ?? null;

    if ($userId <= 0) {
        return 0;
    }

    if ($sourceType && $sourceId) {
        $existing = $conn->prepare("
            SELECT id
            FROM user_notifications
            WHERE user_id = ? AND type = ? AND source_type = ? AND source_id = ?
            LIMIT 1
        ");
        $existing->execute([$userId, $type, $sourceType, $sourceId]);
        $existingId = (int) $existing->fetchColumn();
        if ($existingId > 0) {
            return $existingId;
        }
    }

    $meta = hq_notification_meta($type);
    $stmt = $conn->prepare("
        INSERT INTO user_notifications (
            user_id, appointment_id, source_type, source_id, category, type, title, message, action_url, is_read, email_sent, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, NOW())
    ");
    $stmt->execute([
        $userId,
        $data['appointment_id'] ?? null,
        $sourceType,
        $sourceId,
        $data['category'] ?? $meta['category'],
        $type,
        $data['title'] ?? 'Notification',
        $data['message'] ?? '',
        $data['action_url'] ?? null,
        $data['email_sent'] ?? 0,
    ]);

    return (int) $conn->lastInsertId();
}

function hq_mark_notification_emailed(PDO $conn, int $notificationId): void
{
    $conn->prepare("UPDATE user_notifications SET email_sent = 1 WHERE id = ?")->execute([$notificationId]);
}

function hq_send_notification_email(string $toEmail, string $toName, string $subject, string $htmlBody): bool
{
    return hq_send_mail_with_profile('notifications', $toEmail, $toName, $subject, $htmlBody) === true;
}

function hq_build_notification_email(string $name, string $icon, string $title, string $message, string $color = 'green'): string
{
    $appConfig = hq_config('app');
    $phone = $appConfig['clinic_phone'] ?? '+63 XXX XXX XXXX';
    $gradients = [
        'green' => 'linear-gradient(135deg,#6abf4b 0%,#2dbfb8 100%)',
        'yellow' => 'linear-gradient(135deg,#f5c842 0%,#f08c00 100%)',
        'teal' => 'linear-gradient(135deg,#2dbfb8 0%,#1a9e98 100%)',
        'confirm' => 'linear-gradient(135deg,#1a4d2e 0%,#2dbfb8 100%)',
    ];
    $grad = $gradients[$color] ?? $gradients['green'];

    return "<!DOCTYPE html><html><head><meta charset='UTF-8'></head>
    <body style='margin:0;padding:0;background:#f0faf4;font-family:Arial,sans-serif;'>
      <div style='max-width:560px;margin:32px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(26,77,46,0.10);'>
        <div style='background:{$grad};padding:32px;text-align:center;'>
          <div style='font-size:2.8rem;margin-bottom:10px;'>{$icon}</div>
          <h1 style='margin:0;color:#fff;font-family:Georgia,serif;font-size:1.25rem;'>" . htmlspecialchars($title) . "</h1>
        </div>
        <div style='padding:28px 32px;'>
          <p style='color:#1a4d2e;font-size:15px;margin-bottom:14px;'>Hi, <strong>" . htmlspecialchars($name) . "</strong> </p>
          <div style='color:#4a6057;font-size:14px;line-height:1.8;'>{$message}</div>
        </div>
        <div style='background:#f7f9f8;padding:16px 32px;text-align:center;border-top:1.5px solid #e8eeeb;'>
          <p style='color:#94a89d;font-size:11px;margin:0;'>
            HealthQuarters &middot; {$phone}<br>
            <span style='font-size:10px;'>Do not reply to this email.</span>
          </p>
        </div>
      </div>
    </body></html>";
}

function hq_build_confirmation_email(string $name, string $service, string $dateLabel, string $time, string $refNum = ''): string
{
    $appConfig = hq_config('app');
    $phone = $appConfig['clinic_phone'] ?? '+63 XXX XXX XXXX';
    $ref = $refNum ? "<div style='margin:20px 0;padding:14px 20px;background:#e8f7ee;border-radius:10px;border:1.5px solid #a8e6c1;'><div style='font-size:11px;color:#94a89d;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px;'>Reference Number</div><div style='font-size:1.1rem;font-weight:700;color:#1a4d2e;letter-spacing:0.08em;'>{$refNum}</div></div>" : '';

    return "<!DOCTYPE html><html><head><meta charset='UTF-8'></head>
    <body style='margin:0;padding:0;background:#f0faf4;font-family:Arial,sans-serif;'>
      <div style='max-width:560px;margin:32px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(26,77,46,0.10);'>
        <div style='background:linear-gradient(135deg,#1a4d2e 0%,#2d7a4f 50%,#2dbfb8 100%);padding:36px 32px;text-align:center;'>
          <div style='font-size:3rem;margin-bottom:10px;'>OK</div>
          <h1 style='margin:0;color:#fff;font-family:Georgia,serif;font-size:1.35rem;'>Appointment Confirmed!</h1>
          <p style='color:rgba(255,255,255,0.75);font-size:13px;margin:8px 0 0;'>Your booking has been scheduled successfully with HealthQuarters</p>
        </div>
        <div style='padding:28px 32px;'>
          <p style='color:#1a4d2e;font-size:15px;margin-bottom:20px;'>Hi, <strong>" . htmlspecialchars($name) . "</strong> </p>
          <p style='color:#4a6057;font-size:14px;line-height:1.75;margin-bottom:20px;'>Your appointment is now <strong style='color:#2d7a4f;'>confirmed</strong>. Here are your appointment details:</p>
          <div style='background:#f7f9f8;border-radius:12px;padding:20px;border:1.5px solid #e8eeeb;margin-bottom:20px;'>
            <table style='width:100%;border-collapse:collapse;'>
              <tr><td style='padding:8px 0;border-bottom:1px solid #e8eeeb;'><span style='font-size:11px;color:#94a89d;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:2px;'>Service</span><span style='font-size:14px;font-weight:600;color:#1a4d2e;'>" . htmlspecialchars($service) . "</span></td></tr>
              <tr><td style='padding:8px 0;border-bottom:1px solid #e8eeeb;'><span style='font-size:11px;color:#94a89d;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:2px;'>Date</span><span style='font-size:14px;font-weight:600;color:#1a4d2e;'>" . htmlspecialchars($dateLabel) . "</span></td></tr>
              <tr><td style='padding:8px 0;'><span style='font-size:11px;color:#94a89d;text-transform:uppercase;letter-spacing:0.08em;display:block;margin-bottom:2px;'>Time</span><span style='font-size:14px;font-weight:600;color:#1a4d2e;'>" . htmlspecialchars($time) . "</span></td></tr>
            </table>
          </div>
          {$ref}
          <div style='background:#fff8e1;border-radius:10px;padding:14px 18px;border:1.5px solid #f5c842;margin-bottom:20px;'>
            <p style='margin:0;font-size:13px;color:#7c4a00;'><strong>What to bring:</strong><br>Please arrive <strong>10–15 minutes early</strong> and bring a <strong>valid government-issued ID</strong>.</p>
          </div>
          <p style='color:#94a89d;font-size:13px;'>If you need to reschedule or cancel, please contact us at <strong style='color:#1a4d2e;'>{$phone}</strong> as soon as possible.</p>
        </div>
        <div style='background:#f7f9f8;padding:16px 32px;text-align:center;border-top:1.5px solid #e8eeeb;'>
          <p style='color:#94a89d;font-size:11px;margin:0;'>HealthQuarters &middot; {$phone}<br><span style='font-size:10px;'>Do not reply to this email.</span></p>
        </div>
      </div>
    </body></html>";
}
