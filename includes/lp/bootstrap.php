<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
include __DIR__ . '/../../db.php';
hq_boot_session_security();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        hq_establish_authenticated_session($user);
        header("Location: homepage.php");
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid login"]);
    }
}

$testimonials = [];
try {
    $t = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 6");
    $testimonials = $t->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$feedbackSuccess = isset($_SESSION['feedback_success']);
$feedbackError = isset($_SESSION['feedback_error']);
unset($_SESSION['feedback_success'], $_SESSION['feedback_error']);
