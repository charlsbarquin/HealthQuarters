<?php
/**
 * notifications_api.php
 * ─────────────────────────────────────────────────────────
 * Handles:
 *   GET  ?action=get_unread_count   → returns { count: N }
 *   GET  ?action=get_notifications  → returns { notifications: [...] }
 *   POST action=mark_read&id=N      → marks one notification read
 *   POST action=mark_all_read       → marks all read for user
 */
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
include 'db.php';
require_once __DIR__ . '/services/patient_portal_service.php';

header('Content-Type: application/json');
hq_boot_session_security();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'unauthorized']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$action  = $_POST['action'] ?? $_GET['action'] ?? '';
$filter = $_GET['filter'] ?? 'all';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hq_verify_csrf('notifications_api', (string) ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''))) {
        http_response_code(419);
        echo json_encode(['error' => 'invalid_csrf']);
        exit;
    }
}

switch ($action) {

    case 'get_unread_count':
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND is_read=0");
        $stmt->execute([$user_id]);
        echo json_encode(['count' => (int) $stmt->fetchColumn()]);
        break;

    case 'get_notifications':
        $rows = hq_fetch_notifications($conn, $user_id, $filter, 100);
        echo json_encode(['notifications' => $rows]);
        break;

    case 'mark_read':
        $id = intval($_POST['id'] ?? 0);
        $conn->prepare("UPDATE user_notifications SET is_read=1 WHERE id=? AND user_id=?")
             ->execute([$id, $user_id]);
        echo json_encode(['ok' => true]);
        break;

    case 'mark_all_read':
        $conn->prepare("UPDATE user_notifications SET is_read=1 WHERE user_id=?")
             ->execute([$user_id]);
        echo json_encode(['ok' => true]);
        break;

    default:
        echo json_encode(['error' => 'unknown action']);
}