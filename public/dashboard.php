<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();
$user = current_user();
$initials = $user['avatar_initials'] ?: strtoupper(substr($user['full_name'], 0, 2));
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Slotsmart — Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
tailwind.config = { theme: { extend: {
  colors: { plmun: { green:'#0B6623', greenDark:'#084B1A', gold:'#FFD700', goldHover:'#E6C200', lightBg:'#F4F6F9', darkText:'#1E293B' } },
  fontFamily:{sans:['Inter','sans-serif']}
} } }
</script>
</head>
<body class="app-view bg-plmun-lightBg">

<?php if ($flash): ?>
  <div class="fixed bottom-5 right-5 text-white text-xs px-4 py-3 rounded-xl shadow-xl z-[2000] toast-notify <?= $flash['type']==='error' ? 'bg-red-800' : 'bg-gray-900' ?>">
    <i class="fa-solid <?= $flash['type']==='error' ? 'fa-circle-exclamation text-red-300' : 'fa-circle-check text-plmun-gold' ?>"></i>
    <span><?= e(strip_tags($flash['msg'])) ?></span>
  </div>
<?php endif; ?>

<div id="mainApp" class="flex flex-col h-screen w-full">

  <!-- HEADER -->
  <header class="bg-plmun-green text-white px-6 py-3 flex items-center justify-between shadow-md z-20 flex-shrink-0">
    <div class="flex items-center space-x-4">
      <div class="logo-circle-header">
        <img src="../assets/img/logo.png" alt="Logo" class="logo-img"
             onerror="this.src='https://i.ibb.co/68036F5/slotsmart-logo.jpg'">
      </div>
      <div class="flex flex-col justify-center">
        <h1 class="text-xl font-bold leading-none tracking-widest text-white">SLOTSMART</h1>
        <p class="text-[11px] text-plmun-gold mt-1 font-medium">Pamantasan ng Lungsod ng Muntinlupa</p>
      </div>
    </div>

    <div class="hidden md:flex items-center space-x-6 text-sm">
      <div class="flex items-center space-x-2 bg-plmun-greenDark bg-opacity-60 px-3 py-1.5 rounded-lg border border-green-700">
        <i class="fa-solid fa-calendar-check text-plmun-gold"></i>
        <span>A.Y. 2026-2027 | <strong id="header-semester">1st Semester</strong></span>
      </div>
    </div>

    <div class="flex items-center space-x-4">
      <div class="flex items-center space-x-2 bg-white text-gray-800 rounded-lg p-1.5 shadow-sm border border-gray-200">
        <i class="fa-solid fa-user-gear text-plmun-green ml-2 text-xs"></i>
        <select id="role-switcher" onchange="switchRole(this.value)"
                class="text-sm font-semibold bg-transparent border-none text-gray-800 focus:outline-none cursor-pointer pr-2">
          <option value="admin" <?= $user['role']==='admin' ? 'selected' : '' ?>>Admin / Chair</option>
          <option value="faculty" <?= $user['role']==='faculty' ? 'selected' : '' ?>>Faculty</option>
        </select>
      </div>
      <div class="flex items-center space-x-2 border-l border-green-700 pl-4">
        <div class="w-8 h-8 rounded-full bg-plmun-gold text-plmun-green font-bold flex items-center justify-center text-xs shadow">
          <span id="user-avatar-text"><?= e($initials) ?></span>
        </div>
        <div class="hidden lg:block text-left text-xs">
          <div id="user-name" class="font-bold"><?= e($user['full_name']) ?></div>
          <div id="user-role-title" class="text-gray-300">
            <?= $user['role']==='admin' ? 'Program Head' : 'Associate Professor' ?>
          </div>
        </div>
      </div>
      <a href="logout.php" title="Logout" class="ml-2 text-plmun-gold hover:text-white transition-colors">
        <i class="fa-solid fa-right-from-bracket"></i>
      </a>
    </div>
  </header>

  <div class="flex flex-1 overflow-hidden relative">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between flex-shrink-0 z-10 shadow-sm">
      <div class="p-4 space-y-6">
        <div id="sidebar-role-badge" class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-xs flex items-center space-x-2 text-emerald-800 font-medium">
          <i class="fa-solid fa-shield-halved text-emerald-600 text-base"></i>
          <div>
            <span class="block font-bold uppercase tracking-wider text-[10px] text-emerald-600">Active View</span>
            <span id="active-role-text"><?= $user['role']==='admin' ? 'Program Head Mode' : 'Faculty Member Mode' ?></span>
          </div>
        </div>

        <nav id="nav-admin" class="space-y-1 <?= $user['role']==='admin' ? '' : 'hidden' ?>">
          <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-2">Management</div>
          <button onclick="switchTab('dashboard')" id="nav-dashboard" class="nav-btn active w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-plmun-green bg-emerald-50 border-l-4 border-plmun-green">
            <i class="fa-solid fa-chart-pie w-5"></i><span>Dashboard</span>
          </button>
          <button onclick="switchTab('engine')" id="nav-engine" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100">
            <i class="fa-solid fa-cogs w-5"></i><span>Schedule Engine</span>
          </button>
          <button onclick="switchTab('settings')" id="nav-settings" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100">
            <i class="fa-solid fa-sliders w-5"></i><span>System Settings</span>
          </button>
        </nav>

        <nav id="nav-faculty" class="space-y-1 <?= $user['role']==='faculty' ? '' : 'hidden' ?>">
          <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-3 mb-2">Faculty Portal</div>
          <button onclick="switchTab('my-schedule')" id="nav-my-schedule" class="nav-btn active w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-plmun-green bg-emerald-50 border-l-4 border-plmun-green">
            <i class="fa-solid fa-calendar-days w-5"></i><span>My Schedule</span>
          </button>
          <button onclick="switchTab('dept-schedule')" id="nav-dept-schedule" class="nav-btn w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100">
            <i class="fa-solid fa-table-list w-5"></i><span>Master Schedule</span>
          </button>
        </nav>
      </div>

      <div class="p-4 border-t border-gray-100 bg-gray-50 text-xs text-gray-500 space-y-2">
        <div class="flex items-center justify-between">
          <span>Java Engine:</span>
          <span class="flex items-center text-emerald-600 font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-1.5"></span> Ready
          </span>
        </div>
        <div class="flex items-center justify-between text-[11px]">
          <span>Conflicts:</span>
          <span id="sidebar-conflicts" class="text-gray-700 font-medium">0 Detected</span>
        </div>
        <div class="text-[10px] text-gray-400 border-t pt-2">
          User: <?= e($user['email']) ?>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto p-6">
      <?php
        // Pull the body HTML from the original file (sections only).
        include __DIR__ . '/../includes/sections.php';
      ?>
    </main>
  </div>
</div>

<script src="../assets/js/app.js"></script>
<script>
  // Initialize role on page load
  document.addEventListener('DOMContentLoaded', () => {
    const initialRole = '<?= e($user['role']) ?>';
    switchRole(initialRole);
  });
</script>
</body>
</html>