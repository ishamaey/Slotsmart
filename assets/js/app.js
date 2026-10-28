/**
 * Slotsmart Client-Side Logic
 * Handles: role switching, tab navigation, engine simulation, timetable rendering.
 */

const APP_STATE = {
  currentSemester: 1,
  generatedSchedule: [],
  conflictCount: 0,
  usedRoomsCount: 0,
};

const timeSlots = [
  { id: 'T1', label: '07:00-08:00' },
  { id: 'T2', label: '08:00-09:00' },
  { id: 'T3', label: '09:00-10:00' },
  { id: 'T4', label: '10:00-11:00' },
  { id: 'T5', label: '11:00-12:00' },
  { id: 'T6', label: '12:00-01:00' },
  { id: 'T7', label: '01:00-02:00' },
  { id: 'T8', label: '02:00-03:00' },
  { id: 'T9', label: '03:00-04:00' },
  { id: 'T10', label: '04:00-05:00' },
  { id: 'T11', label: '05:00-06:00' },
  { id: 'T12', label: '06:00-07:00' },
];
const days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

const curriculum = [
  { code: 'ITE101', desc: 'Intro to Computing',   units: 3, sem: 1, program: 'BSIT' },
  { code: 'ITE102', desc: 'Computer Programming 1', units: 3, sem: 1, program: 'BSIT' },
  { code: 'ITE103', desc: 'Discrete Mathematics',  units: 3, sem: 1, program: 'BSCS' },
  { code: 'ITE104', desc: 'Data Structures',        units: 3, sem: 1, program: 'BSCS' },
  { code: 'ACT101', desc: 'Accounting Basics',      units: 3, sem: 1, program: 'ACT'  },
  { code: 'ACT102', desc: 'Business Math',          units: 3, sem: 1, program: 'ACT'  },
  { code: 'ITE105', desc: 'Networking 1',           units: 3, sem: 2, program: 'BSIT' },
  { code: 'ITE106', desc: 'Web Development',        units: 3, sem: 2, program: 'BSCS' },
  { code: 'ITE107', desc: 'Database Management',    units: 3, sem: 2, program: 'BSCS' },
  { code: 'ACT103', desc: 'Financial Accounting',   units: 3, sem: 2, program: 'ACT'  },
  { code: 'ACT104', desc: 'Business Law',           units: 3, sem: 2, program: 'ACT'  },
  { code: 'ITE108', desc: 'Software Engineering',   units: 3, sem: 2, program: 'BSIT' },
  { code: 'ITE109', desc: 'Cybersecurity Basics',   units: 3, sem: 2, program: 'BSIT' },
  { code: 'ACT105', desc: 'Taxation',               units: 3, sem: 2, program: 'ACT'  },
];

const faculty = [
  { id: 'F01', name: 'Dr. A. Santos' },
  { id: 'F02', name: 'Engr. R. Garcia' },
  { id: 'F03', name: 'Prof. J. Dela Cruz' },
  { id: 'F04', name: 'Prof. M. Reyes' },
  { id: 'F05', name: 'Prof. C. Bautista' },
  { id: 'F06', name: 'Prof. L. Villanueva' },
  { id: 'F07', name: 'Prof. T. Fernandez' },
  { id: 'F08', name: 'Prof. K. Aquino' },
];

const rooms = [
  { id: 'R1', name: 'Lab 301',  type: 'lab' },
  { id: 'R2', name: 'Lab 302',  type: 'lab' },
  { id: 'R3', name: 'Room 201', type: 'lecture' },
  { id: 'R4', name: 'Room 202', type: 'lecture' },
  { id: 'R5', name: 'Room 203', type: 'lecture' },
  { id: 'R6', name: 'Room 204', type: 'lecture' },
  { id: 'R7', name: 'Online - MS Teams' },
  { id: 'R8', name: 'Online - Canvas' },
];

const sections = [
  { id: 'BSIT-1A', program: 'BSIT' },
  { id: 'BSIT-1B', program: 'BSIT' },
  { id: 'BSCS-1A', program: 'BSCS' },
  { id: 'BSCS-1B', program: 'BSCS' },
  { id: 'ACT-1A',  program: 'ACT'  },
  { id: 'ACT-1B',  program: 'ACT'  },
  { id: 'BSIT-2A', program: 'BSIT' },
  { id: 'BSCS-2A', program: 'BSCS' },
];

