<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/public_footer.php';
$isLoggedIn   = hq_is_logged_in();
$patient_name = hq_patient_name();
$initials     = hq_initials($patient_name);
$current_page = 'services';
// Redirect target for booking links: logged-in users go to booking.php, guests to signup.php
$bookingLink  = $isLoggedIn ? 'booking.php' : 'signup.php';
// Home link: logged-in users go to homepage.php, guests to lp.php
$homeLink     = $isLoggedIn ? 'homepage.php' : 'lp.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Services &amp; Price List — HealthQuarters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --gs:#6abf4b;--ge:#2dbfb8;--accent:#2dbfb8;
      --deep:#1a4d2e;--mid:#2d7a4f;--bright:#3aad6e;
      --pale:#e8f7ee;--muted:#f0faf4;
      --g100:#f7f9f8;--g200:#e8eeeb;--g400:#94a89d;--g600:#4a6057;
      --border:#dde8e4;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    html{scroll-behavior:smooth;}
    body{font-family:'DM Sans',sans-serif;background:#f7faf8;color:#1a2e22;}

    /* ══════════════════════════════════════════
       NAVBAR — unified lp.php style
    ══════════════════════════════════════════ */
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
    .mobile-nav-toggle{
      display:none;align-items:center;justify-content:center;
      width:42px;height:42px;margin-left:auto;
      border-radius:12px;border:1.5px solid rgba(255,255,255,.3);
      background:rgba(255,255,255,.14);color:#fff;
    }
    .mobile-nav-panel{display:none;background:#fff;border-bottom:1px solid var(--border);box-shadow:0 12px 28px rgba(13,46,30,.08);}
    .mobile-nav-panel.open{display:block;}
    .mobile-nav-links{max-width:1280px;margin:0 auto;padding:14px 24px 18px;display:grid;gap:10px;}
    .mobile-nav-links a{display:block;padding:12px 14px;border-radius:12px;background:var(--muted);border:1px solid var(--border);color:var(--deep);text-decoration:none;font-weight:600;}
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
    .nav-chevron { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.5; fill: none; }

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

    /* Right side — adapts based on login state */
    .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; }

    /* Patient chip (logged in) */
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

    /* Logout button (logged in) */
    .btn-logout {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
    .btn-logout:hover { background: rgba(255,255,255,.28); color: #fff; }

    /* Sign In button (guest) */
    .btn-signin {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
    .btn-signin:hover { background: rgba(255,255,255,.28); color: #fff; }

    /* ══════════════════════════════════════════
       SEARCH BAR — sticky below navbar
    ══════════════════════════════════════════ */
    .search-bar{background:#fff;border-bottom:1px solid var(--border);padding:14px 0;position:sticky;top:76px;z-index:100;}
    .search-inner{max-width:1280px;margin:0 auto;padding:0 28px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
    .search-wrap{position:relative;flex:1;min-width:200px;}
    .search-wrap input{
      width:100%;padding:9px 14px 9px 38px;
      border:1px solid var(--border);border-radius:4px;
      font-family:'DM Sans',sans-serif;font-size:.88rem;background:#fff;
      outline:none;transition:border-color .18s;
    }
    .search-wrap input:focus{border-color:var(--accent);}
    .search-ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--g400);}
    .cat-filters{display:flex;gap:4px;flex-wrap:wrap;}
    .cat-btn{
      padding:5px 12px;border-radius:4px;font-size:.74rem;font-weight:600;
      border:1px solid var(--border);background:#fff;color:var(--g600);
      cursor:pointer;transition:all .18s;white-space:nowrap;flex-shrink:0;
    }
    .cat-btn:hover,.cat-btn.active{background:var(--mid);color:#fff;border-color:var(--mid);}
    .results-count{font-size:.78rem;color:var(--g400);margin-left:auto;}

    /* ══════════════════════════════════════════
       PAGE HERO
    ══════════════════════════════════════════ */
    .page-hero{background:linear-gradient(135deg,var(--deep) 0%,#2d7a4f 100%);padding:44px 0 36px;}
    .page-wrap{max-width:1280px;margin:0 auto;padding:0 28px;}
    .page-hero h1{font-family:'DM Serif Display',serif;font-size:2rem;color:#fff;margin-bottom:8px;}
    .page-hero p{font-size:.88rem;color:rgba(255,255,255,.72);max-width:520px;line-height:1.75;}

    /* ══════════════════════════════════════════
       CONTENT LAYOUT
    ══════════════════════════════════════════ */
    .content-wrap{max-width:1280px;margin:0 auto;padding:28px 28px 60px;}
    .section-panel{background:#fff;border:1px solid var(--border);border-radius:24px;padding:24px;box-shadow:0 10px 30px rgba(13,46,30,.06);margin-bottom:24px;}
    .section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;border-bottom:1px solid rgba(106,191,75,.18);padding-bottom:14px;margin-bottom:20px;}
    .section-head h2{font-family:'DM Serif Display',serif;font-size:1.22rem;color:var(--deep);display:flex;align-items:center;gap:10px;margin:0;}
    .section-head h2::before{content:'';width:10px;height:10px;border-radius:999px;background:linear-gradient(135deg,var(--gs),var(--ge));box-shadow:0 0 0 6px rgba(106,191,75,.09);}
    .section-head p{font-size:.82rem;color:var(--g600);margin:0;max-width:520px;line-height:1.7;text-align:right;}
    .quick-grid,.journey-grid,.support-grid{display:grid;gap:16px;margin-bottom:24px;}
    .quick-grid{grid-template-columns:repeat(4,1fr);}
    .journey-grid{grid-template-columns:repeat(3,1fr);}
    .support-grid{grid-template-columns:1.15fr .85fr;}
    .quick-card,.journey-card,.support-card{
      background:#fff;border:1px solid var(--border);border-radius:20px;padding:20px;box-shadow:0 8px 24px rgba(13,46,30,.06);
    }
    .quick-icon,.journey-step{
      width:40px;height:40px;border-radius:12px;background:var(--pale);color:var(--mid);
      display:inline-flex;align-items:center;justify-content:center;font-weight:800;margin-bottom:12px;
    }
    .quick-card h3,.journey-card h3,.support-card h3{font-family:'DM Serif Display',serif;font-size:1.08rem;color:var(--deep);margin-bottom:8px;}
    .quick-card p,.journey-card p,.support-card p{font-size:.82rem;color:var(--g600);line-height:1.68;margin-bottom:0;}
    .quick-link,.support-link{
      display:inline-flex;align-items:center;gap:8px;text-decoration:none;
      margin-top:14px;padding:10px 16px;border-radius:999px;font-size:.78rem;font-weight:700;
      transition:transform .2s, box-shadow .2s, background .2s;
    }
    .quick-link{background:var(--pale);color:var(--mid);border:1px solid #a8e6c1;}
    .support-link{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;box-shadow:0 6px 18px rgba(45,191,184,.24);}
    .support-link.alt{background:var(--muted);color:var(--mid);border:1px solid var(--border);}
    .quick-link:hover,.support-link:hover{transform:translateY(-2px);}
    .support-link:hover{box-shadow:0 10px 24px rgba(45,191,184,.34);color:#fff;}
    .prep-list{display:grid;gap:10px;margin-top:14px;}
    .prep-item{padding:11px 12px;border-radius:12px;background:var(--muted);border:1px solid var(--border);font-size:.78rem;color:var(--g600);line-height:1.55;}
    .prep-item strong{display:block;color:var(--deep);margin-bottom:3px;}

    /* CATEGORY SECTIONS */
    .cat-section{margin-bottom:40px;}
    .cat-header{
      display:flex;align-items:center;gap:12px;
      padding:12px 18px;border-radius:6px;margin-bottom:0;
      cursor:pointer;user-select:none;
      border:1px solid var(--border);background:#fff;
      transition:background .18s;
    }
    .cat-header:hover{background:var(--muted);}
    .cat-header-left{display:flex;align-items:center;gap:12px;flex:1;}
    .cat-badge{
      font-size:.66rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;
      padding:4px 12px;border-radius:4px;white-space:nowrap;
    }
    .cat-title{font-family:'DM Serif Display',serif;font-size:1.05rem;color:var(--deep);}
    .cat-count{font-size:.75rem;color:var(--g400);}
    .cat-chevron{
      width:18px;height:18px;flex-shrink:0;
      border:none;background:none;cursor:pointer;
      display:flex;align-items:center;justify-content:center;
      transition:transform .22s;color:var(--g400);
    }
    .cat-section.open .cat-chevron{transform:rotate(180deg);}

    .svc-table-wrap{
      border:1px solid var(--border);border-top:none;border-radius:0 0 6px 6px;
      overflow:auto;display:none;
    }
    .cat-section.open .svc-table-wrap{display:block;}
    .svc-table{width:100%;border-collapse:collapse;}
    .svc-table thead th{
      background:var(--g100);padding:9px 14px;
      font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;
      color:var(--g400);border-bottom:1px solid var(--border);text-align:left;
    }
    .svc-table thead th.price-col{text-align:right;}
    .svc-table tbody tr{border-bottom:1px solid var(--border);transition:background .14s;}
    .svc-table tbody tr:last-child{border-bottom:none;}
    .svc-table tbody tr:hover{background:var(--muted);}
    .svc-table tbody tr.hidden-row{display:none;}
    .svc-table td{padding:10px 14px;font-size:.86rem;color:var(--g600);}
    .svc-name{font-weight:500;color:var(--deep);}
    .svc-desc{font-size:.76rem;color:var(--g400);margin-top:3px;line-height:1.5;}
    .svc-price{text-align:right;font-weight:700;color:var(--mid);font-size:.92rem;}
    .svc-note{font-size:.72rem;color:var(--g400);margin-top:2px;}

    /* PACKAGES */

    .disclaimer{background:var(--pale);border:1px solid #a8e6c1;border-radius:6px;padding:14px 18px;font-size:.78rem;color:var(--mid);display:flex;align-items:flex-start;gap:8px;margin-bottom:28px;}
    .price-note{font-size:.72rem;color:var(--g400);text-align:center;margin-top:32px;}
    .rv{opacity:0;transform:translateY(16px);transition:opacity .5s ease,transform .5s ease;}
    .rv.on{opacity:1;transform:translateY(0);}

    @media(max-width:900px){
      .pkg-grid{grid-template-columns:1fr 1fr;}
      .quick-grid,.journey-grid,.support-grid{grid-template-columns:1fr 1fr;}
    }
    @media(max-width:580px){
      .pkg-grid{grid-template-columns:1fr;}
      .content-wrap{padding:20px 16px 48px;}
      .section-head{align-items:flex-start;flex-direction:column;}
      .section-head p{text-align:left;}
      .search-inner{padding:0 16px;flex-direction:column;gap:8px;}
      .cat-filters{order:2;justify-content:center;flex-wrap:wrap;max-width:100%;}
      .results-count{order:1;align-self:center;}
      .svc-table td,.svc-table th{padding:8px 6px;font-size:.8rem;}
    }
    @media(max-width:768px){
      .topbar-inner{height:60px;padding:0 16px;}
      .brand-logo{height:40px;width:40px;}
      .brand-name{font-size:1.2rem;}
      .topbar-nav{display:none;}
      .mobile-nav-toggle{display:inline-flex;}
      .patient-name{display:none;}
      .search-bar{top:60px;}
      .support-grid{grid-template-columns:1fr;}
    }
    @media(max-width:480px){
      .brand-name{display:none;}
      .search-wrap{min-width:100%;}
      .cat-btn{padding:4px 10px;font-size:.7rem;}
      .search-inner{padding:0 12px;}
      .cat-filters{gap:3px;}
      .page-wrap{padding:0 16px;}
      .content-wrap{padding:16px 12px 40px;}
      .quick-grid,.journey-grid{grid-template-columns:1fr;}
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

<!-- ══════════════════════════════════════════════════════════
     NAVBAR — unified, session-aware
══════════════════════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => $homeLink,
  'active' => 'services',
  'is_logged_in' => $isLoggedIn,
  'patient_name' => $patient_name,
  'initials' => $initials,
  'show_notification_dot' => true,
]); ?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="page-wrap">
    <h1>Services &amp; Price List</h1>
    <p>Complete laboratory, imaging, and wellness services with searchable categories, preparation guidance, and direct next steps for patients and organizations.</p>
  </div>
</div>

<!-- STICKY SEARCH + FILTER -->
<div class="search-bar">
  <div class="search-inner">
    <div class="search-wrap">
      <svg class="search-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
      <input type="text" id="svcSearch" placeholder="Search for a service..." autocomplete="off">
    </div>
    <div class="cat-filters" id="catFilters">
      <button class="cat-btn active" data-cat="all" onclick="filterCat('all',this)">All</button>
      <button class="cat-btn" data-cat="hematology" onclick="filterCat('hematology',this)">Hematology</button>
      <button class="cat-btn" data-cat="microscopy" onclick="filterCat('microscopy',this)">Microscopy</button>
      <button class="cat-btn" data-cat="serology" onclick="filterCat('serology',this)">Serology</button>
      <button class="cat-btn" data-cat="chemistry" onclick="filterCat('chemistry',this)">Chemistry</button>
      <button class="cat-btn" data-cat="other" onclick="filterCat('other',this)">Other</button>
      <button class="cat-btn" data-cat="ultrasound" onclick="filterCat('ultrasound',this)">Ultrasound</button>
      <button class="cat-btn" data-cat="special" onclick="filterCat('special',this)">Special Tests</button>
    </div>
    <span class="results-count" id="resultsCount"></span>
  </div>
</div>

<div class="content-wrap">

  <div class="section-panel rv">
    <div class="section-head">
      <h2>Explore Main Service Paths</h2>
      <p>Browse the service catalog with the same guided structure used across the rest of the site, starting from the most common patient needs.</p>
    </div>
    <div class="quick-grid" style="margin-bottom:0;">
    <div class="quick-card">
      <div class="quick-icon">H</div>
      <h3>Routine Lab Tests</h3>
      <p>Browse hematology, microscopy, serology, and chemistry services commonly requested for screening and follow-up care.</p>
      <a class="quick-link" href="#hematology">View routine categories</a>
    </div>
    <div class="quick-card">
      <div class="quick-icon">U</div>
      <h3>Imaging and Ultrasound</h3>
      <p>Review available ultrasound studies and exam preparation notes before choosing the right service.</p>
      <a class="quick-link" href="#ultrasound">See ultrasound services</a>
    </div>
    <div class="quick-card">
      <div class="quick-icon">S</div>
      <h3>Special Tests</h3>
      <p>Access expanded thyroid, tumor marker, hormone, hepatitis, and other physician-requested special diagnostics.</p>
      <a class="quick-link" href="#special_blood_chem">Open special tests</a>
    </div>
    <div class="quick-card">
      <div class="quick-icon">B</div>
      <h3>Booking Paths</h3>
      <p>Need care at home or arranging a company package? Jump directly to the right intake flow.</p>
      <a class="quick-link" href="<?= htmlspecialchars($bookingLink) ?>">Start booking</a>
    </div>
    </div>
  </div>

  <div class="section-panel rv">
    <div class="section-head">
      <h2>Use the Catalog With Confidence</h2>
      <p>The flow below keeps search, preparation, and booking decisions organized so patients can move forward without guessing the next step.</p>
    </div>
    <div class="journey-grid" style="margin-bottom:0;">
    <div class="journey-card">
      <div class="journey-step">1</div>
      <h3>Search by need</h3>
      <p>Use the search bar or category filters to narrow the full catalog quickly and compare preparation notes.</p>
    </div>
    <div class="journey-card">
      <div class="journey-step">2</div>
      <h3>Check preparation</h3>
      <p>Review fasting, sample, bladder, and physician-advised requirements before booking or visiting a branch.</p>
    </div>
    <div class="journey-card">
      <div class="journey-step">3</div>
      <h3>Choose the right next step</h3>
      <p>Book as a patient, request home service, or move to a corporate inquiry based on the service type you need.</p>
    </div>
    </div>
  </div>

  <div class="section-panel rv">
    <div class="section-head">
      <h2>Preparation and Booking Help</h2>
      <p>Common reminders and direct action links stay together here so the catalog feels more like a guided service hub than a standalone list.</p>
    </div>
    <div class="support-grid" style="margin-bottom:0;">
    <div class="support-card">
      <h3>Common preparation reminders</h3>
      <p>Preparation varies by service. The list below highlights patterns patients commonly need before visiting a branch or requesting service.</p>
      <div class="prep-list">
        <div class="prep-item"><strong>Fasting tests</strong>Blood sugar, lipid, and selected chemistry tests may require 8-12 hours of fasting.</div>
        <div class="prep-item"><strong>Urine and stool tests</strong>Bring a clean sample or follow the collection instructions provided by staff.</div>
        <div class="prep-item"><strong>Ultrasound studies</strong>Some scans require a full bladder, while others require no oral intake beforehand.</div>
      </div>
    </div>
    <div class="support-card">
      <h3>Need help deciding?</h3>
      <p>If you already know the service type, go straight to the correct flow. If not, start with branch or corporate information first.</p>
      <a class="support-link" href="<?= htmlspecialchars($bookingLink) ?>">Book as Patient</a>
      <a class="support-link alt" href="home_service_info.php">Home Service Info</a>
      <a class="support-link alt" href="corporate_info.php">Corporate Packages</a>
      <a class="support-link alt" href="locations.php">Find a Branch</a>
    </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       SERVICE CATEGORIES
  ══════════════════════════════════════════ -->
  <?php

  $categories = [
    'hematology' => [
      'label'  => 'Hematology',
      'badge'  => ['#e8f0fe','#2563eb'],
      'anchor' => 'hematology',
      'items'  => [
        ['CBC','250','No fasting required','Counts red cells, white cells, and platelets to assess overall blood health and detect anemia or infection.'],
        ['Platelet Count','150','No fasting required','Measures the number of platelets in the blood; used to evaluate clotting ability and bleeding disorders.'],
        ['WBC Count','125','No fasting required','Determines the number of white blood cells to help identify infections, inflammation, or immune disorders.'],
        ['Hgb/Hct','100','No fasting required','Measures hemoglobin and hematocrit levels to screen for anemia and assess oxygen-carrying capacity.'],
        ['ESR (Erythrocyte Sedimentation Rate)','150','No fasting required','A non-specific marker that indicates the presence of inflammation or infection in the body.'],
        ['BT (Bleeding Time)','180','No fasting required','Assesses how quickly small blood vessels close after a minor cut; screens for platelet function disorders.'],
        ['CTBT (Clotting Time & Bleeding Time)','150','No fasting required','Evaluates both the time it takes blood to clot and to stop bleeding, screening for coagulation abnormalities.'],
      ],
    ],
    'microscopy' => [
      'label'  => 'Microscopy',
      'badge'  => ['#fdf4ff','#7c3aed'],
      'anchor' => 'microscopy',
      'items'  => [
        ['Urinalysis','75','Clean catch midstream urine sample','Examines urine for signs of kidney disease, urinary tract infection, diabetes, and other metabolic conditions.'],
        ['Fecalysis','75','Fresh stool sample in provided container','Analyzes stool for parasites, bacteria, blood, and digestive abnormalities.'],
        ['PT Urine (Pregnancy Test — Urine)','210','First morning urine preferred','Detects the pregnancy hormone hCG in urine to confirm or rule out pregnancy.'],
      ],
    ],
    'serology' => [
      'label'  => 'Serology',
      'badge'  => ['#fff7ed','#c2410c'],
      'anchor' => 'serology',
      'items'  => [
        ['PT Serum (Pregnancy Test — Serum)','240','No fasting required','A blood-based pregnancy test that detects hCG with higher sensitivity than a urine test.'],
        ['FOBT (Fecal Occult Blood Test)','240','Avoid red meat 3 days before','Detects hidden blood in the stool, which may indicate colorectal cancer or gastrointestinal bleeding.'],
        ['Hepa B (Hepatitis B Surface Antigen)','285','No fasting required','Screens for active Hepatitis B infection by detecting the surface antigen of the virus.'],
        ['RPR/VDRL','285','No fasting required','A blood test used to screen for syphilis, a sexually transmitted bacterial infection.'],
        ['Hepa A (IgG)','490','No fasting required','Checks for past Hepatitis A infection or immunity, indicating prior exposure or vaccination.'],
        ['Hepa A (IgG IgM)','585','No fasting required','Detects both recent (IgM) and past (IgG) Hepatitis A exposure for a complete immune status picture.'],
        ['Dengue Duo','1200','No fasting; best taken 1–5 days after fever onset','Simultaneously detects dengue NS1 antigen and IgM/IgG antibodies to diagnose dengue at any stage.'],
      ],
    ],
    'chemistry' => [
      'label'  => 'Chemistry',
      'badge'  => ['#f0fdf4','#15803d'],
      'anchor' => 'chemistry',
      'items'  => [
        ['FBS (Fasting Blood Sugar)','140','8–10 hours fasting required','Measures blood glucose after fasting to screen for diabetes or pre-diabetes.'],
        ['RBS (Random Blood Sugar)','140','No fasting required','Checks blood glucose at any time of day to monitor diabetes management.'],
        ['Cholesterol','140','9–12 hours fasting recommended','Measures total cholesterol to assess cardiovascular disease risk.'],
        ['Triglycerides','250','9–12 hours fasting required','Measures fat levels in the blood; elevated levels increase risk of heart disease and pancreatitis.'],
        ['HDL Cholesterol','250','9–12 hours fasting required','Measures "good" cholesterol that helps remove other forms of cholesterol from the bloodstream.'],
        ['BUN (Blood Urea Nitrogen)','140','No fasting required','Evaluates kidney function by measuring the amount of urea nitrogen in the blood.'],
        ['Creatinine','140','No fasting required','Assesses kidney health by measuring creatinine, a waste product filtered by the kidneys.'],
        ['BUA (Blood Uric Acid)','140','No fasting required','Measures uric acid levels to diagnose or monitor gout and kidney stone risk.'],
        ['SGOT (AST)','230','No fasting required','Detects liver or heart muscle damage by measuring aspartate aminotransferase enzyme levels.'],
        ['SGPT (ALT)','230','No fasting required','A liver-specific enzyme test used to detect liver inflammation, injury, or disease.'],
        ['Comp. Chem. (Comprehensive Chemistry)','1660','8–10 hours fasting required','A broad panel covering blood sugar, kidney, liver, and lipid markers for a complete metabolic overview.'],
        ['Lipid Profile','640','9–12 hours fasting required','Measures total cholesterol, HDL, LDL, and triglycerides to evaluate cardiovascular risk.'],
        ['75g OGTT (Oral Glucose Tolerance Test)','650','8–10 hours fasting; bring snack','Diagnoses gestational diabetes or impaired glucose tolerance by measuring blood sugar response to a glucose drink.'],
        ['2HR PPBS (2-Hour Post Prandial Blood Sugar)','280','Eat normally before test','Measures blood sugar 2 hours after a meal to evaluate how well the body manages glucose after eating.'],
        ['HBA1C (Glycated Hemoglobin)','720','No fasting required','Reflects average blood sugar levels over the past 2–3 months; key test for long-term diabetes management.'],
        ['Electrolytes','1100','No fasting required','Measures sodium, potassium, chloride, and bicarbonate to assess fluid balance and organ function.'],
      ],
    ],
    'other' => [
      'label'  => 'Other Services',
      'badge'  => ['#f0faf4','#2d7a4f'],
      'anchor' => 'other',
      'items'  => [
        ['Drug Test','300','Valid ID required; do not urinate 1–2 hrs before','Urine-based screening for prohibited substances; required for employment, school, or legal purposes.'],
        ['ECG (Electrocardiogram)','265','Wear loose clothing; avoid lotions on chest','Records the electrical activity of the heart to detect arrhythmias, heart attacks, and other cardiac conditions.'],
        ['RAT (Rapid Antigen Test)','660','No eating/drinking 30 min before','A rapid nasal swab test that detects COVID-19 or other viral antigens for quick screening results.'],
        ['Chest X-Ray','285','Remove metal accessories; inform staff if pregnant','Imaging of the lungs and chest to detect pneumonia, tuberculosis, fluid, or other abnormalities.'],
      ],
    ],
    'ultrasound' => [
      'label'  => 'Ultrasound',
      'badge'  => ['#e8f7f6','#0f766e'],
      'anchor' => 'ultrasound',
      'items'  => [
        ['Whole Abdomen','1900','NPO 6–8 hrs; full bladder','Comprehensive ultrasound of all abdominal organs including liver, gallbladder, kidneys, spleen, and pancreas.'],
        ['Upper Abdomen','1500','NPO 4–6 hrs','Evaluates the liver, gallbladder, bile ducts, pancreas, and upper abdominal structures.'],
        ['Lower Abdomen','1500','Full bladder','Examines the bladder, uterus, and lower abdominal organs for masses or abnormalities.'],
        ['Mass UTZ','1100','As advised by physician','Targeted ultrasound to characterize a specific mass or lump anywhere in the body.'],
        ['Abdomino-Pelvic','2200','NPO + full bladder','Combined scan covering all abdominal and pelvic organs in a single comprehensive examination.'],
        ['Pelvic','1000','Full bladder','Evaluates the uterus, ovaries, and bladder; used for gynecological assessments and pelvic pain.'],
        ['Pelvic Twins','2000','Full bladder','Pelvic ultrasound for twin pregnancies to assess fetal position, growth, and placental health.'],
        ['BPS (Biophysical Profile Score)','1500','Full bladder','Assesses fetal well-being by scoring fetal breathing, movement, tone, fluid, and heart rate.'],
        ['TVS (Trans-Vaginal Sonography)','1400','Empty bladder','Internal pelvic ultrasound providing detailed imaging of the uterus and ovaries; used in early pregnancy and gynecology.'],
        ['KUB (Kidney-Ureter-Bladder)','1200','Full bladder','Examines the kidneys, ureters, and bladder to detect stones, obstructions, or urinary tract abnormalities.'],
        ['Renal','900','Full bladder','Focused imaging of the kidneys to evaluate size, structure, and detect cysts, masses, or stones.'],
        ['HBT (Hepatobiliary Tree)','1200','NPO 4–6 hrs','Evaluates the liver, gallbladder, and bile ducts; used to detect gallstones and biliary obstruction.'],
        ['Inguinal','1200','As advised by physician','Images the inguinal region to assess hernias, lymph nodes, or vascular structures.'],
        ['Scrotal','1200','No special preparation','Evaluates the testes and epididymis for masses, varicoceles, torsion, or inflammation.'],
        ['Transrectal','1200','As advised by physician','Internal ultrasound used primarily to evaluate the prostate gland and surrounding structures.'],
        ['Neck','1400','No special preparation','Scans the neck for lymph node enlargement, masses, or vascular abnormalities.'],
        ['Thyroid','1300','No special preparation','Evaluates the thyroid gland for nodules, goiter, cysts, or signs of thyroid disease.'],
        ['Breast','1300','No special preparation','Assesses breast tissue for lumps, cysts, or masses; often used alongside mammography.'],
        ['Chest UTZ','1000','As advised by physician','Detects pleural effusion (fluid around the lungs) or guides chest procedures.'],
        ['Single Organ','1000','As advised by physician','Focused ultrasound on one specific organ as directed by the attending physician.'],
        ['KUB with Prostate','1400','Full bladder','Combines kidney-ureter-bladder imaging with prostate evaluation in a single scan.'],
      ],
    ],
    'additional' => [
      'label'  => 'Additional / Cardiac Tests',
      'badge'  => ['#fdecea','#b91c1c'],
      'anchor' => 'additional',
      'items'  => [
        ['Troponin I (Trop I)','1530','No fasting required','Measures troponin I protein released when heart muscle is damaged; a key marker for heart attack diagnosis.'],
        ['Troponin T (Trop T)','1530','No fasting required','Detects troponin T to confirm cardiac injury; used alongside Troponin I for comprehensive cardiac assessment.'],
        ['NT-ProBNP','1730','No fasting required','Measures a hormone released by the heart under stress; used to diagnose and monitor heart failure severity.'],
        ['2D ECHO (Echocardiogram)','3600','Wear comfortable clothing','Ultrasound of the heart that visualizes its structure and function, including valve and chamber performance.'],
      ],
    ],
    'special_blood_chem' => [
      'label'  => 'Blood Chemistry (Special Tests)',
      'badge'  => ['#fef9c3','#854d0e'],
      'anchor' => 'special_blood_chem',
      'special'=> true,
      'items'  => [
        ['Bilirubin','425','No fasting required','Measures bilirubin levels to assess liver function and detect jaundice or bile duct obstruction.'],
        ['Total Protein','375','No fasting required','Evaluates total protein in the blood to assess nutritional status and liver or kidney function.'],
        ['Albumin','350','No fasting required','Measures albumin to evaluate liver function, nutritional health, and protein loss from kidneys.'],
        ['TPAG (Total Protein, Albumin, Globulin)','400','No fasting required','A combined panel assessing total protein, albumin, and globulin for liver and nutritional health.'],
      ],
    ],
    'special_hematology' => [
      'label'  => 'Hematology (Special Tests)',
      'badge'  => ['#e0e7ff','#3730a3'],
      'anchor' => 'special_hematology',
      'special'=> true,
      'items'  => [
        ['Reticulocyte Count','400','No fasting required','Counts immature red blood cells to evaluate bone marrow activity and response to anemia treatment.'],
        ['PBS (Peripheral Blood Smear)','515','No fasting required','Microscopic examination of blood cells to identify abnormalities in shape, size, and structure.'],
        ['RH Factor','350','No fasting required','Determines whether the Rh antigen is present on red blood cells; essential for blood transfusions and pregnancy.'],
        ['COOMBS Test','1650','No fasting required','Detects antibodies against red blood cells; used in hemolytic anemia, transfusion reactions, and newborn jaundice.'],
      ],
    ],
    'special_serology' => [
      'label'  => 'Serology (Special Tests)',
      'badge'  => ['#fff1f2','#be123c'],
      'anchor' => 'special_serology',
      'special'=> true,
      'items'  => [
        ['TPHA Rapid Test','590','No fasting required','Rapid blood test for confirming syphilis infection using the Treponema Pallidum Hemagglutination method.'],
        ['TPHA with Titer','875','No fasting required','Confirms syphilis and provides a titer measurement to assess infection severity and treatment response.'],
        ['Widal Test','465','No fasting required','Detects antibodies against Salmonella typhi to diagnose typhoid fever.'],
        ['Typhidot','690','No fasting required','A rapid antibody test for typhoid fever that detects specific IgM and IgG against S. typhi.'],
        ['ASO LATEX (Screening & with Titer)','575','No fasting required','Detects antibodies to streptolysin O, used to confirm recent streptococcal infection or rheumatic fever.'],
        ['CRP LATEX (Screening & with Titer)','675','No fasting required','Measures C-reactive protein, a sensitive marker of inflammation, infection, or tissue injury.'],
        ['VDRL/RPR with Titer','775','No fasting required','Quantitative syphilis screening test that provides a titer for staging and monitoring treatment.'],
        ['RA/RF LATEX (Screening & with Titer)','475','No fasting required','Detects rheumatoid factor in the blood; used to help diagnose rheumatoid arthritis and other autoimmune disorders.'],
        ['C3 (Complement)','675','No fasting required','Measures complement C3 protein to evaluate immune system activity and detect autoimmune or kidney disorders.'],
        ['ANA with Titer (Anti-Nuclear Antibody)','875','No fasting required','Screens for autoimmune diseases like lupus by detecting antibodies that attack the body\'s own cell nuclei.'],
        ['Leptospiral Test — Rapid (IgG/IgM each)','1225','No fasting required','Rapid antibody test to detect Leptospirosis, a bacterial infection transmitted through contaminated water.'],
        ['H. Pylori IgM/IgG ELISA (each)','1225','No fasting required','Detects antibodies to Helicobacter pylori, the bacterium responsible for peptic ulcers and gastritis.'],
        ['Rubella IgM — German Measles (ELISA)','1025','No fasting required','Detects recent Rubella infection; important during pregnancy due to risk of congenital defects.'],
        ['Rubella IgG — German Measles (ELISA)','1025','No fasting required','Checks for past Rubella exposure or vaccination immunity, especially before or during pregnancy.'],
        ['CMV IgM (ELISA)','1425','No fasting required','Detects recent Cytomegalovirus infection; critical in immunocompromised patients and pregnant women.'],
        ['CMV IgG (ELISA)','1425','No fasting required','Indicates past CMV exposure and immunity; relevant for transplant recipients and prenatal care.'],
        ['Toxoplasma IgM (ELISA)','1425','No fasting required','Detects active Toxoplasma gondii infection; particularly important during pregnancy to protect the fetus.'],
        ['Toxoplasma IgG (ELISA)','1425','No fasting required','Indicates prior toxoplasma exposure and existing immunity; used in prenatal screening.'],
        ['HSV 1 & 2 ELISA IgM','2425','No fasting required','Detects recent Herpes Simplex Virus (oral or genital) infection through IgM antibody testing.'],
        ['HSV 1 & 2 ELISA IgG','2425','No fasting required','Identifies past HSV exposure and latent infection status; helps differentiate HSV-1 and HSV-2.'],
        ['Varicella IgG (ELISA)','1725','No fasting required','Confirms past chickenpox infection or vaccination immunity against Varicella-Zoster Virus.'],
        ['Varicella IgM (ELISA)','1725','No fasting required','Detects recent or active chickenpox (varicella) or shingles (zoster) infection.'],
        ['TORCH Test ELISA (IgG/IgM each)','4025','No fasting required','Comprehensive prenatal panel screening for Toxoplasma, Rubella, CMV, and Herpes infections affecting the fetus.'],
        ['Mumps IgG','1625','No fasting required','Checks for immunity to mumps from prior infection or vaccination.'],
        ['Rubeola IgG — Measles','1625','No fasting required','Confirms measles immunity from prior exposure or vaccination; important for outbreak prevention.'],
      ],
    ],
    'special_thyroid' => [
      'label'  => 'Thyroid Function Tests (Special)',
      'badge'  => ['#ecfdf5','#065f46'],
      'anchor' => 'special_thyroid',
      'special'=> true,
      'items'  => [
        ['T3 ELISA','525','No fasting required','Measures total triiodothyronine (T3) to evaluate thyroid hormone production and metabolism.'],
        ['T4 ELISA','525','No fasting required','Measures total thyroxine (T4) to assess thyroid gland function and screen for hypo- or hyperthyroidism.'],
        ['TSH ELISA','625','No fasting required','Measures thyroid-stimulating hormone, the primary marker for diagnosing and monitoring thyroid disorders.'],
        ['FT3 ELISA','625','No fasting required','Measures the free (active) form of T3 for a more accurate assessment of thyroid hormone activity.'],
        ['FT4 ELISA','625','No fasting required','Measures unbound thyroxine to provide a precise evaluation of thyroid hormone levels.'],
        ['TSH IRMA (After 3 Days)','2475','No fasting required','A highly sensitive immunoradiometric assay for TSH, used when greater precision is needed.'],
        ['Parathyroid Hormone','3125','No fasting required','Measures PTH to evaluate calcium regulation and diagnose parathyroid disorders or bone disease.'],
        ['FT3 RIA (After 3 Days)','2525','No fasting required','A radioimmunoassay for free T3 offering high sensitivity; results available after 3 days.'],
        ['FT4 RIA (After 3 Days)','2525','No fasting required','A radioimmunoassay for free T4 with high precision; results available after 3 days.'],
        ['Thyroglobulin','3625','No fasting required','A tumor marker used to monitor thyroid cancer treatment response and detect recurrence.'],
      ],
    ],
    'special_enzymes' => [
      'label'  => 'Enzymes (Special Tests)',
      'badge'  => ['#fef3c7','#92400e'],
      'anchor' => 'special_enzymes',
      'special'=> true,
      'items'  => [
        ['GGTP (Gamma-Glutamyl Transferase)','575','No fasting required','Detects liver disease and bile duct problems; also elevated by alcohol use and certain medications.'],
        ['Alkaline Phosphatase','325','No fasting required','Evaluates liver and bone disease by measuring this enzyme found in the liver, bones, and kidneys.'],
        ['Acid Phosphatase','400','No fasting required','Historically used to screen for prostate cancer; also elevated in bone disorders and red cell conditions.'],
        ['Amylase','425','No fasting required','Diagnoses pancreatitis and other pancreatic conditions by measuring amylase enzyme levels.'],
        ['Lipase','575','No fasting required','A more specific test for pancreatitis than amylase; detects inflammation or injury to the pancreas.'],
        ['Total CPK (Creatine Phosphokinase)','675','Avoid strenuous exercise 24 hrs before','Measures total CPK enzyme released from damaged muscle tissue; used in heart attack and muscle disorder diagnosis.'],
        ['CPK-MB','675','Avoid strenuous exercise 24 hrs before','The cardiac-specific form of CPK; elevated after a heart attack or cardiac muscle injury.'],
        ['CPK-MM','675','Avoid strenuous exercise 24 hrs before','The skeletal muscle form of CPK; elevated in muscular dystrophy, rhabdomyolysis, or muscle trauma.'],
        ['LDH (Lactate Dehydrogenase)','400','No fasting required','A non-specific marker of tissue damage used to monitor various conditions including heart attack, hemolysis, and cancer.'],
      ],
    ],
    'special_electrolytes' => [
      'label'  => 'Electrolytes (Special Tests)',
      'badge'  => ['#f0f9ff','#0369a1'],
      'anchor' => 'special_electrolytes',
      'special'=> true,
      'items'  => [
        ['Magnesium','425','No fasting required','Measures magnesium levels to assess nerve and muscle function; low levels can cause cardiac arrhythmias.'],
        ['Inorganic Phosphorous','425','No fasting required','Evaluates phosphate levels related to bone health, kidney function, and parathyroid disorders.'],
        ['Total Iron','575','8 hours fasting recommended','Measures the amount of iron in the blood to diagnose iron-deficiency anemia or iron overload.'],
        ['TIBC + Total Iron','775','8 hours fasting recommended','Assesses iron-binding capacity alongside total iron to provide a complete picture of iron status.'],
        ['Lithium Serum (3 Days)','1225','No fasting required','Monitors lithium drug levels in patients with bipolar disorder to ensure safe and effective dosing.'],
        ['Ammonia (EDTA)','2025','Immediate processing required','Measures blood ammonia levels to evaluate liver function and diagnose hepatic encephalopathy.'],
      ],
    ],
    'special_hepatitis' => [
      'label'  => 'Hepatitis ELISA (Special Tests)',
      'badge'  => ['#fdf4ff','#86198f'],
      'anchor' => 'special_hepatitis',
      'special'=> true,
      'items'  => [
        ['HBsAg with Titer (#1)','455','No fasting required','Detects and quantifies Hepatitis B surface antigen to confirm active infection and assess viral load.'],
        ['Anti-HBs (#2)','475','No fasting required','Measures antibodies against HBsAg to confirm Hepatitis B immunity from vaccination or recovery.'],
        ['HBeAg (#3)','525','No fasting required','Indicates active viral replication in Hepatitis B infection; used to assess infectivity.'],
        ['Anti-HBe (#4)','525','No fasting required','Detects antibodies against HBeAg, suggesting reduced viral replication and lower infectivity.'],
        ['Anti-HBc IgM (#5)','525','No fasting required','Indicates recent or acute Hepatitis B infection through detection of IgM core antibodies.'],
        ['Anti-HBc IgG (#6)','575','No fasting required','Confirms past Hepatitis B exposure through detection of IgG core antibodies.'],
        ['Anti-HAV IgG (#7)','525','No fasting required','Checks for Hepatitis A immunity from past infection or vaccination.'],
        ['Anti-HAV IgM (#8)','575','No fasting required','Detects recent or active Hepatitis A infection through IgM antibody presence.'],
        ['Anti-HCV (#9)','775','No fasting required','Screens for Hepatitis C infection by detecting antibodies to the hepatitis C virus.'],
        ['Hepatitis Profile (#1–#7 except #6)','1925','No fasting required','A bundled panel testing key Hepatitis A and B markers for comprehensive screening.'],
        ['Hepatitis A Profile (#7–#8)','1425','No fasting required','Tests both IgG and IgM for Hepatitis A to determine current infection or immune status.'],
        ['Hepatitis B Profile (#1–#6)','1675','No fasting required','A full Hepatitis B marker panel assessing infection status, immunity, and viral activity.'],
        ['Hepatitis A & B Profile (#1–#8)','2500','No fasting required','Combined panel for complete Hepatitis A and B immune and infection status evaluation.'],
        ['Hepatitis A, B & C Profile (#1–#9)','3125','No fasting required','The most comprehensive hepatitis panel covering all three major hepatitis viruses in one test.'],
      ],
    ],
    'special_hormones' => [
      'label'  => 'Hormones (Special Tests)',
      'badge'  => ['#fff0f3','#9f1239'],
      'anchor' => 'special_hormones',
      'special'=> true,
      'items'  => [
        ['FSH / LH (each)','725','Best drawn on Day 2–3 of menstrual cycle; no fasting','Measures reproductive hormones that regulate ovulation and sperm production; used in fertility evaluation.'],
        ['Prolactin','975','Blood drawn in morning; avoid stress before test','Evaluates prolactin levels to investigate irregular periods, infertility, or unexplained milk production.'],
        ['Estrogen / Estradiol','1500','No fasting required','Measures the primary female sex hormone to assess reproductive health, menopause, and hormonal balance.'],
        ['Progesterone','1225','Taken on specific cycle day as advised','Evaluates progesterone levels to confirm ovulation and assess pregnancy support and luteal function.'],
        ['Testosterone','1750','Morning blood draw preferred','Measures testosterone in men and women to evaluate libido, fertility, and hormonal disorders.'],
        ['Cortisol','1475','Morning blood draw; avoid stress','Assesses adrenal gland function; abnormal levels may indicate Cushing\'s syndrome or Addison\'s disease.'],
        ['Ferritin','1475','No fasting required','Measures stored iron in the body; low levels indicate iron deficiency, high levels may suggest inflammation or overload.'],
      ],
    ],
    'special_tumor' => [
      'label'  => 'Tumor Markers (Special Tests)',
      'badge'  => ['#fdecea','#991b1b'],
      'anchor' => 'special_tumor',
      'special'=> true,
      'items'  => [
        ['AFP (Alpha-Fetoprotein)','975','No fasting required','A tumor marker used to screen for liver cancer and monitor treatment; also elevated in certain testicular cancers.'],
        ['CEA — Colon','975','No fasting required','Carcinoembryonic antigen used to monitor colorectal cancer and detect recurrence after treatment.'],
        ['PSA — Prostate','1325','Avoid prostate exam 48 hrs before','Prostate-Specific Antigen test used to screen for prostate cancer and monitor treatment response.'],
        ['B-HCG (Beta Human Chorionic Gonadotropin)','925','No fasting required','Detects hCG to confirm pregnancy or monitor gestational trophoblastic disease and testicular cancer.'],
        ['CA-125 — Ovary','2000','No fasting required','An ovarian cancer marker used for diagnosis, monitoring treatment, and detecting recurrence.'],
        ['CA-15-3 — Breast','2000','No fasting required','A breast cancer marker used to monitor treatment response and detect cancer recurrence.'],
        ['CA-19-9 — Pancreas','2125','No fasting required','A marker primarily used for pancreatic cancer diagnosis and monitoring of treatment effectiveness.'],
      ],
    ],
  ];

  $catDataAttr = [
    'hematology'           => 'hematology',
    'microscopy'           => 'microscopy',
    'serology'             => 'serology',
    'chemistry'            => 'chemistry',
    'other'                => 'other',
    'ultrasound'           => 'ultrasound',
    'additional'           => 'other',
    'special_blood_chem'   => 'special',
    'special_hematology'   => 'special',
    'special_serology'     => 'special',
    'special_thyroid'      => 'special',
    'special_enzymes'      => 'special',
    'special_electrolytes' => 'special',
    'special_hepatitis'    => 'special',
    'special_hormones'     => 'special',
    'special_tumor'        => 'special',
  ];

  foreach($categories as $catKey => $cat):
    $catAttr   = $catDataAttr[$catKey] ?? 'other';
    $openClass = in_array($catKey, ['hematology','microscopy','chemistry','other','ultrasound']) ? 'open' : '';
  ?>
  <div class="cat-section <?= $openClass ?> rv" id="<?= $cat['anchor'] ?>" data-section-id="section-<?= $cat['anchor'] ?>" data-cat="<?= $catAttr ?>">
    <div class="cat-header" onclick="toggleCat(this)">
      <div class="cat-header-left">
        <span class="cat-badge" style="background:<?= $cat['badge'][0] ?>;color:<?= $cat['badge'][1] ?>;">
          <?= $cat['label'] ?>
        </span>
        <span class="cat-count"><?= count($cat['items']) ?> tests</span>
      </div>
      <svg class="cat-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="svc-table-wrap">
      <table class="svc-table">
        <thead>
          <tr>
            <th style="width:38%">Test / Service</th>
            <th>Description</th>
            <th>Preparation</th>
            <th class="price-col">Price</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cat['items'] as $item): ?>
          <tr class="svc-row" data-name="<?= strtolower(htmlspecialchars($item[0])) ?>">
            <td class="svc-name"><?= htmlspecialchars($item[0]) ?></td>
            <td><span class="svc-desc"><?= htmlspecialchars($item[3]) ?></span></td>
            <td><span class="svc-note"><?= htmlspecialchars($item[2]) ?></span></td>
            <td class="svc-price">₱<?= number_format((int)$item[1]) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endforeach; ?>

  <p class="price-note">* Prices are indicative and subject to change without prior notice. PWD, Senior Citizen, and PhilHealth discounts available — please inquire at our branch.</p>

</div><!-- /content-wrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  <?php hq_render_public_nav_script(); ?>

  /* ── Toggle category open/close ── */
  function toggleCat(header) {
    const section = header.closest('.cat-section');
    section.classList.toggle('open');
  }

  /* ── Category filter buttons ── */
  function filterCat(cat, btn) {
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const sections = document.querySelectorAll('.cat-section');
    sections.forEach(sec => {
      if (cat === 'all') {
        sec.style.display = '';
      } else {
        sec.style.display = sec.dataset.cat === cat ? '' : 'none';
      }
    });
    if (cat !== 'all') {
      sections.forEach(sec => { if (sec.dataset.cat === cat) sec.classList.add('open'); });
    }
    updateCount();
  }

  /* ── Search ── */
  document.getElementById('svcSearch').addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    if (!q) {
      document.querySelectorAll('.svc-row').forEach(r => r.classList.remove('hidden-row'));
      document.querySelectorAll('.cat-section').forEach(sec => { sec.style.display = ''; });
      updateCount();
      return;
    }
    document.querySelectorAll('.cat-section').forEach(sec => sec.style.display = '');
    document.querySelectorAll('.cat-section').forEach(sec => {
      const rows = sec.querySelectorAll('.svc-row');
      let hasMatch = false;
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(q)) {
          row.classList.remove('hidden-row');
          hasMatch = true;
        } else {
          row.classList.add('hidden-row');
        }
      });
      if (hasMatch) { sec.style.display = ''; sec.classList.add('open'); }
      else { sec.style.display = 'none'; }
    });
    updateCount();
  });

  function updateCount() {
    const visible = document.querySelectorAll('.svc-row:not(.hidden-row)').length;
    const total   = document.querySelectorAll('.svc-row').length;
    const el = document.getElementById('resultsCount');
    el.textContent = visible < total ? `${visible} of ${total} tests` : `${total} tests total`;
  }

  /* ── Scroll reveal ── */
  const io = new IntersectionObserver(es=>{
    es.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('on'); io.unobserve(e.target); } });
  }, {threshold:.04});
  document.querySelectorAll('.rv').forEach(el => io.observe(el));

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

  updateCount();

  /* ── Auto-scroll to category from hash ── */
  function scrollToCategory() {
    const hash = window.location.hash.replace('#', '');
    if (!hash) return;
    const targetSection = document.querySelector(`[id="section-${hash}"], [data-cat="${hash}"]`);
    if (targetSection) {
      targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      targetSection.classList.add('open');
      const filterBtn = document.querySelector(`[data-cat="${hash}"]`);
      if (filterBtn) filterCat(hash, filterBtn);
      return true;
    }
    return false;
  }
  window.addEventListener('load', scrollToCategory);
  window.addEventListener('hashchange', scrollToCategory);
</script>
<?php hq_render_public_footer([
  'home_href' => $homeLink,
  'primary_cta_href' => $bookingLink,
  'primary_cta_label' => $isLoggedIn ? 'Book an Appointment' : 'Create an Account',
]); ?>
</body>
</html>