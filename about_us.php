<?php
// about_us.php — unified About page (Profile, Mission/Vision, Values, Org Chart, Milestones)
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/public_footer.php';
$isLoggedIn   = hq_is_logged_in();
$is_logged_in = $isLoggedIn;
$patient_name = hq_patient_name();
$initials     = hq_initials($patient_name);
$homeLink     = $isLoggedIn ? 'homepage.php' : 'lp.php';
$current_page = 'about';
$aboutContent = require __DIR__ . '/data/about_us_content.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>About HealthQuarters — Profile, Mission &amp; More</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* ── TOKENS ─────────────────────────────────────────────────────── */
    :root{
      --gs:#6abf4b;--ge:#2dbfb8;--accent:#2dbfb8;
      --deep:#1a4d2e;--mid:#2d7a4f;--bright:#3aad6e;
      --pale:#e8f7ee;--muted:#f0faf4;
      --g100:#f7f9f8;--g200:#e8eeeb;--g400:#94a89d;--g600:#4a6057;
      --border:#dde8e4;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{scroll-behavior:smooth;}
    body{font-family:'DM Sans',sans-serif;background:#f4faf6;color:#1a2e22;}

    /* ═══════════════════════════════════════
       NAVBAR — exact copy from lp.php
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
    /* Brand */
    .brand-wrap { 
      display: flex; align-items: center; gap: 12px; text-decoration: none; 
      flex-shrink: 0; padding-right: 24px; border-right: 1px solid rgba(255,255,255,.18); margin-right: 8px; position: relative; z-index: 1; 
    }
    .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
    .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }
    /* Nav */
    .topbar-nav { display: flex; align-items: stretch; flex: 1; position: relative; z-index: 1; }
    .mobile-nav-toggle{display:none;align-items:center;justify-content:center;width:42px;height:42px;margin-left:auto;border-radius:12px;border:1.5px solid rgba(255,255,255,.3);background:rgba(255,255,255,.14);color:#fff;}
    .mobile-nav-panel{display:none;background:#fff;border-bottom:1px solid var(--border);box-shadow:0 12px 28px rgba(13,46,30,.08);}
    .mobile-nav-panel.open{display:block;}
    .mobile-nav-links{max-width:1260px;margin:0 auto;padding:14px 24px 18px;display:grid;gap:10px;}
    .mobile-nav-links a{display:block;padding:12px 14px;border-radius:12px;background:var(--muted);border:1px solid var(--border);color:var(--deep);text-decoration:none;font-weight:600;}
    .nav-item { position: relative; display: flex; align-items: stretch; }
    .nav-btn {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 0 15px; height: 100%;
      font-family: 'DM Sans', sans-serif;
      font-size: .8rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase;
      color: rgba(255,255,255,.9); text-decoration: none;
      background: transparent; border: none; cursor: pointer;
      transition: background .18s, color .18s;
      white-space: nowrap;
    }
    .nav-btn:hover, .nav-item.open > .nav-btn { color: #fff; background: rgba(0,0,0,.16); }

    /* ── Active nav indicator ── */
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

    /* Dimmer indicator when a dropdown is open */
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
    /* Sign In */
    .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; position: relative; z-index: 1; }
    .btn-signin {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
    .btn-signin:hover { background: rgba(255,255,255,.28); color: #fff; }

    /* Patient chip & logout styles - from homepage.php */
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
    /* Dropdowns */
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
    /* Responsive navbar */
    @media(max-width:768px) {
      .topbar-inner { padding: 0 16px; height: 60px; }
      .brand-name { font-size: 1.2rem; }
      .brand-logo { height: 40px; width: 40px; }
      .nav-btn { padding: 0 10px; font-size: .74rem; }
    }
    @media(max-width:480px) { .brand-name { display: none; } }

    /* ── IN-PAGE STICKY SUB-NAV ──────────────────────────────────────── */
    .subnav{
      background:#fff;border-bottom:1px solid var(--border);
      position:sticky;top:68px;z-index:900;
      box-shadow:0 2px 12px rgba(26,77,46,.06);
    }
    .subnav-inner{
      max-width:1260px;margin:0 auto;padding:0 28px;
      display:flex;align-items:center;gap:4px;overflow-x:auto;
      scrollbar-width:none;-ms-overflow-style:none;
    }
    .subnav-inner::-webkit-scrollbar{display:none;}
    .sn-link{
      display:inline-flex;align-items:center;gap:6px;
      font-size:.78rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;
      color:var(--g600);text-decoration:none;
      padding:14px 16px;border-bottom:2.5px solid transparent;
      white-space:nowrap;transition:all .18s;
    }
    .sn-link:hover{color:var(--mid);}
    .sn-link.active{color:var(--mid);border-bottom-color:var(--bright);}

    /* ── PAGE HERO ───────────────────────────────────────────────────── */
    .page-hero{
      background:linear-gradient(135deg,var(--deep) 0%,#2d7a4f 60%,#1f7050 100%);
      padding:72px 0 56px;text-align:center;position:relative;overflow:hidden;
    }
    .page-hero::before{
      content:'';position:absolute;top:-60px;right:-60px;
      width:340px;height:340px;
      background:radial-gradient(circle,rgba(106,191,75,.15) 0%,transparent 70%);
      border-radius:50%;
    }
    .page-hero::after{
      content:'';position:absolute;bottom:-40px;left:-40px;
      width:260px;height:260px;
      background:radial-gradient(circle,rgba(45,191,184,.12) 0%,transparent 70%);
      border-radius:50%;
    }
    .page-hero h1{font-family:'DM Serif Display',serif;font-size:2.8rem;color:#fff;margin-bottom:12px;position:relative;z-index:1;}
    .page-hero p{font-size:.95rem;color:rgba(255,255,255,.72);max-width:520px;margin:0 auto;line-height:1.8;position:relative;z-index:1;}
    .hero-quick-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:18px;max-width:1260px;margin:24px auto 0;padding:0 24px;position:relative;z-index:1;}
    .hero-quick-card{background:#fff;border:1px solid var(--border);border-radius:20px;padding:22px;box-shadow:0 8px 24px rgba(13,46,30,.06);}
    .hero-quick-card h3{font-family:'DM Serif Display',serif;font-size:1.2rem;color:var(--deep);margin-bottom:8px;}
    .hero-quick-card p{font-size:.84rem;color:var(--g600);line-height:1.7;margin:0;}
    .hero-quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
    .hero-quick-links a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;text-decoration:none;font-size:.8rem;font-weight:700;}
    .hero-quick-links .primary-link{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;}
    .hero-quick-links .secondary-link{background:var(--muted);color:var(--mid);border:1px solid var(--border);}

    /* ── SHARED COMPONENTS ───────────────────────────────────────────── */
    .sec-eyebrow{
      display:inline-flex;align-items:center;gap:7px;
      font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
      color:var(--mid);background:var(--pale);border:1.5px solid #a8e6c1;
      padding:4px 14px;border-radius:50px;margin-bottom:12px;
    }
    .sec-h{font-family:'DM Serif Display',serif;font-size:2rem;color:var(--deep);line-height:1.2;}
    .sec-h em{font-style:italic;color:var(--accent);}
    .grad-bar{height:4px;width:52px;background:linear-gradient(90deg,var(--gs),var(--ge));border-radius:2px;margin:16px 0 28px;}
    .scroll-target{scroll-margin-top:130px;}
    .section-light{background:#fff;}
    .section-muted{background:var(--muted);}

    /* ── PROFILE STAT CARDS ──────────────────────────────────────────── */
    .stat-card{
      background:#fff;border-radius:20px;padding:28px 24px;
      box-shadow:0 8px 24px rgba(13,46,30,.06);text-align:center;
      border-bottom:3px solid var(--bright);
    }
    .stat-num{font-family:'DM Serif Display',serif;font-size:2.6rem;color:var(--deep);line-height:1;margin-bottom:8px;}
    .stat-lbl{font-size:.82rem;color:var(--g600);line-height:1.5;}
    .profile-text p{font-size:.93rem;color:var(--g600);line-height:1.9;margin-bottom:16px;}
    .profile-text p:last-child{margin-bottom:0;}

    /* ── MISSION / VISION CARDS ──────────────────────────────────────── */
    .mv-card{border-radius:20px;padding:40px 36px;height:100%;}
    .mv-card.mission{background:linear-gradient(135deg,var(--deep),#2d7a4f);}
    .mv-card.vision{background:linear-gradient(135deg,#14485c,#2dbfb8);}
    .mv-label{font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:10px;}
    .mv-card h3{font-family:'DM Serif Display',serif;font-size:1.7rem;color:#fff;margin-bottom:18px;}
    .mv-card p{font-size:.93rem;color:rgba(255,255,255,.78);line-height:1.85;margin:0;}

    /* ── VALUE CARDS ─────────────────────────────────────────────────── */
    .value-card{
      background:#fff;border-radius:16px;padding:28px 24px;
      box-shadow:0 4px 20px rgba(26,77,46,.07);height:100%;
      border-top:3px solid var(--bright);transition:all .22s;
    }
    .value-card:hover{transform:translateY(-5px);box-shadow:0 16px 36px rgba(26,77,46,.13);}
    .value-card h5{font-family:'DM Serif Display',serif;font-size:1.05rem;color:var(--deep);margin-bottom:10px;}
    .value-card p{font-size:.84rem;color:var(--g600);line-height:1.7;margin:0;}

    /* ── COMMITMENT / WHY CHOOSE ─────────────────────────────────────── */
    .why-item{display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid var(--border);}
    .why-item:last-child{border-bottom:none;}
    .why-check{width:26px;height:26px;min-width:26px;background:linear-gradient(135deg,var(--gs),var(--ge));border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:.72rem;font-weight:700;margin-top:1px;}
    .why-item p{font-size:.9rem;color:var(--g600);line-height:1.75;margin:0;}
    .info-card{background:#fff;border-radius:20px;padding:36px 32px;box-shadow:0 8px 24px rgba(13,46,30,.06);height:100%;}
    .info-card h4{font-family:'DM Serif Display',serif;font-size:1.3rem;color:var(--deep);margin-bottom:18px;}
    .info-card p{font-size:.92rem;color:var(--g600);line-height:1.85;margin-bottom:16px;}
    .info-card p:last-child{margin-bottom:0;}
    .info-card .highlight-text{font-size:.92rem;color:var(--mid);font-weight:500;font-style:italic;margin:0;}

    /* ── ORG CHART ───────────────────────────────────────────────────── */
    .branch-tabs{display:flex;gap:6px;background:#fff;border-radius:14px;padding:6px;box-shadow:0 2px 14px rgba(26,77,46,.08);width:fit-content;margin:0 auto 40px;}
    .branch-tab{padding:9px 24px;border-radius:10px;font-size:.82rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--g400);background:transparent;border:none;cursor:pointer;transition:all .2s;}
    .branch-tab.active{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;box-shadow:0 4px 14px rgba(45,191,184,.3);}
    .branch-tab:hover:not(.active){background:var(--pale);color:var(--mid);}
    .branch-panel{display:none;}.branch-panel.active{display:block;}
    .leader-card{background:linear-gradient(135deg,var(--deep),#2d7a4f);border-radius:20px;padding:32px 28px;text-align:center;margin-bottom:28px;}
    .leader-avatar{width:80px;height:80px;border-radius:50%;border:3px solid rgba(255,255,255,.35);background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:2rem;}
    .leader-name{font-family:'DM Serif Display',serif;font-size:1.15rem;color:#fff;margin-bottom:5px;}
    .leader-title{font-size:.78rem;color:rgba(255,255,255,.65);letter-spacing:.06em;text-transform:uppercase;}
    .staff-card{background:#fff;border-radius:20px;padding:22px 20px;text-align:center;box-shadow:0 8px 24px rgba(13,46,30,.06);height:100%;transition:all .22s;border-top:3px solid var(--bright);}
    .staff-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px rgba(13,46,30,.1);}
    .staff-avatar{width:64px;height:64px;border-radius:50%;background:var(--pale);border:2px solid #a8e6c1;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.5rem;}
    .staff-name{font-family:'DM Serif Display',serif;font-size:.96rem;color:var(--deep);margin-bottom:4px;}
    .staff-title{font-size:.75rem;color:var(--g400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;}
    .staff-dept{display:inline-block;font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:50px;background:var(--pale);color:var(--mid);}
    .dept-divider{display:flex;align-items:center;gap:12px;margin:32px 0 20px;}
    .dept-divider span{font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--mid);white-space:nowrap;}
    .dept-divider::before,.dept-divider::after{content:'';flex:1;height:1.5px;background:var(--g200);}

    /* ── MILESTONES TIMELINE ─────────────────────────────────────────── */
    .tl-wrap{position:relative;padding-left:0;}
    .tl-item{display:flex;gap:24px;margin-bottom:32px;align-items:flex-start;}
    .tl-left{display:flex;flex-direction:column;align-items:center;flex-shrink:0;width:88px;}
    .tl-year{font-family:'DM Serif Display',serif;font-size:1.15rem;color:var(--deep);font-weight:700;line-height:1;margin-bottom:8px;text-align:center;}
    .tl-dot{width:16px;height:16px;border-radius:50%;background:linear-gradient(135deg,var(--gs),var(--ge));flex-shrink:0;box-shadow:0 0 0 4px rgba(106,191,75,.18);}
    .tl-line{width:2px;flex:1;background:linear-gradient(to bottom,var(--bright),rgba(45,191,184,.12));min-height:40px;margin-top:8px;}
    .tl-item:last-child .tl-line{display:none;}
    .tl-card{background:#fff;border:1px solid var(--border);border-left:3px solid var(--bright);border-radius:20px;padding:22px 24px;flex:1;box-shadow:0 8px 24px rgba(13,46,30,.06);transition:all .2s;}
    .tl-card:hover{box-shadow:0 16px 32px rgba(13,46,30,.1);transform:translateX(4px);}
    .tl-tag{display:inline-block;font-size:.65rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:3px 10px;border-radius:50px;background:var(--pale);color:var(--mid);margin-bottom:10px;}
    .tl-emoji{font-size:1.4rem;margin-bottom:8px;}
    .tl-card h4{font-family:'DM Serif Display',serif;font-size:1rem;color:var(--deep);margin-bottom:8px;}
    .tl-card p{font-size:.85rem;color:var(--g600);line-height:1.7;margin:0;}

    /* ── PLACEHOLDER NOTE ────────────────────────────────────────────── */
    .placeholder-note{background:var(--pale);border:1.5px dashed #a8e6c1;border-radius:12px;padding:14px 20px;font-size:.82rem;color:var(--mid);display:flex;align-items:flex-start;gap:10px;margin-bottom:24px;}

    /* ── CONTACT CARD ────────────────────────────────────────────────── */
    .contact-card{background:linear-gradient(135deg,var(--deep),#2d7a4f);border-radius:20px;padding:48px 40px;text-align:center;}
    .contact-card h3{font-family:'DM Serif Display',serif;font-size:1.8rem;color:#fff;margin-bottom:12px;}
    .contact-card p{font-size:.93rem;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:0;}
    .contact-card a{color:#6ee7a0;font-weight:600;text-decoration:none;}
    .contact-card a:hover{text-decoration:underline;color:#a8f0c8;}

    /* ── SCROLL REVEAL ───────────────────────────────────────────────── */
    .rv{opacity:0;transform:translateY(22px);transition:opacity .55s ease,transform .55s ease;}
    .rv.on{opacity:1;transform:translateY(0);}
    .d1{transition-delay:.06s}.d2{transition-delay:.14s}.d3{transition-delay:.22s}.d4{transition-delay:.30s}.d5{transition-delay:.38s}.d6{transition-delay:.46s}

    footer{background:#0d2818;padding:28px 0;margin-top:0;text-align:center;}
    footer p{font-size:.74rem;color:rgba(255,255,255,.26);margin:0;}
    footer a{color:rgba(255,255,255,.26);text-decoration:none;margin:0 6px;}
    footer a:hover{color:#a8e6c1;}

    @media(max-width:768px){
      .page-hero h1{font-size:2rem;}
      .sec-h{font-size:1.6rem;}
      .branch-tabs{flex-wrap:wrap;width:100%;justify-content:center;}
      .tl-item{flex-direction:column;gap:10px;}
      .tl-left{flex-direction:row;align-items:center;width:auto;gap:10px;}
      .tl-line{display:none;}
      .mv-card{padding:28px 24px;}
      .hero-quick-grid{grid-template-columns:1fr;padding:0 16px;}
      .mobile-nav-toggle{display:inline-flex;}
    }

    /* ── Patient chip notification dot ── */
.patient-chip { position: relative; }
.chip-dot {
  position: absolute; top: 2px; right: 2px;
  width: 10px; height: 10px; border-radius: 50%;
  background: #e05252; border: 2px solid var(--gs);
  display: none;
  animation: chipPulse 2s ease infinite;
}
.chip-dot.show { display: block; }
@keyframes chipPulse {
  0%,100% { box-shadow: 0 0 0 0 rgba(224,82,82,.5); }
  50%      { box-shadow: 0 0 0 4px rgba(224,82,82,.0); }
}
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVBAR — identical structure to lp.php
═══════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => $homeLink,
  'active' => 'about',
  'is_logged_in' => $isLoggedIn,
  'patient_name' => $patient_name,
  'initials' => $initials,
  'show_notification_dot' => true,
]); ?>


<!-- ── HERO ─────────────────────────────────────────────────────────── -->
<div class="page-hero">
  <div class="container" style="position:relative;z-index:1;">
    <div class="sec-eyebrow" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#a8e6c1;margin-bottom:16px;"><?= htmlspecialchars($aboutContent['hero']['eyebrow']) ?></div>
    <h1><?= htmlspecialchars($aboutContent['hero']['title']) ?></h1>
    <p><?= htmlspecialchars($aboutContent['hero']['description']) ?></p>
  </div>
</div>
<div class="hero-quick-grid">
  <div class="hero-quick-card">
    <h3>Explore the story behind the care experience</h3>
    <p>This page brings together HealthQuarters profile details, mission and vision, organization, milestones, and contact points in one place.</p>
    <div class="hero-quick-links">
      <a class="primary-link" href="#profile">Start with Profile</a>
      <a class="secondary-link" href="#contact">Go to Contact</a>
    </div>
  </div>
  <div class="hero-quick-card">
    <h3>Need to take action now?</h3>
    <p>If you are done exploring, you can continue to services, locate a branch, or start a booking path from here.</p>
    <div class="hero-quick-links">
      <a class="secondary-link" href="service.php">Browse Services</a>
      <a class="secondary-link" href="locations.php">Find a Branch</a>
      <a class="secondary-link" href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>"><?= $isLoggedIn ? 'Book Now' : 'Create Account' ?></a>
    </div>
  </div>
</div>

<main>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 1 — PROFILE
══════════════════════════════════════════════════════════════════ -->
<section id="profile" class="scroll-target py-5 section-light">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-5 rv d1">
        <div class="sec-eyebrow"><?= htmlspecialchars($aboutContent['profile']['eyebrow']) ?></div>
        <h2 class="sec-h"><?= $aboutContent['profile']['title_html'] ?></h2>
        <div class="grad-bar"></div>
        <div class="profile-text">
          <?php foreach ($aboutContent['profile']['paragraphs'] as $paragraph): ?>
          <p><?= $paragraph ?></p>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-lg-7 rv d2">
        <div class="row g-3">
          <?php foreach($aboutContent['profile']['facts'] as $f): ?>
          <div class="col-6">
            <div class="stat-card">
              <div class="stat-num"><?= $f[0] ?></div>
              <div class="stat-lbl"><?= $f[1] ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 2 — MISSION & VISION
══════════════════════════════════════════════════════════════════ -->
<section id="mission" class="scroll-target py-5 section-muted">
  <div class="container">
    <div class="text-center mb-5 rv d1">
      <div class="sec-eyebrow"><?= htmlspecialchars($aboutContent['mission_vision']['eyebrow']) ?></div>
      <h2 class="sec-h"><?= $aboutContent['mission_vision']['title_html'] ?></h2>
    </div>
    <div class="row g-4">
      <div class="col-md-6 rv d2">
        <div class="mv-card mission">
          <div class="mv-label"><?= htmlspecialchars($aboutContent['mission_vision']['mission']['label']) ?></div>
          <h3><?= htmlspecialchars($aboutContent['mission_vision']['mission']['heading']) ?></h3>
          <p><?= htmlspecialchars($aboutContent['mission_vision']['mission']['text']) ?></p>
        </div>
      </div>
      <div class="col-md-6 rv d3">
        <div class="mv-card vision">
          <div class="mv-label"><?= htmlspecialchars($aboutContent['mission_vision']['vision']['label']) ?></div>
          <h3><?= htmlspecialchars($aboutContent['mission_vision']['vision']['heading']) ?></h3>
          <p><?= htmlspecialchars($aboutContent['mission_vision']['vision']['text']) ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 3 — COMMITMENT & WHY CHOOSE US
══════════════════════════════════════════════════════════════════ -->
<section id="commitment" class="scroll-target py-5 section-muted">
  <div class="container">
    <div class="text-center mb-5 rv d1">
      <div class="sec-eyebrow"><?= htmlspecialchars($aboutContent['commitment']['eyebrow']) ?></div>
      <h2 class="sec-h"><?= $aboutContent['commitment']['title_html'] ?></h2>
    </div>
    <div class="row g-4 align-items-start">
      <div class="col-lg-6 rv d2">
        <div class="info-card">
          <h4><?= htmlspecialchars($aboutContent['commitment']['card_title']) ?></h4>
          <?php foreach ($aboutContent['commitment']['paragraphs'] as $index => $paragraph): ?>
          <p><?= htmlspecialchars($paragraph) ?></p>
          <?php endforeach; ?>
          <p class="highlight-text"><?= htmlspecialchars($aboutContent['commitment']['highlight']) ?></p>
        </div>
      </div>
      <div class="col-lg-6 rv d3">
        <div class="info-card">
          <h4><?= htmlspecialchars($aboutContent['commitment']['why_title']) ?></h4>
          <?php foreach($aboutContent['commitment']['whys'] as $w): ?>
          <div class="why-item">
            <div class="why-check"></div>
            <p><strong><?= $w[0] ?></strong> — <?= $w[1] ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 4 — ORGANIZATIONAL CHART
══════════════════════════════════════════════════════════════════ -->
<section id="orgchart" class="scroll-target py-5 section-light">
  <div class="container">
    <div class="text-center mb-5 rv d1">
      <div class="sec-eyebrow"><?= htmlspecialchars($aboutContent['orgchart']['eyebrow']) ?></div>
      <h2 class="sec-h"><?= $aboutContent['orgchart']['title_html'] ?></h2>
      <p style="font-size:.9rem;color:var(--g400);margin-top:10px;"><?= htmlspecialchars($aboutContent['orgchart']['description']) ?></p>
    </div>
    <div class="placeholder-note rv d2">
      <span>Note</span>
      <span><?= htmlspecialchars($aboutContent['orgchart']['note']) ?></span>
    </div>
    <div class="branch-tabs rv d2">
      <button class="branch-tab active" onclick="switchBranch('ligao',this)"><?= htmlspecialchars($aboutContent['orgchart']['branches']['ligao']['button_icon']) ?> <?= htmlspecialchars($aboutContent['orgchart']['branches']['ligao']['label']) ?></button>
      <button class="branch-tab" onclick="switchBranch('polangui',this)"><?= htmlspecialchars($aboutContent['orgchart']['branches']['polangui']['button_icon']) ?> <?= htmlspecialchars($aboutContent['orgchart']['branches']['polangui']['label']) ?></button>
      <button class="branch-tab" onclick="switchBranch('tabaco',this)"><?= htmlspecialchars($aboutContent['orgchart']['branches']['tabaco']['button_icon']) ?> <?= htmlspecialchars($aboutContent['orgchart']['branches']['tabaco']['label']) ?></button>
    </div>

    <!-- LIGAO -->
    <div class="branch-panel active" id="panel-ligao">
      <div class="row justify-content-center mb-4">
        <div class="col-md-4">
          <div class="leader-card">
            <div class="leader-avatar"><?= htmlspecialchars($aboutContent['orgchart']['branches']['ligao']['leader'][0]) ?></div>
            <div class="leader-name"><?= htmlspecialchars($aboutContent['orgchart']['branches']['ligao']['leader'][1]) ?></div>
            <div class="leader-title"><?= htmlspecialchars($aboutContent['orgchart']['branches']['ligao']['leader'][2]) ?></div>
          </div>
        </div>
      </div>
      <div class="dept-divider"><span>Medical Staff</span></div>
      <div class="row g-3 mb-4">
        <?php foreach($aboutContent['orgchart']['branches']['ligao']['medical_staff'] as $m): ?>
        <div class="col-md-4"><div class="staff-card"><div class="staff-avatar"><?= $m[0] ?></div><div class="staff-name"><?= $m[1] ?></div><div class="staff-title"><?= $m[2] ?></div><span class="staff-dept"><?= $m[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
      <div class="dept-divider"><span>Support Staff</span></div>
      <div class="row g-3">
        <?php foreach($aboutContent['orgchart']['branches']['ligao']['support_staff'] as $s): ?>
        <div class="col-md-4 col-sm-6"><div class="staff-card"><div class="staff-avatar"><?= $s[0] ?></div><div class="staff-name"><?= $s[1] ?></div><div class="staff-title"><?= $s[2] ?></div><span class="staff-dept"><?= $s[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- POLANGUI -->
    <div class="branch-panel" id="panel-polangui">
      <div class="row justify-content-center mb-4">
        <div class="col-md-4">
          <div class="leader-card" style="<?= $aboutContent['orgchart']['branches']['polangui']['leader_style'] ?>">
            <div class="leader-avatar"><?= htmlspecialchars($aboutContent['orgchart']['branches']['polangui']['leader'][0]) ?></div>
            <div class="leader-name"><?= htmlspecialchars($aboutContent['orgchart']['branches']['polangui']['leader'][1]) ?></div>
            <div class="leader-title"><?= htmlspecialchars($aboutContent['orgchart']['branches']['polangui']['leader'][2]) ?></div>
          </div>
        </div>
      </div>
      <div class="dept-divider"><span>Medical Staff</span></div>
      <div class="row g-3 mb-4">
        <?php foreach($aboutContent['orgchart']['branches']['polangui']['medical_staff'] as $m): ?>
        <div class="col-md-4"><div class="staff-card" <?= $aboutContent['orgchart']['branches']['polangui']['staff_style'] ?>><div class="staff-avatar"><?= $m[0] ?></div><div class="staff-name"><?= $m[1] ?></div><div class="staff-title"><?= $m[2] ?></div><span class="staff-dept" <?= $aboutContent['orgchart']['branches']['polangui']['dept_style'] ?>><?= $m[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
      <div class="dept-divider"><span>Support Staff</span></div>
      <div class="row g-3">
        <?php foreach($aboutContent['orgchart']['branches']['polangui']['support_staff'] as $s): ?>
        <div class="col-md-4 col-sm-6"><div class="staff-card" <?= $aboutContent['orgchart']['branches']['polangui']['staff_style'] ?>><div class="staff-avatar"><?= $s[0] ?></div><div class="staff-name"><?= $s[1] ?></div><div class="staff-title"><?= $s[2] ?></div><span class="staff-dept" <?= $aboutContent['orgchart']['branches']['polangui']['dept_style'] ?>><?= $s[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- TABACO -->
    <div class="branch-panel" id="panel-tabaco">
      <div class="row justify-content-center mb-4">
        <div class="col-md-4">
          <div class="leader-card" style="<?= $aboutContent['orgchart']['branches']['tabaco']['leader_style'] ?>">
            <div class="leader-avatar"><?= htmlspecialchars($aboutContent['orgchart']['branches']['tabaco']['leader'][0]) ?></div>
            <div class="leader-name"><?= htmlspecialchars($aboutContent['orgchart']['branches']['tabaco']['leader'][1]) ?></div>
            <div class="leader-title"><?= htmlspecialchars($aboutContent['orgchart']['branches']['tabaco']['leader'][2]) ?></div>
          </div>
        </div>
      </div>
      <div class="dept-divider"><span>Medical Staff</span></div>
      <div class="row g-3 mb-4">
        <?php foreach($aboutContent['orgchart']['branches']['tabaco']['medical_staff'] as $m): ?>
        <div class="col-md-4"><div class="staff-card" <?= $aboutContent['orgchart']['branches']['tabaco']['staff_style'] ?>><div class="staff-avatar"><?= $m[0] ?></div><div class="staff-name"><?= $m[1] ?></div><div class="staff-title"><?= $m[2] ?></div><span class="staff-dept" <?= $aboutContent['orgchart']['branches']['tabaco']['dept_style'] ?>><?= $m[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
      <div class="dept-divider"><span>Support Staff</span></div>
      <div class="row g-3">
        <?php foreach($aboutContent['orgchart']['branches']['tabaco']['support_staff'] as $s): ?>
        <div class="col-md-4 col-sm-6"><div class="staff-card" <?= $aboutContent['orgchart']['branches']['tabaco']['staff_style'] ?>><div class="staff-avatar"><?= $s[0] ?></div><div class="staff-name"><?= $s[1] ?></div><div class="staff-title"><?= $s[2] ?></div><span class="staff-dept" <?= $aboutContent['orgchart']['branches']['tabaco']['dept_style'] ?>><?= $s[3] ?></span></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 5 — MILESTONES
══════════════════════════════════════════════════════════════════ -->
<section id="milestones" class="scroll-target py-5 section-muted">
  <div class="container">
    <div class="text-center mb-5 rv d1">
      <div class="sec-eyebrow"><?= htmlspecialchars($aboutContent['milestones']['eyebrow']) ?></div>
      <h2 class="sec-h"><?= $aboutContent['milestones']['title_html'] ?></h2>
      <p style="font-size:.9rem;color:var(--g400);margin-top:10px;"><?= htmlspecialchars($aboutContent['milestones']['description']) ?></p>
    </div>
    <div class="placeholder-note rv d2">
      <span>Note</span>
      <span><?= htmlspecialchars($aboutContent['milestones']['note']) ?></span>
    </div>
    <div class="info-card rv d3" style="margin-bottom:44px;">
      <h4 style="font-size:1.5rem;"><?= htmlspecialchars($aboutContent['milestones']['origin']['title']) ?></h4>
      <?php foreach ($aboutContent['milestones']['origin']['paragraphs'] as $index => $paragraph): ?>
      <p style="<?= $index < count($aboutContent['milestones']['origin']['paragraphs']) - 1 ? 'margin-bottom:14px;' : 'margin:0;' ?>"><?= $paragraph ?></p>
      <?php endforeach; ?>
    </div>
    <div class="tl-wrap">
      <?php foreach($aboutContent['milestones']['items'] as $m): ?>
      <div class="tl-item rv d2">
        <div class="tl-left">
          <div class="tl-year"><?= $m[0] ?></div>
          <div class="tl-dot"></div>
          <div class="tl-line"></div>
        </div>
        <div class="tl-card">
          <span class="tl-tag"><?= $m[4] ?></span>
          <div class="tl-emoji"><?= $m[1] ?></div>
          <h4><?= $m[2] ?></h4>
          <p><?= $m[3] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════════════════
     SECTION 6 — CONTACT
══════════════════════════════════════════════════════════════════ -->
<section id="contact" class="scroll-target py-5 section-light">
  <div class="container">
    <div class="rv d1">
      <div class="contact-card">
        <div class="sec-eyebrow" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:#a8e6c1;margin-bottom:16px;"><?= htmlspecialchars($aboutContent['contact']['eyebrow']) ?></div>
        <h3><?= htmlspecialchars($aboutContent['contact']['title']) ?></h3>
        <p style="max-width:480px;margin:0 auto 24px;"><?= htmlspecialchars($aboutContent['contact']['description']) ?></p>
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-top:8px;">
          <a href="<?= htmlspecialchars($aboutContent['contact']['facebook_url']) ?>" target="_blank"
             style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border:1.5px solid rgba(255,255,255,.25);color:#fff;font-size:.86rem;font-weight:600;padding:10px 22px;border-radius:50px;text-decoration:none;transition:all .2s;">
            Facebook Page
          </a>
          <a href="<?= htmlspecialchars($aboutContent['contact']['phone_href']) ?>"
             style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.14);border:1.5px solid rgba(255,255,255,.25);color:#fff;font-size:.86rem;font-weight:600;padding:10px 22px;border-radius:50px;text-decoration:none;transition:all .2s;">
            <?= htmlspecialchars($aboutContent['contact']['phone_display']) ?>
          </a>
          <a href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>"
             style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;font-size:.86rem;font-weight:600;padding:10px 22px;border-radius:50px;text-decoration:none;transition:opacity .2s;">
            <?= htmlspecialchars($aboutContent['contact']['booking_label']) ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

<?php hq_render_public_footer([
  'home_href' => $homeLink,
  'primary_cta_href' => $isLoggedIn ? 'homepage.php' : 'lp.php',
  'primary_cta_label' => 'Return Home',
]); ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* Branch tab switcher */
function switchBranch(id, btn) {
  document.querySelectorAll('.branch-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.branch-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('panel-' + id).classList.add('active');
  btn.classList.add('active');
}

/* Sub-nav active state on scroll */
const sections = document.querySelectorAll('.scroll-target');
const snLinks  = document.querySelectorAll('.sn-link');
const activeObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const id = entry.target.id;
      snLinks.forEach(link => {
        link.classList.toggle('active', link.getAttribute('href') === '#' + id);
      });
    }
  });
}, { rootMargin: '-30% 0px -60% 0px' });
sections.forEach(s => activeObserver.observe(s));

/* Scroll-to anchor on page load */
window.addEventListener('load', () => {
  if (location.hash) {
    const target = document.querySelector(location.hash);
    if (target) setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300);
  }
});

/* Navbar dropdown toggle — exact same logic as lp.php */
<?php hq_render_public_nav_script(); ?>

/* Scroll reveal */
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('on'); revealObs.unobserve(e.target); }
  });
}, { threshold: 0.06 });
document.querySelectorAll('.rv').forEach(el => revealObs.observe(el));

/* ── Notification dot ── */           // <-- ADD FROM HERE
  function checkUnread() {
    fetch('notifications_api.php?action=get_unread_count')
      .then(r => r.json())
      .then(data => {
        const count = data.count ?? 0;
        const dot   = document.getElementById('chipDot');
        if (dot) dot.classList.toggle('show', count > 0);
      })
      .catch(() => {});
  }
  checkUnread();                          // run immediately on page load
  setInterval(checkUnread, 30000);        // re-check every 30 seconds

</script>
</body>
</html>
