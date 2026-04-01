<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
hq_boot_session_security();
$corporateSuccess = isset($_SESSION['corporate_success']);
$corporateError   = isset($_SESSION['corporate_error']);
unset($_SESSION['corporate_success'], $_SESSION['corporate_error']);
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Corporate Service Inquiry — HealthQuarters</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --gs:#6abf4b;--ge:#2dbfb8;--accent:#2dbfb8;
    --deep:#1a4d2e;--mid:#2d7a4f;--bright:#3aad6e;
    --pale:#e8f7ee;--muted:#f0faf4;
    --g100:#f7f9f8;--g200:#e8eeeb;--g400:#94a89d;--g600:#4a6057;
    --border:#dde8e4;
    --green-deep: #1a4d2e;
    --green-mid: #2d7a4f;
    --green-bright: #3aad6e;
    --green-light: #a8e6c1;
    --green-pale: #e8f7ee;
    --green-muted: #f0faf4;
    --white: #ffffff;
    --gray-100: #f7f9f8;
    --gray-200: #e8eeeb;
    --gray-400: #94a89d;
    --gray-600: #4a6057;
    --gray-800: #1e302a;
    --error: #e05252;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow-lg: 0 20px 60px rgba(26,77,46,0.16);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--green-muted);
    min-height: 100vh;
    color: var(--gray-800);
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed;
    top: -120px; right: -120px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(58,173,110,0.13) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
  }
  body::after {
    content: '';
    position: fixed;
    bottom: -100px; left: -100px;
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(26,77,46,0.09) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
  }

  /* ═══════════════════════════════════════
     NAVBAR
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
  .brand-wrap { display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0; padding-right: 24px; border-right: 1px solid rgba(255,255,255,.18); margin-right: 8px; position: relative; z-index: 1; }
  .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
  .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }
  .topbar-nav { display: flex; align-items: stretch; flex: 1; position: relative; z-index: 1; }
  .mobile-nav-toggle{display:none;align-items:center;justify-content:center;width:42px;height:42px;margin-left:auto;border-radius:12px;border:1.5px solid rgba(255,255,255,.3);background:rgba(255,255,255,.14);color:#fff;}
  .mobile-nav-panel{display:none;background:#fff;border-bottom:1px solid var(--border);box-shadow:0 12px 28px rgba(13,46,30,.08);}
  .mobile-nav-panel.open{display:block;}
  .mobile-nav-links{max-width:900px;margin:0 auto;padding:14px 24px 18px;display:grid;gap:10px;}
  .mobile-nav-links a{display:block;padding:12px 14px;border-radius:12px;background:var(--green-muted);border:1px solid var(--gray-200);color:var(--green-deep);text-decoration:none;font-weight:600;}
  .nav-item { position: relative; display: flex; align-items: stretch; }
  .nav-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 0 15px; height: 100%;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
    color: rgba(255,255,255,.9); text-decoration: none;
    background: transparent; border: none; cursor: pointer;
    transition: background .18s, color .18s; white-space: nowrap;
  }
  .nav-btn:hover, .nav-item.open > .nav-btn { color: #fff; background: rgba(255,255,255,.25); }

  .nav-btn.active {
    position: relative;
    color: #fff;
    background: rgba(255,255,255,.22);
  }
  .nav-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0; left: 12px; right: 12px;
    height: 3px;
    background: #fff;
    border-radius: 2px 2px 0 0;
    box-shadow: 0 0 8px rgba(255,255,255,.5);
  }
  .nav-item.open > .nav-btn::after {
    content: '';
    position: absolute;
    bottom: 0; left: 12px; right: 12px;
    height: 3px;
    background: rgba(255,255,255,.6);
    border-radius: 2px 2px 0 0;
  }

  .nav-chevron { width: 10px; height: 10px; fill: none; stroke: currentColor; stroke-width: 2.5; transition: transform .2s; flex-shrink: 0; }
  .nav-item.open .nav-chevron { transform: rotate(180deg); }
  .topbar-right { display: flex; align-items: center; margin-left: auto; padding-left: 16px; position: relative; z-index: 1; }
  .btn-signin {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
    color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
    border-radius: 4px; text-decoration: none; transition: all .2s;
  }
  .btn-signin:hover { background: rgba(255,255,255,.28); color: #fff; }
  .nav-dropdown {
    position: absolute; top: 100%; left: 0;
    background: #fff; min-width: 220px;
    box-shadow: 0 8px 32px rgba(13,46,30,.2);
    border: 1px solid var(--border);
    border-top: 3px solid var(--gs);
    border-radius: 0 0 8px 8px;
    display: none; z-index: 9999; padding: 6px 0;
    animation: dropSlide .15s ease;
  }
  @keyframes dropSlide { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
  .nav-item.open .nav-dropdown { display: block; }
  .drop-link {
    display: block; padding: 9px 18px;
    font-size: .84rem; font-weight: 500; color: var(--deep);
    text-decoration: none; transition: background .14s;
    border-left: 3px solid transparent;
  }
  .drop-link:hover { background: var(--pale); color: var(--mid); border-left-color: var(--bright); }
  .drop-section-head { font-size: .65rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--g400); padding: 10px 18px 5px; margin-top: 4px; }
  .drop-divider { height: 1px; background: var(--g200); margin: 5px 12px; }
  .drop-services { min-width: 280px; }

  @media(max-width:768px) {
    .topbar-inner { padding: 0 16px; height: 60px; }
    .brand-name { font-size: 1.2rem; }
    .brand-logo { height: 40px; width: 40px; }
    .nav-btn { padding: 0 10px; font-size: .74rem; }
  }
  @media(max-width:480px) { .brand-name { display: none; } }

  /* ═══════════════════════════════════════
     lAGE HERO
  ═══════════════════════════════════════ */
  .page-hero {
    background: linear-gradient(135deg, var(--deep) 0%, #2d7a4f 55%, #1f6040 100%);
    padding: 52px 0 44px; text-align: center;
    position: relative; overflow: hidden;
  }
  .page-hero::before { content:''; position:absolute; top:-60px; right:-60px; width:300px; height:300px; background:radial-gradient(circle,rgba(106,191,75,.15) 0%,transparent 70%); border-radius:50%; }
  .page-hero h1 { font-family:'DM Serif Display',serif; font-size:clamp(1.6rem,3.5vw,2.4rem); color:#fff; margin-bottom:8px; position:relative; z-index:1; }
  .page-hero p { font-size:.88rem; color:rgba(255,255,255,.7); position:relative; z-index:1; }
  .hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    color: #a8e6c1; font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 50px; margin-bottom: 14px;
    position: relative; z-index: 1; display: inline-flex;
  }
  .hero-quick-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:18px;max-width:900px;margin:22px auto 0;padding:0 24px;position:relative;z-index:1;}
  .hero-quick-card{background:#fff;border:1px solid var(--gray-200);border-radius:18px;padding:20px 22px;box-shadow:0 8px 24px rgba(13,46,30,.08);}
  .hero-quick-card h3{font-family:'DM Serif Display',serif;font-size:1.18rem;color:var(--green-deep);margin-bottom:8px;}
  .hero-quick-card p{font-size:.83rem;color:var(--gray-600);line-height:1.68;margin:0;}
  .hero-quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
  .hero-quick-links a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;text-decoration:none;font-size:.8rem;font-weight:700;}
  .hero-quick-links .primary-link{background:linear-gradient(135deg,#6abf4b 0%, #2dbfb8 100%);color:#fff;}
  .hero-quick-links .secondary-link{background:var(--green-muted);color:var(--green-mid);border:1px solid var(--gray-200);}

  /* ═══════════════════════════════════════
     FORM CARD
  ═══════════════════════════════════════ */
  main {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 24px 80px;
    position: relative; z-index: 1;
  }

  .card {
    background: var(--white);
    border-radius: 24px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    animation: cardIn 0.45s cubic-bezier(.4,0,.2,1);
  }
  @keyframes cardIn {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .card-header {
    background: linear-gradient(135deg, var(--green-pale) 0%, var(--green-muted) 100%);
    padding: 32px 40px 24px;
    border-bottom: 1.5px solid var(--gray-200);
  }
  .step-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: linear-gradient(135deg, #6abf4b, #2dbfb8);
    color: var(--white); font-size: .7rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;
  }
  .card-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.6rem; color: var(--green-deep); letter-spacing: -.02em; }
  .card-header p { font-size: .88rem; color: var(--gray-600); margin-top: 6px; }
  .card-body { padding: 36px 40px 32px; }
  .sec-header{
    display:flex;align-items:flex-end;justify-content:space-between;gap:16px;
    border-bottom:1px solid rgba(106,191,75,.18);padding-bottom:14px;margin-bottom:18px;
  }
  .sec-header h2{
    font-family:'DM Serif Display',serif;font-size:1.22rem;color:var(--green-deep);
    display:flex;align-items:center;gap:10px;margin:0;
  }
  .sec-header h2::before{
    content:'';width:10px;height:10px;border-radius:999px;
    background:linear-gradient(135deg,var(--gs),var(--ge));box-shadow:0 0 0 6px rgba(106,191,75,.09);
  }
  .form-callout{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-bottom:24px;}
  .callout-card{background:linear-gradient(180deg,#ffffff 0%,#fbfefd 100%);border:1px solid var(--gray-200);border-radius:16px;padding:14px 15px;}
  .callout-card strong{display:block;font-family:'DM Serif Display',serif;font-size:1.15rem;color:var(--green-deep);margin-bottom:6px;}
  .callout-card span{display:block;font-size:.75rem;color:var(--gray-600);line-height:1.55;}

  .alert-box { border-radius: 12px; padding: 14px 18px; font-size: .88rem; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }
  .alert-success { background: var(--green-pale); border: 1.5px solid var(--green-light); color: var(--green-mid); }
  .alert-error   { background: #fdecea; border: 1.5px solid #f5b4b4; color: var(--error); }

  .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 22px 28px; }
  .form-grid .full { grid-column: 1 / -1; }
  .form-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px 28px; }
  .field { display: flex; flex-direction: column; gap: 7px; }

  label { font-size: .78rem; font-weight: 600; color: var(--green-deep); letter-spacing: .04em; text-transform: uppercase; }
  label .req { color: var(--green-bright); margin-left: 2px; }

  input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select, textarea {
    width: 100%; padding: 12px 16px;
    border: 2px solid var(--gray-200); border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: .92rem; color: var(--gray-800);
    background: var(--gray-100); transition: border-color .2s, box-shadow .2s, background .2s;
    outline: none; appearance: none; -webkit-appearance: none;
  }
  input:focus, select:focus, textarea:focus {
    border-color: var(--green-bright);
    box-shadow: 0 0 0 4px rgba(58,173,110,.14);
    background: var(--white);
  }
  input.error, select.error, textarea.error { border-color: var(--error); }

  select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%234a6057' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
  }
  textarea { resize: vertical; min-height: 130px; }

  .error-msg { font-size: .74rem; color: var(--error); display: none; }
  .error-msg.show { display: block; }

  .section-divider { display: flex; align-items: center; gap: 14px; margin: 28px 0 22px; }
  .section-divider span { font-size: .73rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--green-mid); white-space: nowrap; }
  .section-divider::before, .section-divider::after { content: ''; flex: 1; height: 1.5px; background: var(--gray-200); }

  .info-note {
    background: var(--green-pale); border-left: 3px solid var(--green-bright);
    border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    padding: 12px 16px; font-size: .82rem; color: var(--green-deep);
    margin-bottom: 24px; line-height: 1.5;
  }

  .card-footer {
    padding: 20px 40px 32px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; border-top: 1.5px solid var(--gray-200); flex-wrap: wrap;
  }

  .btn {
    display: inline-flex; align-items: center; justify-content: center;
    gap: 8px; padding: 13px 32px; border-radius: 50px;
    font-family: 'DM Sans', sans-serif; font-size: .92rem; font-weight: 600;
    cursor: pointer; border: none; transition: all .22s cubic-bezier(.4,0,.2,1);
    outline: none; white-space: nowrap; text-decoration: none;
  }
  .btn-primary { background: linear-gradient(135deg, #6abf4b 0%, #2dbfb8 100%); color: var(--white); box-shadow: 0 4px 18px rgba(45,191,184,.3); }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(45,191,184,.42); color: var(--white); }
  .btn-ghost { background: transparent; color: var(--green-mid); border: 2px solid var(--gray-200); }
  .btn-ghost:hover { background: var(--green-pale); border-color: var(--green-light); color: var(--green-mid); }

  .success-screen { text-align: center; padding: 64px 40px; }
  .success-icon {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #6abf4b, #2dbfb8);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 28px;
    box-shadow: 0 0 0 16px rgba(106,191,75,.1), 0 8px 32px rgba(106,191,75,.28);
    animation: popIn 0.5s cubic-bezier(.4,0,.2,1);
  }
  @keyframes popIn { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
  .success-screen h2 { font-family: 'DM Serif Display', serif; font-size: 2rem; color: var(--green-deep); margin-bottom: 12px; }
  .success-screen p { color: var(--gray-600); font-size: .95rem; line-height: 1.7; max-width: 440px; margin: 0 auto 28px; }
  .ref-badge {
    display: inline-block; background: var(--green-pale); border: 1.5px solid var(--green-light);
    border-radius: var(--radius-sm); padding: 12px 28px; font-size: .85rem;
    color: var(--green-deep); font-weight: 600; margin-bottom: 28px; letter-spacing: .04em;
  }
  .success-actions { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }

  @media(max-width:680px) {
    main { padding: 24px 16px 60px; }
    .card-body, .card-header, .card-footer { padding-left: 20px; padding-right: 20px; }
    .form-grid, .form-grid-3 { grid-template-columns: 1fr; }
    .form-grid .full { grid-column: 1; }
    .btn-primary { width: 100%; }
    .success-actions { flex-direction: column; width: 100%; }
    .success-actions .btn { width: 100%; }
    .hero-quick-grid{grid-template-columns:1fr;padding:0 16px;}
    .mobile-nav-toggle{display:inline-flex;}
    .form-callout{grid-template-columns:1fr;}
  }

  .hidden { display: none; }
  .site-footer{
    background:linear-gradient(135deg,#0f2a1c 0%,#1a4d2e 48%,#17595a 100%);
    color:rgba(255,255,255,.82);
  }
  .footer-inner{max-width:1280px;margin:0 auto;padding:38px 24px 18px;}
  .footer-grid{display:grid;grid-template-columns:1.3fr .9fr .9fr;gap:20px;}
  .footer-card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:22px;padding:22px 20px;box-shadow:0 14px 36px rgba(0,0,0,.18);}
  .footer-card h3,.footer-card h4{margin:0 0 12px;}
  .footer-card h3{font-family:'DM Serif Display',serif;font-size:1.3rem;color:#fff;}
  .footer-card h4{font-size:.78rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#a8e6c1;}
  .footer-card p,.footer-card a,.footer-card span{font-size:.82rem;line-height:1.65;color:rgba(255,255,255,.76);text-decoration:none;}
  .footer-links{display:flex;flex-direction:column;gap:10px;}
  .footer-links a:hover{color:#fff;}
  .footer-bottom{margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.12);font-size:.76rem;color:rgba(255,255,255,.62);display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;}
</style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => $isLoggedIn ? 'homepage.php' : 'lp.php',
  'active' => 'services',
  'is_logged_in' => $isLoggedIn,
  'show_account_actions' => false,
]); ?>

<!-- ═══════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════ -->
<div class="page-hero">
  <div class="container">
    <div class="hero-eyebrow">Corporate Service</div>
    <h1>Corporate Service Inquiry</h1>
    <p>Fill in the form below and our team will reach out within 1–2 business days.</p>
  </div>
</div>
<div class="hero-quick-grid">
  <div class="hero-quick-card">
    <h3>Best for organizations and team-based requests</h3>
    <p>Use this inquiry form for APE, pre-employment screening, drug testing, and customized corporate packages that need coordination with your organization.</p>
    <div class="hero-quick-links">
      <a class="primary-link" href="corporate_info.php">View Corporate Overview</a>
      <a class="secondary-link" href="service.php">Review Service Catalog</a>
    </div>
  </div>
  <div class="hero-quick-card">
    <h3>Prepare these details first</h3>
    <p>Having your company name, estimated headcount, timeline, and required service scope ready helps us respond with a better recommendation.</p>
    <div class="hero-quick-links">
      <a class="secondary-link" href="locations.php">See Branches</a>
      <a class="secondary-link" href="<?= $isLoggedIn ? 'homepage.php' : 'lp.php' ?>">Return Home</a>
    </div>
  </div>
</div>

<main>
  <div class="card" id="mainCard">

    <?php if ($corporateSuccess): ?>
    <!-- ===== SUCCESS VIEW ===== -->
    <div class="success-screen">
      <div class="success-icon">
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h2>Message Received!</h2>
      <p>Thank you for your corporate inquiry. One of our staff members will review your request and reach out to you within <strong>1–2 business days</strong>.</p>
      <div class="ref-badge">Reference No: CS-<?= strtoupper(substr(md5(uniqid()), 0, 6)) ?></div>
      <br>
      <div class="success-actions">
        <a href="<?= $isLoggedIn ? 'homepage.php' : 'lp.php' ?>" class="btn btn-ghost">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          Go Back Home
        </a>
        <a href="corporateservice.php" class="btn btn-primary">Submit Another Inquiry</a>
      </div>
    </div>

    <?php else: ?>
    <!-- ===== FORM VIEW ===== -->
    <div id="formView">
      <div class="card-header">
        <div class="step-badge">Corporate Inquiry</div>
        <h2>Leave Us a Message</h2>
        <p>Fill in your company and contact details and we'll have a specialist reach out to you shortly.</p>
      </div>
      <div class="card-body">
        <div class="form-callout">
          <div class="callout-card"><strong>Company</strong><span>Prepare your organization details, industry, size, and office address.</span></div>
          <div class="callout-card"><strong>Contact</strong><span>Add the main representative who will coordinate with HealthQuarters.</span></div>
          <div class="callout-card"><strong>Service Scope</strong><span>Describe the service type, headcount, timing, and any special requirements.</span></div>
        </div>

        <?php if ($corporateError): ?>
          <div class="alert-box alert-error">Please fill in all required fields correctly before submitting.</div>
        <?php endif; ?>

        <div class="info-note">
          This form is for corporate and business accounts. For individual or home service inquiries, please use the Home Service Appointment form.
        </div>

        <form method="lOST" action="submit_corporate.php" id="corporateForm">
          <?= hq_csrf_input('corporate_submit') ?>
          <input type="hidden" name="submit_corporate" value="1">

          <!-- Company Info -->
          <div class="section-divider"><span>Company Information</span></div>
          <div class="form-grid">
            <div class="field">
              <label>Company Name <span class="req">*</span></label>
              <input type="text" name="companyName" id="companyName" placeholder="e.g. Acme Corporation">
              <span class="error-msg" id="err-company">Required field.</span>
            </div>
            <div class="field">
              <label>Company Number <span class="req">*</span></label>
              <input type="tel" name="companyNumber" id="companyNumber" placeholder="e.g. 02-XXXX-XXXX">
              <span class="error-msg" id="err-compnum">Required field.</span>
            </div>
            <div class="field">
              <label>Industry / Sector <span class="req">*</span></label>
              <select name="industry" id="industry">
                <option value="">Select industry...</option>
                <option>Banking & Finance</option>
                <option>Business lrocess Outsourcing (BlO)</option>
                <option>Construction & Real Estate</option>
                <option>Education</option>
                <option>Food & Beverage</option>
                <option>Government / lublic Sector</option>
                <option>Healthcare & lharmaceuticals</option>
                <option>Hospitality & Tourism</option>
                <option>Information Technology</option>
                <option>Manufacturing</option>
                <option>Retail & E-Commerce</option>
                <option>Telecommunications</option>
                <option>Transportation & Logistics</option>
                <option>Other</option>
              </select>
              <span class="error-msg" id="err-industry">llease select an industry.</span>
            </div>
            <div class="field">
              <label>Company Size</label>
              <select name="companySize" id="companySize">
                <option value="">Select size...</option>
                <option>1–10 employees</option>
                <option>11–50 employees</option>
                <option>51–200 employees</option>
                <option>201–500 employees</option>
                <option>500+ employees</option>
              </select>
            </div>
            <div class="field full">
              <label>Company Address <span class="req">*</span></label>
              <input type="text" name="companyAddress" id="companyAddress" placeholder="e.g. 8F One Corporate Centre, Doña Julia Vargas Ave, lasig City">
              <span class="error-msg" id="err-address">Required field.</span>
            </div>
          </div>

          <!-- Contact lerson -->
          <div class="section-divider"><span>Contact lerson</span></div>
          <div class="form-grid-3">
            <div class="field">
              <label>Contact lerson <span class="req">*</span></label>
              <input type="text" name="contactlerson" id="contactlerson" placeholder="Full name">
              <span class="error-msg" id="err-contact">Required field.</span>
            </div>
            <div class="field">
              <label>Designation <span class="req">*</span></label>
              <input type="text" name="designation" id="designation" placeholder="e.g. HR Manager">
              <span class="error-msg" id="err-designation">Required field.</span>
            </div>
            <div class="field">
              <label>Email Address <span class="req">*</span></label>
              <input type="email" name="email" id="email" placeholder="email@company.com">
              <span class="error-msg" id="err-email">Enter a valid email.</span>
            </div>
            <div class="field">
              <label>Contact Number <span class="req">*</span></label>
              <input type="tel" name="contactNumber" id="contactNumber" placeholder="e.g. +639123456789">
              <span class="error-msg" id="err-contactnumber">Enter a valid contact number.</span>
            </div>
          </div>

          <!-- HMO Information -->
          <div class="section-divider"><span>HMO Information <span style="font-weight:400;color:var(--gray-400);text-transform:none;letter-spacing:0;">(Optional)</span></span></div>
          <div class="form-grid">
            <div class="field">
              <label>HMO lrovider</label>
              <input type="text" name="hmolrovider" id="hmolrovider" placeholder="e.g. Maxicare, Intellicare, MediCard">
            </div>
            <div class="field">
              <label>HMO Account / Group Code</label>
              <input type="text" name="hmoCode" id="hmoCode" placeholder="e.g. GRl-000123">
            </div>
            <div class="field">
              <label>HMO Coverage Type</label>
              <select name="hmoCoverage" id="hmoCoverage">
                <option value="">Select coverage...</option>
                <option>Outpatient Only</option>
                <option>Inpatient Only</option>
                <option>Outpatient & Inpatient</option>
                <option>Dental & Medical</option>
                <option>Comprehensive (Medical, Dental, Vision)</option>
              </select>
            </div>
            <div class="field">
              <label>No. of HMO-covered Employees</label>
              <input type="number" name="hmoCoveredCount" id="hmoCoveredCount" placeholder="e.g. 80" min="1">
            </div>
          </div>

          <!-- Service Interest -->
          <div class="section-divider"><span>Service Interest</span></div>
          <div class="form-grid">
            <div class="field full">
              <label>Type of Service Needed <span class="req">*</span></label>
              <input type="text" name="serviceType" id="serviceType"
                     placeholder="e.g. Annual lhysical Examination, Drug Testing, COVID-19 Swab Test..."
                     value="<?= htmlspecialchars($_GET['service'] ?? '') ?>">
              <span class="error-msg" id="err-service">llease describe the service you need.</span>
            </div>
            <div class="field">
              <label>Estimated No. of Employees</label>
              <input type="number" name="empCount" id="empCount" placeholder="e.g. 150" min="1">
            </div>
            <div class="field">
              <label>lreferred Schedule</label>
              <select name="schedule" id="schedule">
                <option value="">Select preference...</option>
                <option>Within this week</option>
                <option>Within this month</option>
                <option>Next month</option>
                <option>Flexible / To be discussed</option>
              </select>
            </div>
            <div class="field full">
              <label>Message / Additional Details <span class="req">*</span></label>
              <textarea name="message" id="message" placeholder="Tell us more about what your company needs, any special requirements, or questions you may have..."></textarea>
              <span class="error-msg" id="err-message">llease enter your message.</span>
            </div>
          </div>

        </form>
      </div>
      <div class="card-footer">
        <div style="font-size:.8rem;color:var(--gray-400);">
          Fields marked <span style="color:var(--green-bright);font-weight:700;">*</span> are required
        </div>
        <button class="btn btn-primary" onclick="validateAndSubmit()">
          Submit Inquiry
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
        </button>
      </div>
    </div>
    <?php endif; ?>

  </div><!-- /card -->
</main>

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-card">
        <h3>HealthQuarters</h3>
        <p>Submit corporate and organizational inquiries through a cleaner, more structured request flow designed for faster coordination.</p>
      </div>
      <div class="footer-card">
        <h4>Quick Access</h4>
        <div class="footer-links">
          <a href="<?= $isLoggedIn ? 'homepage.php' : 'lp.php' ?>">Home</a>
          <a href="corporate_info.php">Corporate Overview</a>
          <a href="service.php">Service Catalog</a>
          <a href="locations.php">Locations</a>
        </div>
      </div>
      <div class="footer-card">
        <h4>Support</h4>
        <div class="footer-links">
          <a href="about_us.php#contact">Contact HealthQuarters</a>
          <a href="about_us.php">About Us</a>
          <a href="booking.php">Home Service Booking</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> HealthQuarters. All rights reserved.</span>
      <span>Corporate inquiries are reviewed through the patient-facing service team workflow.</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  <?php hq_render_public_nav_script(); ?>

  // Auto-focus the service field when it's empty (e.g. from Custom lackage button)
  window.addEventListener('DOMContentLoaded', () => {
    const svc = document.getElementById('serviceType');
    if (svc && svc.value.trim() === '' && window.location.search.includes('service=')) {
      svc.focus();
      svc.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
  function showError(id, show) {
    const el = document.getElementById(id);
    if (el) el.classList.toggle('show', show);
  }
  function markField(id, error) {
    const el = document.getElementById(id);
    if (el) el.classList.toggle('error', error);
  }

  function validateAndSubmit() {
    let ok = true;
    const required = [
      ['companyName',    'err-company'],
      ['companyNumber',  'err-compnum'],
      ['industry',       'err-industry'],
      ['companyAddress', 'err-address'],
      ['contactlerson',  'err-contact'],
      ['designation',    'err-designation'],
      ['email',          'err-email'],
      ['contactNumber',  'err-contactnumber'],
      ['serviceType',    'err-service'],
      ['message',        'err-message'],
    ];
    required.forEach(([id, errId]) => {
      const val = document.getElementById(id).value.trim();
      const empty = !val;
      markField(id, empty);
      showError(errId, empty);
      if (empty) ok = false;
    });

    const email = document.getElementById('email').value.trim();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      markField('email', true);
      showError('err-email', true);
      ok = false;
    }
    if (ok) document.getElementById('corporateForm').submit();
  }
</script>
</body>
</html>