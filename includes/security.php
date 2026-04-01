<?php

const HQ_SESSION_TIMEOUT_SECONDS = 7200;

function hq_boot_session_security(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return;
    }

    $now = time();
    $fingerprint = hash('sha256', (string) ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'));

    if (isset($_SESSION['session_fingerprint']) && $_SESSION['session_fingerprint'] !== $fingerprint) {
        hq_logout_session(false);
        return;
    }

    if (isset($_SESSION['last_activity']) && ($now - (int) $_SESSION['last_activity']) > HQ_SESSION_TIMEOUT_SECONDS) {
        hq_logout_session(false);
        return;
    }

    $_SESSION['session_fingerprint'] = $fingerprint;
    $_SESSION['last_activity'] = $now;
}

function hq_establish_authenticated_session(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) ($user['user_id'] ?? 0);
    $_SESSION['fullname'] = $user['fullname'] ?? '';
    $_SESSION['session_fingerprint'] = hash('sha256', (string) ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'));
    $_SESSION['last_activity'] = time();
    $_SESSION['login_time'] = time();
}

function hq_logout_session(bool $destroy = true): void
{
    $_SESSION = [];

    if ($destroy && session_status() === PHP_SESSION_ACTIVE) {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }
}

function hq_csrf_token(string $scope = 'default'): string
{
    if (!isset($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = [];
    }

    if (empty($_SESSION['_csrf'][$scope])) {
        $_SESSION['_csrf'][$scope] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'][$scope];
}

function hq_csrf_input(string $scope = 'default'): string
{
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(hq_csrf_token($scope), ENT_QUOTES, 'UTF-8') . '">';
}

function hq_verify_csrf(string $scope = 'default', ?string $token = null): bool
{
    $expected = $_SESSION['_csrf'][$scope] ?? '';
    $provided = $token ?? (string) ($_POST['_csrf'] ?? '');

    return $expected !== '' && hash_equals($expected, $provided);
}

function hq_require_csrf(string $scope = 'default'): void
{
    if (!hq_verify_csrf($scope)) {
        http_response_code(419);
        exit('Invalid or expired form token.');
    }
}

