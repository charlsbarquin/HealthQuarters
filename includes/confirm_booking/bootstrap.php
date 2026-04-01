<?php

session_start();
include __DIR__ . '/../../db.php';

if (!isset($_SESSION['appointment_data'])) {
    header("Location: booking.php");
    exit();
}

$data = $_SESSION['appointment_data'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $stmt = $conn->prepare("
            INSERT INTO appointments 
            (user_id, fullname, email, contact_number, address, sex, age, birthday, service, location, appointment_date, appointment_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if ($stmt->execute([
            $data['user_id'], $data['fullname'], $data['email'], $data['contact_number'],
            $data['address'], $data['sex'], $data['age'], $data['birthday'],
            $data['service'], $data['location'], $data['appointment_date'], $data['appointment_time']
        ])) {
            $message = "Appointment confirmed successfully!";
            unset($_SESSION['appointment_data']);
        } else {
            $message = "Failed to confirm appointment. Try again.";
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: booking.php");
        exit();
    }
}
