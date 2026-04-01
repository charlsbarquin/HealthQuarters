<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../services/notification_service.php';
require_once __DIR__ . '/../../services/patient_portal_service.php';
hq_boot_session_security();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include __DIR__ . '/../../db.php';

$ref = '';
$appointmentId = 0;
$show_success = false;
$slot_taken = false;
$booking_error = '';
$branchOptions = hq_patient_branch_options();
$allowedSlots = hq_booking_allowed_slots();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_appointment'])) {
    hq_require_csrf('booking_submit');
    $user_id = $_SESSION['user_id'];
    $appt_date = $_POST['appt_date'];
    $appt_time = $_POST['appt_time'];
    $service_type = $_POST['service_type'];
    $branch = $_POST['branch'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'] ?? '';
    $dob = $_POST['dob'];
    $age = $_POST['age'] ?? null;
    $gender = $_POST['gender'];
    $contact_num = $_POST['contact_num'];
    $alt_contact = $_POST['alt_contact'] ?? '';
    $email = $_POST['email'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = 'Albay';

    $full_address = implode(', ', array_filter([$house_no, $street, $barangay, $city, $province]));
    $errors = hq_validate_booking_payload($conn, $_POST);

    if (!empty($errors)) {
        $booking_error = $errors[0];
        $slot_taken = str_contains(strtolower($booking_error), 'slot');
    } else {
        $stmt = $conn->prepare("
            INSERT INTO home_service_appointments
            (user_id, appointment_date, preferred_time, service_type, branch, notes,
             first_name, last_name, middle_name, dob, age, gender,
             contact_num, alt_contact, email, address, status, appointment_type, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Confirmed', 'Home Service', NOW())
        ");
        $stmt->execute([
            $user_id, $appt_date, $appt_time, $service_type, $branch, $notes,
            $first_name, $last_name, $middle_name, $dob, $age, $gender,
            $contact_num, $alt_contact, $email, $full_address
        ]);

        $appointmentId = (int) $conn->lastInsertId();

        hq_create_notification($conn, [
            'user_id' => $user_id,
            'appointment_id' => $appointmentId,
            'source_type' => 'appointment',
            'source_id' => $appointmentId,
            'type' => 'confirmed',
            'title' => 'Appointment Scheduled',
            'message' => "Your <strong>{$service_type}</strong> appointment for <strong>" . date('F j, Y', strtotime($appt_date)) . " at {$appt_time}</strong> has been recorded successfully.",
            'action_url' => 'profile.php?tab=appointments',
        ]);

        $ref = 'HS-' . str_pad((string) $appointmentId, 6, '0', STR_PAD_LEFT);
        $show_success = true;
    }
}

$patient_name = hq_patient_name();
$initials = hq_initials($patient_name);
