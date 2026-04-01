<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
hq_boot_session_security();

if (isset($_GET['reset'])) {
    unset($_SESSION['pending_user'], $_SESSION['signup_stage']);
    header('Location: signup.php');
    exit;
}

include __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../mailer.php';

function generateAndStoreOtp(PDO $conn, string $email): string {
    $otp     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expires = date('o-m-d H:i:s', strtotime('+10 minutes'));
    $conn->prepare("DELETE FROM email_otps WHERE email = ?")->execute([$email]);
    $conn->prepare("INSERT INTO email_otps (email, otp, expires_at) VALUES (?, ?, ?)")
         ->execute([$email, $otp, $expires]);
    return $otp;
}

$error = '';
$resendSent = false;
$success = false;
$stage = $_SESSION['signup_stage'] ?? 'form';
$pendingEmail = $_SESSION['pending_user']['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_otp'])) {
    hq_require_csrf('signup_send_otp');
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPwd = $_POST['confirm_password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $sex = $_POST['gender'] ?? '';
    $contact_number = trim($_POST['contact_number'] ?? '');
    $dob = trim($_POST['dob'] ?? '');

    if (empty($fullname) || empty($email) || empty($password) || empty($contact_number) || empty($sex) || empty($dob)) {
        $error = "All required fields must be filled.";
        $stage = 'form';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
        $stage = 'form';
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
        $stage = 'form';
    } elseif ($password !== $confirmPwd) {
        $error = "Passwords do not match.";
        $stage = 'form';
    } else {
        $check = 