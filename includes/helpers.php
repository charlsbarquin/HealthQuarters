<?php

function hq_is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function hq_patient_name(string $default = 'Patient'): string
{
    return $_SESSION['fullname'] ?? $_SESSION['full_name'] ?? $default;
}

function hq_initials(string $name, string $default = 'P'): string
{
    $value = trim($name);
    if ($value === '') {
        $value = $default;
    }

    return strtoupper(substr($value, 0, 1));
}
