<?php

session_start();
require_once __DIR__ . '/../auth.php';

include __DIR__ . '/../../db.php';

hq_require_login('login.php');

$user_id = $_SESSION['user_id'];

if (isset($_POST['cancel_id'])) {
    $cancel_id = $_POST['cancel_id'];

    $stmt = $conn->prepare("
        UPDATE appointments 
        SET status = 'Cancelled', cancelled_by = 'user'
        WHERE id = ? AND user_id = ? AND status != 'Cancelled'
    ");
    $stmt->execute([$cancel_id, $user_id]);

    header("Location: view_appointment.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT * FROM appointments 
    WHERE user_id = ? 
    ORDER BY appointment_date DESC, appointment_time DESC
");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
