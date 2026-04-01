<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/services/patient_portal_service.php';

hq_require_login('login.php');

$userId = (int) ($_SESSION['user_id'] ?? 0);
$appointmentId = (int) ($_GET['id'] ?? 0);
$detail = hq_fetch_patient_appointment_detail($conn, $userId, $appointmentId);

if (!$detail) {
    http_response_code(404);
    exit('Appointment not found.');
}

$patientName = hq_patient_name();
$initials = hq_initials($patientName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Detail - HealthQuarters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --gs:#6abf4b; --ge:#2dbfb8; --deep:#1a4d2e; --mid:#2d7a4f; --bright:#3aad6e; --pale:#e8f7ee; --muted:#f0faf4; --g200:#e8eeeb; --g400:#94a89d; --g600:#4a6057; }
    body { font-family:'DM Sans',sans-serif; background:var(--muted); color:#1e302a; }
    .page { max-width:980px; margin:0 auto; padding:28px 20px 48px; }
    .hero { background:linear-gradient(135deg,var(--gs),var(--ge)); color:#fff; border-radius:22px; padding:24px; margin-bottom:22px; }
    .hero h1 { font-family:'DM Serif Display',serif; font-size:2rem; margin:0 0 8px; }
    .hero p { margin:0; opacity:.88; }
    .grid { display:grid; grid-template-columns:1.2fr .8fr; gap:20px; }
    .card { background:#fff; border:1px solid var(--g200); border-radius:18px; padding:20px; box-shadow:0 8px 24px rgba(26,77,46,.07); }
    .label { font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; color:var(--g400); margin-bottom:6px; font-weight:700; }
    .value { font-size:.95rem; color:#1e302a; margin-bottom:14px; }
    .status { display:inline-flex; padding:5px 12px; border-radius:50px; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; background:var(--pale); color:var(--mid); }
    .prep { background:var(--pale); border:1px solid #a8e6c1; border-radius:14px; padding:14px; color:var(--deep); margin-top:14px; }
    .timeline { display:flex; flex-direction:column; gap:10px; }
    .timeline-item { background:var(--muted); border:1px solid var(--g200); border-radius:12px; padding:12px 14px; }
    .back-link { display:inline-flex; align-items:center; gap:8px; color:var(--mid); text-decoration:none; font-weight:600; margin-bottom:14px; }
    .actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:18px; }
    .btn-soft { display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:999px; text-decoration:none; background:var(--pale); color:var(--mid); font-weight:600; }
    @media(max-width:820px){ .grid{grid-template-columns:1fr;} .hero h1{font-size:1.6rem;} }
  </style>
</head>
<body>
  <div class="page">
    <a href="profile.php?tab=appointments" class="back-link">← Back to Appointments</a>
    <section class="hero">
      <div style="display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:flex-start;">
        <div>
          <h1><?= htmlspecialchars($detail['service']) ?></h1>
          <p><?= htmlspecialchars($detail['date_label']) ?> at <?= htmlspecialchars($detail['time_label']) ?> • <?= htmlspecialchars($detail['branch']) ?></p>
        </div>
        <div class="status"><?= htmlspecialchars($detail['status']) ?></div>
      </div>
    </section>

    <div class="grid">
      <div class="card">
        <div class="label">Schedule</div>
        <div class="value"><?= htmlspecialchars($detail['date_label']) ?> at <?= htmlspecialchars($detail['time_label']) ?></div>

        <div class="label">Branch</div>
        <div class="value"><?= htmlspecialchars($detail['branch']) ?></div>

        <div class="label">Notes</div>
        <div class="value"><?= htmlspecialchars($detail['notes'] !== '' ? $detail['notes'] : 'No special notes recorded.') ?></div>

        <div class="label">Visit Address</div>
        <div class="value"><?= htmlspecialchars($detail['address'] !== '' ? $detail['address'] : 'No address stored.') ?></div>

        <?php if ($detail['prep_note'] !== ''): ?>
          <div class="prep">
            <div class="label" style="color:var(--mid);margin-bottom:8px;">Preparation Reminder</div>
            <?= htmlspecialchars($detail['prep_note']) ?>
          </div>
        <?php endif; ?>

        <div class="actions">
          <a href="profile.php?tab=appointments" class="btn-soft">Open Tracking</a>
          <a href="download_booking_confirmation.php?id=<?= (int) $detail['id'] ?>" class="btn-soft">Download Confirmation PDF</a>
          <a href="booking.php" class="btn-soft">Book Another Service</a>
        </div>
      </div>

      <div style="display:flex;flex-direction:column;gap:20px;">
        <div class="card">
          <div class="label">Patient Contact</div>
          <div class="value"><?= htmlspecialchars($patientName) ?></div>
          <div class="value"><?= htmlspecialchars($detail['contact'] !== '' ? $detail['contact'] : 'No contact number stored.') ?></div>
          <div class="value" style="margin-bottom:0;"><?= htmlspecialchars($detail['email'] !== '' ? $detail['email'] : 'No email stored.') ?></div>
        </div>

        <div class="card">
          <div class="label">Checklist</div>
          <div class="timeline">
            <?php foreach ($detail['checklist'] as $item): ?>
              <div class="timeline-item"><?= htmlspecialchars($item) ?></div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if (!empty($detail['reschedule'])): ?>
          <div class="card">
            <div class="label">Latest Reschedule Request</div>
            <div class="value"><?= htmlspecialchars($detail['reschedule']['requested_date']) ?> at <?= htmlspecialchars($detail['reschedule']['requested_time']) ?></div>
            <div class="value">Status: <?= htmlspecialchars($detail['reschedule']['status']) ?></div>
            <div class="value" style="margin-bottom:0;"><?= htmlspecialchars($detail['reschedule']['reason'] ?: 'No reason provided.') ?></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
