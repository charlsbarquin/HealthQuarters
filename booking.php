<?php require __DIR__ . '/includes/booking/request.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Service Appointment — HealthQuarters</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --gs: #6abf4b; --ge: #2dbfb8; --accent: #2dbfb8;
    --deep: #1a4d2e; --mid: #2d7a4f; --bright: #3aad6e;
    --pale: #e8f7ee; --muted: #f0faf4;
    --g100: #f7f9f8; --g200: #e8eeeb; --g400: #94a89d; --g600: #4a6057;
    --border: #dde8e4;
    --green-deep: #1a4d2e;
    --green-mid: #2d7a4f;
    --green-bright: #3aad6e;
    --green-light: #a8e6c1;
    --green-pale: #e8f7ee;
    --green-muted: #f0faf4;
    --gray-100: #f7f9f8;
    --gray-200: #e8eeeb;
    --gray-400: #94a89d;
    --gray-600: #4a6057;
    --gray-800: #1e302a;
    --error: #e05252;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 8px 40px rgba(26,77,46,0.10);
    --shadow-lg: 0 20px 60px rgba(26,77,46,0.16);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--green-muted);
    min-height: 100vh;
    color: var(--gray-800);
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed; top: -120px; right: -120px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(58,173,110,0.13) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
  }
  body::after {
    content: '';
    position: fixed; bottom: -100px; left: -100px;
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(26,77,46,0.09) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
  }

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
  }
  .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
  .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }

  .topbar-nav { display: flex; align-items: stretch; flex: 1; }
  .mobile-nav-toggle { display:none; margin-left:auto; align-items:center; justify-content:center; width:42px; height:42px; border-radius:12px; border:1.5px solid rgba(255,255,255,.28); background:rgba(255,255,255,.14); color:#fff; }
  .mobile-nav-panel { display:none; background:#fff; border-bottom:1px solid var(--border); box-shadow:0 10px 28px rgba(13,46,30,.1); }
  .mobile-nav-panel.open { display:block; }
  .mobile-nav-links { max-width:900px; margin:0 auto; padding:14px 24px 18px; display:grid; gap:10px; }
  .mobile-nav-links a { display:block; padding:12px 14px; border-radius:12px; text-decoration:none; color:var(--deep); background:var(--green-muted); border:1px solid var(--gray-200); font-weight:600; }
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

  /* Right side */
  .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; }
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
  .btn-logout {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
    color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
    border-radius: 4px; text-decoration: none; transition: all .2s;
  }
  .btn-logout:hover { background: rgba(255,255,255,.28); color: #fff; }

  /* ═══════════════════════════════════════
     BOOKING FORM STYLES (unchanged)
  ═══════════════════════════════════════ */
  main { max-width: 980px; margin: 0 auto; padding: 40px 24px 80px; position: relative; z-index: 1; }
  .page-intro {
    max-width: 980px; margin: 0 auto 24px; padding: 0 24px;
    display:grid; grid-template-columns:1.08fr .92fr; gap:18px;
  }
  .intro-card {
    background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%);
    border:1px solid var(--gray-200); border-radius:22px; padding:22px;
    box-shadow:0 10px 30px rgba(26,77,46,0.08);
  }
  .sec-header {
    display:flex; align-items:flex-end; justify-content:space-between; gap:16px;
    border-bottom:1px solid rgba(106,191,75,.18); padding-bottom:14px; margin-bottom:18px;
  }
  .sec-header h2 {
    font-family:'DM Serif Display', serif; font-size:1.22rem; color:var(--green-deep);
    display:flex; align-items:center; gap:10px; margin:0;
  }
  .sec-header h2::before {
    content:''; width:10px; height:10px; border-radius:999px;
    background:linear-gradient(135deg, var(--gs), var(--ge)); box-shadow:0 0 0 6px rgba(106,191,75,.09);
  }
  .intro-card p { font-size:.84rem; color:var(--gray-600); line-height:1.72; margin:0; }
  .intro-pills { display:flex; flex-wrap:wrap; gap:8px; margin-top:14px; }
  .intro-pill {
    display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px;
    background:var(--green-pale); border:1px solid var(--gray-200); color:var(--green-mid);
    font-size:.72rem; font-weight:700; letter-spacing:.04em;
  }

  /* STEPPER */
  .stepper { display: flex; align-items: flex-start; justify-content: center; gap: 0; margin-bottom: 48px; }
  .step-item { display: flex; flex-direction: column; align-items: center; flex: 1; max-width: 200px; position: relative; }
  .step-item:not(:last-child)::after {
    content: ''; position: absolute; top: 24px;
    left: calc(50% + 28px); right: calc(-50% + 28px);
    height: 2px; background: var(--gray-200); transition: background 0.4s; z-index: 0;
  }
  .step-item.completed:not(:last-child)::after { background: var(--green-bright); }
  .step-circle {
    width: 48px; height: 48px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 600; font-size: 1rem; position: relative; z-index: 1;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    border: 2.5px solid var(--gray-200); background: #fff; color: var(--gray-400);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  .step-item.active .step-circle {
    background: var(--green-bright); border-color: var(--green-bright); color: #fff;
    box-shadow: 0 0 0 6px rgba(58,173,110,0.18), 0 4px 16px rgba(58,173,110,0.3); transform: scale(1.08);
  }
  .step-item.completed .step-circle { background: var(--green-mid); border-color: var(--green-mid); color: #fff; }
  .step-label { margin-top: 10px; font-size: 0.75rem; color: var(--gray-400); text-align: center; font-weight: 400; max-width: 110px; line-height: 1.4; transition: color 0.3s; }
  .step-item.active .step-label { color: var(--green-mid); font-weight: 600; }
  .step-item.completed .step-label { color: var(--green-mid); }

  /* CARD */
  .card { background: #fff; border-radius: 24px; box-shadow: var(--shadow-lg); overflow: hidden; animation: cardIn 0.45s cubic-bezier(.4,0,.2,1); }
  @keyframes cardIn { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: translateY(0); } }
  .card-header { background: linear-gradient(135deg, var(--green-pale) 0%, var(--green-muted) 100%); padding: 32px 40px 24px; border-bottom: 1.5px solid var(--gray-200); }
  .step-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--green-bright); color: #fff; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 4px 12px; border-radius: 50px; margin-bottom: 12px; }
  .card-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.6rem; color: var(--green-deep); letter-spacing: -0.02em; }
  .card-header p { font-size: 0.88rem; color: var(--gray-600); margin-top: 6px; }
  .card-body { padding: 36px 40px 32px; }
  .form-callout { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:12px; margin-bottom:24px; }
  .callout-card { background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%); border:1px solid var(--gray-200); border-radius:16px; padding:14px 15px; }
  .callout-card strong { display:block; font-family:'DM Serif Display', serif; font-size:1.15rem; color:var(--green-deep); margin-bottom:6px; }
  .callout-card span { display:block; font-size:.75rem; color:var(--gray-600); line-height:1.55; }

  /* FORM */
  .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 22px 28px; }
  .form-grid .full { grid-column: 1 / -1; }
  .field { display: flex; flex-direction: column; gap: 7px; }

  label { font-size: 0.8rem; font-weight: 600; color: var(--green-deep); letter-spacing: 0.03em; text-transform: uppercase; }
  label .req { color: var(--green-bright); margin-left: 2px; }

  input[type="text"],
  input[type="email"],
  input[type="tel"],
  input[type="date"],
  input[type="number"],
  select, textarea {
    width: 100%; padding: 12px 16px;
    border: 2px solid var(--gray-200); border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 0.92rem;
    color: var(--gray-800); background: var(--gray-100);
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none; appearance: none; -webkit-appearance: none;
  }
  input:focus, select:focus, textarea:focus {
    border-color: var(--green-bright);
    box-shadow: 0 0 0 4px rgba(58,173,110,0.14);
    background: #fff;
  }
  input.error, select.error { border-color: var(--error); }
  input[type="number"] { -moz-appearance: textfield; }
  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button { opacity: 1; }

  .error-msg { font-size: 0.75rem; color: var(--error); display: none; }
  .error-msg.show { display: block; }

  select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%234a6057' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
  }
  select:disabled { opacity: 0.5; cursor: not-allowed; }
  .age-hint { font-size: 0.73rem; color: var(--gray-400); margin-top: -4px; }

  .autofill-banner {
    background: var(--green-pale); border: 1.5px solid var(--green-light);
    border-radius: var(--radius-sm); padding: 12px 16px;
    display: flex; align-items: center; gap: 10px;
    font-size: 0.82rem; color: var(--green-deep); margin-bottom: 20px;
  }
  .autofill-banner strong { font-weight: 700; }
  .autofill-banner svg { flex-shrink: 0; }

  .locked-field { position: relative; }
  .locked-field input {
    background: var(--gray-200) !important; color: var(--gray-600) !important;
    cursor: not-allowed; padding-right: 40px;
  }

  .radio-group { display: flex; gap: 12px; flex-wrap: wrap; }
  .radio-option { flex: 1; min-width: 100px; }
  .radio-option input[type="radio"] { display: none; }
  .radio-option label {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 11px 16px; border: 2px solid var(--gray-200); border-radius: var(--radius-sm);
    cursor: pointer; font-size: 0.88rem; font-weight: 500;
    text-transform: none; letter-spacing: 0; color: var(--gray-600); background: var(--gray-100);
    transition: all 0.2s;
  }
  .radio-option input[type="radio"]:checked + label { border-color: var(--green-bright); background: var(--green-pale); color: var(--green-deep); }
  .radio-option label:hover { border-color: var(--green-light); }

  .time-slots { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 10px; }
  .time-slot {
    padding: 10px 8px; text-align: center;
    border: 2px solid var(--gray-200); border-radius: var(--radius-sm);
    font-size: 0.82rem; font-weight: 500;
    cursor: pointer; color: var(--gray-600); background: var(--gray-100);
    transition: all 0.2s; user-select: none;
  }
  .time-slot:hover { border-color: var(--green-light); background: var(--green-pale); color: var(--green-deep); }
  .time-slot.selected { border-color: var(--green-bright); background: var(--green-bright); color: #fff; font-weight: 600; }
  .time-slot.taken { border-color: var(--gray-200) !important; background: var(--gray-100) !important; color: var(--gray-400) !important; cursor: not-allowed !important; opacity: 0.45; pointer-events: none; }

  .section-divider { display: flex; align-items: center; gap: 14px; margin: 28px 0 24px; }
  .section-divider span { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--green-mid); white-space: nowrap; }
  .section-divider::before, .section-divider::after { content: ''; flex: 1; height: 1.5px; background: var(--gray-200); }

  .review-block { background: var(--gray-100); border-radius: var(--radius); padding: 24px 28px; margin-bottom: 20px; border: 1.5px solid var(--gray-200); }
  .review-block h3 { font-family: 'DM Serif Display', serif; font-size: 1.05rem; color: var(--green-deep); margin-bottom: 16px; }
  .review-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px 28px; }
  .review-item label { font-size: 0.72rem; color: var(--gray-400); text-transform: uppercase; font-weight: 600; letter-spacing: 0.06em; margin-bottom: 2px; display: block; }
  .review-item span { font-size: 0.92rem; color: var(--gray-800); font-weight: 500; }

  .consent-box { background: var(--green-pale); border: 1.5px solid var(--green-light); border-radius: var(--radius-sm); padding: 18px 20px; display: flex; gap: 14px; align-items: flex-start; margin-top: 20px; cursor: pointer; transition: background 0.2s; }
  .consent-box:hover { background: #d5f2e3; }
  .consent-box input[type="checkbox"] { display: none; }
  .custom-check { width: 22px; height: 22px; min-width: 22px; border: 2px solid var(--green-bright); border-radius: 6px; display: flex; align-items: center; justify-content: center; background: #fff; transition: all 0.2s; margin-top: 1px; }
  .custom-check.checked { background: var(--green-bright); border-color: var(--green-bright); }
  .custom-check svg { display: none; }
  .custom-check.checked svg { display: block; }
  .consent-text { font-size: 0.85rem; color: var(--gray-600); line-height: 1.6; }
  .consent-text strong { color: var(--green-deep); }

  .card-footer { padding: 20px 40px 32px; display: flex; align-items: center; justify-content: space-between; gap: 16px; border-top: 1.5px solid var(--gray-200); flex-wrap: wrap; }
  .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 28px; border-radius: 50px; font-family: 'DM Sans', sans-serif; font-size: 0.92rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.22s cubic-bezier(.4,0,.2,1); text-decoration: none; outline: none; white-space: nowrap; }
  .btn-primary { background: linear-gradient(135deg, var(--green-bright) 0%, var(--green-mid) 100%); color: #fff; box-shadow: 0 4px 16px rgba(45,122,79,0.28); }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,122,79,0.38); }
  .btn-secondary { background: transparent; color: var(--green-mid); border: 2px solid var(--gray-200); }
  .btn-secondary:hover { background: var(--green-pale); border-color: var(--green-light); }
  .btn-success { background: linear-gradient(135deg, var(--green-mid) 0%, var(--green-deep) 100%); color: #fff; box-shadow: 0 4px 20px rgba(26,77,46,0.3); padding: 14px 36px; font-size: 1rem; }
  .btn-success:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,77,46,0.38); }

  .success-screen { text-align: center; padding: 60px 40px; }
  .success-icon { width: 90px; height: 90px; background: linear-gradient(135deg, var(--green-bright), var(--green-mid)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 28px; box-shadow: 0 0 0 16px rgba(58,173,110,0.12), 0 8px 32px rgba(58,173,110,0.28); animation: popIn 0.5s cubic-bezier(.4,0,.2,1); }
  @keyframes popIn { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
  .success-screen h2 { font-family: 'DM Serif Display', serif; font-size: 2rem; color: var(--green-deep); margin-bottom: 12px; }
  .success-screen p { color: var(--gray-600); font-size: 0.95rem; line-height: 1.7; max-width: 420px; margin: 0 auto 32px; }
  .btn-view-profile { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 50px; background: transparent; color: var(--green-mid); border: 2px solid var(--green-light); font-family: 'DM Sans', sans-serif; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: all 0.2s; margin-left: 12px; }
  .btn-view-profile:hover { background: var(--green-pale); border-color: var(--green-bright); }

  .progress-bar-wrap { height: 4px; background: var(--gray-200); border-radius: 2px; margin-bottom: 40px; overflow: hidden; }
  .progress-bar { height: 100%; background: linear-gradient(90deg, var(--green-bright), var(--green-mid)); border-radius: 2px; transition: width 0.5s cubic-bezier(.4,0,.2,1); }

  .info-note { background: var(--green-pale); border-left: 3px solid var(--green-bright); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding: 12px 16px; font-size: 0.82rem; color: var(--green-deep); margin-bottom: 20px; line-height: 1.5; }

  .slot-error { background: #fdecea; border: 1.5px solid #f5b4b4; border-radius: var(--radius-sm); padding: 14px 18px; font-size: 0.88rem; color: var(--error); display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px; }
  .slot-error svg { flex-shrink: 0; margin-top: 1px; }

  .step-panel { display: none; }
  .step-panel.active { display: block; }

  optgroup { font-weight: 700; color: var(--green-deep); font-style: normal; }
  optgroup option { font-weight: 400; color: var(--gray-800); padding-left: 8px; }

  @media (max-width: 860px) {
    .topbar-inner { height: 60px; padding: 0 16px; }
    .brand-logo { height: 40px; width: 40px; }
    .brand-name { font-size: 1.2rem; }
    .topbar-nav { display: none; }
    .patient-name { display: none; }
    .mobile-nav-toggle { display:inline-flex; }
  }
  @media (max-width: 680px) {
    main { padding: 24px 16px 60px; }
    .card-body, .card-header, .card-footer { padding-left: 20px; padding-right: 20px; }
    .form-grid { grid-template-columns: 1fr; }
    .form-grid .full { grid-column: 1; }
    .review-grid { grid-template-columns: 1fr; }
    .stepper { gap: 0; }
    .step-label { font-size: 0.65rem; max-width: 80px; }
    .step-circle { width: 40px; height: 40px; font-size: 0.85rem; }
    .step-item:not(:last-child)::after { top: 20px; }
    .time-slots { grid-template-columns: repeat(3, 1fr); }
    .btn-success { width: 100%; }
    .page-intro, .form-callout, .footer-grid { grid-template-columns:1fr; }
    .footer-inner { padding:30px 16px 16px; }
  }
  @media (max-width: 480px) { .brand-name { display: none; } }

  /* ── Multi-Service Picker ── */
.service-picker { border: 2px solid var(--gray-200); border-radius: var(--radius-sm); background: var(--gray-100); overflow: hidden; transition: border-color 0.2s, box-shadow 0.2s; }
.service-picker.focused { border-color: var(--green-bright); box-shadow: 0 0 0 4px rgba(58,173,110,0.14); background: #fff; }
.service-picker.error { border-color: var(--error); }
.service-search-wrap { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-bottom: 1.5px solid var(--gray-200); background: #fff; }
.service-search-wrap svg { flex-shrink: 0; color: var(--gray-400); }
.service-search { border: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; width: 100%; background: transparent; color: var(--gray-800); }
.service-search::placeholder { color: var(--gray-400); }
.service-list { max-height: 260px; overflow-y: auto; padding: 6px 0; }
.service-list::-webkit-scrollbar { width: 6px; }
.service-list::-webkit-scrollbar-track { background: transparent; }
.service-list::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 3px; }
.service-group-label { font-size: 0.68rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--gray-400); padding: 10px 14px 4px; pointer-events: none; }
.service-option { display: flex; align-items: center; gap: 10px; padding: 8px 14px; cursor: pointer; transition: background 0.15s; }
.service-option:hover { background: var(--green-pale); }
.service-option.hidden { display: none; }
.service-option input[type="checkbox"] { display: none; }
.svc-check { width: 18px; height: 18px; min-width: 18px; border: 2px solid var(--gray-200); border-radius: 5px; display: flex; align-items: center; justify-content: center; background: #fff; transition: all 0.15s; }
.service-option.checked .svc-check { background: var(--green-bright); border-color: var(--green-bright); }
.service-option.checked .svc-check svg { display: block; }
.svc-check svg { display: none; width: 11px; height: 11px; stroke: #fff; stroke-width: 3; fill: none; }
.service-option.checked { background: var(--green-pale); }
.svc-label { font-size: 0.88rem; color: var(--gray-800); }
.service-option.checked .svc-label { color: var(--green-deep); font-weight: 500; }
.service-no-results { padding: 18px 14px; font-size: 0.85rem; color: var(--gray-400); text-align: center; display: none; }

.selected-tags-wrap { min-height: 42px; padding: 8px 12px; display: flex; flex-wrap: wrap; gap: 7px; align-items: flex-start; }
.selected-tags-wrap.empty::before { content: 'No services selected yet'; font-size: 0.82rem; color: var(--gray-400); align-self: center; }
.svc-tag { display: inline-flex; align-items: center; gap: 6px; background: var(--green-pale); border: 1.5px solid var(--green-light); border-radius: 50px; padding: 4px 10px 4px 12px; font-size: 0.78rem; font-weight: 500; color: var(--green-deep); }
.svc-tag button { background: none; border: none; cursor: pointer; padding: 0; color: var(--green-mid); display: flex; align-items: center; line-height: 1; font-size: 14px; transition: color 0.15s; }
.svc-tag button:hover { color: var(--error); }
.service-count-hint { font-size: 0.73rem; color: var(--gray-400); margin-top: 4px; }

.site-footer {
  background: linear-gradient(135deg, #0f2a1c 0%, #1a4d2e 48%, #17595a 100%);
  color: rgba(255,255,255,.82);
}
.footer-inner { max-width:1280px; margin:0 auto; padding:38px 24px 18px; }
.footer-grid { display:grid; grid-template-columns:1.3fr .9fr .9fr; gap:20px; }
.footer-card {
  background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:22px;
  padding:22px 20px; box-shadow:0 14px 36px rgba(0,0,0,.18);
}
.footer-card h3,.footer-card h4 { margin:0 0 12px; }
.footer-card h3 { font-family:'DM Serif Display', serif; font-size:1.3rem; color:#fff; }
.footer-card h4 { font-size:.78rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:#a8e6c1; }
.footer-card p,.footer-card a,.footer-card span { font-size:.82rem; line-height:1.65; color:rgba(255,255,255,.76); text-decoration:none; }
.footer-links { display:flex; flex-direction:column; gap:10px; }
.footer-links a:hover { color:#fff; }
.footer-bottom { margin-top:20px; padding-top:16px; border-top:1px solid rgba(255,255,255,.12); font-size:.76rem; color:rgba(255,255,255,.62); display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; }

</style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVBAR — lp.php style with patient chip + logout
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
        <button class="nav-btn active" onclick="toggleNav('navServices',event)">
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
          <a class="drop-link" href="booking.php">Home Service</a>
          <a class="drop-link" href="corporateservice.php">Corporate Service</a>
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

  </div>
</nav>
<div class="mobile-nav-panel" id="mobileNavPanel">
  <div class="mobile-nav-links">
    <a href="homepage.php">Home</a>
    <a href="profile.php">My Profile</a>
    <a href="booking.php">Book Home Service</a>
    <a href="corporateservice.php">Corporate Inquiry</a>
    <a href="locations.php">Locations</a>
  </div>
</div>

<section class="page-intro">
  <div class="intro-card">
    <div class="sec-header"><h2>Home Service Booking</h2></div>
    <p>Schedule a visit with clearer steps, easier service selection, and a more guided booking flow built for patients on both desktop and mobile.</p>
    <div class="intro-pills">
      <span class="intro-pill">3-step process</span>
      <span class="intro-pill">Branch-based availability</span>
      <span class="intro-pill">Downloadable confirmation</span>
    </div>
  </div>
  <div class="intro-card">
    <div class="sec-header"><h2>Before You Start</h2></div>
    <p>Prepare your preferred branch, target date, contact details, and requested services so you can finish the booking process more smoothly.</p>
    <div class="intro-pills">
      <span class="intro-pill">Patient details ready</span>
      <span class="intro-pill">Address prepared</span>
      <span class="intro-pill">Time slot selection</span>
    </div>
  </div>
</section>

<main>

  <div class="stepper">
    <div class="step-item <?php echo $show_success ? 'completed' : 'active'; ?>" id="step-dot-1">
      <div class="step-circle">1</div>
      <div class="step-label">Schedule & Branch</div>
    </div>
    <div class="step-item <?php echo $show_success ? 'completed' : ''; ?>" id="step-dot-2">
      <div class="step-circle">2</div>
      <div class="step-label">Patient Details</div>
    </div>
    <div class="step-item <?php echo $show_success ? 'completed' : ''; ?>" id="step-dot-3">
      <div class="step-circle">3</div>
      <div class="step-label">Review & Submit</div>
    </div>
  </div>

  <div class="progress-bar-wrap">
    <div class="progress-bar" id="progressBar" style="width:<?php echo $show_success ? '100' : '33'; ?>%"></div>
  </div>

  <div class="card">

    <?php if ($show_success): ?>
    <div class="step-panel active" id="panel-success">
      <div class="success-screen">
        <div class="success-icon">
          <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h2>Request Submitted!</h2>
        <p>Your home service appointment request has been received. Our team will review your request and contact you within <strong>24–48 hours</strong> to confirm your schedule.</p>
        <?php if (!empty($ref) && !empty($appointmentId)): ?>
        <div style="margin-top:18px;padding:14px 16px;background:#f0faf4;border:1px solid #d9ebe1;border-radius:14px;text-align:left;max-width:520px;margin-left:auto;margin-right:auto;">
          <div style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6a8577;margin-bottom:8px;">Appointment Confirmation</div>
          <div style="font-size:.98rem;font-weight:700;color:#1a4d2e;">Reference Number: <?= htmlspecialchars($ref) ?></div>
          <div style="font-size:.82rem;color:#4a6057;margin-top:6px;">Download a PDF copy containing your submitted appointment details, personal information, contact number, and service address for your records.</div>
        </div>
        <?php endif; ?>
        <br><br>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
          <button class="btn btn-primary" onclick="window.location.href='booking.php'">Book Another</button>
          <a href="profile.php" class="btn-view-profile">View My Appointments</a>
          <?php if (!empty($appointmentId)): ?>
          <a href="download_booking_confirmation.php?id=<?= (int) $appointmentId ?>" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
            Download Confirmation PDF
          </a>
          <?php endif; ?>
          <button class="btn btn-secondary" onclick="window.location.href='homepage.php'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Go Back Home
          </button>
        </div>
      </div>
    </div>

    <?php else: ?>

    <!-- ===== STEP 1: Schedule & Branch ===== -->
    <div class="step-panel active" id="panel-1">
      <div class="card-header">
        <div class="step-badge">Step 1 of 3</div>
        <h2>Schedule an Appointment</h2>
        <p>Choose your preferred branch, date, time, and service.</p>
      </div>
      <div class="card-body">
        <div class="form-callout">
          <div class="callout-card"><strong>Step 1</strong><span>Pick the branch, date, and time slot that works best for you.</span></div>
          <div class="callout-card"><strong>Step 2</strong><span>Complete the patient details exactly as you want them recorded.</span></div>
          <div class="callout-card"><strong>Step 3</strong><span>Review everything before submitting your appointment request.</span></div>
        </div>

        <?php if ($slot_taken || !empty($booking_error)): ?>
        <div class="slot-error">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span><strong>Booking request needs attention.</strong> <?= htmlspecialchars($booking_error ?: 'This time slot is no longer available. Another patient has already booked this schedule. Please choose a different date or time.') ?></span>
        </div>
        <?php endif; ?>

        <div class="info-note">
          Our home service team covers all municipalities in Albay. Appointments are available Monday–Saturday, 7 AM – 5 PM.
        </div>

        <div class="form-grid">
          <div class="field full">
            <label>HealthQuarters Branch <span class="req">*</span></label>
            <select id="branch">
              <option value="">Select a branch...</option>
              <?php foreach ($branchOptions as $value => $branchMeta): ?>
                <option value="<?= htmlspecialchars($value) ?>" <?= (($slot_taken || !empty($booking_error)) && (($value) === ($_POST['branch'] ?? ''))) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($branchMeta['label'] . ' — ' . $branchMeta['city']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="error-msg" id="err-branch">Please select a branch.</span>
            <div style="margin-top:8px;padding:10px 12px;background:var(--green-muted);border:1px solid var(--gray-200);border-radius:10px;font-size:.78rem;color:var(--gray-600);" id="branchHint">
              Pick a branch first. Slot availability and branch capacity will update automatically.
            </div>
          </div>

          <div class="field full">
            <label>Preferred Date of Visit <span class="req">*</span></label>
            <input type="date" id="apptDate" min=""
              value="<?php echo $slot_taken ? htmlspecialchars($_POST['appt_date'] ?? '') : ''; ?>">
            <span class="error-msg" id="err-date">Please select a date.</span>
          </div>

          <div class="field full">
            <label>Preferred Time Slot <span class="req">*</span></label>
            <div class="time-slots" id="timeSlots">
              <?php foreach ($allowedSlots as $slot): ?>
                <div class="time-slot" data-val="<?= htmlspecialchars($slot) ?>"><?= htmlspecialchars($slot) ?></div>
              <?php endforeach; ?>
            </div>
            <span class="error-msg" id="err-time">Please select a time slot.</span>
            <div style="margin-top:8px;font-size:.76rem;color:var(--gray-600);" id="slotHint">Available slots are checked per branch, date, and time.</div>
          </div>

          <div class="field full">
            <label>Service Type(s) <span class="req">*</span> <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--gray-400);font-size:0.75rem;">(select one or more)</span></label>

            <!-- Selected tags display -->
            <div class="selected-tags-wrap empty" id="selectedTagsWrap"></div>
            <div class="service-count-hint" id="svcCountHint"></div>

            <!-- Picker dropdown -->
            <div class="service-picker" id="servicePicker">
              <div class="service-search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" class="service-search" id="serviceSearch" placeholder="Search services..." autocomplete="off">
              </div>
              <div class="service-list" id="serviceList">
                <div class="service-no-results" id="svcNoResults">No services match your search.</div>

                <div class="service-group-label">Hematology</div>
                <label class="service-option" data-val="CBC"><input type="checkbox" value="CBC"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CBC</span></label>
                <label class="service-option" data-val="Platelet Count"><input type="checkbox" value="Platelet Count"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Platelet Count</span></label>
                <label class="service-option" data-val="WBC Count"><input type="checkbox" value="WBC Count"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">WBC Count</span></label>
                <label class="service-option" data-val="Hgb/Hct"><input type="checkbox" value="Hgb/Hct"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hgb/Hct</span></label>
                <label class="service-option" data-val="ESR"><input type="checkbox" value="ESR"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">ESR</span></label>
                <label class="service-option" data-val="BT"><input type="checkbox" value="BT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">BT</span></label>
                <label class="service-option" data-val="CTBT"><input type="checkbox" value="CTBT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CTBT</span></label>

                <div class="service-group-label">Hematology (Special Test)</div>
                <label class="service-option" data-val="Reticulocyte Count"><input type="checkbox" value="Reticulocyte Count"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Reticulocyte Count</span></label>
                <label class="service-option" data-val="PBS"><input type="checkbox" value="PBS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">PBS</span></label>
                <label class="service-option" data-val="RH Factor"><input type="checkbox" value="RH Factor"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">RH Factor</span></label>
                <label class="service-option" data-val="COOMBS"><input type="checkbox" value="COOMBS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">COOMBS</span></label>

                <div class="service-group-label">Microscopy</div>
                <label class="service-option" data-val="Urinalysis"><input type="checkbox" value="Urinalysis"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Urinalysis</span></label>
                <label class="service-option" data-val="Fecalysis"><input type="checkbox" value="Fecalysis"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Fecalysis</span></label>
                <label class="service-option" data-val="PT Urine"><input type="checkbox" value="PT Urine"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">PT Urine</span></label>

                <div class="service-group-label">Serology</div>
                <label class="service-option" data-val="PT Serum"><input type="checkbox" value="PT Serum"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">PT Serum</span></label>
                <label class="service-option" data-val="FOBT"><input type="checkbox" value="FOBT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FOBT</span></label>
                <label class="service-option" data-val="Hepa B"><input type="checkbox" value="Hepa B"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepa B</span></label>
                <label class="service-option" data-val="RPR/VDRL"><input type="checkbox" value="RPR/VDRL"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">RPR/VDRL</span></label>
                <label class="service-option" data-val="Hepa A (IgG)"><input type="checkbox" value="Hepa A (IgG)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepa A (IgG)</span></label>
                <label class="service-option" data-val="Hepa A (IgG IgM)"><input type="checkbox" value="Hepa A (IgG IgM)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepa A (IgG IgM)</span></label>
                <label class="service-option" data-val="Dengue Duo"><input type="checkbox" value="Dengue Duo"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Dengue Duo</span></label>

                <div class="service-group-label">Serology (Special Test)</div>
                <label class="service-option" data-val="TPHA Rapid Test"><input type="checkbox" value="TPHA Rapid Test"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TPHA Rapid Test</span></label>
                <label class="service-option" data-val="TPHA w/ Titer"><input type="checkbox" value="TPHA w/ Titer"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TPHA w/ Titer</span></label>
                <label class="service-option" data-val="Widal Test"><input type="checkbox" value="Widal Test"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Widal Test</span></label>
                <label class="service-option" data-val="Typhidot"><input type="checkbox" value="Typhidot"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Typhidot</span></label>
                <label class="service-option" data-val="ASO LATEX (Screening &amp; w/ titer)"><input type="checkbox" value="ASO LATEX (Screening &amp; w/ titer)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">ASO LATEX (Screening &amp; w/ titer)</span></label>
                <label class="service-option" data-val="CRP Latex (Screening &amp; w/ titer)"><input type="checkbox" value="CRP Latex (Screening &amp; w/ titer)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CRP Latex (Screening &amp; w/ titer)</span></label>
                <label class="service-option" data-val="VDRL/RPR w/ titer"><input type="checkbox" value="VDRL/RPR w/ titer"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">VDRL/RPR w/ titer</span></label>
                <label class="service-option" data-val="RA/RF Latex (screening &amp; w/ titer)"><input type="checkbox" value="RA/RF Latex (screening &amp; w/ titer)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">RA/RF Latex (screening &amp; w/ titer)</span></label>
                <label class="service-option" data-val="C3"><input type="checkbox" value="C3"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">C3</span></label>
                <label class="service-option" data-val="ANA w/ Titer"><input type="checkbox" value="ANA w/ Titer"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">ANA w/ Titer</span></label>
                <label class="service-option" data-val="Leptospiral Test (IgG/IgM each)"><input type="checkbox" value="Leptospiral Test (IgG/IgM each)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Leptospiral Test (IgG/IgM each)</span></label>
                <label class="service-option" data-val="H. Pylori IgM/IgG ELISA (each)"><input type="checkbox" value="H. Pylori IgM/IgG ELISA (each)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">H. Pylori IgM/IgG ELISA (each)</span></label>
                <label class="service-option" data-val="Rubella IgM (ELISA)"><input type="checkbox" value="Rubella IgM (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Rubella IgM (ELISA)</span></label>
                <label class="service-option" data-val="Rubella IgG (ELISA)"><input type="checkbox" value="Rubella IgG (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Rubella IgG (ELISA)</span></label>
                <label class="service-option" data-val="CMV IgM (ELISA)"><input type="checkbox" value="CMV IgM (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CMV IgM (ELISA)</span></label>
                <label class="service-option" data-val="CMV IgG (ELISA)"><input type="checkbox" value="CMV IgG (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CMV IgG (ELISA)</span></label>
                <label class="service-option" data-val="Toxoplasma IgM (ELISA)"><input type="checkbox" value="Toxoplasma IgM (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Toxoplasma IgM (ELISA)</span></label>
                <label class="service-option" data-val="Toxoplasma IgG (ELISA)"><input type="checkbox" value="Toxoplasma IgG (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Toxoplasma IgG (ELISA)</span></label>
                <label class="service-option" data-val="HSV 1 &amp; 2 ELISA IgM"><input type="checkbox" value="HSV 1 &amp; 2 ELISA IgM"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HSV 1 &amp; 2 ELISA IgM</span></label>
                <label class="service-option" data-val="HSV 1 &amp; 2 ELISA IgG"><input type="checkbox" value="HSV 1 &amp; 2 ELISA IgG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HSV 1 &amp; 2 ELISA IgG</span></label>
                <label class="service-option" data-val="Varicella IgG (ELISA)"><input type="checkbox" value="Varicella IgG (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Varicella IgG (ELISA)</span></label>
                <label class="service-option" data-val="Varicella IgM (ELISA)"><input type="checkbox" value="Varicella IgM (ELISA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Varicella IgM (ELISA)</span></label>
                <label class="service-option" data-val="TORCH TEST ELISA (IgG/IgM each)"><input type="checkbox" value="TORCH TEST ELISA (IgG/IgM each)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TORCH TEST ELISA (IgG/IgM each)</span></label>
                <label class="service-option" data-val="Mumps IgG"><input type="checkbox" value="Mumps IgG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Mumps IgG</span></label>
                <label class="service-option" data-val="Rubeola IgG (Measles)"><input type="checkbox" value="Rubeola IgG (Measles)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Rubeola IgG (Measles)</span></label>

                <div class="service-group-label">Blood Chemistry</div>
                <label class="service-option" data-val="FBS"><input type="checkbox" value="FBS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FBS</span></label>
                <label class="service-option" data-val="RBS"><input type="checkbox" value="RBS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">RBS</span></label>
                <label class="service-option" data-val="Cholesterol"><input type="checkbox" value="Cholesterol"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Cholesterol</span></label>
                <label class="service-option" data-val="Triglycerides"><input type="checkbox" value="Triglycerides"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Triglycerides</span></label>
                <label class="service-option" data-val="HDL"><input type="checkbox" value="HDL"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HDL</span></label>
                <label class="service-option" data-val="BUN"><input type="checkbox" value="BUN"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">BUN</span></label>
                <label class="service-option" data-val="Creatinine"><input type="checkbox" value="Creatinine"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Creatinine</span></label>
                <label class="service-option" data-val="BUA"><input type="checkbox" value="BUA"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">BUA</span></label>
                <label class="service-option" data-val="SGOT"><input type="checkbox" value="SGOT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">SGOT</span></label>
                <label class="service-option" data-val="SGPT"><input type="checkbox" value="SGPT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">SGPT</span></label>
                <label class="service-option" data-val="Complete Chemistry"><input type="checkbox" value="Complete Chemistry"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Complete Chemistry</span></label>
                <label class="service-option" data-val="Lipid Profile"><input type="checkbox" value="Lipid Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Lipid Profile</span></label>
                <label class="service-option" data-val="75g OGTT"><input type="checkbox" value="75g OGTT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">75g OGTT</span></label>
                <label class="service-option" data-val="2HR PPBS"><input type="checkbox" value="2HR PPBS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">2HR PPBS</span></label>
                <label class="service-option" data-val="HBA1C"><input type="checkbox" value="HBA1C"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HBA1C</span></label>
                <label class="service-option" data-val="Electrolytes"><input type="checkbox" value="Electrolytes"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Electrolytes</span></label>

                <div class="service-group-label">Blood Chemistry (Special Test)</div>
                <label class="service-option" data-val="Bilirubin"><input type="checkbox" value="Bilirubin"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Bilirubin</span></label>
                <label class="service-option" data-val="Total Protein"><input type="checkbox" value="Total Protein"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Total Protein</span></label>
                <label class="service-option" data-val="Albumin"><input type="checkbox" value="Albumin"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Albumin</span></label>
                <label class="service-option" data-val="TPAG"><input type="checkbox" value="TPAG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TPAG</span></label>

                <div class="service-group-label">Enzymes (Special Test)</div>
                <label class="service-option" data-val="GGTP"><input type="checkbox" value="GGTP"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">GGTP</span></label>
                <label class="service-option" data-val="Alkaline Phosphatase"><input type="checkbox" value="Alkaline Phosphatase"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Alkaline Phosphatase</span></label>
                <label class="service-option" data-val="Acid Phosphatase"><input type="checkbox" value="Acid Phosphatase"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Acid Phosphatase</span></label>
                <label class="service-option" data-val="Amylase"><input type="checkbox" value="Amylase"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Amylase</span></label>
                <label class="service-option" data-val="Lipase"><input type="checkbox" value="Lipase"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Lipase</span></label>
                <label class="service-option" data-val="Total CPK"><input type="checkbox" value="Total CPK"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Total CPK</span></label>
                <label class="service-option" data-val="CPK-MB"><input type="checkbox" value="CPK-MB"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CPK-MB</span></label>
                <label class="service-option" data-val="CPK-MM"><input type="checkbox" value="CPK-MM"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CPK-MM</span></label>
                <label class="service-option" data-val="LDH"><input type="checkbox" value="LDH"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">LDH</span></label>

                <div class="service-group-label">Electrolytes (Special Test)</div>
                <label class="service-option" data-val="Magnesium"><input type="checkbox" value="Magnesium"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Magnesium</span></label>
                <label class="service-option" data-val="Inorganic Phosphorous"><input type="checkbox" value="Inorganic Phosphorous"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Inorganic Phosphorous</span></label>
                <label class="service-option" data-val="Total Iron"><input type="checkbox" value="Total Iron"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Total Iron</span></label>
                <label class="service-option" data-val="TIBC + Total Iron"><input type="checkbox" value="TIBC + Total Iron"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TIBC + Total Iron</span></label>
                <label class="service-option" data-val="Lithium Serum (3 days)"><input type="checkbox" value="Lithium Serum (3 days)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Lithium Serum (3 days)</span></label>
                <label class="service-option" data-val="Ammonia (EDTA)"><input type="checkbox" value="Ammonia (EDTA)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Ammonia (EDTA)</span></label>

                <div class="service-group-label">Thyroid Function Test (Special Test)</div>
                <label class="service-option" data-val="T3 ELISA"><input type="checkbox" value="T3 ELISA"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">T3 ELISA</span></label>
                <label class="service-option" data-val="TSH ELISA"><input type="checkbox" value="TSH ELISA"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TSH ELISA</span></label>
                <label class="service-option" data-val="FT3 ELISA"><input type="checkbox" value="FT3 ELISA"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FT3 ELISA</span></label>
                <label class="service-option" data-val="FT4 ELISA"><input type="checkbox" value="FT4 ELISA"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FT4 ELISA</span></label>
                <label class="service-option" data-val="TSH IRMA (After 3 Days)"><input type="checkbox" value="TSH IRMA (After 3 Days)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TSH IRMA (After 3 Days)</span></label>
                <label class="service-option" data-val="Parathyroid Hormone"><input type="checkbox" value="Parathyroid Hormone"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Parathyroid Hormone</span></label>
                <label class="service-option" data-val="FT3 RIA (After 3 Days)"><input type="checkbox" value="FT3 RIA (After 3 Days)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FT3 RIA (After 3 Days)</span></label>
                <label class="service-option" data-val="FT4 RIA (After 3 Days)"><input type="checkbox" value="FT4 RIA (After 3 Days)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FT4 RIA (After 3 Days)</span></label>
                <label class="service-option" data-val="Thyroglobulin"><input type="checkbox" value="Thyroglobulin"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Thyroglobulin</span></label>

                <div class="service-group-label">Hepatitis ELISA (Special Test)</div>
                <label class="service-option" data-val="HBsAg w/ Titer"><input type="checkbox" value="HBsAg w/ Titer"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HBsAg w/ Titer</span></label>
                <label class="service-option" data-val="Anti-HBs"><input type="checkbox" value="Anti-HBs"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-HBs</span></label>
                <label class="service-option" data-val="HBeAg"><input type="checkbox" value="HBeAg"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HBeAg</span></label>
                <label class="service-option" data-val="Anti-Hbe"><input type="checkbox" value="Anti-Hbe"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-Hbe</span></label>
                <label class="service-option" data-val="Anti-Hbc IgM"><input type="checkbox" value="Anti-Hbc IgM"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-Hbc IgM</span></label>
                <label class="service-option" data-val="Anti-Hbc IgG"><input type="checkbox" value="Anti-Hbc IgG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-Hbc IgG</span></label>
                <label class="service-option" data-val="Anti-HAV IgG"><input type="checkbox" value="Anti-HAV IgG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-HAV IgG</span></label>
                <label class="service-option" data-val="Anti-HAV IgM"><input type="checkbox" value="Anti-HAV IgM"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-HAV IgM</span></label>
                <label class="service-option" data-val="Anti-HCV"><input type="checkbox" value="Anti-HCV"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Anti-HCV</span></label>
                <label class="service-option" data-val="Hepatitis Profile"><input type="checkbox" value="Hepatitis Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepatitis Profile</span></label>
                <label class="service-option" data-val="Hepatitis A Profile"><input type="checkbox" value="Hepatitis A Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepatitis A Profile</span></label>
                <label class="service-option" data-val="Hepatitis B Profile"><input type="checkbox" value="Hepatitis B Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepatitis B Profile</span></label>
                <label class="service-option" data-val="Hepatitis A &amp; B Profile"><input type="checkbox" value="Hepatitis A &amp; B Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepatitis A &amp; B Profile</span></label>
                <label class="service-option" data-val="Hepatitis A, B &amp; C Profile"><input type="checkbox" value="Hepatitis A, B &amp; C Profile"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Hepatitis A, B &amp; C Profile</span></label>

                <div class="service-group-label">Hormones (Special Test)</div>
                <label class="service-option" data-val="FSH/LH (each)"><input type="checkbox" value="FSH/LH (each)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">FSH/LH (each)</span></label>
                <label class="service-option" data-val="Prolactin"><input type="checkbox" value="Prolactin"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Prolactin</span></label>
                <label class="service-option" data-val="Estrogen / Estradiol"><input type="checkbox" value="Estrogen / Estradiol"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Estrogen / Estradiol</span></label>
                <label class="service-option" data-val="Progesterone"><input type="checkbox" value="Progesterone"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Progesterone</span></label>
                <label class="service-option" data-val="Testosterone"><input type="checkbox" value="Testosterone"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Testosterone</span></label>
                <label class="service-option" data-val="Cortisol"><input type="checkbox" value="Cortisol"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Cortisol</span></label>
                <label class="service-option" data-val="Ferritin"><input type="checkbox" value="Ferritin"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Ferritin</span></label>

                <div class="service-group-label">Tumor Markers (Special Test)</div>
                <label class="service-option" data-val="AFP"><input type="checkbox" value="AFP"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">AFP</span></label>
                <label class="service-option" data-val="CEA (Colon)"><input type="checkbox" value="CEA (Colon)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CEA (Colon)</span></label>
                <label class="service-option" data-val="PSA (Prostate)"><input type="checkbox" value="PSA (Prostate)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">PSA (Prostate)</span></label>
                <label class="service-option" data-val="B-HCG"><input type="checkbox" value="B-HCG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">B-HCG</span></label>
                <label class="service-option" data-val="CA-125 (Ovary)"><input type="checkbox" value="CA-125 (Ovary)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CA-125 (Ovary)</span></label>
                <label class="service-option" data-val="CA-15-3 (Breast)"><input type="checkbox" value="CA-15-3 (Breast)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CA-15-3 (Breast)</span></label>
                <label class="service-option" data-val="CA-19-9 (Pancreas)"><input type="checkbox" value="CA-19-9 (Pancreas)"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">CA-19-9 (Pancreas)</span></label>

                <div class="service-group-label">Ultrasound / Imaging</div>
                <label class="service-option" data-val="Whole Abdomen"><input type="checkbox" value="Whole Abdomen"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Whole Abdomen</span></label>
                <label class="service-option" data-val="Upper Abdomen"><input type="checkbox" value="Upper Abdomen"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Upper Abdomen</span></label>
                <label class="service-option" data-val="Lower Abdomen"><input type="checkbox" value="Lower Abdomen"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Lower Abdomen</span></label>
                <label class="service-option" data-val="Abdomino Pelvic"><input type="checkbox" value="Abdomino Pelvic"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Abdomino Pelvic</span></label>
                <label class="service-option" data-val="Pelvic"><input type="checkbox" value="Pelvic"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Pelvic</span></label>
                <label class="service-option" data-val="Pelvic Twins"><input type="checkbox" value="Pelvic Twins"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Pelvic Twins</span></label>
                <label class="service-option" data-val="BPS"><input type="checkbox" value="BPS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">BPS</span></label>
                <label class="service-option" data-val="TVS"><input type="checkbox" value="TVS"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">TVS</span></label>
                <label class="service-option" data-val="KUB"><input type="checkbox" value="KUB"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">KUB</span></label>
                <label class="service-option" data-val="KUB w/ Prostate"><input type="checkbox" value="KUB w/ Prostate"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">KUB w/ Prostate</span></label>
                <label class="service-option" data-val="Renal"><input type="checkbox" value="Renal"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Renal</span></label>
                <label class="service-option" data-val="HBT"><input type="checkbox" value="HBT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">HBT</span></label>
                <label class="service-option" data-val="Inguinal"><input type="checkbox" value="Inguinal"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Inguinal</span></label>
                <label class="service-option" data-val="Scrotal"><input type="checkbox" value="Scrotal"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Scrotal</span></label>
                <label class="service-option" data-val="Transrectal"><input type="checkbox" value="Transrectal"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Transrectal</span></label>
                <label class="service-option" data-val="Neck"><input type="checkbox" value="Neck"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Neck</span></label>
                <label class="service-option" data-val="Thyroid"><input type="checkbox" value="Thyroid"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Thyroid</span></label>
                <label class="service-option" data-val="Breast"><input type="checkbox" value="Breast"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Breast</span></label>
                <label class="service-option" data-val="Chest UTZ"><input type="checkbox" value="Chest UTZ"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Chest UTZ</span></label>
                <label class="service-option" data-val="Mass UTZ"><input type="checkbox" value="Mass UTZ"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Mass UTZ</span></label>
                <label class="service-option" data-val="Single Organ"><input type="checkbox" value="Single Organ"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Single Organ</span></label>

                <div class="service-group-label">Other Services</div>
                <label class="service-option" data-val="Drug Test"><input type="checkbox" value="Drug Test"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">Drug Test</span></label>
                <label class="service-option" data-val="ECG"><input type="checkbox" value="ECG"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">ECG</span></label>
                <label class="service-option" data-val="RAT"><input type="checkbox" value="RAT"><div class="svc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div><span class="svc-label">RAT</span></label>
              </div>
            </div>
            <span class="error-msg" id="err-service">Please select at least one service.</span>
          </div>
          <div class="field full">
            <label>Special Notes / Concerns</label>
            <textarea id="notes" rows="3" placeholder="Any special instructions or concerns for the attending team..." style="resize:vertical;"></textarea>
          </div>
          <div class="field full">
            <div style="padding:14px 16px;background:var(--green-muted);border:1px solid var(--gray-200);border-radius:14px;">
              <div style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--green-mid);margin-bottom:8px;">Preparation Reminder</div>
              <div style="font-size:.82rem;color:var(--gray-600);line-height:1.65;">
                Confirm your branch, keep your phone available for approval updates, and use the review step to verify patient and address details before submitting.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div></div>
        <button class="btn btn-primary" onclick="goToStep(2)">
          Continue <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    <!-- ===== STEP 2: Patient Details ===== -->
    <div class="step-panel" id="panel-2">
      <div class="card-header">
        <div class="step-badge">Step 2 of 3</div>
        <h2>Patient Details</h2>
        <p>Fill in the patient's personal and contact information.</p>
      </div>
      <div class="card-body">
        <div class="autofill-banner" id="autofillBanner" style="display:none;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green-mid)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Your profile information has been <strong>auto-filled</strong> below. Please review and update if needed.</span>
        </div>

        <div class="section-divider"><span>Personal Information</span></div>
        <div class="form-grid">
          <div class="field">
            <label>Last Name <span class="req">*</span></label>
            <input type="text" id="lastName" placeholder="e.g. Santos">
            <span class="error-msg" id="err-lname">Required field.</span>
          </div>
          <div class="field">
            <label>First Name <span class="req">*</span></label>
            <input type="text" id="firstName" placeholder="e.g. Maria">
            <span class="error-msg" id="err-fname">Required field.</span>
          </div>
          <div class="field">
            <label>Middle Name</label>
            <input type="text" id="middleName" placeholder="Optional">
          </div>
          <div class="field">
            <label>Date of Birth <span class="req">*</span></label>
            <input type="date" id="dob" onchange="autoFillAge()">
            <span class="error-msg" id="err-dob">Required field.</span>
          </div>
          <div class="field">
            <label>Age <span class="req">*</span></label>
            <input type="number" id="age" min="0" max="150" placeholder="e.g. 35">
            <span class="age-hint">Auto-filled from date of birth — you may edit if needed.</span>
            <span class="error-msg" id="err-age">Please enter a valid age.</span>
          </div>
          <div class="field full">
            <label>Gender <span class="req">*</span></label>
            <div class="radio-group">
              <div class="radio-option"><input type="radio" name="gender" id="gMale" value="Male"><label for="gMale">Male</label></div>
              <div class="radio-option"><input type="radio" name="gender" id="gFemale" value="Female"><label for="gFemale">Female</label></div>
              <div class="radio-option"><input type="radio" name="gender" id="gOther" value="Other"><label for="gOther">Other</label></div>
            </div>
            <span class="error-msg" id="err-gender">Please select gender.</span>
          </div>
        </div>

        <div class="section-divider"><span>Contact Information</span></div>
        <div class="form-grid">
          <div class="field">
            <label>Contact Number <span class="req">*</span></label>
            <input type="tel" id="contactNum" placeholder="09XX XXX XXXX">
            <span class="error-msg" id="err-contact">Required field.</span>
          </div>
          <div class="field">
            <label>Alternative Number</label>
            <input type="tel" id="altContact" placeholder="Optional">
          </div>
          <div class="field full">
            <label>Email Address <span class="req">*</span></label>
            <input type="email" id="email" placeholder="email@example.com">
            <span class="error-msg" id="err-email">Please enter a valid email.</span>
          </div>
        </div>

        <div class="section-divider"><span>Home Address</span></div>
        <div class="form-grid">
          <div class="field">
            <label>House / Unit No. <span class="req">*</span></label>
            <input type="text" id="houseNo" placeholder="e.g. Unit 4B">
            <span class="error-msg" id="err-house">Required field.</span>
          </div>
          <div class="field">
            <label>Street / Building Name <span class="req">*</span></label>
            <input type="text" id="street" placeholder="e.g. Rizal Street">
            <span class="error-msg" id="err-street">Required field.</span>
          </div>
          <div class="field">
            <label>Municipality / City <span class="req">*</span></label>
            <select id="city" onchange="updateBarangays()">
              <option value="">Select municipality...</option>
              <option value="Bacacay">Bacacay</option><option value="Camalig">Camalig</option>
              <option value="Daraga">Daraga</option><option value="Guinobatan">Guinobatan</option>
              <option value="Jovellar">Jovellar</option><option value="Legazpi">Legazpi City</option>
              <option value="Libon">Libon</option><option value="Ligao">Ligao City</option>
              <option value="Malilipot">Malilipot</option><option value="Malinao">Malinao</option>
              <option value="Manito">Manito</option><option value="Oas">Oas</option>
              <option value="Pio Duran">Pio Duran</option><option value="Polangui">Polangui</option>
              <option value="Rapu-Rapu">Rapu-Rapu</option><option value="Santo Domingo">Santo Domingo</option>
              <option value="Tabaco">Tabaco City</option><option value="Tiwi">Tiwi</option>
            </select>
            <span class="error-msg" id="err-city">Required field.</span>
          </div>
          <div class="field">
            <label>Barangay <span class="req">*</span></label>
            <select id="barangay" disabled>
              <option value="">Select municipality first...</option>
            </select>
            <span class="error-msg" id="err-brgy">Required field.</span>
          </div>
          <div class="field full">
            <label>Province</label>
            <div class="locked-field">
              <input type="text" id="province" value="Albay" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-secondary" onclick="goToStep(1)">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> Back
        </button>
        <button class="btn btn-primary" onclick="goToStep(3)">
          Review Details <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>

    <!-- ===== STEP 3: Review & Submit ===== -->
    <div class="step-panel" id="panel-3">
      <div class="card-header">
        <div class="step-badge">Step 3 of 3</div>
        <h2>Review & Submit</h2>
        <p>Please carefully verify all your information before submitting.</p>
      </div>
      <div class="card-body">
        <div class="review-block">
          <h3>Appointment Details</h3>
          <div class="review-grid">
            <div class="review-item"><label>Branch</label><span id="rv-branch">—</span></div>
            <div class="review-item"><label>Date of Visit</label><span id="rv-date">—</span></div>
            <div class="review-item"><label>Preferred Time</label><span id="rv-time">—</span></div>
            <div class="review-item" style="grid-column:1/-1;"><label>Services Requested</label><span id="rv-service" style="white-space:pre-wrap;">—</span></div>
            <div class="review-item"><label>Notes</label><span id="rv-notes">None</span></div>
            <div class="review-item"><label>Request Type</label><span>Home Service Appointment Request</span></div>
          </div>
        </div>
        <div class="review-block">
          <h3>Patient Information</h3>
          <div class="review-grid">
            <div class="review-item"><label>Full Name</label><span id="rv-name">—</span></div>
            <div class="review-item"><label>Date of Birth</label><span id="rv-dob">—</span></div>
            <div class="review-item"><label>Age</label><span id="rv-age">—</span></div>
            <div class="review-item"><label>Gender</label><span id="rv-gender">—</span></div>
            <div class="review-item"><label>Contact Number</label><span id="rv-contact">—</span></div>
            <div class="review-item"><label>Email</label><span id="rv-email">—</span></div>
            <div class="review-item"><label>Alt. Number</label><span id="rv-alt">—</span></div>
          </div>
        </div>
        <div class="review-block">
          <h3>Home Address</h3>
          <div class="review-grid">
            <div class="review-item" style="grid-column:1/-1;">
              <label>Full Address</label><span id="rv-address">—</span>
            </div>
          </div>
        </div>
        <label class="consent-box" for="consentCheck">
          <input type="checkbox" id="consentCheck" onchange="toggleConsent(this)">
          <div class="custom-check" id="customCheck">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="consent-text">
            I confirm that all the information I have provided is <strong>accurate and complete</strong>. I understand that submitting this form is a <strong>request for appointment approval</strong> and does not guarantee an immediate scheduled visit.
          </div>
        </label>
        <span class="error-msg" id="err-consent" style="margin-top:6px;">You must confirm your information before submitting.</span>
      </div>
      <div class="card-footer">
        <button class="btn btn-secondary" onclick="goToStep(2)">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg> Edit Details
        </button>
        <button class="btn btn-success" onclick="submitAppointment()">Submit Request</button>
      </div>
    </div>

    <?php endif; ?>

  </div><!-- /card -->

  <form method="POST" id="appointmentForm" style="display:none;">
    <?= hq_csrf_input('booking_submit') ?>
    <input type="hidden" name="submit_appointment" value="1">
    <input type="hidden" name="appt_date"    id="h_date">
    <input type="hidden" name="appt_time"    id="h_time">
    <input type="hidden" name="service_type" id="h_service">
    <input type="hidden" name="branch"       id="h_branch">
    <input type="hidden" name="notes"        id="h_notes">
    <input type="hidden" name="first_name"   id="h_fname">
    <input type="hidden" name="last_name"    id="h_lname">
    <input type="hidden" name="middle_name"  id="h_mname">
    <input type="hidden" name="dob"          id="h_dob">
    <input type="hidden" name="age"          id="h_age">
    <input type="hidden" name="gender"       id="h_gender">
    <input type="hidden" name="contact_num"  id="h_contact">
    <input type="hidden" name="alt_contact"  id="h_alt">
    <input type="hidden" name="email"        id="h_email">
    <input type="hidden" name="house_no"     id="h_house">
    <input type="hidden" name="street"       id="h_street">
    <input type="hidden" name="barangay"     id="h_brgy">
    <input type="hidden" name="city"         id="h_city">
    <input type="hidden" name="province"     value="Albay">
  </form>

</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-card">
        <h3>HealthQuarters</h3>
        <p>Book home service appointments through a clearer, guided form experience designed for faster scheduling and easier follow-up.</p>
      </div>
      <div class="footer-card">
        <h4>Quick Links</h4>
        <div class="footer-links">
          <a href="homepage.php">Dashboard Home</a>
          <a href="profile.php">My Profile</a>
          <a href="corporateservice.php">Corporate Inquiry</a>
          <a href="locations.php">Locations</a>
        </div>
      </div>
      <div class="footer-card">
        <h4>Need Help?</h4>
        <div class="footer-links">
          <a href="home_service_info.php">Home Service Information</a>
          <a href="service.php">Service Catalog</a>
          <a href="about_us.php#contact">Contact HealthQuarters</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> HealthQuarters. All rights reserved.</span>
      <span>Need updates after booking? Open `profile.php` to track your requests.</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Navbar dropdown ── */
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

/* ── Barangay data ── */
const BARANGAYS = {
  "Bacacay": ["Baclayon","Banao","Barangay 1","Barangay 10","Barangay 11","Barangay 12","Barangay 13","Barangay 14","Barangay 2","Barangay 3","Barangay 4","Barangay 5","Barangay 6","Barangay 7","Barangay 8","Barangay 9","Bariw","Basud","Bayandong","Bonga","Buang","Busdac","Cabasan","Cagbulacao","Cagraray","Cajogutan","Cawayan","Damacan","Gubat Ilawod","Gubat Iraya","Hindi","Igang","Langaton","Manaet","Mapulang Daga","Mataas","Misibis","Nahapunan","Namanday","Namantao","Napao","Panarayon","Pigcobohan","Pili Ilawod","Pili Iraya","Pongco","San Pablo","San Pedro","Sogod","Sula","Tambilagao","Tambongon","Tanagan","Uson","Vinisitahan-Basud","Vinisitahan-Napao"],
  "Camalig": ["Anoling","Baligang","Bantonan","Barangay 1","Barangay 2","Barangay 3","Barangay 4","Barangay 5","Barangay 6","Barangay 7","Bariw","Binanderahan","Binitayan","Bongabong","Cabagñan","Cabraran Pequeño","Caguiba","Calabidongan","Comun","Cotmon","Del Rosario","Gapo","Gotob","Ilawod","Iluluan","Libod","Ligban","Mabunga","Magogon","Manawan","Maninila","Mina","Miti","Palanog","Panoypoy","Pariaan","Quinartilan","Quirangay","Quitinday","Salugan","Solong","Sua","Sumlang","Tagaytay","Tagoytoy","Taladong","Taloto","Taplacon","Tinago","Tumpa"],
  "Daraga": ["Alcala","Alobo","Anislag","Bagumbayan","Balinad","Bascaran","Bañadero","Bañag","Bigao","Binitayan","Bongalon","Budiao","Burgos","Busay","Canarom","Cullat","Dela Paz","Dinoronan","Gabawan","Gapo","Ibaugan","Ilawod Area Poblacion","Inarado","Kidaco","Kilicao","Kimantong","Kinawitan","Kiwalo","Lacag","Mabini","Malabog","Malobago","Maopi","Market Area Poblacion","Maroroy","Matnog","Mayon","Mi-isi","Nabasan","Namantao","Pandan","Peñafrancia","Sagpon","Salvacion","San Rafael","San Ramon","San Roque","San Vicente Grande","San Vicente Pequeño","Sipi","Tabon-tabon","Tagas","Talahib","Villahermosa"],
  "Guinobatan": ["Agpay","Balite","Banao","Batbat","Binogsacan Lower","Binogsacan Upper","Bololo","Bubulusan","Calzada","Catomag","Doña Mercedes","Doña Tomasa","Ilawod","Inamnan Grande","Inamnan Pequeño","Inascan","Iraya","Lomacao","Maguiron","Maipon","Malabnig","Malipo","Malobago","Maninila","Mapaco","Marcial O. Rañola","Masarawag","Mauraro","Minto","Morera","Muladbucad Grande","Muladbucad Pequeño","Ongo","Palanas","Poblacion","Pood","Quibongbongan","Quitago","San Francisco","San Jose","San Rafael","Sinungtan","Tandarora","Travesia"],
  "Jovellar": ["Aurora Poblacion","Bagacay","Bautista","Cabraran","Calzada Poblacion","Del Rosario","Estrella","Florista","Mabini Poblacion","Magsaysay Poblacion","Mamlad","Maogog","Mercado Poblacion","Plaza Poblacion","Quitinday Poblacion","Rizal Poblacion","Salvacion","San Isidro","San Roque","San Vicente","Sinagaran","Villa Paz","White Deer Poblacion"],
  "Legazpi": ["Barangay 1-Em's Barrio","Barangay 10-Cabugao","Barangay 11-Maoyod Poblacion","Barangay 12-Tula-tula","Barangay 13-Ilawod West Poblacion","Barangay 14-Ilawod Poblacion","Barangay 15-Ilawod East Poblacion","Barangay 16-Kawit-East Washington Drive","Barangay 17-Rizal Street, Ilawod","Barangay 18-Cabagñan West","Barangay 19-Cabagñan","Barangay 2-Em's Barrio South","Barangay 20-Cabagñan East","Barangay 21-Binanuahan West","Barangay 22-Binanuahan East","Barangay 23-Imperial Court Subd.","Barangay 24-Rizal Street","Barangay 25-Lapu-lapu","Barangay 26-Dinagaan","Barangay 27-Victory Village South","Barangay 28-Victory Village North","Barangay 29-Sabang","Barangay 3-Em's Barrio East","Barangay 30-Pigcale","Barangay 31-Centro-Baybay","Barangay 32-San Roque","Barangay 33-PNR-Peñaranda St.-Iraya","Barangay 34-Oro Site-Magallanes St.","Barangay 35-Tinago","Barangay 36-Kapantawan","Barangay 37-Bitano","Barangay 38-Gogon","Barangay 39-Bonot","Barangay 4-Sagpon Poblacion","Barangay 40-Cruzada","Barangay 41-Bogtong","Barangay 42-Rawis","Barangay 43-Tamaoyan","Barangay 44-Pawa","Barangay 45-Dita","Barangay 46-San Joaquin","Barangay 47-Arimbay","Barangay 48-Bagong Abre","Barangay 49-Bigaa","Barangay 5-Sagmin Poblacion","Barangay 50-Padang","Barangay 51-Buyuan","Barangay 52-Matanag","Barangay 53-Bonga","Barangay 54-Mabinit","Barangay 55-Estanza","Barangay 56-Taysan","Barangay 57-Dap-dap","Barangay 58-Buragwis","Barangay 59-Puro","Barangay 6-Bañadero Poblacion","Barangay 60-Lamba","Barangay 61-Maslog","Barangay 62-Homapon","Barangay 63-Mariawa","Barangay 64-Bagacay","Barangay 65-Imalnod","Barangay 66-Banquerohan","Barangay 67-Bariis","Barangay 68-San Francisco","Barangay 69-Buenavista","Barangay 7-Baño","Barangay 70-Cagbacong","Barangay 8-Bagumbayan","Barangay 9-Pinaric"],
  "Libon": ["Alongong","Apud","Bacolod","Bariw","Bonbon","Buga","Bulusan","Burabod","Caguscos","East Carisac","Harigue","Libtong","Linao","Mabayawas","Macabugos","Magallang","Malabiga","Marayag","Matara","Molosbolos","Natasan","Niño Jesus","Nogpo","Pantao","Rawis","Sagrada Familia","Salvacion","Sampongan","San Agustin","San Antonio","San Isidro","San Jose","San Pascual","San Ramon","San Vicente","Santa Cruz","Talin-talin","Tambo","Villa Petrona","West Carisac","Zone I","Zone II","Zone III","Zone IV","Zone V","Zone VI","Zone VII"],
  "Ligao": ["Abella","Allang","Amtic","Bacong","Bagumbayan","Balanac","Baligang","Barayong","Basag","Batang","Bay","Binanowan","Binatagan","Bobonsuran","Bonga","Busac","Busay","Cabarian","Calzada","Catburawan","Cavasi","Culliat","Dunao","Francia","Guilid","Herrera","Layon","Macalidong","Mahaba","Malama","Maonon","Nabonton","Nasisi","Oma-oma","Palapas","Pandan","Paulba","Paulog","Pinamaniquian","Pinit","Ranao-ranao","San Vicente","Santa Cruz","Tagpo","Tambo","Tandarura","Tastas","Tinago","Tinampo","Tiongson","Tomolin","Tuburan","Tula-tula Grande","Tula-tula Pequeño","Tupas"],
  "Malilipot": ["Barangay I","Barangay II","Barangay III","Barangay IV","Barangay V","Binitayan","Calbayog","Canaway","Salvacion","San Antonio Santicon","San Antonio Sulong","San Francisco","San Isidro Ilawod","San Isidro Iraya","San Jose","San Roque","Santa Cruz","Santa Teresa"],
  "Malinao": ["Awang","Bagatangki","Bagumbayan","Balading","Balza","Bariw","Baybay","Bulang","Burabod","Cabunturan","Comun","Diaro","Estancia","Jonop","Labnig","Libod","Malolos","Matalipni","Ogob","Pawa","Payahan","Poblacion","Quinarabasahan","Santa Elena","Soa","Sugcad","Tagoytoy","Tanawan","Tuliw"],
  "Manito": ["Balabagon","Balasbas","Bamban","Buyo","Cabacongan","Cabit","Cawayan","Cawit","Holugan","It-ba","Malobago","Manumbalay","Nagotgot","Pawa","Tinapian"],
  "Oas": ["Badbad","Badian","Bagsa","Bagumbayan","Balogo","Banao","Bangiawon","Bogtong","Bongoran","Busac","Cadawag","Cagmanaba","Calaguimit","Calpi","Calzada","Camagong","Casinagan","Centro Poblacion","Coliat","Del Rosario","Gumabao","Ilaor Norte","Ilaor Sur","Iraya Norte","Iraya Sur","Manga","Maporong","Maramba","Matambo","Mayag","Mayao","Moroponros","Nagas","Obaliw-Rinas","Pistola","Ramay","Rizal","Saban","San Agustin","San Antonio","San Isidro","San Jose","San Juan","San Miguel","San Pascual","San Ramon","San Vicente","Tablon","Talisay","Talongog","Tapel","Tobgon","Tobog"],
  "Pio Duran": ["Agol","Alabangpuro","Banawan","Barangay I","Barangay II","Barangay III","Barangay IV","Barangay V","Basicao Coastal","Basicao Interior","Binodegahan","Buenavista","Buyo","Caratagan","Cuyaoyao","Flores","La Medalla","Lawinon","Macasitas","Malapay","Malidong","Mamlad","Marigondon","Matanglad","Nablangbulod","Oringon","Palapas","Panganiran","Rawis","Salvacion","Santo Cristo","Sukip","Tibabo"],
  "Polangui": ["Agos","Alnay","Alomon","Amoguis","Anopol","Apad","Balaba","Balangibang","Balinad","Basud","Binagbangan","Buyo","Centro Occidental","Centro Oriental","Cepres","Cotmon","Cotnogan","Danao","Gabon","Gamot","Itaran","Kinale","Kinuartilan","La Medalla","La Purisima","Lanigay","Lidong","Lourdes","Magpanambo","Magurang","Matacon","Maynaga","Maysua","Mendez","Napo","Pinagdapugan","Ponso","Salvacion","San Roque","Santa Cruz","Santa Teresita","Santicon","Sugcad","Ubaliw"],
  "Rapu-Rapu": ["Bagaobawan","Batan","Bilbao","Binosawan","Bogtong","Buenavista","Buhatan","Calanaga","Caracaran","Carogcog","Dap-dap","Gaba","Galicia","Guadalupe","Hamorawon","Lagundi","Liguan","Linao","Malobago","Mananao","Mancao","Manila","Masaga","Morocborocan","Nagcalsot","Pagcolbon","Poblacion","Sagrada","San Ramon","Santa Barbara","Tinocawan","Tinopan","Viga","Villahermosa"],
  "Santo Domingo": ["Alimsog","Bagong San Roque","Buhatan","Calayucay","Del Rosario Poblacion","Fidel Surtida","Lidong","Market Site Poblacion","Nagsiya Poblacion","Pandayan Poblacion","Salvacion","San Andres","San Fernando","San Francisco Poblacion","San Isidro","San Juan Poblacion","San Pedro Poblacion","San Rafael Poblacion","San Roque","San Vicente Poblacion","Santa Misericordia","Santo Domingo Poblacion","Santo Niño"],
  "Tabaco": ["Agnas","Bacolod","Bangkilingan","Bantayan","Baranghawon","Basagan","Basud","Bogñabong","Bombon","Bonot","Buang","Buhian","Cabagñan","Cobo","Comon","Cormidal","Divino Rostro","Fatima","Guinobat","Hacienda","Magapo","Mariroc","Matagbac","Oras","Oson","Panal","Pawa","Pinagbobong","Quinale Cabasan","Quinastillojan","Rawis","Sagurong","Salvacion","San Antonio","San Carlos","San Isidro","San Juan","San Lorenzo","San Ramon","San Roque","San Vicente","Santo Cristo","Sua-Igot","Tabiguian","Tagas","Tayhi","Visita"],
  "Tiwi": ["Bagumbayan","Bariis","Baybay","Belen","Biyong","Bolo","Cale","Cararayan","Coro-coro","Dap-dap","Gajo","Joroan","Libjo","Libtong","Matalibong","Maynonong","Mayong","Misibis","Naga","Nagas","Oyama","Putsan","San Bernardo","Sogod","Tigbi"]
};

function updateBarangays() {
  const cityEl = document.getElementById('city');
  const brgyEl = document.getElementById('barangay');
  const muni   = cityEl.value;
  brgyEl.innerHTML = '';
  if (!muni || !BARANGAYS[muni]) {
    brgyEl.innerHTML = '<option value="">Select municipality first...</option>';
    brgyEl.disabled = true; return;
  }
  brgyEl.disabled = false;
  const ph = document.createElement('option');
  ph.value = ''; ph.textContent = 'Select barangay...';
  brgyEl.appendChild(ph);
  BARANGAYS[muni].forEach(b => {
    const opt = document.createElement('option');
    opt.value = b; opt.textContent = b;
    brgyEl.appendChild(opt);
  });
  showError('err-city', false); markField('city', false);
}

window.addEventListener('DOMContentLoaded', () => {
  fetch('get_patient_info.php')
    .then(r => r.json())
    .then(data => {
      if (data.error) return;
      const set = (id, val) => { const el = document.getElementById(id); if (el && val) el.value = val; };
      set('firstName', data.first_name); set('middleName', data.middle_name);
      set('lastName', data.last_name); set('email', data.email); set('contactNum', data.contact_number);
      set('dob', data.dob);
      if (data.dob) autoFillAge();
      if (data.sex) {
        const s = data.sex.toLowerCase();
        document.querySelectorAll('input[name="gender"]').forEach(r => { if (r.value.toLowerCase() === s) r.checked = true; });
      }
      const banner = document.getElementById('autofillBanner');
      if (banner) banner.style.display = 'flex';
    }).catch(() => {});
});

const today = new Date().toISOString().split('T')[0];
document.getElementById('apptDate').min = today;
let selectedTime = '';
const branchMeta = <?= json_encode($branchOptions) ?>;

document.getElementById('apptDate').addEventListener('change', checkSlotAvailability);
document.getElementById('branch').addEventListener('change', () => {
  updateBranchHint();
  checkSlotAvailability();
});
<?php if ($slot_taken): ?>window.addEventListener('DOMContentLoaded', checkSlotAvailability);<?php endif; ?>

function updateBranchHint() {
  const branch = document.getElementById('branch').value;
  const hint = document.getElementById('branchHint');
  if (!hint) return;
  if (!branch || !branchMeta[branch]) {
    hint.textContent = 'Pick a branch first. Slot availability and branch capacity will update automatically.';
    return;
  }
  const meta = branchMeta[branch];
  hint.textContent = `${meta.label} serves ${meta.city} with up to ${meta.slot_capacity} patient request(s) per time slot.`;
}

function checkSlotAvailability() {
  const date = document.getElementById('apptDate').value;
  const branch = document.getElementById('branch').value;
  if (!date || !branch) return;
  document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('taken', 'selected'));
  selectedTime = '';
  fetch('check_slots.php?date=' + encodeURIComponent(date) + '&branch=' + encodeURIComponent(branch))
    .then(r => r.json())
    .then(taken => {
      document.querySelectorAll('.time-slot').forEach(slot => { if (taken.includes(slot.dataset.val)) slot.classList.add('taken'); });
      const slotHint = document.getElementById('slotHint');
      if (slotHint) {
        slotHint.textContent = taken.length ? 'Gray time slots are already full for the selected branch and date.' : 'All standard slots are currently open for the selected branch and date.';
      }
    })
    .catch(() => {});
}

document.querySelectorAll('.time-slot').forEach(slot => {
  slot.addEventListener('click', () => {
    if (slot.classList.contains('taken')) return;
    document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
    slot.classList.add('selected');
    selectedTime = slot.dataset.val;
  });
});

function autoFillAge() {
  const dobVal = document.getElementById('dob').value;
  if (!dobVal) return;
  const dob = new Date(dobVal + 'T00:00:00');
  const now = new Date();
  let age = now.getFullYear() - dob.getFullYear();
  const m = now.getMonth() - dob.getMonth();
  if (m < 0 || (m === 0 && now.getDate() < dob.getDate())) age--;
  if (age >= 0 && age <= 150) { document.getElementById('age').value = age; showError('err-age', false); markField('age', false); }
}

function showError(id, show) { const el = document.getElementById(id); if (el) el.classList.toggle('show', show); }
function markField(id, error) { const el = document.getElementById(id); if (el) el.classList.toggle('error', error); }

function goToStep(n) {
  if (n === 2 && !validateStep1()) return;
  if (n === 3 && !validateStep2()) return;
  if (n === 3) populateReview();
  document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('panel-' + n).classList.add('active');
  document.querySelectorAll('.step-item').forEach((item, idx) => {
    item.classList.remove('active', 'completed');
    if (idx + 1 < n) item.classList.add('completed');
    if (idx + 1 === n) item.classList.add('active');
  });
  const pct = { 1: 33, 2: 66, 3: 100 };
  document.getElementById('progressBar').style.width = pct[n] + '%';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep1() {
  let ok = true;
  const branch = document.getElementById('branch').value;
  const date   = document.getElementById('apptDate').value;
  const svcs   = getSelectedServices();
  markField('branch', !branch); showError('err-branch', !branch); if (!branch) ok = false;
  markField('apptDate', !date); showError('err-date', !date); if (!date) ok = false;
  if (date && date < today) { markField('apptDate', true); showError('err-date', true); ok = false; }
  if (!selectedTime) { showError('err-time', true); ok = false; } else showError('err-time', false);
  const noSvc = svcs.length === 0;
  document.getElementById('servicePicker').classList.toggle('error', noSvc);
  showError('err-service', noSvc); if (noSvc) ok = false;
  return ok;
}

function validateStep2() {
  let ok = true;
  [['lastName','err-lname'],['firstName','err-fname'],['dob','err-dob'],['contactNum','err-contact'],
   ['email','err-email'],['houseNo','err-house'],['street','err-street'],['city','err-city']].forEach(([id, errId]) => {
    const val = document.getElementById(id).value.trim();
    markField(id, !val); showError(errId, !val); if (!val) ok = false;
  });
  const brgy = document.getElementById('barangay').value;
  markField('barangay', !brgy); showError('err-brgy', !brgy); if (!brgy) ok = false;
  const ageVal = document.getElementById('age').value;
  const ageNum = parseInt(ageVal, 10);
  const ageInvalid = ageVal === '' || isNaN(ageNum) || ageNum < 0 || ageNum > 150;
  markField('age', ageInvalid); showError('err-age', ageInvalid); if (ageInvalid) ok = false;
  const email = document.getElementById('email').value.trim();
  if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { markField('email', true); showError('err-email', true); ok = false; }
  const gender = document.querySelector('input[name="gender"]:checked');
  showError('err-gender', !gender); if (!gender) ok = false;
  return ok;
}

function populateReview() {
  const fmt     = id => document.getElementById(id).value.trim() || '—';
  const fmtDate = id => { const v = document.getElementById(id).value; if (!v) return '—'; return new Date(v + 'T00:00:00').toLocaleDateString('en-PH', { weekday:'long', year:'numeric', month:'long', day:'numeric' }); };
  const gender  = (document.querySelector('input[name="gender"]:checked') || {}).value || '—';
  const branchEl = document.getElementById('branch');
  document.getElementById('rv-branch').textContent  = branchEl.options[branchEl.selectedIndex]?.text || '—';
  document.getElementById('rv-date').textContent    = fmtDate('apptDate');
  document.getElementById('rv-time').textContent    = selectedTime || '—';
  const svcs = getSelectedServices();
  document.getElementById('rv-service').textContent = svcs.length ? svcs.join(', ') : '—';
  document.getElementById('rv-notes').textContent   = document.getElementById('notes').value.trim() || 'None';
  const full = [fmt('firstName'), fmt('middleName'), fmt('lastName')].filter(s => s !== '—').join(' ');
  document.getElementById('rv-name').textContent    = full || '—';
  document.getElementById('rv-dob').textContent     = fmtDate('dob');
  document.getElementById('rv-age').textContent     = fmt('age') !== '—' ? fmt('age') + ' yrs old' : '—';
  document.getElementById('rv-gender').textContent  = gender;
  document.getElementById('rv-contact').textContent = fmt('contactNum');
  document.getElementById('rv-email').textContent   = fmt('email');
  document.getElementById('rv-alt').textContent     = fmt('altContact') === '—' ? 'None' : fmt('altContact');
  const addr = [fmt('houseNo'), fmt('street'), fmt('barangay'), fmt('city'), 'Albay'].filter(s => s && s !== '—').join(', ');
  document.getElementById('rv-address').textContent = addr || '—';
}

function toggleConsent(cb) { document.getElementById('customCheck').classList.toggle('checked', cb.checked); showError('err-consent', false); }

function submitAppointment() {
  if (!document.getElementById('consentCheck').checked) { showError('err-consent', true); return; }
  document.getElementById('h_date').value    = document.getElementById('apptDate').value;
  document.getElementById('h_time').value    = selectedTime;
  document.getElementById('h_service').value = getSelectedServices().join(', ');
  document.getElementById('h_branch').value  = document.getElementById('branch').value;
  document.getElementById('h_notes').value   = document.getElementById('notes').value;
  document.getElementById('h_fname').value   = document.getElementById('firstName').value;
  document.getElementById('h_lname').value   = document.getElementById('lastName').value;
  document.getElementById('h_mname').value   = document.getElementById('middleName').value;
  document.getElementById('h_dob').value     = document.getElementById('dob').value;
  document.getElementById('h_age').value     = document.getElementById('age').value;
  document.getElementById('h_gender').value  = (document.querySelector('input[name="gender"]:checked') || {}).value || '';
  document.getElementById('h_contact').value = document.getElementById('contactNum').value;
  document.getElementById('h_alt').value     = document.getElementById('altContact').value;
  document.getElementById('h_email').value   = document.getElementById('email').value;
  document.getElementById('h_house').value   = document.getElementById('houseNo').value;
  document.getElementById('h_street').value  = document.getElementById('street').value;
  document.getElementById('h_brgy').value    = document.getElementById('barangay').value;
  document.getElementById('h_city').value    = document.getElementById('city').value;
  document.getElementById('appointmentForm').submit();
}

/* ── Multi-Service Picker ── */
function getSelectedServices() {
  return [...document.querySelectorAll('.service-option.checked')]
    .map(el => el.dataset.val);
}

function updateTagsDisplay() {
  const wrap = document.getElementById('selectedTagsWrap');
  const hint = document.getElementById('svcCountHint');
  const selected = getSelectedServices();
  wrap.innerHTML = '';
  if (selected.length === 0) {
    wrap.classList.add('empty');
    hint.textContent = '';
  } else {
    wrap.classList.remove('empty');
    selected.forEach(val => {
      const tag = document.createElement('span');
      tag.className = 'svc-tag';
      tag.innerHTML = `${val}<button type="button" title="Remove" onclick="removeService('${val.replace(/'/g,"\\'")}')">×</button>`;
      wrap.appendChild(tag);
    });
    hint.textContent = selected.length + ' service' + (selected.length > 1 ? 's' : '') + ' selected';
  }
  // clear error state if something selected
  if (selected.length > 0) {
    document.getElementById('servicePicker').classList.remove('error');
    showError('err-service', false);
  }
}

function removeService(val) {
  const opt = document.querySelector(`.service-option[data-val="${CSS.escape(val)}"]`);
  if (opt) {
    opt.classList.remove('checked');
    opt.querySelector('input[type="checkbox"]').checked = false;
  }
  updateTagsDisplay();
}

document.querySelectorAll('.service-option').forEach(opt => {
  opt.addEventListener('click', function(e) {
    if (e.target.tagName === 'BUTTON') return;
    e.preventDefault(); // ← stops the native checkbox toggle
    const isChecked = this.classList.contains('checked');
    this.classList.toggle('checked', !isChecked);
    this.querySelector('input[type="checkbox"]').checked = !isChecked;
    updateTagsDisplay();
  });
});

document.getElementById('serviceSearch').addEventListener('input', function() {
  const q = this.value.toLowerCase().trim();
  let anyVisible = false;
  document.querySelectorAll('#serviceList .service-option').forEach(opt => {
    const match = !q || opt.dataset.val.toLowerCase().includes(q);
    opt.classList.toggle('hidden', !match);
    if (match) anyVisible = true;
  });
  // Show/hide group labels
  document.querySelectorAll('#serviceList .service-group-label').forEach(label => {
    if (!q) { label.style.display = ''; return; }
    let next = label.nextElementSibling;
    let hasVisible = false;
    while (next && !next.classList.contains('service-group-label')) {
      if (!next.classList.contains('hidden') && next.classList.contains('service-option')) hasVisible = true;
      next = next.nextElementSibling;
    }
    label.style.display = hasVisible ? '' : 'none';
  });
  document.getElementById('svcNoResults').style.display = anyVisible ? 'none' : 'block';
});

document.getElementById('serviceSearch').addEventListener('focus', () => {
  document.getElementById('servicePicker').classList.add('focused');
});
document.getElementById('serviceSearch').addEventListener('blur', () => {
  document.getElementById('servicePicker').classList.remove('focused');
});
window.addEventListener('DOMContentLoaded', updateBranchHint);
</script>
</body>
</html>