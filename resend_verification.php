<?php
require_once __DIR__ . '/../includes/functions.php';

$msg = null; $err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $err = 'Invalid security token.';
    } else {
        $email = trim($_POST['email'] ?? '');
        if (resend_verification($email)) {
            $msg = 'If that email is registered and unverified, a new link has been sent.';
        } else {
            $msg = 'If that email is registered and unverified, a new link has been sent.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resend Verification — Slotsmart</title>
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
      <h1 class="text-xl font-extrabold text-plmun-green tracking-wider mb-1">RESEND VERIFICATION</h1>
    </div>
    <?php if ($err): ?><div class="w-full mb-3 text-xs rounded-lg px-3 py-2 bg-red-100 text-red-800"><?= e($err) ?></div><?php endif; ?>
    <?php if ($msg): ?><div class="w-full mb-3 text-xs rounded-lg px-3 py-2 bg-emerald-100 text-emerald-800"><?= e($msg) ?></div><?php endif; ?>

    <form method="post">
      <?= csrf_field() ?>
      <div class="input-group">
        <label>Registered Email</label>
        <i class="fa-solid fa-envelope input-icon"></i>
        <input type="email" name="email" class="input-field" required>
      </div>
      <button type="submit" class="btn-login"><i class="fa-solid fa-paper-plane mr-2"></i> Resend Link</button>
    </form>
    <p class="text-xs text-center text-gray-500 mt-4">
      <a href="index.php" class="text-plmun-green font-bold hover:underline">Back to Sign in</a>
    </p>
  </div>
</div>
</body>
</html>