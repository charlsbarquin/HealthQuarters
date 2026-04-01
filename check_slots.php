<?php
/**
 * check_slots.php
 * AJAX endpoint — returns array of taken time slots for a given date.
 * Called by the booking form's JS when the patient picks a date.
 *
 * Place in: healthquarters-main/check_slots.php
 *
 * Request:  GET check_slots.php?date=2025-07-15
 * Response: JSON array of taken slot strings, e.g. ["8:00 AM","2:00 PM"]
 */
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

include 'db.php';
require_once __DIR__ . '/includes/runtime_schema.php';
require_once __DIR__ . '/services/patient_portal_service.php';

$date = $_GET['date'] ?? '';
$branch = trim((string) ($_GET['branch'] ?? ''));

if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("
    SELECT preferred_time, COUNT(*) AS slot_count
    FROM home_service_appointments
    WHERE appointment_date = ?
      AND (? = '' OR branch = ?)
      AND status NOT IN ('Cancelled')
    GROUP BY preferred_time
");
$stmt->execute([$date, $branch, $branch]);
$rows = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $time = (string) ($row['preferred_time'] ?? '');
    if ($time === '') {
        continue;
    }
    if ((int) ($row['slot_count'] ?? 0) >= hq_booking_branch_capacity($branch)) {
        $rows[] = $time;
    }
}

echo json_encode(array_values(array_unique($rows)));