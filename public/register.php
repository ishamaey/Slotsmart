<?php
require_once __DIR__ . '/../includes/functions.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$err = null;
$success = null;
$debugLink = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $err = 'Invalid security token.';
    } else {
        $res = register_user(
            $_POST['username'] ?? '',
            $_POST['email'] ?? '',
            $_POST['password'] ?? '',
            $_POST['full_name'] ?? '',
            $_POST['role'] ?? 'faculty'
        );
        if ($res['ok']) {
            $success = $res['msg'];
            $debugLink = $res['debug_link'] ?? null;
        } else {
            $err = $res['msg'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — Slotsmart</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
tailwind.config = { theme: { extend: { colors: { plmun: { green:'#0B6623', greenDark:'#084B1A', gold:'#FFD700' } }, fontFamily:{sans:['Inter','sans-serif']} } } }
</script>
</head>
<body>
<div class="login-bg">
  <div class="login-card">
    <div class="mb-6 flex flex-col items-center w-full">
      <div class="logo-circle">
        <img src="../assets/img/logo.png" alt="Logo" class="logo-img"
             onerror="this.src='https://i.ibb.co/68036F5/slotsmart-logo.jpg'">
      </div>
      <h1 class="text-2xl font-extrabold text-plmun-green tracking-wider mb-1">CREATE ACCOUNT</h1>
      <p class="text-center text-xs text-gray-500 tracking-wide font-semibold uppercase">Slotsmart Registration</p>
    </div>

    <?php if ($err): ?>
      <div class="w-full mb-3 text-xs rounded-lg px-3 py-2 bg-red-100 text-red-800"><?= e($err) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="w-full mb-3 text-xs rounded-lg px-3 py-2 bg-emerald-100 text-emerald-800">
        <?= e($success) ?>
        <?php if ($debugLink): ?>
          <br><br><span class="font-mono break-all">Dev link: <a class="underline" href="<?= e($debugLink) ?>"><?= e($debugLink) ?></a></span>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form class="w-full" method="post">
      <?= csrf_field() ?>
      <div class="input-group">
        <label>Full Name</label>
        <i class="fa-solid fa-id-card input-icon"></i>
        <input type="text" name="full_name" class="input-field" required maxlength="120">
      </div>
      <div class="input-group">
        <label>Username</label>
        <i class="fa-solid fa-user input-icon"></i>
        <input type="text" name="username" class="input-field" required pattern="[A-Za-z0-9_]{3,50}">
      </div>
      <div class="input-group">
        <label>Email</label>
        <i class="fa-solid fa-envelope input-icon"></i>
        <input type="email" name="email" class="input-field" required maxlength="120">
      </div>
      <div class="input-group">
        <label>Password (min 8 chars)</label>
        <i class="fa-solid fa-lock input-icon"></i>
        <input type="password" name="password" class="input-field" required minlength="8">
      </div>
      <div class="input-group">
        <label>Role</label>
        <i class="fa-solid fa-user-shield input-icon"></i>
        <select name="role" class="input-field">
          <option value="faculty">Faculty</option>
          <option value="admin">Admin / Chair</option>
        </select>
      </div>
      <button type="submit" class="btn-login">
        <i class="fa-solid fa-user-plus mr-2"></i> Register
      </button>
    </form>
    <?php endif; ?>

    <p class="text-xs text-center text-gray-500 mt-4">
      Already registered? <a href="index.php" class="text-plmun-green font-bold hover:underline">Sign in</a>
    </p>
  </div>
</div>
</body>
</html>