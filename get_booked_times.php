<?php
include 'db.php';

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE appointment_date = ?");
    $stmt->execute([$date]);
    $times = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($times);
}