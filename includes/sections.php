<?php
// sections.php — renders all dashboard section blocks.
?>
<!-- DASHBOARD -->
<section id="section-dashboard" class="space-y-6">
    <div class="bg-gradient-to-r from-plmun-green to-emerald-800 rounded-xl p-5 text-white shadow-md flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold">Automated Hybrid Scheduling</h2>
            <p class="text-emerald-100 text-sm mt-1">School Year Curriculum (BSIT, BSCS, ACT) • <span id="dash-semester">1st Semester</span></p>
        </div>
        <button onclick="switchTab('engine')" class="bg-plmun-gold hover:bg-plmun-goldHover text-plmun-green font-bold px-4 py-2 rounded-lg text-sm shadow transition-all flex items-center space-x-2">
            <i class="fa-solid fa-bolt"></i><span>Launch Engine</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <p class="text-xs font-semibold text-gray-500 uppercase">Total Sections</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-sections">8 Sections</h3>
            <span class="text-xs text-emerald-600 font-medium flex items-center mt-1"><i class="fa-solid fa-check mr-1"></i> 3 Programs</span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <p class="text-xs font-semibold text-gray-500 uppercase">Conflicts</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-conflicts">0</h3>
            <span class="text-xs text-emerald-600 font-medium flex items-center mt-1"><i class="fa-solid fa-shield-check mr-1"></i> Validated</span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <p class="text-xs font-semibold text-gray-500 uppercase">Rooms Used</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1" id="stat-rooms">0 Rooms</h3>
            <span class="text-xs text-blue-600 font-medium flex items-center mt-1"><i class="fa-solid fa-door-open mr-1"></i> Active</span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <p class="text-xs font-semibold text-gray-500 uppercase">Hybrid Rule</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rotating</h3>
            <span class="text-xs text-amber-600 font-medium flex items-center mt-1"><i class="fa-solid fa-arrows-rotate mr-1"></i> IT/CS/ACT Sync</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Constraint Validation Log</h3>
            <div id="dashboard-log" class="space-y-2 text-xs text-gray-600 font-mono bg-gray-50 p-4 rounded-lg border h-48 overflow-y-auto">
                <p>Waiting for engine execution...</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Hybrid Modality Rule</h3>
            <div class="text-xs text-gray-600 space-y-2">
                <p class="font-semibold text-emerald-700"><i class="fa-solid fa-building mr-1"></i> On-Site:</p>
                <p>One program (e.g., BSIT) is assigned to physical rooms.</p>
                <p class="font-semibold text-blue-700 mt-3"><i class="fa-solid fa-laptop mr-1"></i> Online:</p>
                <p>Simultaneously, the other programs (BSCS, ACT) are assigned to virtual platforms (MS Teams/Canvas) for that same time block.</p>
                <p class="mt-2 text-[10px] text-gray-400 italic">*Lab courses remain On-Site for all programs.</p>
            </div>
        </div>
    </div>
</section>

