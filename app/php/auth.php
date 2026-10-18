<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ini_set('session.cookie_secure', '1');
    session_start();
}

require_once __DIR__ . '/config.php';

/* Single-admin account configured by the hosting environment. */
define('LEADERBOARD_USERNAME', getenv('ADMIN_USER') ?: 'admin');
define('LEADERBOARD_PASSWORD', getenv('ADMIN_PASSWORD') ?: '');
define('LEADERBOARD_PASSWORD_HASH', getenv('ADMIN_PASSWORD_HASH') ?: '');
function validAdminPassword($password) {
    if (LEADERBOARD_PASSWORD_HASH !== '') return password_verify($password, LEADERBOARD_PASSWORD_HASH);
    return LEADERBOARD_PASSWORD !== '' && hash_equals(LEADERBOARD_PASSWORD, $password);
}

function isLoggedIn()
{
    return !empty($_SESSION['loggedin']);
}

function isAdmin()
{
    return isLoggedIn();
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
}

function csrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        try {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (Throwable $e) {
            $_SESSION['csrf_token'] = hash('sha256', uniqid(mt_rand(), true));
        }
    }
    return $_SESSION['csrf_token'];
}

function refreshCsrfToken()
{
    unset($_SESSION['csrf_token']);
    return csrfToken();
}

function verifyCsrfToken($token)
{
    if (!is_string($token) || !isset($_SESSION['csrf_token'])) {
        return false;
    }

    if (function_exists('hash_equals')) {
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    return $_SESSION['csrf_token'] === $token;
}
