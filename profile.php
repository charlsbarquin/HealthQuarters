<?php
require __DIR__ . '/includes/profile/bootstrap.php';

function timeAgo(string $datetime): string {
    return hq_time_ago($datetime);
}

$todayAppts = array_filter($appointments, fn($a) =>
    $a['appointment_date'] === $today && in_array(strtolower((string) ($a['status'] ?? '')), ['approved', 'confirmed'], true)
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile — HealthQuarters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --gs: #6abf4b; --ge: #2dbfb8; --accent: #2dbfb8;
      --deep: #1a4d2e; --mid: #2d7a4f; --bright: #3aad6e;
      --pale: #e8f7ee; --muted: #f0faf4;
      --g100: #f7f9f8; --g200: #e8eeeb; --g400: #94a89d; --g600: #4a6057;
      --border: #dde8e4; --error: #e05252;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: var(--muted); color: #1e302a; min-height: 100vh; -webkit-font-smoothing: antialiased; }

    /* ═══════════════════════════════════════
       NAVBAR — matches lp.php / homepage.php
    ═══════════════════════════════════════ */
    .topbar {
      background: linear-gradient(135deg, var(--gs) 0%, var(--ge) 100%);
      position: sticky; top: 0; z-index: 999;
      box-shadow: 0 2px 20px rgba(13,46,30,.35);
    }
    .topbar-inner {
      width: 100vw; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%);
      display: flex; align-items: stretch;
      padding: 0 24px; height: 76px;
      position: relative; z-index: 2;
    }
    .brand-wrap {
      display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0;
      padding-right: 24px; border-right: 1px solid rgba(255,255,255,.18); margin-right: 8px;
      position: relative; z-index: 1;
    }
    .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
    .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }

    /* Nav links */
    .topbar-nav { display: flex; align-items: stretch; flex: 1; position: relative; z-index: 1; }
    .mobile-nav-toggle { display:none; margin-left:auto; align-items:center; justify-content:center; width:42px; height:42px; border-radius:12px; border:1.5px solid rgba(255,255,255,.28); background:rgba(255,255,255,.14); color:#fff; }
    .mobile-nav-panel { display:none; background:#fff; border-bottom:1px solid var(--border); box-shadow:0 10px 28px rgba(13,46,30,.1); }
    .mobile-nav-panel.open { display:block; }
    .mobile-nav-links { max-width:1060px; margin:0 auto; padding:14px 20px 18px; display:grid; gap:10px; }
    .mobile-nav-links a { display:block; padding:12px 14px; border-radius:12px; text-decoration:none; color:var(--deep); background:var(--muted); border:1px solid var(--g200); font-weight:600; }
    .nav-item { position: relative; display: flex; align-items: stretch; }
    .nav-btn {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 0 15px; height: 100%;
      font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 600;
      letter-spacing: .06em; text-transform: uppercase;
      color: rgba(255,255,255,.9); text-decoration: none;
      background: transparent; border: none; cursor: pointer;
      transition: background .18s, color .18s; white-space: nowrap;
    }
    .nav-btn:hover, .nav-item.open > .nav-btn { color: #fff; background: rgba(255,255,255,.25); }
    .nav-btn.active { color: #fff; background: rgba(255,255,255,.22); position: relative; }
    .nav-btn.active::after {
      content: ''; position: absolute; bottom: 0; left: 12px; right: 12px;
      height: 3px; background: #fff; border-radius: 2px 2px 0 0;
      box-shadow: 0 0 8px rgba(255,255,255,.5);
    }
    .nav-item.open > .nav-btn::after {
      content: ''; position: absolute; bottom: 0; left: 12px; right: 12px;
      height: 3px; background: rgba(255,255,255,.6); border-radius: 2px 2px 0 0;
    }

    /* Dropdowns */
    .nav-dropdown {
      position: absolute; top: 100%; left: 0;
      background: #fff; min-width: 220px;
      box-shadow: 0 8px 32px rgba(13,46,30,.2);
      border: 1px solid var(--border); border-top: 3px solid var(--gs);
      border-radius: 0 0 8px 8px;
      display: none; z-index: 9999; padding: 6px 0;
      animation: dropSlide .15s ease;
    }
    @keyframes dropSlide { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
    .nav-item.open .nav-dropdown { display: block; }
    .drop-link {
      display: block; padding: 9px 18px; font-size: .84rem; font-weight: 500;
      color: var(--deep); text-decoration: none; transition: background .14s;
      border-left: 3px solid transparent;
    }
    .drop-link:hover { background: var(--pale); color: var(--mid); border-left-color: var(--bright); }
    .drop-section-head { font-size: .65rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--g400); padding: 10px 18px 5px; margin-top: 4px; }
    .drop-divider { height: 1px; background: var(--g200); margin: 5px 12px; }
    .drop-services { min-width: 280px; }
    .nav-chevron { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.5; fill: none; }

    /* Right-side actions */
    .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; position: relative; z-index: 100; }

    /* Bell */
    .bell-wrap { position: relative; }
    .bell-btn {
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: background .2s; color: white;
    }
    .bell-btn:hover { background: rgba(255,255,255,.28); }
    .bell-btn.has-unread svg { animation: bellRing 1.2s ease infinite; }
    @keyframes bellRing { 0%,100%{transform:rotate(0)} 10%,30%{transform:rotate(-14deg)} 20%,40%{transform:rotate(14deg)} 50%{transform:rotate(0)} }
    .bell-badge {
      position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px;
      background: #e05252; border-radius: 50px; font-size: .62rem; font-weight: 700;
      color: #fff; display: flex; align-items: center; justify-content: center;
      padding: 0 4px; box-shadow: 0 0 0 2px rgba(106,191,75,.7);
      animation: pulse 2s ease infinite;
    }
    @keyframes pulse { 0%,100%{box-shadow:0 0 0 2px rgba(106,191,75,.7)} 50%{box-shadow:0 0 0 5px rgba(106,191,75,.2)} }
    .bell-badge.hidden { display: none; }

    /* Patient chip */
    .patient-chip {
      display: flex; align-items: center; gap: 9px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.25);
      border-radius: 50px; padding: 6px 16px 6px 6px;
      text-decoration: none; transition: background .2s;
    }
    .patient-chip:hover { background: rgba(255,255,255,.22); }
    .patient-avatar {
      width: 32px; height: 32px; background: rgba(255,255,255,.9); color: var(--gs);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      font-size: .8rem; font-weight: 700;
    }
    .patient-name { font-size: .82rem; font-weight: 500; color: #fff; max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* Logout */
    .btn-logout {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
    .btn-logout:hover { background: rgba(255,255,255,.28); color: #fff; }

    /* NOTIF DROPDOWN */
    .notif-dropdown {
      position: absolute; top: calc(100% + 12px); right: 0;
      width: 360px; max-height: 480px; background: #fff;
      border-radius: 18px; box-shadow: 0 20px 60px rgba(26,77,46,.18), 0 4px 20px rgba(0,0,0,.08);
      border: 1.5px solid var(--g200); overflow: hidden;
      display: none; z-index: 9999; animation: dropIn .2s cubic-bezier(.4,0,.2,1);
    }
    @keyframes dropIn { from{opacity:0;transform:translateY(-8px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
    .notif-dropdown.open { display: flex; flex-direction: column; }
    .notif-drop-header {
      padding: 16px 20px 12px; border-bottom: 1.5px solid var(--g200);
      display: flex; align-items: center; justify-content: space-between;
      background: var(--muted); flex-shrink: 0;
    }
    .notif-drop-header h3 { font-family: 'DM Serif Display', serif; font-size: 1rem; color: var(--deep); }
    .mark-all-btn { font-size: .75rem; color: var(--mid); background: none; border: none; cursor: pointer; font-weight: 600; padding: 4px 10px; border-radius: 50px; transition: background .2s; }
    .mark-all-btn:hover { background: var(--pale); }
    .notif-list { overflow-y: auto; flex: 1; }
    .notif-item { display: flex; gap: 12px; padding: 14px 18px; border-bottom: 1px solid var(--g200); cursor: pointer; transition: background .15s; position: relative; }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--g100); }
    .notif-item.unread { background: #f0faf4; }
    .notif-item.unread::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--bright); border-radius: 0 2px 2px 0; }
    .notif-dot { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
    .notif-dot-today{background:#e8f7ee} .notif-dot-tomorrow{background:#e8f7f6}
    .notif-dot-fasting{background:#fff8e1} .notif-dot-3day{background:#f0f0ff}
    .notif-dot-confirmed{background:#e8f7ee} .notif-dot-pending{background:#fff8e1}
    .notif-dot-corp_pending{background:#fff8e1} .notif-dot-corp_confirmed{background:#e8f7ee}
    .notif-dot-general{background:var(--g100)}
    .notif-item-content { flex: 1; min-width: 0; }
    .notif-item-title { font-size: .82rem; font-weight: 600; color: #1e302a; margin-bottom: 3px; }
    .notif-item.unread .notif-item-title { color: var(--deep); }
    .notif-item-msg { font-size: .78rem; color: var(--g600); line-height: 1.5; }
    .notif-item-time { font-size: .7rem; color: var(--g400); margin-top: 4px; }
    .email-sent-chip { display: inline-flex; align-items: center; gap: 3px; font-size: .65rem; color: #2d7a4f; background: #e8f7ee; border-radius: 50px; padding: 1px 7px; margin-top: 4px; }
    .notif-empty { padding: 36px 20px; text-align: center; color: var(--g400); font-size: .85rem; }
    .live-dot { display: inline-flex; align-items: center; gap: 5px; font-size: .68rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #2d7a4f; }
    .live-dot::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #3aad6e; display: inline-block; animation: livePulse 1.4s ease infinite; }
    @keyframes livePulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.4)} }

    /* BANNERS */
    .notif-zone { max-width: 1060px; margin: 24px auto 0; padding: 0 20px; display: flex; flex-direction: column; gap: 10px; }
    .notif-banner { display: flex; align-items: flex-start; gap: 14px; padding: 14px 18px; border-radius: 14px; border: 1.5px solid transparent; position: relative; animation: slideDown .35s ease; }
    @keyframes slideDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
    .notif-green{background:#e8f7ee;border-color:#a8e6c1} .notif-teal{background:#e8f7f6;border-color:#7de8e4}
    .notif-yellow{background:#fff8e1;border-color:#f5c842} .notif-gray{background:#f7f9f8;border-color:#c8d4ce}
    .notif-yellow.notif-important{background:#fff3cd;border-color:#f08c00;border-width:2px}
    .notif-icon { font-size: 1.4rem; flex-shrink: 0; line-height: 1; }
    .notif-content { flex: 1; }
    .notif-title { font-weight: 700; font-size: .88rem; margin-bottom: 3px; }
    .notif-green .notif-title{color:#1a4d2e} .notif-teal .notif-title{color:#1a4d4d}
    .notif-yellow .notif-title{color:#7c4a00} .notif-gray .notif-title{color:#4a6057}
    .notif-msg { font-size: .83rem; line-height: 1.6; }
    .notif-green .notif-msg{color:#2d7a4f} .notif-teal .notif-msg{color:#1a6060}
    .notif-yellow .notif-msg{color:#5a3800} .notif-gray .notif-msg{color:#4a6057}
    .notif-dismiss { background: none; border: none; cursor: pointer; font-size: 1rem; opacity: .4; transition: opacity .18s; flex-shrink: 0; padding: 0; line-height: 1; color: #333; margin-top: 2px; }
    .notif-dismiss:hover { opacity: .8; }
    .countdown-chip { display: inline-flex; align-items: center; gap: 5px; background: rgba(26,77,46,.08); border-radius: 50px; padding: 3px 10px; font-size: .72rem; font-weight: 700; color: var(--deep); margin-top: 6px; }

    /* PAGE LAYOUT */
    .page-wrap { max-width: 1240px; margin: 30px auto; padding: 0 20px 64px; display: grid; grid-template-columns: 320px minmax(0, 1fr); gap: 30px; align-items: start; }
    .page-side { display:flex; flex-direction:column; gap:18px; position:sticky; top:96px; }
    .card { background: linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border-radius: 24px; box-shadow: 0 14px 40px rgba(26,77,46,.08); border: 1px solid var(--g200); overflow: hidden; }
    .profile-shell { padding: 30px 26px 24px; text-align:center; }
    .profile-kicker { display:inline-flex; align-items:center; padding:5px 12px; border-radius:999px; background:var(--muted); border:1px solid var(--g200); font-size:.64rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--mid); margin-bottom:16px; }
    .avatar-circle { width: 96px; height: 96px; border-radius: 50%; border: 4px solid var(--pale); box-shadow: 0 10px 26px rgba(26,77,46,.14); background: linear-gradient(135deg, #f6fffa, #e8f7ee); display: flex; align-items: center; justify-content: center; font-family: 'DM Serif Display', serif; font-size: 2.5rem; color: var(--mid); margin: 0 auto 18px; }
    .profile-name { font-family: 'DM Serif Display', serif; font-size: 1.42rem; color: var(--deep); text-align: center; margin-bottom: 6px; line-height:1.1; }
    .profile-email { font-size: .82rem; color: var(--g400); text-align: center; margin-bottom: 22px; line-height:1.5; }
    .info-grid { text-align:left; display:grid; gap:0; }
    .info-row { display: flex; flex-direction: column; gap: 4px; padding: 13px 0; border-bottom: 1px solid var(--g200); }
    .info-row:last-child { border-bottom: none; }
    .info-row .lbl { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--g400); }
    .info-row .val { font-size: .9rem; color: #1e302a; font-weight: 500; }
    .back-home-link { display:flex; align-items:center; justify-content:center; gap:8px; margin-top:22px; padding:12px 20px; background:var(--pale); color:var(--mid); border-radius:999px; font-size:.82rem; font-weight:700; text-decoration:none; transition:all .2s; }
    .back-home-link:hover { background:#dff3e7; color:var(--deep); transform:translateY(-1px); }
    .mini-side-card { padding:18px 18px 16px; }
    .mini-side-card strong { display:block; font-family:'DM Serif Display', serif; font-size:1.25rem; color:var(--deep); margin-bottom:4px; }
    .mini-side-card span { display:block; font-size:.76rem; color:var(--g600); line-height:1.55; }
    .tab-nav { display: flex; gap: 8px; padding: 18px 22px 0; border-bottom: 1px solid var(--g200); background: linear-gradient(180deg, #f7fcf9 0%, #f0faf4 100%); flex-wrap:wrap; }
    .tab-btn { font-size: .78rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--g400); background: transparent; border: 1px solid transparent; padding: 12px 18px; border-radius: 14px 14px 0 0; cursor: pointer; transition: all .2s; position: relative; bottom: -1px; }
    .tab-btn.active { color: var(--deep); background: #fff; border-color: var(--g200); border-bottom-color: #fff; box-shadow: 0 -4px 16px rgba(26,77,46,.04); }
    .tab-btn:hover:not(.active) { color: var(--mid); }
    .tab-panel { display: none; padding: 30px 26px; } .tab-panel.active { display: block; }
    .panel-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:20px; }
    .panel-header-copy { min-width:0; }
    .panel-kicker { display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; background:var(--muted); border:1px solid var(--g200); font-size:.63rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--mid); margin-bottom:10px; }
    .panel-title { font-family:'DM Serif Display', serif; font-size:1.55rem; color:var(--deep); line-height:1.1; margin-bottom:8px; }
    .panel-subtitle { font-size:.84rem; color:var(--g600); line-height:1.72; max-width:62ch; }
    .panel-aside { min-width:120px; padding:12px 14px; border-radius:16px; background:var(--muted); border:1px solid var(--g200); }
    .panel-aside strong { display:block; font-family:'DM Serif Display', serif; font-size:1.2rem; color:var(--deep); line-height:1; }
    .panel-aside span { display:block; margin-top:5px; font-size:.72rem; color:var(--g600); line-height:1.45; }
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .field label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--deep); }
    .field label .req { color: var(--bright); margin-left: 2px; }
    .field input { padding: 11px 14px; border: 2px solid var(--g200); border-radius: 10px; font-family: 'DM Sans', sans-serif; font-size: .9rem; color: #1e302a; background: var(--g100); outline: none; transition: border-color .2s, box-shadow .2s; }
    .field input:focus { border-color: var(--bright); box-shadow: 0 0 0 4px rgba(58,173,110,.14); background: #fff; }
    .field input[readonly] { background: var(--g200); color: var(--g400); cursor: not-allowed; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 24px; } .form-grid .full { grid-column: 1/-1; }
    .btn-save { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: linear-gradient(135deg, var(--gs), var(--ge)); border: none; border-radius: 50px; font-family: 'DM Sans', sans-serif; font-size: .9rem; font-weight: 600; color: #fff; cursor: pointer; box-shadow: 0 4px 16px rgba(45,191,184,.28); transition: all .22s; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,191,184,.38); }
    .appt-table-wrap { overflow-x:auto; border:1px solid var(--g200); border-radius:18px; background:#fff; }
    .appt-table { width: 100%; border-collapse: collapse; }
    .appt-table th { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--g400); padding: 10px 14px; border-bottom: 2px solid var(--g200); text-align: left; }
    .appt-table td { padding: 14px; font-size: .88rem; border-bottom: 1px solid var(--g200); color: #1e302a; vertical-align: middle; }
    .appt-table tr:last-child td { border-bottom: none; } .appt-table tr:hover td { background: var(--muted); }
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 50px; font-size: .72rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; }
    .status-pending{background:#fff8e1;color:#b7791f} .status-approved{background:#e8f7ee;color:#2d7a4f}
    .status-completed{background:#e8f7f6;color:#2dbfb8} .status-cancelled{background:#fdecea;color:#e05252}
    .status-chip { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:50px; font-size:.72rem; font-weight:700; background:#f7f9f8; color:var(--deep); }
    .today-row td{background:#f0faf4!important} .tomorrow-row td{background:#f7fefd!important}
    .row-badge { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 2px 7px; border-radius: 50px; margin-left: 6px; }
    .badge-today{background:#e8f7ee;color:#2d7a4f} .badge-tomorrow{background:#e8f7f6;color:#2dbfb8} .badge-fasting{background:#fff8e1;color:#b7791f}
    .empty-state { text-align: center; padding: 48px 24px; color: var(--g400); }
    .alert-custom { padding: 14px 18px; border-radius: 14px; font-size: .85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: var(--pale); color: var(--mid); border: 1px solid #a8e6c1; }
    .alert-error { background: #fdecea; color: var(--error); border: 1px solid #f5b4b4; }
    .section-sub { font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--accent); margin-bottom: 16px; }
    .sub-tab-nav { display: flex; gap: 6px; margin-bottom: 20px; border-bottom: 2px solid var(--g200); padding-bottom: 0; }
    .sub-tab-btn { font-size: .78rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--g400); background: transparent; border: none; border-bottom: 2.5px solid transparent; padding: 8px 16px; cursor: pointer; transition: all .2s; margin-bottom: -2px; display: flex; align-items: center; gap: 6px; }
    .sub-tab-btn:hover { color: var(--mid); }
    .sub-tab-btn.active { color: var(--deep); border-bottom-color: var(--bright); }
    .sub-tab-panel { display: none; } .sub-tab-panel.active { display: block; }
    .sub-count { background: var(--accent); color: #fff; border-radius: 50px; padding: 1px 7px; font-size: .62rem; font-weight: 700; }
    .reschedule-card, .inbox-card { background:linear-gradient(180deg, #f9fdfb 0%, #f0faf4 100%); border:1px solid var(--g200); border-radius:18px; padding:18px; margin-top:18px; }
    .summary-strip { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px; margin-bottom:22px; }
    .summary-tile { background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border:1px solid var(--g200); border-radius:16px; padding:16px 16px 15px; min-height:120px; }
    .summary-tile strong { display:block; font-family:'DM Serif Display', serif; font-size:1.38rem; color:var(--deep); line-height:1; margin:8px 0 7px; }
    .summary-tile span { display:block; font-size:.74rem; color:var(--g600); line-height:1.55; }
    .action-list { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px; }
    .action-card { background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border:1px solid var(--g200); border-radius:16px; padding:16px; text-decoration:none; color:inherit; transition:all .2s; }
    .action-card:hover { border-color:var(--bright); transform:translateY(-2px); box-shadow:0 10px 24px rgba(26,77,46,.07); }
    .action-chip { display:inline-flex; align-items:center; padding:3px 8px; border-radius:50px; background:#fff; border:1px solid var(--g200); font-size:.63rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--mid); margin-bottom:8px; }
    .action-card strong { display:block; color:var(--deep); font-size:.9rem; }
    .action-card span { display:block; color:var(--g600); font-size:.77rem; line-height:1.6; margin-top:5px; }
    .detail-card-list { display:flex; flex-direction:column; gap:14px; margin-bottom:20px; }
    .detail-card { background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border:1px solid var(--g200); border-radius:18px; padding:16px 18px; box-shadow:0 8px 22px rgba(26,77,46,.05); }
    .detail-card-head { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; }
    .detail-flags { display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
    .detail-flag { display:inline-flex; align-items:center; padding:3px 8px; border-radius:50px; background:#fff; border:1px solid var(--g200); font-size:.64rem; font-weight:700; color:var(--mid); text-transform:uppercase; }
    .activity-list { display:flex; flex-direction:column; gap:12px; }
    .activity-row { background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border:1px solid var(--g200); border-radius:16px; padding:15px 16px; }
    .activity-row strong { display:block; color:var(--deep); font-size:.84rem; }
    .activity-row span { display:block; color:var(--g600); font-size:.76rem; line-height:1.5; margin-top:4px; }
    .result-card-grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:14px; margin-bottom:18px; }
    .result-card { background:var(--muted); border:1px solid var(--g200); border-radius:14px; padding:16px; }
    .result-card strong { display:block; color:var(--deep); font-size:.9rem; }
    .result-card small { display:block; color:var(--g400); font-size:.72rem; margin-top:4px; }
    .reschedule-grid { display:grid; grid-template-columns: 1.2fr 1fr 1fr; gap:12px; }
    .reschedule-card select, .reschedule-card input, .reschedule-card textarea, .notif-filter {
      width:100%; padding:10px 12px; border:1.5px solid var(--g200); border-radius:10px; background:#fff; font-size:.86rem;
    }
    .reschedule-card textarea { min-height:86px; resize:vertical; }
    .timeline-list { display:flex; flex-direction:column; gap:12px; }
    .timeline-item { border:1px solid var(--g200); border-radius:12px; padding:14px 16px; background:#fff; }
    .timeline-item strong { color:var(--deep); display:block; margin-bottom:4px; }
    .timeline-item span { font-size:.8rem; color:var(--g600); }

    @media(max-width:860px) {
      .page-wrap { grid-template-columns: 1fr; }
      .page-side { position:static; }
      .topbar-nav { display: none; }
      .topbar-inner { height: 60px; padding: 0 16px; }
      .brand-logo { height: 40px; width: 40px; }
      .brand-name { font-size: 1.2rem; }
      .patient-name { display: none; }
      .summary-strip, .action-list { grid-template-columns:1fr; }
      .form-grid { grid-template-columns: 1fr; } .form-grid .full { grid-column: 1; }
      .notif-dropdown { width: 300px; right: -60px; }
      .result-card-grid { grid-template-columns:1fr; }
      .panel-header { flex-direction:column; }
      .panel-aside { width:100%; }
    }
    @media(max-width:480px) { .brand-name { display: none; } .mobile-nav-toggle { display:inline-flex; } }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVBAR — lp.php style with bell + patient chip + logout
═══════════════════════════════════════════ -->
<nav class="topbar">
  <div class="topbar-inner">

    <a class="brand-wrap" href="homepage.php">
      <img src="image/Healthquarterlogo.png" class="brand-logo" alt="HealthQuarters">
      <span class="brand-name">HealthQuarters</span>
    </a>

    <div class="topbar-nav">
      <div class="nav-item">
        <a class="nav-btn" href="homepage.php">Home</a>
      </div>

      <div class="nav-item" id="navServices">
        <button class="nav-btn" onclick="toggleNav('navServices',event)">
          Services
          <svg class="nav-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="nav-dropdown drop-services">
          <div class="drop-section-head">By Category</div>
          <a class="drop-link" href="service.php#hematology">Hematology</a>
          <a class="drop-link" href="service.php#chemistry">Blood Chemistry</a>
          <a class="drop-link" href="service.php#ultrasound">Ultrasound / Imaging</a>
          <a class="drop-link" href="service.php#other">Other Services</a>
          <div class="drop-divider"></div>
          <div class="drop-section-head">Service Programs</div>
          <a class="drop-link" href="home_service_info.php">Home Service</a>
          <a class="drop-link" href="corporate_info.php">Corporate Service</a>
        </div>
      </div>

      <div class="nav-item">
        <a class="nav-btn" href="locations.php">Locations</a>
      </div>

      <div class="nav-item" id="navAbout">
        <button class="nav-btn" onclick="toggleNav('navAbout',event)">
          About Us
          <svg class="nav-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="nav-dropdown">
          <a class="drop-link" href="about_us.php#profile">Profile of HealthQuarters</a>
          <a class="drop-link" href="about_us.php#mission">Mission &amp; Vision</a>
          <a class="drop-link" href="about_us.php#commitment">Commitment</a>
          <a class="drop-link" href="about_us.php#orgchart">Organizational Chart</a>
          <a class="drop-link" href="about_us.php#milestones">Milestones</a>
          <a class="drop-link" href="about_us.php#contact">Contact Information</a>
        </div>
      </div>
    </div>
    <button class="mobile-nav-toggle" type="button" onclick="toggleMobileNav()" aria-label="Open navigation">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>

    <!-- Right side: bell + patient chip + logout -->
    <div class="topbar-right">

      <!-- Notification Bell -->
      <div class="bell-wrap" id="bellWrap">
        <button class="bell-btn <?= $unreadCount > 0 ? 'has-unread' : '' ?>" id="bellBtn" onclick="toggleNotifDropdown(event)">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
          <span class="bell-badge <?= $unreadCount === 0 ? 'hidden' : '' ?>" id="bellBadge"><?= $unreadCount ?></span>
        </button>

        <div class="notif-dropdown" id="notifDropdown">
          <div class="notif-drop-header">
            <div>
              <h3>Notifications</h3>
              <div class="live-dot" style="margin-top:3px;">Live + Email</div>
            </div>
            <button class="mark-all-btn" onclick="markAllRead()">Mark all read</button>
          </div>
          <div class="notif-list" id="notifList">
            <?php if (empty($allNotifications)): ?>
            <div class="notif-empty"><p>No notifications yet</p></div>
            <?php else: foreach ($allNotifications as $notif):
              $unreadClass = $notif['is_read'] ? '' : 'unread';
              $icon = match($notif['type']) {
                'today'          => 'Today', 'tomorrow'       => 'Soon',
                'fasting'        => 'Prep', '3day'          => 'Plan',
                'confirmed'      => 'OK', 'pending'        => 'Pending',
                'corp_pending'   => 'Pending', 'corp_confirmed' => 'OK',
                default          => 'Info',
              };
            ?>
            <div class="notif-item <?= $unreadClass ?>" data-action-url="<?= htmlspecialchars($notif['action_url'] ?? '') ?>" onclick="markRead(<?= $notif['id'] ?>, this)">
              <div class="notif-dot notif-dot-<?= $notif['type'] ?>"><?= $icon ?></div>
              <div class="notif-item-content">
                <div class="notif-item-title"><?= htmlspecialchars($notif['title']) ?></div>
                <div class="notif-item-msg"><?= $notif['message'] ?></div>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                  <div class="notif-item-time"><?= timeAgo($notif['created_at']) ?></div>
                  <?php if (!empty($notif['email_sent'])): ?>
                    <span class="email-sent-chip">Email sent</span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; endif; ?>
          </div>
        </div>
      </div>

      <!-- Patient chip -->
      <a href="profile.php" class="patient-chip">
        <div class="patient-avatar"><?= htmlspecialchars($initials) ?></div>
        <span class="patient-name"><?= htmlspecialchars($user['fullname'] ?? 'Patient') ?></span>
      </a>

      <!-- Logout -->
      <form method="post" action="logout.php" style="margin:0;">
        <?= hq_csrf_input('logout') ?>
        <button type="submit" class="btn-logout" style="border:none;">Logout</button>
      </form>

    </div>
  </div>
</nav>
<div class="mobile-nav-panel" id="mobileNavPanel">
  <div class="mobile-nav-links">
    <a href="homepage.php">Home</a>
    <a href="profile.php?tab=info">Personal Info</a>
    <a href="profile.php?tab=appointments">Appointments</a>
    <a href="profile.php?tab=inbox">Inbox</a>
    <a href="booking.php">Book Home Service</a>
  </div>
</div>

<!-- BANNERS -->
<?php if (!empty($banners)): ?>
<div class="notif-zone" id="notifZone">
  <?php foreach ($banners as $i => $n):
    $colorClass = 'notif-' . $n['color'];
    $impClass   = !empty($n['important']) ? ' notif-important' : '';
  ?>
  <div class="notif-banner <?= $colorClass . $impClass ?>" id="banner-<?= $i ?>">
    <div class="notif-icon"><?= $n['icon'] ?></div>
    <div class="notif-content">
      <div class="notif-title"><?= htmlspecialchars($n['title']) ?></div>
      <div class="notif-msg"><?= $n['msg'] ?></div>
      <?php if ($n['type'] === 'today'): ?>
        <div class="countdown-chip" id="countdownChip-<?= $i ?>">⏱ Loading...</div>
      <?php endif; ?>
    </div>
    <button class="notif-dismiss" onclick="dismissBanner(<?= $i ?>)">x</button>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
const notificationsCsrfToken = <?= json_encode(hq_csrf_token('notifications_api')) ?>;
const todayAppointments = <?= json_encode(array_values(array_map(fn($a) => $a['preferred_time'] ?? '', $todayAppts))) ?>;
</script>

<!-- PAGE BODY -->
<div class="page-wrap">

  <!-- Sidebar -->
  <div class="page-side">
    <div class="card">
      <div class="profile-shell">
        <div class="profile-kicker">Patient Summary</div>
        <div class="avatar-circle"><?= htmlspecialchars($initials) ?></div>
        <div class="profile-name"><?= htmlspecialchars($user['fullname'] ?? '—') ?></div>
        <div class="profile-email"><?= htmlspecialchars($user['email'] ?? '—') ?></div>
        <div class="info-grid">
          <div class="info-row"><span class="lbl">Date of Birth</span><span class="val"><?= isset($user['dob']) && $user['dob'] ? date('F j, Y', strtotime($user['dob'])) : '—' ?></span></div>
          <div class="info-row"><span class="lbl">Gender</span><span class="val"><?= htmlspecialchars($user['sex'] ?? '—') ?></span></div>
          <div class="info-row"><span class="lbl">Contact</span><span class="val"><?= htmlspecialchars($user['contact_number'] ?? '—') ?></span></div>
          <div class="info-row"><span class="lbl">Address</span><span class="val"><?= htmlspecialchars($user['address'] ?? '—') ?></span></div>
          <div class="info-row"><span class="lbl">Member Since</span><span class="val"><?= isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : '—' ?></span></div>
        </div>
        <a href="homepage.php" class="back-home-link">
          ← Go Back Home
        </a>
      </div>
    </div>
    <div class="card">
      <div class="mini-side-card">
        <strong><?= (int) hq_profile_completion_score($user) ?>%</strong>
        <span>Profile completion based on your stored patient details and contact information.</span>
      </div>
    </div>
  </div>

  <!-- Main panel -->
  <div class="card" style="overflow:visible;">
    <?php if ($success): ?><div class="alert-custom alert-success" style="margin:20px 24px 0;"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert-custom alert-error"   style="margin:20px 24px 0;">x <?= htmlspecialchars($error) ?></div><?php endif; ?>

    <div class="tab-nav">
      <button class="tab-btn active" onclick="switchTab('info',this)">Personal Info</button>
      <button class="tab-btn" onclick="switchTab('appointments',this)">
        My Appointments
        <?php $totalActive = $upcomingCount + $pendingCorpCount; if ($totalActive > 0): ?>
          <span style="background:var(--accent);color:#fff;border-radius:50px;padding:1px 7px;font-size:.65rem;margin-left:4px;"><?= $totalActive ?></span>
        <?php endif; ?>
      </button>
      <button class="tab-btn" onclick="switchTab('inbox',this)">
        Notification Inbox
        <?php if ($unreadCount > 0): ?><span style="background:var(--accent);color:#fff;border-radius:50px;padding:1px 7px;font-size:.65rem;margin-left:4px;"><?= $unreadCount ?></span><?php endif; ?>
      </button>
    </div>

    <!-- Personal Info Tab -->
    <div class="tab-panel active" id="tab-info">
      <div class="panel-header">
        <div class="panel-header-copy">
          <div class="panel-kicker">Account Details</div>
          <div class="panel-title">Personal Information</div>
          <div class="panel-subtitle">Keep your personal and contact information up to date so your appointments, notifications, and patient records stay accurate.</div>
        </div>
        <div class="panel-aside">
          <strong><?= (int) hq_profile_completion_score($user) ?>%</strong>
          <span>Profile completion</span>
        </div>
      </div>
      <div class="summary-strip">
        <div class="summary-tile">
          <strong><?= (int) hq_profile_completion_score($user) ?>%</strong>
          <span>Profile completion based on your stored patient details.</span>
        </div>
        <div class="summary-tile">
          <strong><?= (int) count($appointments) ?></strong>
          <span>Total home service requests recorded in your account.</span>
        </div>
        <div class="summary-tile">
          <strong><?= (int) $unreadCount ?></strong>
          <span>Unread updates waiting in your patient inbox.</span>
        </div>
      </div>
      <div class="action-list">
        <?php foreach ($nextSteps as $step): ?>
          <a class="action-card" href="<?= htmlspecialchars($step['href']) ?>">
            <div class="action-chip"><?= htmlspecialchars($step['badge']) ?></div>
            <strong><?= htmlspecialchars($step['title']) ?></strong>
            <span><?= htmlspecialchars($step['detail']) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
      <form method="POST">
        <?= hq_csrf_input('profile_update') ?>
        <input type="hidden" name="update_profile" value="1">
        <div class="form-grid">
          <div class="field full"><label>Full Name <span class="req">*</span></label><input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required></div>
          <div class="field"><label>Email Address</label><input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly></div>
          <div class="field"><label>Date of Birth</label><input type="date" name="dob" value="<?= htmlspecialchars($user['dob'] ?? '') ?>"></div>
          <div class="field"><label>Gender</label><input type="text" value="<?= htmlspecialchars($user['sex'] ?? '') ?>" readonly></div>
          <div class="field"><label>Contact Number <span class="req">*</span></label><input type="text" name="contact_number" value="<?= htmlspecialchars($user['contact_number'] ?? '') ?>" required></div>
          <div class="field full"><label>Home Address</label><input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="e.g. 123 Rizal St, Quezon City"></div>
        </div>
        <button type="submit" class="btn-save">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Save Changes
        </button>
      </form>
    </div>

    <!-- My Appointments Tab -->
    <div class="tab-panel" id="tab-appointments">
      <div class="panel-header">
        <div class="panel-header-copy">
          <div class="panel-kicker">Tracking Center</div>
          <div class="panel-title">Appointments and Requests</div>
          <div class="panel-subtitle">Review your home service schedules, track reschedule requests, and keep tabs on corporate submissions from one place.</div>
        </div>
        <div class="panel-aside">
          <strong><?= (int) ($upcomingCount + $pendingCorpCount) ?></strong>
          <span>Active tracked items</span>
        </div>
      </div>
      <div class="sub-tab-nav">
        <button class="sub-tab-btn active" onclick="switchSubTab('home',this)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          Home Service
          <?php $homeCount = count(array_filter($appointments, fn($a) => !in_array(strtolower($a['status']),['cancelled','completed']) && ($a['appointment_date'] ?? '') >= $today)); ?>
          <?php if ($homeCount > 0): ?><span class="sub-count"><?= $homeCount ?></span><?php endif; ?>
        </button>
        <button class="sub-tab-btn" onclick="switchSubTab('corporate',this)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
          Corporate Inquiries
          <?php if ($pendingCorpCount > 0): ?><span class="sub-count"><?= $pendingCorpCount ?></span><?php endif; ?>
        </button>
      </div>

      <!-- Home Service sub-panel -->
      <div class="sub-tab-panel active" id="sub-home">
        <p class="section-sub">Home Service Appointments</p>
        <?php if (!empty($appointmentCards)): ?>
          <div class="detail-card-list">
            <?php foreach ($appointmentCards as $card): ?>
              <div class="detail-card">
                <div class="detail-card-head">
                  <div>
                    <strong><?= htmlspecialchars($card['service']) ?></strong>
                    <span><?= htmlspecialchars($card['date']) ?> at <?= htmlspecialchars($card['time']) ?></span>
                  </div>
                  <span class="status-chip"><?= htmlspecialchars($card['status']) ?></span>
                </div>
                <?php if (!empty($card['prep_note'])): ?><span><?= htmlspecialchars($card['prep_note']) ?></span><?php endif; ?>
                <?php if (!empty($card['flags'])): ?>
                  <div class="detail-flags">
                    <?php foreach ($card['flags'] as $flag): ?><span class="detail-flag"><?= htmlspecialchars($flag) ?></span><?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <a href="patient_appointment.php?id=<?= (int) ($card['id'] ?? 0) ?>" style="display:inline-flex;margin-top:10px;color:var(--mid);font-size:.78rem;font-weight:600;text-decoration:none;">Open appointment detail</a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if (empty($appointments)): ?>
          <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p style="margin-top:12px;">No home service appointments yet.<br>
              <a href="booking.php" style="color:var(--mid);font-weight:600;">Book a home service</a> to get started.
            </p>
          </div>
        <?php else: ?>
          <div class="appt-table-wrap">
            <table class="appt-table">
              <thead><tr><th>Date</th><th>Time</th><th>Service</th><th>Status</th><th>Tracking</th></tr></thead>
              <tbody>
              <?php foreach ($appointments as $appt):
                $status   = strtolower($appt['status'] ?? 'pending');
                $badge    = match($status) {'approved'=>'status-approved','completed'=>'status-completed','cancelled'=>'status-cancelled',default=>'status-pending'};
                $apptDate = $appt['appointment_date'] ?? '';
                $date     = $apptDate ? date('M j, Y', strtotime($apptDate)) : '—';
                $time     = $appt['preferred_time'] ?? $appt['appointment_time'] ?? '—';
                $service  = $appt['service_type'] ?? $appt['service'] ?? '—';
                $rowClass = $extraBadge = '';
                if ($apptDate === $today && !in_array($status,['cancelled','completed'])) {
                    $rowClass='today-row'; $extraBadge='<span class="row-badge badge-today">Today</span>';
                } elseif ($apptDate === $tomorrow && !in_array($status,['cancelled','completed'])) {
                    $rowClass='tomorrow-row'; $extraBadge='<span class="row-badge badge-tomorrow">Tomorrow</span>';
                }
                $fastingBadge = '';
                foreach ($FASTING_SERVICES as $f) { if (stripos($service,$f)!==false && !in_array($status,['cancelled','completed'])) { $fastingBadge='<span class="row-badge badge-fasting">Fasting</span>'; break; } }
                $statusLabel = hq_normalize_appointment_status($appt['status'] ?? 'Pending');
                $rescheduleRequest = $rescheduleByAppointment[(int) ($appt['id'] ?? 0)] ?? null;
              ?>
              <tr class="<?= $rowClass ?>">
                <td><?= htmlspecialchars($date) ?><?= $extraBadge ?></td>
                <td><?= htmlspecialchars($time) ?></td>
                <td><a href="patient_appointment.php?id=<?= (int) ($appt['id'] ?? 0) ?>" style="color:var(--deep);font-weight:600;text-decoration:none;"><?= htmlspecialchars($service) ?></a><?= $fastingBadge ?></td>
                <td><span class="status-badge <?= $badge ?>"><?= htmlspecialchars($statusLabel) ?></span></td>
                <td>
                  <?php if ($rescheduleRequest): ?>
                    <span class="status-chip">Reschedule <?= htmlspecialchars($rescheduleRequest['status']) ?></span>
                  <?php else: ?>
                    <span class="status-chip">Tracking active</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div style="margin-top:14px;display:flex;gap:14px;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:6px;font-size:.74rem;color:var(--g400);"><span style="width:11px;height:11px;background:#f0faf4;border:1px solid #a8e6c1;border-radius:3px;display:inline-block;"></span> Today</div>
            <div style="display:flex;align-items:center;gap:6px;font-size:.74rem;color:var(--g400);"><span style="width:11px;height:11px;background:#f7fefd;border:1px solid #7de8e4;border-radius:3px;display:inline-block;"></span> Tomorrow</div>
            <div style="display:flex;align-items:center;gap:6px;font-size:.74rem;color:var(--g400);"><span class="row-badge badge-fasting" style="margin:0;">Fasting</span> Requires fasting</div>
          </div>
          <div class="reschedule-card">
            <p class="section-sub" style="margin-bottom:12px;">Request a Reschedule</p>
            <form method="post">
              <?= hq_csrf_input('profile_reschedule') ?>
              <input type="hidden" name="request_reschedule" value="1">
              <div class="reschedule-grid">
                <div class="field" style="margin:0;">
                  <label>Appointment</label>
                  <select name="appointment_id" required>
                    <?php foreach ($appointments as $appt): ?>
                      <?php if (!in_array(strtolower($appt['status'] ?? ''), ['cancelled','completed'], true)): ?>
                        <option value="<?= (int) $appt['id'] ?>"><?= htmlspecialchars(($appt['service_type'] ?? 'Appointment') . ' - ' . ($appt['appointment_date'] ?? '') . ' ' . ($appt['preferred_time'] ?? '')) ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="field" style="margin:0;">
                  <label>New Date</label>
                  <input type="date" name="requested_date" required>
                </div>
                <div class="field" style="margin:0;">
                  <label>New Time</label>
                  <input type="text" name="requested_time" placeholder="e.g. 10:00 AM" required>
                </div>
              </div>
              <div class="field" style="margin-top:12px;">
                <label>Reason</label>
                <textarea name="reason" placeholder="Optional reason for the requested change"></textarea>
              </div>
              <button type="submit" class="btn-save">Submit Reschedule Request</button>
            </form>
          </div>
          <?php if (!empty($rescheduleRequests)): ?>
            <div class="reschedule-card">
              <p class="section-sub" style="margin-bottom:12px;">Status Timeline</p>
              <div class="timeline-list">
                <?php foreach (array_slice($rescheduleRequests, 0, 5) as $request): ?>
                  <div class="timeline-item">
                    <strong><?= htmlspecialchars($request['requested_date']) ?> at <?= htmlspecialchars($request['requested_time']) ?></strong>
                    <span>Reschedule request <?= htmlspecialchars($request['status']) ?> • Submitted <?= htmlspecialchars(timeAgo($request['created_at'])) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Corporate Inquiries sub-panel -->
      <div class="sub-tab-panel" id="sub-corporate">
        <p class="section-sub">Corporate Inquiries</p>
        <?php if (empty($corpInquiries)): ?>
          <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            <p style="margin-top:12px;">No corporate inquiries yet.<br>
              <a href="corporateservice.php" style="color:var(--mid);font-weight:600;">Submit a corporate inquiry</a> to get started.
            </p>
          </div>
        <?php else: ?>
          <div class="appt-table-wrap">
            <table class="appt-table">
              <thead><tr><th>Submitted</th><th>Company</th><th>Service</th><th>Schedule</th><th>Status</th></tr></thead>
              <tbody>
              <?php foreach ($corpInquiries as $ci):
                $cStatus = strtolower($ci['status'] ?? 'pending');
                $cBadge  = match($cStatus) {'in progress'=>'status-approved','completed'=>'status-completed','cancelled'=>'status-cancelled',default=>'status-pending'};
                $cDate   = isset($ci['created_at']) ? date('M j, Y', strtotime($ci['created_at'])) : '—';
                $cLabel  = match($cStatus) {'in progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled',default=>'Pending'};
              ?>
              <tr>
                <td><?= htmlspecialchars($cDate) ?></td>
                <td>
                  <div style="font-weight:600;color:var(--deep);"><?= htmlspecialchars($ci['company_name'] ?? '—') ?></div>
                  <div style="font-size:.75rem;color:var(--g400);"><?= htmlspecialchars($ci['contact_person'] ?? '') ?> &middot; <?= htmlspecialchars($ci['designation'] ?? '') ?></div>
                </td>
                <td><?= htmlspecialchars($ci['service_type'] ?? '—') ?></td>
                <td><?= htmlspecialchars($ci['schedule'] ?? '—') ?></td>
                <td><span class="status-badge <?= $cBadge ?>"><?= $cLabel ?></span></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div style="margin-top:14px;background:var(--pale);border-radius:8px;padding:10px 14px;border:1px solid #a8e6c1;font-size:.78rem;color:var(--g400);">
            In Progress: <strong style="color:var(--deep);">In Progress</strong> means our team has reviewed your inquiry and a clinic staff member will contact you shortly.
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="tab-panel" id="tab-inbox">
      <div class="panel-header">
        <div class="panel-header-copy">
          <div class="panel-kicker">Communication</div>
          <div class="panel-title">Notification Inbox</div>
          <div class="panel-subtitle">View updates from your appointments, account activity, and corporate inquiries. Use filters to focus on the messages you need.</div>
        </div>
        <div class="panel-aside">
          <strong><?= (int) $unreadCount ?></strong>
          <span>Unread notifications</span>
        </div>
      </div>
      <div class="inbox-card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:14px;">
          <select class="notif-filter" id="notifFilter" style="max-width:240px;">
            <option value="all">All notifications</option>
            <option value="unread">Unread only</option>
            <option value="appointments">Appointments</option>
            <option value="corporate">Corporate updates</option>
          </select>
          <button class="mark-all-btn" type="button" onclick="markAllRead()">Mark all read</button>
        </div>
        <div class="notif-list" id="inboxList">
          <div class="notif-empty"><p>Use the filter to review your latest updates.</p></div>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  /* Tab switching */
  function switchTab(id, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
    if (id === 'inbox') fetchNotifList();
  }
  function switchSubTab(id, btn) {
    document.querySelectorAll('.sub-tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.sub-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('sub-' + id).classList.add('active');
    btn.classList.add('active');
  }

  /* Banner dismiss */
  function dismissBanner(i) {
    const el = document.getElementById('banner-' + i);
    if (!el) return;
    el.style.transition = 'opacity .25s,transform .25s';
    el.style.opacity = '0'; el.style.transform = 'translateY(-8px)';
    setTimeout(() => { el.remove(); const z = document.getElementById('notifZone'); if (z && !z.children.length) z.remove(); }, 280);
  }

  /* Navbar dropdown */
  function toggleNav(id, e) {
    e.stopPropagation();
    const item = document.getElementById(id);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
  function toggleMobileNav() {
    document.getElementById('mobileNavPanel')?.classList.toggle('open');
  }
  document.addEventListener('click', () => {
    document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
  });
  document.querySelectorAll('.nav-dropdown').forEach(d => d.addEventListener('click', e => e.stopPropagation()));
  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('mouseenter', () => { if (window.innerWidth > 768 && item.querySelector('.nav-dropdown')) { document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open')); item.classList.add('open'); } });
    item.addEventListener('mouseleave', () => { if (window.innerWidth > 768) item.classList.remove('open'); });
  });

  /* Notification bell */
  function toggleNotifDropdown(e) {
    e.stopPropagation();
    document.getElementById('notifDropdown').classList.toggle('open');
  }
  document.addEventListener('click', e => {
    const w = document.getElementById('bellWrap');
    if (w && !w.contains(e.target)) document.getElementById('notifDropdown')?.classList.remove('open');
  });
  function markRead(id, el) {
    const actionUrl = el?.dataset?.actionUrl || '';
    const finish = () => {
      if (actionUrl) window.location.href = actionUrl;
    };

    if (!el.classList.contains('unread')) {
      finish();
      return;
    }

    fetch('notifications_api.php', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-Token': notificationsCsrfToken }, body: 'action=mark_read&id=' + id })
      .then(() => { el.classList.remove('unread'); updateBadgeCount(-1); finish(); });
  }
  function markAllRead() {
    fetch('notifications_api.php', { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-Token': notificationsCsrfToken }, body: 'action=mark_all_read' })
      .then(() => {
        document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
        updateBadgeCount(0, true);
        document.getElementById('bellBtn')?.classList.remove('has-unread');
      });
  }
  let currentUnread = <?= $unreadCount ?>;
  function updateBadgeCount(delta, reset = false) {
    if (reset) currentUnread = 0; else currentUnread = Math.max(0, currentUnread + delta);
    const badge = document.getElementById('bellBadge'), btn = document.getElementById('bellBtn');
    if (badge) { badge.textContent = currentUnread; badge.classList.toggle('hidden', currentUnread === 0); }
    if (btn) btn.classList.toggle('has-unread', currentUnread > 0);
  }
  function pollNotifications() {
    fetch('notifications_api.php?action=get_unread_count').then(r => r.json()).then(data => {
      if (data.count !== undefined && data.count !== currentUnread) {
        if (data.count > currentUnread) fetchNotifList();
        currentUnread = data.count;
        const badge = document.getElementById('bellBadge'), btn = document.getElementById('bellBtn');
        if (badge) { badge.textContent = data.count; badge.classList.toggle('hidden', data.count === 0); }
        if (btn) btn.classList.toggle('has-unread', data.count > 0);
      }
    }).catch(() => {});
  }
  function fetchNotifList() {
    const filter = document.getElementById('notifFilter')?.value || 'all';
    fetch('notifications_api.php?action=get_notifications&filter=' + encodeURIComponent(filter)).then(r => r.json()).then(data => {
      if (!data.notifications) return;
      const list = document.getElementById('notifList');
      const inbox = document.getElementById('inboxList');
      const iconMap = { today:'Today', tomorrow:'Soon', fasting:'Prep', '3day':'Plan', confirmed:'OK', pending:'Pending', corp_pending:'Pending', corp_in_progress:'Call', corp_contacted:'Update', corp_completed:'OK', result_ready:'Result', reschedule_requested:'Note', admin:'Admin' };
      const markup = data.notifications.map(n => `
        <div class="notif-item ${n.is_read == 0 ? 'unread' : ''}" data-action-url="${escHtml(n.action_url || '')}" onclick="markRead(${n.id}, this)">
          <div class="notif-dot notif-dot-${n.type}">${iconMap[n.type] || 'Info'}</div>
          <div class="notif-item-content">
            <div class="notif-item-title">${escHtml(n.title)}</div>
            <div class="notif-item-msg">${n.message}</div>
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
              <div class="notif-item-time">${escHtml(n.time_ago)}</div>
              ${n.category ? '<span class="email-sent-chip">' + escHtml(n.category) + '</span>' : ''}
              ${n.email_sent ? '<span class="email-sent-chip">Email sent</span>' : ''}
            </div>
          </div>
        </div>`).join('') || '<div class="notif-empty"><p>No notifications yet</p></div>';
      if (list) list.innerHTML = markup;
      if (inbox) inbox.innerHTML = markup;
    }).catch(() => {});
  }
  function escHtml(s) { const d = document.createElement('div'); d.appendChild(document.createTextNode(s)); return d.innerHTML; }
  setInterval(pollNotifications, 30000);
  document.getElementById('notifFilter')?.addEventListener('change', fetchNotifList);
  fetchNotifList();

  const initialTab = new URLSearchParams(window.location.search).get('tab');
  if (initialTab) {
    const btn = Array.from(document.querySelectorAll('.tab-btn')).find(el => {
      return el.textContent.toLowerCase().includes(initialTab.toLowerCase());
    });
    if (btn && document.getElementById('tab-' + initialTab)) {
      switchTab(initialTab, btn);
    }
  }

  /* Countdown */
  function runCountdowns() {
    document.querySelectorAll('[id^="countdownChip-"]').forEach((chip, idx) => {
      const timeStr = todayAppointments[idx]; if (!timeStr) return;
      const now = new Date(), parts = timeStr.match(/(\d+):(\d+)\s*(AM|PM)/i); if (!parts) return;
      let h = parseInt(parts[1]); const m = parseInt(parts[2]), ampm = parts[3].toUpperCase();
      if (ampm === 'PM' && h !== 12) h += 12; if (ampm === 'AM' && h === 12) h = 0;
      const apptTime = new Date(now); apptTime.setHours(h, m, 0, 0);
      const diff = apptTime - now;
      if (diff <= 0) { chip.innerHTML = '⏱ Your appointment time has arrived!'; return; }
      const hrs = Math.floor(diff / 3600000), mins = Math.floor((diff % 3600000) / 60000), secs = Math.floor((diff % 60000) / 1000);
      chip.innerHTML = `⏱ Starts in <strong>${hrs}h ${mins}m ${secs}s</strong>`;
    });
  }
  if (todayAppointments.length > 0) { runCountdowns(); setInterval(runCountdowns, 1000); }
</script>
</body>
</html>