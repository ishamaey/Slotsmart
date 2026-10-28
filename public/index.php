<?php
require_once __DIR__ . '/../includes/functions.php';

if (is_logged_in()) { header('Location: dashboard.php'); exit; }

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $err = 'Invalid security token. Refresh and try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $res = attempt_login($username, $password);
        if ($res['ok']) {
            header('Location: dashboard.php');
            exit;
        }
        $err = $res['msg'];
    }
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — Slotsmart</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
tailwind.config = { theme: { extend: { colors: { plmun: { green:'#0B6623', greenDark:'#084B1A', gold:'#FFD700', goldHover:'#E6C200' } }, fontFamily:{sans:['Inter','sans-serif']} } } }
</script>
</head>
<body>
<div class="login-bg">
  <div class="login-card flex flex-col items-center">
    <div class="mb-6 flex flex-col items-center w-full">
      <div class="logo-circle">
        <img src="../assets/img/logo.png" alt="Logo" class="logo-img"
             onerror="this.src='https://i.ibb.co/68036F5/slotsmart-logo.jpg'">
      </div>
      <h1 class="text-2xl font-extrabold text-plmun-green tracking-wider mb-1">SLOTSMART</h1>
      <p class="text-center text-xs text-gray-500 tracking-wide font-semibold uppercase">Pamantasan ng Lungsod ng Muntinlupa</p>
    </div>

    <?php if ($flash): ?>
      <div class="w-full mb-3 text-xs rounded-lg px-3 py-2 <?= $flash['type']==='error' ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800' ?>">
        <?= e(strip_tags($flash['msg'])) ?>
      </div>
    <?php endif; ?>
    <?php if ($err): ?>
      <div class="w-full mb-3 text-xs rounded-lg px-3 py-2 bg-red-100 text-red-800">
        <?= e(strip_tags($err)) ?>
      </div>
    <?php endif; ?>

    <form class="w-full mt-2" method="post" autocomplete="on">
      <?= csrf_field() ?>
      <div class="input-group">
        <label>Username or Email</label>
        <i class="fa-solid fa-user input-icon"></i>
        <input type="text" name="username" id="loginUsername" class="input-field" placeholder="Enter username" required>
      </div>
      <div class="input-group">
        <label>Password</label>
        <i class="fa-solid fa-lock input-icon"></i>
        <input type="password" name="password" id="loginPassword" class="input-field" placeholder="Enter password" required>
      </div>
      <div class="flex items-center justify-between mb-4 px-1">
        <label class="flex items-center text-xs text-gray-600 cursor-pointer">
          <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-plmun-green focus:ring-plmun-green">
          Remember me
        </label>
        <a href="resend_verification.php" class="text-xs text-plmun-green font-semibold hover:underline">Resend verification?</a>
      </div>
      <button type="submit" class="btn-login">
        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Sign In
      </button>
    </form>

    <p class="text-xs text-center text-gray-500 mt-4">
      No account? <a href="register.php" class="text-plmun-green font-bold hover:underline">Register here</a>
    </p>

    <p class="text-[10px] text-center text-gray-400 mt-6">
      <i class="fa-solid fa-shield-halved text-emerald-500 mr-1"></i> Secured with Bcrypt + CSRF + Email Verification
    </p>
  </div>
</div>
</body>
</html>