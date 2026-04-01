<?php

session_start();
require_once __DIR__ . '/../bootstrap.php';
include __DIR__ . '/../../db.php';

hq_boot_session_security();
$error = $error ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hq_require_csrf('login');

    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email and password.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, (string) ($user['password'] ?? ''))) {
                hq_establish_authenticated_session($user);

                header("Location: homepage.php");
                exit;
            }

            $error = "Invalid email or password.";
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
