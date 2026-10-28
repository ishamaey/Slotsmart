<?php
require_once __DIR__ . '/../includes/functions.php';
logout_user();
set_flash('success', 'You have been logged out.');
header('Location: index.php');
exit;