<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>UNIPULSE — Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg: #ffffff;
    --bg-2: #f7f7f5;
    --bg-3: #f1efe8;
    --text-1: #1a1a18;
    --text-2: #5f5e5a;
    --text-3: #b4b2a9;
    --border: rgba(0,0,0,0.12);
    --border-2: rgba(0,0,0,0.22);
    --purple-50: #EEEDFE;
    --purple-200: #AFA9EC;
    --purple-400: #7F77DD;
    --purple-600: #534AB7;
    --purple-800: #3C3489;
    --teal-50: #E1F5EE;
    --teal-400: #1D9E75;
    --teal-600: #0F6E56;
    --amber-50: #FAEEDA;
    --amber-400: #EF9F27;
    --amber-800: #854F0B;
    --red-50: #FCEBEB;
    --red-400: #E24B4A;
    --red-600: #A32D2D;
    --green-50: #E1F5EE;
    --green-600: #0F6E56;
    --r-md: 8px;
    --r-lg: 12px;
  }

  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #1c1c1a;
      --bg-2: #242422;
      --bg-3: #2c2c2a;
      --text-1: #f1efe8;
      --text-2: #b4b2a9;
      --text-3: #5f5e5a;
      --border: rgba(255,255,255,0.10);
      --border-2: rgba(255,255,255,0.18);
    }
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
    background: var(--bg-3);
    color: var(--text-1);
    min-height: 100vh;
    padding: 1.5rem;
  }

  /* ── top bar ── */
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
  }
  .wordmark {
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 2px;
    color: var(--text-3);
  }
  .wordmark b { color: var(--text-1); font-weight: 500; }
  .hright { display: flex; align-items: center; gap: 10px; }
  .date-pill {
    font-size: 12px;
    color: var(--text-2);
    border: 0.5px solid var(--border);
    border-radius: 20px;
    padding: 4px 12px;
    background: var(--bg);
  }
  .notif-btn {
    width: 28px; height: 28px;
    border-radius: var(--r-md);
    border: 0.5px solid var(--border);
    background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: var(--text-2);
  }

  /* ── main shell ── */
  .body-grid {
    display: grid;
    grid-template-columns: 180px 1fr;
    border: 0.5px solid var(--border);
    border-radius: var(--r-lg);
    overflow: hidden;
    background: var(--bg);
  }

  /* ── sidebar ── */
  .sidenav {
    border-right: 0.5px solid var(--border);
    padding: 16px 0;
    background: var(--bg);
  }
  .nav-profile {
    padding: 0 16px 14px;
    border-bottom: 0.5px solid var(--border);
    margin-bottom: 10px;
  }
  .av {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--purple-50);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 500; color: var(--purple-600);
    margin-bottom: 8px;
  }
  .nav-name { font-size: 13px; font-weight: 500; color: var(--text-1); }
  .nav-sub { font-size: 11px; color: var(--text-3); }

  .nav-sec-label {
    display: block;
    font-size: 10px;
    color: var(--text-3);
    letter-spacing: 0.8px;
    padding: 8px 16px 3px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 10px;
    margin: 0 6px;
    border-radius: var(--r-md);
    font-size: 12px;
    color: var(--text-2);
    cursor: pointer;
    transition: background 0.12s;
  }
  .nav-item:hover { background: var(--bg-2); }
  .nav-item.active { background: var(--purple-50); color: var(--purple-600); font-weight: 500; }
  .nav-item i { font-size: 15px; }
  .nav-badge {
    margin-left: auto;
    font-size: 10px;
    padding: 1px 7px;
    border-radius: 20px;
  }
  .nav-badge.red { background: var(--red-50); color: var(--red-600); }
  .nav-badge.green { background: var(--green-50); color: var(--green-600); }

  /* ── stat strip ── */
  .main { background: var(--bg); }
  .stat-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-bottom: 0.5px solid var(--border);
  }
  .stat {
    padding: 14px 16px;
    border-right: 0.5px solid var(--border);
  }
  .stat:last-child { border-right: none; }
  .stat-lbl { font-size: 11px; color: var(--text-3); margin-bottom: 4px; }
  .stat-num { font-size: 20px; font-weight: 500; color: var(--text-1); }
  .stat-note { font-size: 11px; color: var(--text-2); margin-top: 2px; }
  .stat-note.green { color: var(--teal-600); }
  .stat-note.red { color: var(--red-600); }

  /* ── two-col body ── */
  .main-body { display: grid; grid-template-columns: 1fr 220px; }

  /* ── timeline ── */
  .timeline-area {
    border-right: 0.5px solid var(--border);
    padding: 16px;
  }
  .tl-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
  }
  .tl-title { font-size: 13px; font-weight: 500; color: var(--text-1); }
  .tl-days { display: flex; gap: 4px; }
  .tl-day {
    font-size: 11px; padding: 3px 10px; border-radius: 20px;
    border: 0.5px solid var(--border); color: var(--text-2);
    cursor: pointer; background: transparent; transition: background 0.12s;
  }
  .tl-day:hover { background: var(--bg-2); }
  .tl-day.active {
    background: var(--purple-50);
    border-color: var(--purple-200);
    color: var(--purple-600);
    font-weight: 500;
  }

  .timeline { display: flex; flex-direction: column; gap: 2px; }

  .tl-hour { display: flex; align-items: flex-start; gap: 10px; min-height: 36px; }
  .tl-time {
    font-size: 10px; color: var(--text-3);
    width: 32px; padding-top: 4px; text-align: right; flex-shrink: 0;
  }
  .tl-line {
    width: 0.5px; background: var(--border);
    align-self: stretch; flex-shrink: 0; margin-top: 8px;
  }
  .tl-slot { flex: 1; display: flex; gap: 4px; align-items: flex-start; padding: 2px 0; }
  .tl-block {
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 11px; font-weight: 500; flex: 1;
  }
  .tl-block.class {
    background: var(--purple-50); color: var(--purple-600);
    border-left: 2px solid var(--purple-400); border-radius: 0 6px 6px 0;
  }
  .tl-block.study {
    background: var(--amber-50); color: var(--amber-800);
    border-left: 2px solid var(--amber-400); border-radius: 0 6px 6px 0;
  }
  .tl-block.free {
    background: var(--bg-2); color: var(--text-2);
    border: 0.5px dashed var(--border-2); border-radius: 6px;
  }
  .tl-block.test {
    background: var(--red-50); color: var(--red-600);
    border-left: 2px solid var(--red-400); border-radius: 0 6px 6px 0;
  }
  .tl-block.break {
    background: var(--teal-50); color: var(--teal-600);
    border-left: 2px solid var(--teal-400); border-radius: 0 6px 6px 0;
  }
  .tl-block-name { font-weight: 500; }
  .tl-block-sub { font-size: 10px; opacity: 0.75; margin-top: 1px; }

  /* ── right column ── */
  .right-col { padding: 16px; display: flex; flex-direction: column; gap: 16px; }
  .rc-title {
    font-size: 12px; font-weight: 500; color: var(--text-1);
    margin-bottom: 8px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .rc-title span { font-size: 11px; font-weight: 400; color: var(--text-3); }

  /* mood */
  .mood-chips { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 7px; }
  .mood-chip {
    font-size: 11px; padding: 4px 10px; border-radius: 20px;
    border: 0.5px solid var(--border); color: var(--text-2);
    cursor: pointer; background: var(--bg-2);
    transition: background 0.12s;
  }
  .mood-chip:hover { background: var(--purple-50); border-color: var(--purple-200); color: var(--purple-600); }
  .mood-chip.sel { background: var(--purple-50); border-color: var(--purple-200); color: var(--purple-600); }

  /* tasks */
  .task-row {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 0;
    border-bottom: 0.5px solid var(--border);
  }
  .task-row:last-of-type { border-bottom: none; }
  .tname { font-size: 12px; flex: 1; color: var(--text-1); }
  .ttag { font-size: 10px; padding: 2px 7px; border-radius: 10px; }
  .ttag.red { background: var(--red-50); color: var(--red-600); }
  .ttag.amber { background: var(--amber-50); color: var(--amber-800); }
  .ttag.green { background: var(--green-50); color: var(--green-600); }

  /* wellness */
  .well-row { display: flex; align-items: center; gap: 8px; padding: 5px 0; }
  .well-label { font-size: 11px; color: var(--text-2); width: 48px; flex-shrink: 0; }
  .well-bar {
    flex: 1; height: 4px; background: var(--bg-2);
    border-radius: 2px; overflow: hidden;
  }
  .well-fill { height: 100%; border-radius: 2px; }
  .well-val { font-size: 11px; color: var(--text-2); width: 28px; text-align: right; }
</style>
</head>
<body>

<div class="header">
  <div class="wordmark">UNI<b>PULSE</b></div>
  <div class="hright">
    <span class="date-pill">
      <i class="ti ti-calendar" style="font-size:12px;vertical-align:-1px;margin-right:4px"></i>Wednesday, Jun 4
    </span>
    <button class="notif-btn" aria-label="Notifications">
      <i class="ti ti-bell" style="font-size:14px"></i>
    </button>
  </div>
</div>

<div class="body-grid">

  <nav class="sidenav">
    <div class="nav-profile">
      <div class="av">AK</div>
      <div class="nav-name">Loading...</div>
      <div class="nav-sub">---</div>
    </div>

    <span class="nav-sec-label">OVERVIEW</span>
    <div class="nav-item active" data-target="page-dashboard"><i class="ti ti-layout-dashboard"></i> Dashboard</div>
    <div class="nav-item" data-target="page-schedule"><i class="ti ti-calendar"></i> Schedule</div>
    <div class="nav-item" data-target="page-tasks"><i class="ti ti-checklist"></i> Tasks <span class="nav-badge red">0</span></div>

    <span class="nav-sec-label">WELLBEING</span>
    <div class="nav-item" data-target="page-mood"><i class="ti ti-mood-smile"></i> Mood</div>
  </nav>

  <main class="main">
    <div class="stat-strip">
      <div class="stat">
        <div class="stat-lbl">Free time today</div>
        <div class="stat-num" id="stat-free-time">0h</div>
        <div class="stat-note green">Calculating...</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Tasks due</div>
        <div class="stat-num" id="stat-tasks-due">0</div>
        <div class="stat-note red">Active</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Next deadline</div>
        <div class="stat-num" style="font-size:14px;padding-top:3px;" id="stat-next-deadline">None</div>
        <div class="stat-note red">-</div>
      </div>
      <div class="stat">
        <div class="stat-lbl">Wellness score</div>
        <div class="stat-num" id="stat-wellness-score">--%</div>
        <div class="stat-note">Syncing...</div>
      </div>
    </div>

    <div id="page-dashboard" class="page-view">
      <div class="main-body">
        <div class="timeline-area">
          <div class="tl-header">
            <span class="tl-title">Today's timeline</span>
            <div class="tl-days">
              <button class="tl-day">Mon</button>
              <button class="tl-day">Tue</button>
              <button class="tl-day active">Wed</button>
              <button class="tl-day">Thu</button>
              <button class="tl-day">Fri</button>
            </div>
          </div>
          <div class="timeline" id="timeline-container"></div>
        </div>

        <div class="right-col">
          <div>
            <div class="rc-title">Mood check-in <span>today</span></div>
            <div class="mood-chips">
              <span class="mood-chip">Great</span>
              <span class="mood-chip">Good</span>
              <span class="mood-chip">Okay</span>
              <span class="mood-chip">Tired</span>
            </div>
          </div>

          <div>
            <div class="rc-title">Tasks <span>this week</span></div>
            <div id="tasks-container"></div>
          </div>

          <div>
            <div class="rc-title">Wellness <span>today</span></div>
            <div class="well-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
              <span class="well-label" style="width:50px;">Sleep</span>
              <div class="well-bar" style="flex:1; background:var(--bg-2); height:6px; border-radius:3px; margin:0 10px;"><div class="well-fill" style="width:72%; background:var(--amber-400); height:100%; border-radius:3px;"></div></div>
              <span class="well-val" style="font-size:12px;">6.5h</span>
            </div>

            <div class="well-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
              <span class="well-label" style="width:50px;">Water</span>
              <button onclick="updateMetric('water', -0.25)" style="background:var(--bg-2); border:0.5px solid var(--border); color:var(--text-1); padding:2px 8px; border-radius:4px; cursor:pointer; font-weight:bold;">-</button>
              <div class="well-bar" style="flex:1; background:var(--bg-2); height:6px; border-radius:3px; margin:0 10px;"><div class="well-fill" style="width:0%; background:var(--teal-400); height:100%; border-radius:3px;"></div></div>
              <button onclick="updateMetric('water', 0.25)" style="background:var(--bg-2); border:0.5px solid var(--border); color:var(--text-1); padding:2px 8px; border-radius:4px; cursor:pointer; font-weight:bold;">+</button>
              <span class="well-val" style="font-size:12px; width:45px; text-align:right;">0.00L</span>
            </div>

            <div class="well-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
              <span class="well-label" style="width:50px;">Meals</span>
              <button onclick="updateMetric('meals', -1)" style="background:var(--bg-2); border:0.5px solid var(--border); color:var(--text-1); padding:2px 8px; border-radius:4px; cursor:pointer; font-weight:bold;">-</button>
              <div class="well-bar" style="flex:1; background:var(--bg-2); height:6px; border-radius:3px; margin:0 10px;"><div class="well-fill" style="width:0%; background:var(--purple-400); height:100%; border-radius:3px;"></div></div>
              <button onclick="updateMetric('meals', 1)" style="background:var(--bg-2); border:0.5px solid var(--border); color:var(--text-1); padding:2px 8px; border-radius:4px; cursor:pointer; font-weight:bold;">+</button>
              <span class="well-val" style="font-size:12px; width:45px; text-align:right;">0/3</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="page-schedule" class="page-view" style="display: none; padding: 20px;">
      <h2 style="font-size: 18px; margin-bottom: 10px;">Academic Calendar & Lectures</h2>
      <p style="font-size: 13px; color: var(--text-2); margin-bottom: 20px;">Review time logs and block allocations scheduled across your active modules.</p>
      <div style="border: 1px dashed var(--border); padding: 30px; text-align: center; border-radius: var(--r-md); color: var(--text-3); font-size: 13px;">
         Core Schedule Calendar View Integration Frame
      </div>
    </div>

    <div id="page-tasks" class="page-view" style="display: none; padding: 20px;">
      <h2 style="font-size: 18px; margin-bottom: 10px;">All Tasks Management</h2>
      <p style="font-size: 13px; color: var(--text-2); margin-bottom: 20px;">Add, edit, and complete your active university tasks directly from the database.</p>
      <div style="border: 1px dashed var(--border); padding: 30px; text-align: center; border-radius: var(--r-md); color: var(--text-3); font-size: 13px;">
         Task Management Module Integration Screen
      </div>
    </div>

    <div id="page-mood" class="page-view" style="display: none; padding: 20px;">
      <h2 style="font-size: 18px; margin-bottom: 10px;">Wellbeing Analytics</h2>
      <p style="font-size: 13px; color: var(--text-2); margin-bottom: 20px;">Monitor your mental performance, diet tracking, and hydration consistency analytics.</p>
      <div style="border: 1px dashed var(--border); padding: 30px; text-align: center; border-radius: var(--r-md); color: var(--text-3); font-size: 13px;">
         Wellbeing Trends & Charts Screen
      </div>
    </div>
  </main>
</div>

<script>
// ==========================================
// 1. APPLICATION ENGINE STATE
// ==========================================
let appData = {
  userInfo: { full_name: "Loading...", major: "---", year: "-" },
  currentMood: "Okay",
  wellnessScore: 0,
  waterAmount: 0.0,
  mealsEaten: 0,
  totalMeals: 3,
  tasks: [],
  schedule: {}
};

// ==========================================
// 2. CORE DATABASE SYNCHRONIZER
// ==========================================
function loadDashboardFromDatabase() {
  fetch('loginRelated/get_dashboard.php')
    .then(res => {
      if (!res.ok) throw new Error("Server communication broken.");
      return res.json();
    })
    .then(data => {
      if (data.error) {
        window.location.href = "loginRelated/login.php";
        return;
      }

      appData.userInfo = data.userInfo || { full_name: "User Account", major: "CompSci", year: "2" };
      appData.currentMood = data.currentMood || "Okay";
      appData.wellnessScore = data.wellnessScore !== undefined ? parseInt(data.wellnessScore) : 0;
      appData.waterAmount = data.waterAmount !== undefined ? parseFloat(data.waterAmount) : 0.0;
      appData.mealsEaten = data.mealsEaten !== undefined ? parseInt(data.mealsEaten) : 0;
      appData.totalMeals = data.totalMeals || 3;
      appData.tasks = data.tasks || [];
      appData.schedule = data.schedule || {};

      // Sync Profile Text
      document.querySelector('.nav-name').innerText = appData.userInfo.full_name;
      document.querySelector('.nav-sub').innerText = `Year ${appData.userInfo.year} · ${appData.userInfo.major}`;
      
      // Sync Sidebar Task Notification Badge (FIX: Explicit query string targeting)
      const pendingCount = appData.tasks.filter(t => t.status === "pending").length;
      const sidebarBadge = document.querySelector('.nav-badge.red');
      if (sidebarBadge) sidebarBadge.innerText = pendingCount;

      // Sync Mood Chip Highlight Positions
      document.querySelectorAll('.mood-chip').forEach(chip => {
        chip.classList.remove('sel');
        if (chip.innerText.trim() === appData.currentMood) {
          chip.classList.add('sel');
        }
      });

      renderAll();
    })
    .catch(err => console.error("Database initialization aborted:", err));
}

// ==========================================
// 3. GRAPHICAL USER INTERFACE RENDERING PIPELINE
// ==========================================
function renderAll() {
  renderTimeline();
  renderTasks();
  renderStats();
  renderWellnessMetrics();
}

function renderTimeline() {
  const container = document.getElementById("timeline-container");
  if (!container) return;
  
  if (Object.keys(appData.schedule).length === 0) {
    container.innerHTML = `<div style="font-size:12px; color:var(--text-2); padding:20px; text-align:center;">No events logged today.</div>`;
    return;
  }

  container.innerHTML = Object.keys(appData.schedule).map(hour => {
    const slot = appData.schedule[hour];
    // FIX: Swapped hardcoded light/dark clashing colors for CSS system theme variable tokens
    return `
      <div class="tl-hour" style="position:relative; margin-bottom:15px;">
        <span class="tl-time" style="width:50px; display:inline-block; font-size:12px; color:var(--text-2);">${hour}</span>
        <div class="tl-slot" style="display:inline-block; width:calc(100% - 60px); vertical-align:top;">
          <div class="tl-block ${slot.type || 'free'}" style="padding:12px; border-radius:8px;">
            <div class="tl-block-name" style="font-weight:600; font-size:13px;">${slot.name}</div>
            ${slot.sub ? `<div class="tl-block-sub" style="font-size:11px; margin-top:2px;">${slot.sub}</div>` : ""}
          </div>
        </div>
      </div>`;
  }).join('');
}

function renderTasks() {
  const container = document.getElementById("tasks-container");
  if (!container) return;
  
  if (appData.tasks.length === 0) {
    container.innerHTML = `<div style="font-size:12px; color:var(--text-3); padding:10px 0;">All caught up!</div>`;
    return;
  }

  container.innerHTML = appData.tasks.map(task => {
    const isDone = task.status === "done";
    let tagClass = "amber";
    if (isDone) tagClass = "green";
    else if (task.tag && (task.tag.includes("Urgent") || task.tag.includes("days"))) tagClass = "red";

    return `
      <div class="task-row" data-id="${task.id}" style="display:flex; align-items:center; justify-content:space-between; padding:10px 0;">
        <div style="display:flex; align-items:center; gap:10px; flex:1;">
          <input type="checkbox" ${isDone ? 'checked' : ''} onchange="toggleTaskStatus(${task.id}, this.checked)" style="accent-color:var(--purple-600); cursor:pointer; width:16px; height:16px;">
          <span class="tname" style="font-size:13px; color:${isDone ? 'var(--text-3)' : 'var(--text-1)'}; text-decoration:${isDone ? 'line-through' : 'none'};">${task.name}</span>
        </div>
        <span class="ttag ${tagClass}" style="font-size:11px; padding:3px 8px; border-radius:12px;">${task.tag || 'Active'}</span>
      </div>`;
  }).join('');
}

function renderStats() {
  const pendingCount = appData.tasks.filter(t => t.status === "pending").length;
  
  const tasksDueElement = document.getElementById("stat-tasks-due");
  const wellnessNumElement = document.getElementById("stat-wellness-score");
  const nextDeadlineElement = document.getElementById("stat-next-deadline");
  const freeTimeElement = document.getElementById("stat-free-time");
  
  if (tasksDueElement) tasksDueElement.innerText = pendingCount;
  if (wellnessNumElement) wellnessNumElement.innerText = `${appData.wellnessScore}%`;
  
  if (nextDeadlineElement) {
    const urgentTasks = appData.tasks.filter(t => t.status === "pending");
    nextDeadlineElement.innerText = urgentTasks.length > 0 ? urgentTasks[0].name : "None";
  }

  if (freeTimeElement) {
    let freeHours = 0;
    Object.values(appData.schedule).forEach(slot => { if(slot.type === 'free') freeHours += 2; });
    freeTimeElement.innerText = `${freeHours || 4}h`;
  }
}

function renderWellnessMetrics() {
  const waterValEl = document.querySelector('.well-row:nth-of-type(2) .well-val');
  const waterBarEl = document.querySelector('.well-row:nth-of-type(2) .well-fill');
  if (waterValEl) waterValEl.innerText = `${appData.waterAmount.toFixed(2)}L`;
  if (waterBarEl) waterBarEl.style.width = `${Math.min((appData.waterAmount / 3.0) * 100, 100)}%`;

  const mealValEl = document.querySelector('.well-row:nth-of-type(3) .well-val');
  const mealBarEl = document.querySelector('.well-row:nth-of-type(3) .well-fill');
  if (mealValEl) mealValEl.innerText = `${appData.mealsEaten}/${appData.totalMeals}`;
  if (mealBarEl) mealBarEl.style.width = `${(appData.mealsEaten / appData.totalMeals) * 100}%`;
}

// ==========================================
// 4. ACTION CONTROLLERS & DATA DISPATCHERS
// ==========================================
function updateMetric(type, value) {
  fetch('loginRelated/save_wellness.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ type: type, value: value })
  })
  .then(res => res.json())
  .then(() => loadDashboardFromDatabase());
}

// FIX: Event execution target binder moved down post interactive array initialization
function attachMoodListeners() {
  document.querySelectorAll('.mood-chip').forEach(chip => {
    chip.onclick = () => updateMetric('mood', chip.innerText.trim());
  });
}

function toggleTaskStatus(taskId, isChecked) {
  fetch('loginRelated/save_wellness.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ type: 'toggle_task', id: taskId, status: isChecked ? 'done' : 'pending' })
  })
  .then(() => loadDashboardFromDatabase());
}

// ==========================================
// SIDEBAR NAVIGATION SCREEN MANAGER
// ==========================================
document.querySelectorAll('.nav-item').forEach(btn => {
  btn.onclick = () => {
    const targetId = btn.getAttribute('data-target');
    if (!targetId || !document.getElementById(targetId)) return;

    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.page-view').forEach(page => page.style.display = 'none');
    document.getElementById(targetId).style.display = 'block';
  };
});

// Run Initializations
attachMoodListeners();
loadDashboardFromDatabase();
loadMoodHistory();
</script>

</body>
</html>
