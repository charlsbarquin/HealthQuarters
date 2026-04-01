<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../../services/patient_portal_service.php';

hq_require_login('login.php');

include __DIR__ . '/../../db.php';

$portal = hq_fetch_patient_context($conn, (int) $_SESSION['user_id']);
$user = $portal['user'];
$patient_name = hq_patient_name();
$initials = hq_initials($patient_name);
$dashboardCards = $portal['dashboard_cards'];
$quickLinks = $portal['quick_links'];
$nextAppointment = $portal['next_appointment'];
$unreadCount = $portal['unread_count'];
$activeAppointments = $portal['active_appointments'];
$corpInquiries = $portal['corporate_inquiries'];
$recentActivity = $portal['recent_activity'];
$nextSteps = $portal['next_steps'];
$resultSummary = $portal['result_summary'];
$appointmentCards = $portal['appointment_cards'];
