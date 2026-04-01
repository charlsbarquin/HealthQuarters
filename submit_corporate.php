<?php
// submit_corporate.php — handles corporate inquiry form submission
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
include 'db.php';
require_once __DIR__ . '/services/notification_service.php';
hq_boot_session_security();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_corporate'])) {
    hq_require_csrf('corporate_submit');
    $company_name    = trim($_POST['companyName']    ?? '');
    $company_number  = trim($_POST['companyNumber']  ?? '');
    $industry        = trim($_POST['industry']       ?? '');
    $company_size    = trim($_POST['companySize']    ?? '');
    $company_address = trim($_POST['companyAddress'] ?? '');
    $contact_person  = trim($_POST['contactPerson']  ?? '');
    $designation     = trim($_POST['designation']    ?? '');
    $email           = trim($_POST['email']          ?? '');
    $contact_number  = trim($_POST['contactNumber']  ?? '');
    $service_type    = trim($_POST['serviceType']    ?? '');
    $emp_count       = intval($_POST['empCount']     ?? 0);
    $schedule        = trim($_POST['schedule']       ?? '');
    $message              = trim($_POST['message']             ?? '');
    $service_type_other   = trim($_POST['serviceTypeOther']    ?? '');

    // Merge "Other" specification into service_type
    if ($service_type === 'Other / Custom Package' && $service_type_other !== '') {
        $service_type = 'Other: ' . $service_type_other;
    }
    $hmo_provider    = trim($_POST['hmoProvider']    ?? '');
    $hmo_code        = trim($_POST['hmoCode']        ?? '');
    $hmo_coverage    = trim($_POST['hmoCoverage']    ?? '');
    $hmo_count       = intval($_POST['hmoCoveredCount'] ?? 0);

    // Get logged-in user_id if available
    $user_id = $_SESSION['user_id'] ?? null;

    // Validate required fields
    $required = [$company_name, $company_number, $industry, $company_address,
                 $contact_person, $designation, $email, $contact_number, $service_type, $message];
    $valid = !in_array('', $required) && filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($valid) {
        $stmt = $conn->prepare("
            INSERT INTO corporate_inquiries
                (user_id, company_name, company_number, industry, company_size, company_address,
                 contact_person, designation, email, contact_number, service_type,
                 emp_count, schedule, message,
                 hmo_provider, hmo_code, hmo_coverage, hmo_covered_count,
                 status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())
        ");
        $stmt->execute([
            $user_id,
            $company_name, $company_number, $industry, $company_size, $company_address,
            $contact_person, $designation, $email, $contact_number, $service_type,
            $emp_count ?: null, $schedule, $message,
            $hmo_provider ?: null, $hmo_code ?: null, $hmo_coverage ?: null, $hmo_count ?: null
        ]);
        if ($user_id) {
            $inquiryId = (int)$conn->lastInsertId();
            hq_create_notification($conn, [
                'user_id' => $user_id,
                'appointment_id' => $inquiryId,
                'source_type' => 'corporate',
                'source_id' => $inquiryId,
                'type' => 'corp_pending',
                'title' => 'Corporate Inquiry Received',
                'message' => "Your corporate inquiry for <strong>{$service_type}</strong> on behalf of <strong>{$company_name}</strong> has been submitted successfully. Keep this record for your reference while we prepare follow-up communication.",
                'action_url' => 'profile.php?tab=appointments',
            ]);
        }

       $_SESSION['corporate_success'] = true;

        // Redirect: guest → lp.php, logged-in → profile.php to track inquiry
        $redirect = isset($_SESSION['user_id']) ? 'profile.php' : 'lp.php';
        header("Location: {$redirect}");
        exit;

    } else {
        $_SESSION['corporate_error'] = true;
    }
}

// Validation failed — go back to form so error message shows
header("Location: corporateservice.php");
exit;