/* =========================================================
 * UI HELPERS
 * ========================================================= */

function showToast(msg, isError = false) {
  const toast = document.createElement('div');
  toast.className = `fixed bottom-5 right-5 text-white text-xs px-4 py-3 rounded-xl shadow-xl z-[2000] flex items-center space-x-2 toast-notify ${isError ? 'bg-red-800' : 'bg-gray-900'}`;
  toast.innerHTML = `<i class="fa-solid ${isError ? 'fa-circle-exclamation text-red-300' : 'fa-circle-check text-plmun-gold'}"></i><span>${msg}</span>`;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

function switchRole(role) {
  const navAdmin = document.getElementById('nav-admin');
  const navFaculty = document.getElementById('nav-faculty');
  const activeRoleText = document.getElementById('active-role-text');
  const userName = document.getElementById('user-name');
  const userRoleTitle = document.getElementById('user-role-title');
  const userAvatarText = document.getElementById('user-avatar-text');
  if (!navAdmin || !navFaculty) return;

  if (role === 'admin') {
    navAdmin.classList.remove('hidden');
    navFaculty.classList.add('hidden');
    if (activeRoleText) activeRoleText.innerText = 'Program Head Mode';
    if (userName) userName.innerText = 'Dr. A. Santos';
    if (userRoleTitle) userRoleTitle.innerText = 'Program Head';
    if (userAvatarText) userAvatarText.innerText = 'DC';
    switchTab('dashboard');
  } else {
    navAdmin.classList.add('hidden');
    navFaculty.classList.remove('hidden');
    if (activeRoleText) activeRoleText.innerText = 'Faculty Member Mode';
    if (userName) userName.innerText = 'Dr. A. Santos';
    if (userRoleTitle) userRoleTitle.innerText = 'Associate Professor';
    if (userAvatarText) userAvatarText.innerText = 'AS';
    switchTab('my-schedule');
  }
}

function switchTab(tabId) {
  const sections = ['dashboard','engine','settings','my-schedule','dept-schedule'];
  sections.forEach(s => {
    const el = document.getElementById('section-' + s);
    if (el) el.classList.add('hidden');
  });
  const target = document.getElementById('section-' + tabId);
  if (target) target.classList.remove('hidden');

  document.querySelectorAll('.nav-btn').forEach(btn => {
    btn.classList.remove('active','text-plmun-green','bg-emerald-50','border-l-4','border-plmun-green');
    btn.classList.add('text-gray-600');
  });
  const activeBtn = document.getElementById('nav-' + tabId);
  if (activeBtn) {
    activeBtn.classList.add('active','text-plmun-green','bg-emerald-50','border-l-4','border-plmun-green');
    activeBtn.classList.remove('text-gray-600');
  }
}

function switchSettingsTab(tabId) {
  document.querySelectorAll('.settings-content').forEach(c => c.classList.add('hidden'));
  document.querySelectorAll('.settings-tab-btn').forEach(b => {
    b.classList.remove('active','text-plmun-green','border-b-2','border-plmun-green');
    b.classList.add('text-gray-500');
  });
  const el = document.getElementById(tabId);
  if (el) el.classList.remove('hidden');
  const activeBtn = document.getElementById('btn-' + tabId);
  if (activeBtn) {
    activeBtn.classList.add('active','text-plmun-green','border-b-2','border-plmun-green');
    activeBtn.classList.remove('text-gray-500');
  }
}

function updateSemesterContext() {
  APP_STATE.currentSemester = parseInt(document.getElementById('semester-selector').value, 10);
  const semLabel = APP_STATE.currentSemester === 1 ? '1st Semester' : '2nd Semester';
  ['header-semester','dash-semester','faculty-semester-label','master-semester-label']
    .forEach(id => { const el = document.getElementById(id); if (el) el.innerText = semLabel; });

  const count = curriculum.filter(c => c.sem === APP_STATE.currentSemester).length;
  const sc = document.getElementById('semester-subject-count');
  if (sc) sc.innerText = `${count} Subjects`;

  APP_STATE.generatedSchedule = [];
  APP_STATE.conflictCount = 0;
  APP_STATE.usedRoomsCount = 0;
  updateUIAfterEngine(true);
  showToast(`Switched context to ${semLabel}`);
}

function handleDragOver(e) {
  e.preventDefault();
  const dz = document.getElementById('drag-drop-zone');
  if (dz) dz.classList.add('drag-over');
}

function handleDragLeave(e) {
  e.preventDefault();
  const dz = document.getElementById('drag-drop-zone');
  if (dz) dz.classList.remove('drag-over');
}

function handleFileDrop(e) {
  e.preventDefault();
  const dz = document.getElementById('drag-drop-zone');
  if (dz) dz.classList.remove('drag-over');
  simulateFileUpload();
}

function handleFileSelect(e) {
  if (e.target.files.length > 0) simulateFileUpload();
}

function simulateFileUpload() {
  const badges = document.getElementById('file-validation-badges');
  const dropZone = document.getElementById('drag-drop-zone');
  if (!dropZone) return;
  const originalHTML = dropZone.innerHTML;
  dropZone.innerHTML = `<div class="flex flex-col items-center justify-center py-8">
    <i class="fa-solid fa-spinner fa-spin text-4xl text-emerald-600 mb-4"></i>
    <p class="text-emerald-800 font-bold">Parsing Excel Data...</p>
  </div>`;
  setTimeout(() => {
    dropZone.innerHTML = originalHTML;
    dropZone.classList.add('bg-emerald-50','border-emerald-300');
    if (badges) badges.classList.remove('hidden');
    showToast('Excel data parsed successfully.');
  }, 1000);
}

/* =========================================================
 * ENGINE SIMULATION (client-side)
 * ========================================================= */

function runJavaEngine() {
  const btn = document.getElementById('btn-run');
  const terminal = document.getElementById('engine-terminal');
  const logs = document.getElementById('terminal-logs');
  const status = document.getElementById('engine-status');
  const progress = document.getElementById('engine-progress');

  if (!btn || !terminal) return;
  btn.disabled = true;
  terminal.classList.remove('hidden');
  logs.innerHTML = '';
  status.innerText = 'Processing...';
  status.className = 'text-yellow-400 font-bold';
  progress.style.width = '0%';

  const steps = [
    'Loading faculty loads...',
    'Loading room capacities...',
    'Loading curriculum...',
    'Validating constraints...',
    'Applying hybrid modality rule...',
    'Backtracking search...',
    'Finalizing timetable...',
  ];

  let i = 0;
  const iv = setInterval(() => {
    if (i < steps.length) {
      logs.innerHTML += `<div>› ${steps[i]}</div>`;
      logs.scrollTop = logs.scrollHeight;
      progress.style.width = Math.round(((i + 1) / (steps.length + 1)) * 100) + '%';
      i++;
    } else {
      clearInterval(iv);
      generateSchedule();
      progress.style.width = '100%';
      status.innerText = 'Completed';
      status.className = 'text-emerald-400 font-bold';
      logs.innerHTML += `<div class="text-emerald-400">✓ Scheduling complete. ${APP_STATE.conflictCount} conflict(s).</div>`;
      logs.scrollTop = logs.scrollHeight;
      btn.disabled = false;
      showToast('Schedule generated successfully.');
    }
  }, 350);
}

function generateSchedule() {
  const semSubjects = curriculum.filter(c => c.sem === APP_STATE.currentSemester);
  const scheduled = [];
  const occupancy = {}; // room -> {day -> {slotId -> true}}
  const facultyLoad = {}; // facultyId -> subject set

  // Hybrid rotation: BSIT onsite, BSCS/ACT online in same slot
  const rotation = ['BSIT', 'BSCS', 'ACT'];

  semSubjects.forEach((subj, idx) => {
    const availableSections = sections.filter(s => s.program === subj.program);
    availableSections.forEach((section, sIdx) => {
      // pick faculty (round robin)
      const fac = faculty[(idx + sIdx) % faculty.length];
      facultyLoad[fac.id] = facultyLoad[fac.id] || new Set();

      // pick 2 time slots per subject
      let placed = 0;
      const day = days[(idx + sIdx) % days.length];

      for (const slot of timeSlots) {
        if (placed >= 2) break;
        const modality = rotation[placed % rotation.length] === subj.program ? 'On-Site' : 'Online';
        const roomId = modality === 'Online' ? (subj.program === 'BSIT' ? 'R7' : 'R8') : rooms[(idx + sIdx + placed) % 5].id;
        const room = rooms.find(r => r.id === roomId);

        scheduled.push({
          subject: subj,
          faculty: fac,
          section,
          day,
          slot,
          modality,
          room: room || { id: 'R7', name: 'Online' },
        });
        placed++;
      }
    });
  });

  APP_STATE.generatedSchedule = scheduled;
  APP_STATE.conflictCount = 0;
  APP_STATE.usedRoomsCount = new Set(scheduled.map(s => s.room.id)).size;
  updateUIAfterEngine(false);
}

function updateUIAfterEngine(isClear = false) {
  const semLabel = APP_STATE.currentSemester === 1 ? '1st Semester' : '2nd Semester';

  if (isClear) {
    const pairs = [
      ['stat-sections', '0 Classes'],
      ['stat-conflicts', '0'],
      ['stat-rooms', '0 Rooms'],
      ['sidebar-conflicts', '0 Detected'],
    ];
    pairs.forEach(([id, v]) => { const el = document.getElementById(id); if (el) el.innerText = v; });
    const dlog = document.getElementById('dashboard-log');
    if (dlog) dlog.innerHTML = `<p>Ready to schedule for ${semLabel}.</p>`;
    const tb = document.getElementById('timetable-body');
    if (tb) tb.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-gray-400">No schedule generated yet for ${semLabel}.</td></tr>`;
    const mb = document.getElementById('my-schedule-body');
    if (mb) mb.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-gray-400">No schedule generated yet for ${semLabel}.</td></tr>`;
    const mb2 = document.getElementById('master-schedule-body');
    if (mb2) mb2.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-gray-400">No schedule generated yet for ${semLabel}.</td></tr>`;
    return;
  }

  const n = APP_STATE.generatedSchedule.length;
  setText('stat-sections', `${n} Classes`);
  setText('stat-conflicts', String(APP_STATE.conflictCount));
  setText('stat-rooms', `${APP_STATE.usedRoomsCount} Rooms`);
  setText('sidebar-conflicts', `${APP_STATE.conflictCount} Detected`);

  const dashLog = document.getElementById('dashboard-log');
  if (dashLog) {
    dashLog.innerHTML = APP_STATE.conflictCount === 0
      ? `<p class="text-emerald-600 font-bold"><i class="fa-solid fa-check"></i> Engine run successful for ${semLabel}. 0 conflicts found.</p>
         <p>Allocated ${n} class sessions. IT/CS/ACT rotating modality applied.</p>`
      : `<p class="text-red-600 font-bold"><i class="fa-solid fa-xmark"></i> ${APP_STATE.conflictCount} conflicts detected for ${semLabel}.</p>`;
  }

  // Timetable grid
  const tbody = document.getElementById('timetable-body');
  if (tbody) {
    tbody.innerHTML = '';
    timeSlots.forEach(slot => {
      let row = `<tr><td class="p-2 border font-bold bg-gray-50 text-center">${slot.label}</td>`;
      days.forEach(day => {
        const classes = APP_STATE.generatedSchedule.filter(c => c.day === day && c.slot.id === slot.id);
        let cell = '';
        classes.forEach(c => {
          const cls = c.modality === 'Online'
            ? 'bg-blue-50 border-blue-500 text-blue-900'
            : (c.modality === 'Lab'
              ? 'bg-amber-50 border-amber-500 text-amber-900'
              : 'bg-emerald-50 border-emerald-500 text-emerald-900');
          cell += `<div class="card-item card-${c.modality.toLowerCase().replace('-','')} ${cls} border-l-4 p-1.5 rounded mb-1 text-[10px] shadow-sm">
            <div class="flex justify-between font-bold"><span>${c.subject.code}</span><span>${c.modality === 'Online' ? 'ONL' : (c.modality === 'Lab' ? 'LAB' : 'ONS')}</span></div>
            <div class="mt-0.5">${c.section.id}</div>
            <div class="text-gray-600">${c.faculty.name.split(' ').pop()} | ${c.room.name}</div>
          </div>`;
        });
        if (!cell) cell = '<div class="text-center text-gray-300 text-[10px] py-2">-</div>';
        row += `<td class="p-1 border align-top w-[14%]">${cell}</td>`;
      });
      row += `</tr>`;
      tbody.innerHTML += row;
    });
  }

  // Faculty
  const myTbody = document.getElementById('my-schedule-body');
  if (myTbody) {
    myTbody.innerHTML = '';
    const myClasses = APP_STATE.generatedSchedule.filter(c => c.faculty.id === 'F01');
    timeSlots.forEach(slot => {
      let row = `<tr><td class="p-2 border font-bold bg-gray-50 text-center">${slot.label}</td>`;
      days.forEach(day => {
        const classes = myClasses.filter(c => c.day === day && c.slot.id === slot.id);
        let cell = '';
        classes.forEach(c => {
          cell += `<div class="border-l-4 border-plmun-green bg-emerald-50 p-1.5 rounded text-[10px] shadow-sm mb-1">
            <div class="font-bold text-emerald-900">${c.subject.code} - ${c.subject.desc}</div>
            <div class="text-gray-700">${c.section.id} | ${c.room.name}</div>
          </div>`;
        });
        if (!cell) cell = '<div class="text-center text-gray-300 text-[10px] py-2">-</div>';
        row += `<td class="p-1 border align-top w-[14%]">${cell}</td>`;
      });
      row += `</tr>`;
      myTbody.innerHTML += row;
    });

    const units = myClasses.reduce((s, c) => s + c.subject.units, 0);
    setText('faculty-load-display', units + ' Units');
    const onsiteDays = [...new Set(myClasses.filter(c => c.modality !== 'Online').map(c => c.day))].length;
    const onlineDays = [...new Set(myClasses.filter(c => c.modality === 'Online').map(c => c.day))].length;
    setText('faculty-onsite-display', String(onsiteDays));
    setText('faculty-online-display', String(onlineDays));
  }

  // Master schedule
  const masterTbody = document.getElementById('master-schedule-body');
  if (masterTbody) {
    masterTbody.innerHTML = '';
    [...APP_STATE.generatedSchedule]
      .sort((a, b) => a.subject.code.localeCompare(b.subject.code))
      .forEach(c => {
        const badge = c.modality === 'Online'
          ? 'bg-blue-100 text-blue-800'
          : (c.modality === 'Lab' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800');
        masterTbody.innerHTML += `<tr class="hover:bg-gray-50">
          <td class="p-2 border font-bold">${c.subject.code} - ${c.subject.desc}</td>
          <td class="p-2 border">${c.faculty.name}</td>
          <td class="p-2 border">${c.section.id}</td>
          <td class="p-2 border"><span class="${badge} px-2 py-0.5 rounded font-bold text-[10px]">${c.modality}</span></td>
          <td class="p-2 border">${c.room.name}</td>
          <td class="p-2 border">${c.day} ${c.slot.label}</td>
        </tr>`;
      });
  }
}

function setText(id, v) { const el = document.getElementById(id); if (el) el.innerText = v; }

function filterSchedule() {
  const filter = document.getElementById('filter-modality').value;
  document.querySelectorAll('.card-item').forEach(card => {
    card.style.display = (filter === 'all' || card.classList.contains(`card-${filter}`)) ? 'block' : 'none';
  });
}

function exportExcel() {
  if (APP_STATE.generatedSchedule.length === 0) return showToast('Please run the engine first.', true);
  showToast('Generating Excel file... (Simulated)');
  setTimeout(() => showToast(`Schedule_${APP_STATE.currentSemester === 1 ? '1stSem' : '2ndSem'}_Hybrid.xlsx downloaded.`), 1000);
}

function exportPDF() {
  if (APP_STATE.generatedSchedule.length === 0) return showToast('Please run the engine first.', true);
  showToast('Generating PDF file... (Simulated)');
  setTimeout(() => showToast(`Schedule_${APP_STATE.currentSemester === 1 ? '1stSem' : '2ndSem'}_Hybrid.pdf downloaded.`), 1000);
}

function saveSettings() {
  showToast('Engine Configuration Saved! Applying rules...');
  APP_STATE.generatedSchedule = [];
  APP_STATE.conflictCount = 0;
  APP_STATE.usedRoomsCount = 0;
  updateUIAfterEngine(true);
}

/* Auto-init on dashboard page */
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('semester-selector')) {
    updateSemesterContext();
  }
});