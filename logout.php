<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';

hq_boot_session_security();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    hq_require_csrf('logout');
    hq_logout_session();
}

header("Location: lp.php");
exit;