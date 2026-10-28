<?php
require_once __DIR__ . '/functions.php';
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — Automated Hybrid Class Scheduling</title>

<link rel="stylesheet" href="<?= e(APP_URL) ?>/../assets/css/style.css">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
tailwind.config = {
  theme: { extend: {
    colors: {
      plmun: {
        green: '#0B6623', greenDark: '#084B1A', gold: '#FFD700',
        goldHover: '#E6C200', lightBg: '#F4F6F9', darkText: '#1E293B'
      }
    },
    fontFamily: { sans: ['Inter','sans-serif'] }
  }}
}
</script>
</head>
<body>