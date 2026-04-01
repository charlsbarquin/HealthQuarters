<?php
// submit_testimonial.php — handles testimonial form submission
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
include 'db.php';
hq_boot_session_security();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    hq_require_csrf('testimonial_submit');
    $name    = trim($_POST['feedback_name'] ?? '');
    $message = trim($_POST['feedback_message'] ?? '');
    $rating  = intval($_POST['feedback_rating'] ?? 5);

    if (!empty($name) && !empty($message) && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("
            INSERT INTO testimonials (name, message, rating, is_approved, created_at)
            VALUES (?, ?, ?, 1, NOW())
        ");
        $stmt->execute([$name, $message, $rating]);
        $_SESSION['feedback_success'] = true;
    } else {
        $_SESSION['feedback_error'] = true;
    }
}

header("Location: lp.php#leave-feedback");
exit;