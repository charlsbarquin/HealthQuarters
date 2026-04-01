<?php require __DIR__ . '/includes/view_appointment/bootstrap.php'; ?>
<!DOCToPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>My Appointments - HealthQuarters</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to bottom, #f0fff4, #ebf8ff);
    min-height: 100vh;
  }
  .card-custom {
    border-radius: 1rem;
  }
  .table thead th {
    background-color: #d1fae5;
    color: #047857;
    font-weight: bold;
    text-align: center;
  }
  .gradient-btn {
    background: linear-gradient(to right, #2563eb, #22c55e);
    color: white;
    font-weight: 500;
  }
  .gradient-btn:hover {
    background: linear-gradient(to right, #1d4ed8, #16a34a);
    color: white;
  }
</style>
</head>
<body>

<div class="container py-5">
  <div class="card shadow card-custom">
    <div class="card-body p-5">

      <h2 class="text-center text-success fw-bold mb-4">My Appointments</h2>

      <?php if (count($appointments) > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center">
            <thead>
              <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Service</th>
                <th>Location</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($appointments as $appt): ?>
                <tr>
                  <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                  <td><?= htmlspecialchars($appt['appointment_time']) ?></td>
                  <td><?= htmlspecialchars($appt['service']) ?></td>
                  <td><?= htmlspecialchars($appt['location']) ?></td>

                  <td class="<?php 
                        if ($appt['status'] === 'Confirmed') echo 'text-success fw-bold';
                        elseif ($appt['status'] === 'Pending') echo 'text-warning fw-bold';
                        elseif ($appt['status'] === 'Cancelled') echo 'text-danger fw-bold';
                        else echo 'text-secondary';
                      ?>">
                    <?= htmlspecialchars($appt['status']) ?>
                  </td>

                  <td>
                    <?php if ($appt['status'] !== 'Cancelled'): ?>
                      <form method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                        <input type="hidden" name="cancel_id" value="<?= $appt['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">
                          Cancel
                        </button>
                      </form>
                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-center text-muted">  oou have no appointments booked yet.</p>
      <?php endif; ?>

      <div class="text-center mt-4">
        <a href="homepage.php" class="btn gradient-btn px-4 py-2 shadow">
          Back to Home
        </a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>