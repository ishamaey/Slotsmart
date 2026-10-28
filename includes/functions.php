<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

/* =========================================================
 * AUTH & SESSION HELPERS
 * ========================================================= */

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function current_user(): ?array
{
    if (!is_logged_in()) return null;
    static $user = null;
    if ($user === null) {
        $stmt = db()->prepare('SELECT id, username, email, full_name, role, avatar_initials, is_verified FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function require_login(): void
{
    if (!is_logged_in()) {
        $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Please log in first.'];
        header('Location: index.php');
        exit;
    }
    $u = current_user();
    if (!$u || (int)$u['is_verified'] !== 1) {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

function require_role(string ...$roles): void
{
    require_login();
    $u = current_user();
    if (!in_array($u['role'], $roles, true)) {
        http_response_code(403);
        die('Access denied.');
    }
}

/* =========================================================
 * CSRF
 * ========================================================= */

function csrf_token(): string
{
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function verify_csrf(?string $token): bool
{
    return is_string($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

/* =========================================================
 * FLASH MESSAGES
 * ========================================================= */

function set_flash(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) return null;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

/* =========================================================
 * AUTH ACTIONS
 * ========================================================= */

function register_user(string $username, string $email, string $password, string $full_name, string $role = 'faculty'): array
{
    $username = trim($username);
    $email = strtolower(trim($email));
    $full_name = trim($full_name);

    if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
        return ['ok' => false, 'msg' => 'Username must be 3-50 chars (letters, numbers, underscore).'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'msg' => 'Invalid email address.'];
    }
    if (strlen($password) < 8) {
        return ['ok' => false, 'msg' => 'Password must be at least 8 characters.'];
    }
    if (!in_array($role, ['admin', 'faculty'], true)) {
        $role = 'faculty';
    }

    $pdo = db();
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        return ['ok' => false, 'msg' => 'Username or email already registered.'];
    }

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + VERIFICATION_EXPIRY_HOURS * 3600);
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, full_name, role, avatar_initials, verification_token, verification_expires) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([
        $username, $email, $hash, $full_name, $role,
        strtoupper(substr($full_name, 0, 2)), $token, $expires,
    ]);
    $userId = (int)$pdo->lastInsertId();

    log_audit($userId, 'register', "role=$role");

    // TODO: Send real email. For dev, write token to a file.
    $link = APP_URL . '/verify.php?token=' . $token;
    file_put_contents(__DIR__ . '/../verification_debug.log',
        "[".date('c')."] $email => $link\n", FILE_APPEND);

    return ['ok' => true, 'msg' => 'Registration successful! Check your email to verify.', 'debug_link' => $link];
}

function verify_user(string $token): bool
{
    $stmt = db()->prepare('SELECT id FROM users WHERE verification_token = ? AND verification_expires > NOW() AND is_verified = 0 LIMIT 1');
    $stmt->execute([$token]);
    $u = $stmt->fetch();
    if (!$u) return false;

    $upd = db()->prepare('UPDATE users SET is_verified = 1, verification_token = NULL, verification_expires = NULL WHERE id = ?');
    $upd->execute([$u['id']]);
    log_audit((int)$u['id'], 'verify_email');
    return true;
}

function resend_verification(string $email): bool
{
    $stmt = db()->prepare('SELECT id, full_name FROM users WHERE email = ? AND is_verified = 0 LIMIT 1');
    $stmt->execute([strtolower(trim($email))]);
    $u = $stmt->fetch();
    if (!$u) return false;

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + VERIFICATION_EXPIRY_HOURS * 3600);
    $upd = db()->prepare('UPDATE users SET verification_token = ?, verification_expires = ? WHERE id = ?');
    $upd->execute([$token, $expires, $u['id']]);

    $link = APP_URL . '/verify.php?token=' . $token;
    file_put_contents(__DIR__ . '/../verification_debug.log',
        "[".date('c')."] RESEND to {$email} => $link\n", FILE_APPEND);
    return true;
}

function attempt_login(string $username, string $password): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $username]);
    $u = $stmt->fetch();

    if (!$u) return ['ok' => false, 'msg' => 'Invalid credentials.'];

    if ($u['locked_until'] && strtotime($u['locked_until']) > time()) {
        return ['ok' => false, 'msg' => 'Account temporarily locked. Try again later.'];
    }

    if (!password_verify($password, $u['password_hash'])) {
        $attempts = (int)$u['login_attempts'] + 1;
        if ($attempts >= MAX_LOGIN_ATTEMPTS) {
            $lock = date('Y-m-d H:i:s', time() + LOCKOUT_MINUTES * 60);
            $pdo->prepare('UPDATE users SET login_attempts = ?, locked_until = ? WHERE id = ?')
                ->execute([$attempts, $lock, $u['id']]);
            log_audit((int)$u['id'], 'lockout', "attempts=$attempts");
            return ['ok' => false, 'msg' => 'Too many failed attempts. Locked for '.LOCKOUT_MINUTES.' minutes.'];
        }
        $pdo->prepare('UPDATE users SET login_attempts = ? WHERE id = ?')->execute([$attempts, $u['id']]);
        log_audit((int)$u['id'], 'login_failed', "attempts=$attempts");
        return ['ok' => false, 'msg' => 'Invalid credentials.'];
    }

    if ((int)$u['is_verified'] !== 1) {
        return ['ok' => false, 'msg' => 'Please verify your email first. <a href="resend_verification.php" class="underline">Resend</a>'];
    }

    // Success: reset counters
    $pdo->prepare('UPDATE users SET login_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = ?')
        ->execute([$u['id']]);

    // Rotate session id
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$u['id'];
    $_SESSION['role']    = $u['role'];

    log_audit((int)$u['id'], 'login_success');
    return ['ok' => true, 'role' => $u['role']];
}

function logout_user(): void
{
    if (is_logged_in()) log_audit((int)$_SESSION['user_id'], 'logout');
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/* =========================================================
 * AUDIT
 * ========================================================= */

function log_audit(?int $userId, string $action, ?string $details = null): void
{
    try {
        $stmt = db()->prepare('INSERT INTO audit_log (user_id, action, details, ip_address) VALUES (?,?,?,?)');
        $stmt->execute([$userId, $action, $details, $_SERVER['REMOTE_ADDR'] ?? null]);
    } catch (Throwable $e) {
        // Non-fatal
    }
}

/* =========================================================
 * UTIL
 * ========================================================= */

function e(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}