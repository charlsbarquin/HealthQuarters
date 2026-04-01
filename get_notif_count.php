<?php
/**
 * get_notif_count.php
 * Lightweight endpoint polled every 60s by profile.php
 * Returns unread notification count for the logged-in user.
 */
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT COUNT(*) AS cnt 
        FROM user_notifications 
        WHERE user_id = ? AND is_read = 0
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['count' => (int)($row['cnt'] ?? 0)]);
} catch (Exception $e) {
    echo json_encode(['count' => 0]);
}