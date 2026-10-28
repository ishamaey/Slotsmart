<?php
/**
 * Slotsmart Application Configuration
 */
declare(strict_types=1);

// Error reporting (turn off display in production)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Session hardening
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Database credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'slotsmart_db');
define('DB_USER', 'root');
define('DB_PASS', '');          // XAMPP default blank; set your MySQL password
define('DB_CHARSET', 'utf8mb4');

// Application
define('APP_NAME', 'Slotsmart');
define('APP_URL', 'http://localhost/slotsmart/public');
define('APP_EMAIL', 'no-reply@slotsmart.local');

// Security
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_MINUTES', 15);
define('VERIFICATION_EXPIRY_HOURS', 24);
define('SESSION_EXPIRY_DAYS', 30);

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Timezone
date_default_timezone_set('Asia/Manila');