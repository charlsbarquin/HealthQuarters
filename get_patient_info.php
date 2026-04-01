<?php
/**
 * get_patient_info.php
 * AJAX endpoint — returns the logged-in patient's profile as JSON
 * for auto-filling the home service appointment form.
 *
 * Place in: healthquarters-main/get_patient_info.php
 */
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

include 'db.php';

$stmt = $conn->prepare("
    SELECT fullname, email, contact_number, address, sex, dob
    FROM users
    WHERE user_id = ?
    LIMIT 1
");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['error' => 'user_not_found']);
    exit;
}

// Split fullname into first / middle / last (best-effort)
$parts     = array_values(array_filter(explode(' ', trim($user['fullname']))));
$partCount = count($parts);

$firstName  = '';
$middleName = '';
$lastName   = '';

if ($partCount === 1) {
    $firstName = $parts[0];
} elseif ($partCount === 2) {
    $firstName = $parts[0];
    $lastName  = $parts[1];
} else {
    $firstName  = array_shift($parts);
    $lastName   = array_pop($parts);
    $middleName = implode(' ', $parts);
}

echo json_encode([
    'fullname'       => $user['fullname'],
    'first_name'     => $firstName,
    'middle_name'    => $middleName,
    'last_name'      => $lastName,
    'email'          => $user['email'],
    'contact_number' => $user['contact_number'],
    'address'        => $user['address'] ?? '',
    'sex'            => $user['sex'] ?? '',
    'dob'            => $user['dob'] ?? '',
]);