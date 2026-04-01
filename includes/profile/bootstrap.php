<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../services/patient_portal_service.php';

hq_boot_session_security();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    hq_require_csrf('profile_update');
    $fullname = trim($_POST['fullname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $dob = trim($_POST['dob'] ?? '');

    if ($fullname !== '' && $contact_number !== '') {
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, address = ?, contact_number = ?, dob = ? WHERE user_id = ?");
        $stmt->execute([$fullname, $address, $contact_number, $dob ?: null, $user_id]);
        $_SESSION['fullname'] = $fullname;
        $success = 'Profile updated successfully!';
    } else {
        $error = 'Full name and contact number are required.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_reschedule'])) {
    hq_require_csrf('profile_reschedule');
    $appointmentId = (int) ($_POST['appointment_id'] ?? 0);
    $requestedDate = trim($_POST['requested_date'] ?? '');
    $requestedTime = trim($_POST['requested_time'] ?? '');
    $reason = trim($_POST['reason'] ?? '');

    if ($appointmentId <= 0 || $requestedDate === '' || $requestedTime === '') {
        $error = 'Please choose a new date and time for your reschedule request.';
    } elseif (hq_request_reschedule($conn, $appointmentId, $user_id, $requestedDate, $requestedTime, $reason)) {
        $success = 'Your reschedule request was submitted successfully.';
    } else {
        $error = 'We could not submit that reschedule request. It may already be pending or the appointment is no longer eligible.';
    }
}

$portal = hq_fetch_patient_context($conn, $user_id);

$today = $portal['today'];
$tomorrow = $portal['tomorrow'];
$threeDays = $portal['three_days'];
$user = $portal['user'];
$appointments = $portal['appointments'];
$activeAppointments = $portal['active_appointments'];
$nextAppointment = $portal['next_appointment'];
$todayAppts = $portal['today_appointments'];
$corpInquiries = $portal['corporate_inquiries'];
$labResults = $portal['lab_results'];
$allNotifications = $portal['notifications'];
$unreadCount = $portal['unread_count'];
$quickLinks = $portal['quick_links'];
$dashboardCards = $portal['dashboard_cards'];
$timelineItems = $portal['timeline_items'];
$banners = $portal['banners'];
$rescheduleRequests = $portal['reschedule_requests'];
$rescheduleByAppointment = $portal['reschedule_by_appointment'];
$FASTING_SERVICES = $portal['fasting_keywords'];
$PREP_NOTES = $portal['prep_notes'];
$recentActivity = $portal['recent_activity'];
$nextSteps = $portal['next_steps'];
$resultSummary = $portal['result_summary'];
$appointmentCards = $portal['appointment_cards'];

$patientName = $user['fullname'] ?? 'Patient';
$patient_name = $patientName;
$patientEmail = $user['email'] ?? '';
$initials = hq_initials($patientName);
$upcomingCount = count($activeAppointments);
$pendingCorpCount = count(array_filter($corpInquiries, fn($c) => !in_array(strtolower((string) ($c['status'] ?? 'pending')), ['completed', 'cancelled'], true)));
