<?php

function hq_require_login(string $redirect = 'login.php'): void
{
    hq_boot_session_security();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $redirect);
        exit;
    }
}
