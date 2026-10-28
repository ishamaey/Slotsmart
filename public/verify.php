<?php
require_once __DIR__ . '/../includes/functions.php';

$token = $_GET['token'] ?? '';
$ok = $token !== '' && verify_user($token);
set_flash($ok ? 'success' : 'error', $ok
    ? 'Email verified! You can now sign in.'
    : 'Invalid or expired verification link.');
header('Location: index.php');
exit;