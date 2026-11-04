<?php

const SPOON_ADMIN_SESSION_NAME = 'SPOONADMIN';
const SPOON_ADMIN_IDLE_TIMEOUT = 1800;
const SPOON_ADMIN_ABSOLUTE_TIMEOUT = 43200;
const SPOON_ADMIN_MAX_ATTEMPTS = 5;
const SPOON_ADMIN_LOCKOUT_SECONDS = 900;

define('SPOON_ADMIN_USER', getenv('SPOON_ADMIN_USER') ?: 'носов');
define(
    'SPOON_ADMIN_PASSWORD_HASH',
    getenv('SPOON_ADMIN_PASSWORD_HASH') ?: '$2y$10$IPbZ3E4IyOdyOjU/Md1BlevNu8rQDLGaNDpk526EDEHrVwduwsv9a'
);

function spoon_admin_is_https(): bool
{
    return !empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off';
}

function spoon_admin_start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_name(SPOON_ADMIN_SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => spoon_admin_is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

function spoon_admin_is_authenticated(): bool
{
    if (empty($_COOKIE[SPOON_ADMIN_SESSION_NAME])) {
        return false;
    }

    spoon_admin_start_session();

    if (empty($_SESSION['spoon_admin'])) {
        spoon_admin_logout();
        return false;
    }

    $now = time();
    $last = (int)($_SESSION['spoon_admin_last'] ?? 0);
    $loginAt = (int)($_SESSION['spoon_admin_login_at'] ?? 0);

    if ($last === 0 || $now - $last > SPOON_ADMIN_IDLE_TIMEOUT
        || $loginAt === 0 || $now - $loginAt > SPOON_ADMIN_ABSOLUTE_TIMEOUT) {
        spoon_admin_logout();
        return false;
    }

    $_SESSION['spoon_admin_last'] = $now;

    return true;
}

function spoon_admin_login(string $username, string $password): bool
{
    $passwordOk = password_verify($password, SPOON_ADMIN_PASSWORD_HASH);
    if (!hash_equals(SPOON_ADMIN_USER, $username) || !$passwordOk) {
        return false;
    }

    spoon_admin_start_session();
    session_regenerate_id(true);

    $_SESSION = [
        'spoon_admin' => true,
        'spoon_admin_login_at' => time(),
        'spoon_admin_last' => time(),
    ];

    return true;
}

function spoon_admin_logout(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        if (empty($_COOKIE[SPOON_ADMIN_SESSION_NAME])) {
            return;
        }
        spoon_admin_start_session();
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Lax',
        ]);
    }

    session_destroy();
}

function spoon_admin_csrf_token(): string
{
    spoon_admin_start_session();

    if (!isset($_SESSION['spoon_admin_csrf']) || !is_string($_SESSION['spoon_admin_csrf'])) {
        $_SESSION['spoon_admin_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['spoon_admin_csrf'];
}

function spoon_admin_valid_csrf(string $token): bool
{
    if ($token === '') {
        return false;
    }

    spoon_admin_start_session();
    $expected = $_SESSION['spoon_admin_csrf'] ?? '';

    return is_string($expected) && $expected !== '' && hash_equals($expected, $token);
}

function spoon_admin_require_csrf(): bool
{
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf'] ?? '');

    return is_string($token) && spoon_admin_valid_csrf($token);
}

function spoon_admin_client_ip(): string
{
    return (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown');
}

function spoon_admin_throttle_file(string $ip): string
{
    $dir = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'spoon-admin-throttle';
    if (!is_dir($dir)) {
        @mkdir($dir, 0700, true);
    }

    return $dir . DIRECTORY_SEPARATOR . hash('sha256', $ip) . '.json';
}

function spoon_admin_is_rate_limited(string $ip): bool
{
    $file = spoon_admin_throttle_file($ip);
    $data = json_decode((string)@file_get_contents($file), true);
    if (!is_array($data)) {
        return false;
    }

    $first = (int)($data['first'] ?? 0);
    $count = (int)($data['count'] ?? 0);

    if ($count < SPOON_ADMIN_MAX_ATTEMPTS) {
        return false;
    }

    if (time() - $first >= SPOON_ADMIN_LOCKOUT_SECONDS) {
        @unlink($file);
        return false;
    }

    return true;
}

function spoon_admin_record_failure(string $ip): void
{
    $file = spoon_admin_throttle_file($ip);
    $data = json_decode((string)@file_get_contents($file), true);
    $now = time();

    if (!is_array($data) || $now - (int)($data['first'] ?? 0) >= SPOON_ADMIN_LOCKOUT_SECONDS) {
        $data = ['first' => $now, 'count' => 0];
    }

    $data['count'] = (int)$data['count'] + 1;
    $data['last'] = $now;

    if (@file_put_contents($file, json_encode($data), LOCK_EX) === false) {
        error_log('admin-auth: не удалось записать файл лимита попыток ' . $file);
    }
}

function spoon_admin_clear_failures(string $ip): void
{
    @unlink(spoon_admin_throttle_file($ip));
}
