<?php require __DIR__ . '/includes/confirm_booking/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Appointment - HealthQuarters</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-green-50 to-blue-50 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-lg max-w-2xl w-full">
  <h2 class="text-3xl font-bold mb-6 text-center text-green-600">Confirm Your Appointment</h2>

  <?php if ($message): ?>
  <p class="mb-4 text-center font-semibold <?= strpos($message, 'OK') !== false ? 'text-green-600' : 'text-red-600' ?>">
    <?= $message ?>
  </p>

  <?php if (strpos($message, 'OK') !== false): ?>
    <div class="text-center mt-6">
      <a href="homepage.php" 
         class="px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg shadow hover:from-green-600 hover:to-blue-600">
        OK
   </a>
      <a href="view_appointment.php" 
   class="px-6 py-3 ml-2 bg-green-100 text-green-600 rounded-lg shadow hover:bg-green-200">
   View My Appointments
</a>

    </div>
  <?php endif; ?>
<?php endif; ?>

  <?php if (!$message): ?>
    <div class="mb-6">
      <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden">
        <tbody class="divide-y divide-gray-200">
          <tr><th class="p-3 bg-gray-100">Full Name</th><td class="p-3"><?= htmlspecialchars($data['fullname']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Email</th><td class="p-3"><?= htmlspecialchars($data['email']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Contact</th><td class="p-3"><?= htmlspecialchars($data['contact_number']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Address</th><td class="p-3"><?= htmlspecialchars($data['address']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Sex</th><td class="p-3"><?= htmlspecialchars($data['sex']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Age</th><td class="p-3"><?= htmlspecialchars($data['age']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Birthday</th><td class="p-3"><?= htmlspecialchars($data['birthday']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Service</th><td class="p-3"><?= htmlspecialchars($data['service']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Location</th><td class="p-3"><?= htmlspecialchars($data['location']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Appointment Date</th><td class="p-3"><?= htmlspecialchars($data['appointment_date']) ?></td></tr>
          <tr><th class="p-3 bg-gray-100">Appointment Time</th><td class="p-3"><?= htmlspecialchars($data['appointment_time']) ?></td></tr>
        </tbody>
      </table>
    </div>

    <form method="POST" class="flex justify-between">
      <button type="submit" name="cancel"
        class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg shadow hover:bg-gray-400">
        Cancel / Edit
      </button>
      <button type="submit" name="confirm"
        class="px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg shadow hover:from-green-600 hover:to-blue-600">
        Confirm Appointment
      </button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