<!-- SCHEDULE ENGINE -->
<section id="section-engine" class="space-y-6 hidden">
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 mb-6">
        <h3 class="font-bold text-lg text-gray-800 flex items-center mb-4">
            <i class="fa-solid fa-arrows-spin text-plmun-green mr-2"></i> Automated Scheduling Process
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <p class="text-emerald-700 font-bold text-sm mb-1">Step 1: Upload</p>
                <h4 class="font-bold text-gray-800 mb-2">Excel Data Drag & Drop</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Drop faculty, course, and room Excel files directly into the engine zone.</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <p class="text-emerald-700 font-bold text-sm mb-1">Step 2: Generate</p>
                <h4 class="font-bold text-gray-800 mb-2">Java Optimization Engine</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Run backtracking heuristic rules to produce a zero-conflict timetable.</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <p class="text-emerald-700 font-bold text-sm mb-1">Step 3: Export</p>
                <h4 class="font-bold text-gray-800 mb-2">Download Excel Schedule</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Preview the timetable grid and download formatted `.xlsx` output files.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6">
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <div>
                <h3 class="font-bold text-lg text-gray-800 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-plmun-green text-white text-xs flex items-center justify-center mr-2">1</span>
                    Excel Data Integration
                </h3>
                <p class="text-xs text-gray-500 mt-1">Upload raw Excel files containing Faculty teaching loads, Course specifications, and Room availability.</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 px-4 py-2 rounded-lg flex items-center space-x-3 shadow-sm">
                <label class="text-xs font-bold text-blue-800">Active Semester:</label>
                <select id="semester-selector" onchange="updateSemesterContext()" class="text-xs border border-blue-300 rounded p-1 text-blue-900 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="1" selected>1st Semester</option>
                    <option value="2">2nd Semester</option>
                </select>
                <span class="text-[10px] text-blue-600 font-medium bg-blue-100 px-2 py-0.5 rounded" id="semester-subject-count">7 Subjects</span>
            </div>
        </div>
        
        <div id="drag-drop-zone" 
             ondragover="handleDragOver(event)" 
             ondragleave="handleDragLeave(event)" 
             ondrop="handleFileDrop(event)" 
             class="border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center bg-white hover:bg-emerald-50/30 transition-all cursor-pointer group"
             onclick="document.getElementById('excel-file-input').click()">
            
            <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-[#dcfce7] text-[#15803d] rounded-2xl flex items-center justify-center text-3xl mb-4 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-lg mb-1">Drag & Drop Excel Source File Here (.xlsx, .xls)</h4>
                <p class="text-sm text-gray-500 mb-6">Contains sheets: Faculty, Courses, Rooms, Time Preferences</p>
                <button class="bg-[#0f6b2d] hover:bg-[#0b5221] text-white font-semibold text-sm px-6 py-2.5 rounded-lg shadow-sm transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-folder-open text-white/90"></i>
                    <span>Browse Computer Files</span>
                </button>
                <input type="file" id="excel-file-input" class="hidden" accept=".xlsx, .xls" onchange="handleFileSelect(event)">
            </div>
        </div>

        <div id="file-validation-badges" class="grid grid-cols-3 gap-4 mt-6 hidden">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                    <div>
                        <p class="font-bold">Faculty_Loads.xlsx</p>
                        <p class="text-[10px] text-emerald-600">8 Professors loaded</p>
                    </div>
                </div>
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            </div>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                    <div>
                        <p class="font-bold">Rooms_Capacity.xlsx</p>
                        <p class="text-[10px] text-emerald-600">8 Rooms mapped</p>
                    </div>
                </div>
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            </div>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-xl text-xs flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                    <div>
                        <p class="font-bold">Curriculum.xlsx</p>
                        <p class="text-[10px] text-emerald-600">14 Subjects parsed</p>
                    </div>
                </div>
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 mt-6">
        <h3 class="font-bold text-lg text-gray-800 flex items-center border-b pb-3 mb-4">
            <span class="w-6 h-6 rounded-full bg-plmun-green text-white text-xs flex items-center justify-center mr-2">2</span>
            Java Automated Processing
        </h3>
        
        <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-microchip text-3xl text-emerald-600"></i>
                <div>
                    <h4 class="font-bold text-gray-800">Constraint Satisfaction Engine</h4>
                    <p class="text-xs text-gray-500">Assigns faculty, rooms, and time slots. Enforces IT/CS/ACT rotating hybrid rule.</p>
                </div>
            </div>
            <button onclick="runJavaEngine()" id="btn-run" class="bg-plmun-green hover:bg-plmun-greenDark text-white font-bold px-6 py-3 rounded-xl shadow-md transition-all flex items-center space-x-2">
                <i class="fa-solid fa-play"></i><span>RUN SCHEDULER</span>
            </button>
        </div>

        <div id="engine-terminal" class="hidden mt-4 bg-gray-900 text-green-400 p-4 rounded-xl font-mono text-xs border border-gray-700 shadow-inner">
            <div class="flex justify-between text-gray-400 border-b border-gray-700 pb-2 mb-2">
                <span>[Slotsmart Java Engine Output]</span>
                <span id="engine-status" class="text-yellow-400 font-bold">Processing...</span>
            </div>
            <div id="terminal-logs" class="space-y-1 h-40 overflow-y-auto"></div>
            <div class="w-full bg-gray-800 rounded-full h-2 mt-3">
                <div id="engine-progress" class="bg-plmun-gold h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6 mt-6">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="font-bold text-lg text-gray-800 flex items-center">
                <span class="w-6 h-6 rounded-full bg-plmun-green text-white text-xs flex items-center justify-center mr-2">3</span>
                Generated Schedule Preview
            </h3>
            <div class="flex space-x-2">
                <select id="filter-modality" onchange="filterSchedule()" class="text-xs border border-gray-300 rounded-lg px-2 py-1">
                    <option value="all">All Modalities</option>
                    <option value="onsite">On-Site</option>
                    <option value="online">Online</option>
                    <option value="lab">Laboratory</option>
                </select>
                <button onclick="exportExcel()" class="bg-emerald-600 text-white text-xs px-3 py-1 rounded-lg font-bold"><i class="fa-solid fa-file-excel mr-1"></i> Excel</button>
                <button onclick="exportPDF()" class="bg-red-600 text-white text-xs px-3 py-1 rounded-lg font-bold"><i class="fa-solid fa-file-pdf mr-1"></i> PDF</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse border">
                <thead>
                    <tr class="bg-plmun-green text-white text-center">
                        <th class="p-2 border w-20">Time</th>
                        <th class="p-2 border">Monday</th>
                        <th class="p-2 border">Tuesday</th>
                        <th class="p-2 border">Wednesday</th>
                        <th class="p-2 border">Thursday</th>
                        <th class="p-2 border">Friday</th>
                        <th class="p-2 border">Saturday</th>
                    </tr>
                </thead>
                <tbody id="timetable-body">
                    <tr><td colspan="7" class="text-center p-4 text-gray-400">No schedule generated yet.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="flex mt-4 space-x-4 text-[10px]">
            <span class="flex items-center"><span class="w-2 h-2 bg-emerald-500 mr-1"></span> On-Site Lecture</span>
            <span class="flex items-center"><span class="w-2 h-2 bg-blue-500 mr-1"></span> Online (Sync)</span>
            <span class="flex items-center"><span class="w-2 h-2 bg-amber-500 mr-1"></span> Laboratory (On-Site)</span>
        </div>
    </div>
</section>

<!-- SETTINGS -->
<section id="section-settings" class="space-y-6 hidden">
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Engine Configuration</h2>
                <p class="text-xs text-gray-500 mt-1">Manage academic parameters, hybrid rules, faculty constraints, and Excel mappings for the Java Engine.</p>
            </div>
            <button onclick="saveSettings()" class="bg-plmun-green hover:bg-plmun-greenDark text-white font-bold px-6 py-2.5 rounded-lg text-xs shadow-md transition-all flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Configuration</span>
            </button>
        </div>

        <div class="flex space-x-6 border-b border-gray-200 mb-6 text-sm font-semibold text-gray-500 overflow-x-auto">
            <button onclick="switchSettingsTab('set-academic')" id="btn-set-academic" class="settings-tab-btn active text-plmun-green border-b-2 border-plmun-green pb-3 whitespace-nowrap"><i class="fa-solid fa-graduation-cap mr-2"></i>Academic Parameters</button>
            <button onclick="switchSettingsTab('set-hybrid')" id="btn-set-hybrid" class="settings-tab-btn text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap"><i class="fa-solid fa-network-wired mr-2"></i>Hybrid Rules</button>
            <button onclick="switchSettingsTab('set-faculty')" id="btn-set-faculty" class="settings-tab-btn text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap"><i class="fa-solid fa-user-clock mr-2"></i>Faculty Constraints</button>
            <button onclick="switchSettingsTab('set-excel')" id="btn-set-excel" class="settings-tab-btn text-gray-500 hover:text-gray-800 pb-3 whitespace-nowrap"><i class="fa-solid fa-table-columns mr-2"></i>Excel Mapping</button>
        </div>

        <div id="set-academic" class="settings-content space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Academic Year</label>
                    <input type="text" value="2026-2027" class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Active Semester</label>
                    <select class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                        <option selected>1st Semester</option>
                        <option>2nd Semester</option>
                        <option>Summer Term</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Daily Start Time</label>
                    <input type="time" value="07:00" class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Daily End Time</label>
                    <input type="time" value="19:00" class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-xs text-blue-800">
                <p class="font-bold mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Note:</p>
                <p>These parameters define the global time boundaries for the scheduling engine. Any class attempting to schedule outside these hours will be rejected by the Java Engine.</p>
            </div>
        </div>

        <div id="set-hybrid" class="settings-content space-y-6 hidden">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">On-Site Target Ratio (%)</label>
                <div class="flex items-center space-x-4">
                    <input type="range" min="0" max="100" value="60" class="w-full accent-plmun-green" oninput="document.getElementById('ratio-val').innerText = this.value + '% On-Site / ' + (100 - this.value) + '% Online'">
                    <span id="ratio-val" class="text-sm font-bold text-plmun-green w-48">60% On-Site / 40% Online</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" checked class="w-4 h-4 text-plmun-green rounded focus:ring-plmun-green">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Enforce IT/CS/ACT Rotating Modality</span>
                        <span class="block text-xs text-gray-500">When one program is On-Site, the others are automatically Online for that time block.</span>
                    </div>
                </label>
                <label class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" checked class="w-4 h-4 text-plmun-green rounded focus:ring-plmun-green">
                    <div>
                        <span class="block text-sm font-bold text-gray-800">Enforce Labs as 100% On-Site</span>
                        <span class="block text-xs text-gray-500">Laboratory courses (ITE101, ITE102) cannot be scheduled online.</span>
                    </div>
                </label>
            </div>
        </div>

        <div id="set-faculty" class="settings-content space-y-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Max Distinct Subjects per Professor</label>
                    <input type="number" value="2" min="1" max="5" class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Max Teaching Hours / Day</label>
                    <input type="number" value="6" min="2" max="12" class="w-full text-sm p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:border-plmun-green">
                </div>
            </div>
            <div class="mt-6 border-t pt-4">
                <h3 class="font-bold text-sm text-gray-800 mb-3 flex items-center">
                    <i class="fa-solid fa-clock mr-2 text-amber-600"></i> Part-Time Faculty Availability Registry
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse border">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="p-2 border">Faculty Name</th>
                                <th class="p-2 border">Status</th>
                                <th class="p-2 border">Available Days</th>
                                <th class="p-2 border">Available Time Slots</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2 border font-bold">Prof. J. Dela Cruz</td>
                                <td class="p-2 border text-amber-600 font-bold">Part-Time</td>
                                <td class="p-2 border">Mon / Wed / Fri</td>
                                <td class="p-2 border">07:00 AM - 01:00 PM</td>
                            </tr>
                            <tr>
                                <td class="p-2 border font-bold">Prof. M. Reyes</td>
                                <td class="p-2 border text-amber-600 font-bold">Part-Time</td>
                                <td class="p-2 border">Tue / Thu</td>
                                <td class="p-2 border">10:00 AM - 07:00 PM</td>
                            </tr>
                            <tr>
                                <td class="p-2 border font-bold">Prof. C. Bautista</td>
                                <td class="p-2 border text-amber-600 font-bold">Part-Time</td>
                                <td class="p-2 border">Mon / Wed / Fri</td>
                                <td class="p-2 border">01:00 PM - 07:00 PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="set-excel" class="settings-content space-y-6 hidden">
            <p class="text-xs text-gray-500 mb-4">Ensure the Java Engine correctly identifies spreadsheet columns. Modify these if your Excel template headers change.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h4 class="font-bold text-sm text-gray-800 mb-3 border-b pb-2">Faculty_Loads.xlsx</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Faculty Name Column</label>
                            <input type="text" value="Faculty_Name" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Max Units Column</label>
                            <input type="text" value="Max_Units" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Availability Column</label>
                            <input type="text" value="Time_Pref" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h4 class="font-bold text-sm text-gray-800 mb-3 border-b pb-2">Rooms_Capacity.xlsx</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Room Code Column</label>
                            <input type="text" value="Room_Name" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Capacity Column</label>
                            <input type="text" value="Seating_Capacity" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Room Type Column</label>
                            <input type="text" value="Room_Type" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h4 class="font-bold text-sm text-gray-800 mb-3 border-b pb-2">Curriculum.xlsx</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Subject Code Column</label>
                            <input type="text" value="Course_Code" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Is Laboratory Column</label>
                            <input type="text" value="Is_Lab" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-600 mb-1">Program Column</label>
                            <input type="text" value="Program" class="w-full text-xs p-2 border border-gray-300 rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MY SCHEDULE (FACULTY) -->
<section id="section-my-schedule" class="space-y-6 hidden">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-plmun-green text-plmun-gold rounded-full flex items-center justify-center text-2xl font-bold">DS</div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Dr. A. Santos</h2>
                <p class="text-sm text-gray-500">Associate Professor • Department of Computer Studies</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded border text-center">
                <p class="text-xs text-gray-500">Assigned Load</p>
                <p class="text-lg font-bold text-plmun-green" id="faculty-load-display">0 Units</p>
            </div>
            <div class="bg-gray-50 p-3 rounded border text-center">
                <p class="text-xs text-gray-500">On-Site Days</p>
                <p class="text-lg font-bold text-gray-800" id="faculty-onsite-display">0</p>
            </div>
            <div class="bg-gray-50 p-3 rounded border text-center">
                <p class="text-xs text-gray-500">Online Days</p>
                <p class="text-lg font-bold text-blue-600" id="faculty-online-display">0</p>
            </div>
        </div>
        
        <h3 class="font-bold text-gray-800 mb-2">My Timetable (<span id="faculty-semester-label">1st Semester</span>)</h3>
        <div class="overflow-x-auto border rounded-lg">
            <table class="w-full text-xs text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Time</th>
                        <th class="p-2 border">Monday</th>
                        <th class="p-2 border">Tuesday</th>
                        <th class="p-2 border">Wednesday</th>
                        <th class="p-2 border">Thursday</th>
                        <th class="p-2 border">Friday</th>
                        <th class="p-2 border">Saturday</th>
                    </tr>
                </thead>
                <tbody id="my-schedule-body">
                    <tr><td colspan="7" class="text-center p-4 text-gray-400">No schedule generated yet.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- DEPT SCHEDULE -->
<section id="section-dept-schedule" class="space-y-6 hidden">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Department Master Schedule (<span id="master-semester-label">1st Semester</span>)</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Subject</th>
                        <th class="p-2 border">Faculty</th>
                        <th class="p-2 border">Section</th>
                        <th class="p-2 border">Modality</th>
                        <th class="p-2 border">Room/Platform</th>
                        <th class="p-2 border">Day & Time</th>
                    </tr>
                </thead>
                <tbody id="master-schedule-body">
                    <tr><td colspan="6" class="text-center p-4 text-gray-400">No schedule generated yet.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>