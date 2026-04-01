<?php
// locations.php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/public_footer.php';
$isLoggedIn = hq_is_logged_in();
$patient_name = hq_patient_name();
$initials     = hq_initials($patient_name);
$homeLink     = $isLoggedIn ? 'homepage.php' : 'lp.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Our Locations — HealthQuarters</title>
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
    body{font-family:'DM Sans',sans-serif;background:#f4faf6;color:#1a2e22;}

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
    .brand-wrap {
      display: flex; align-items: center; gap: 12px; text-decoration: none;
      flex-shrink: 0; padding-right: 24px;
      border-right: 1px solid rgba(255,255,255,.18); margin-right: 8px;
      position: relative; z-index: 1;
    }
    .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
    .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }
    .topbar-nav { display: flex; align-items: stretch; flex: 1; position: relative; z-index: 1; }
    .mobile-nav-toggle{display:none;align-items:center;justify-content:center;width:42px;height:42px;margin-left:auto;border-radius:12px;border:1.5px solid rgba(255,255,255,.3);background:rgba(255,255,255,.14);color:#fff;}
    .mobile-nav-panel{display:none;background:#fff;border-bottom:1px solid var(--border);box-shadow:0 12px 28px rgba(13,46,30,.08);}
    .mobile-nav-panel.open{display:block;}
    .mobile-nav-links{max-width:1280px;margin:0 auto;padding:14px 24px 18px;display:grid;gap:10px;}
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
    .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; position: relative; z-index: 1; }
    .btn-signin {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
.btn-signin:hover { background: rgba(255,255,255,.28); color: #fff; }

/* Patient chip & logout styles */
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

    @media(max-width:768px) {
      .topbar-inner { padding: 0 16px; height: 60px; }
      .brand-name { font-size: 1.2rem; }
      .brand-logo { height: 40px; width: 40px; }
      .nav-btn { padding: 0 10px; font-size: .74rem; }
    }
    @media(max-width:480px) { .brand-name { display: none; } }

    /* ═══════════════════════════════════════
       PAGE HERO
    ═══════════════════════════════════════ */
    .page-hero{background:linear-gradient(135deg,var(--deep) 0%,#2d7a4f 100%);padding:64px 0 56px;text-align:center;position:relative;overflow:hidden;}
    .page-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:300px;height:300px;background:radial-gradient(circle,rgba(106,191,75,.15) 0%,transparent 70%);border-radius:50%;}
    .page-hero h1{font-family:'DM Serif Display',serif;font-size:2.6rem;color:#fff;margin-bottom:12px;}
    .page-hero p{font-size:.95rem;color:rgba(255,255,255,.72);max-width:480px;margin:0 auto;line-height:1.8;}
    .sec-eyebrow{display:inline-flex;align-items:center;gap:7px;font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--mid);background:var(--pale);border:1.5px solid #a8e6c1;padding:4px 14px;border-radius:50px;margin-bottom:12px;}

    /* ═══════════════════════════════════════
       BRANCH CARDS
    ═══════════════════════════════════════ */
    .branch-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 10px 30px rgba(13,46,30,.06);height:100%;transition:all .28s;}
    .branch-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px rgba(13,46,30,.1);}
    .branch-header{padding:32px 32px 24px;position:relative;}
    .branch-num{position:absolute;top:16px;right:24px;font-family:'DM Serif Display',serif;font-size:5rem;color:rgba(26,77,46,.05);line-height:1;}
    .branch-badge{display:inline-flex;align-items:center;gap:7px;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:4px 12px;border-radius:50px;margin-bottom:14px;}
    .branch-card h3{font-family:'DM Serif Display',serif;font-size:1.5rem;color:var(--deep);margin-bottom:6px;}
    .branch-city{font-size:.85rem;color:var(--g400);font-weight:500;margin-bottom:0;}
    .branch-body{padding:0 32px 28px;}
    .branch-info-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:14px;font-size:.87rem;color:var(--g600);}
    .branch-info-ico{width:32px;height:32px;border-radius:9px;background:var(--muted);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;}
    .branch-divider{height:1px;background:var(--g200);margin:20px 0;}
    .branch-hours-row{display:flex;justify-content:space-between;font-size:.82rem;padding:6px 0;border-bottom:1px dashed var(--g200);}
    .branch-hours-row:last-child{border-bottom:none;}
    .branch-hours-day{color:var(--g600);}
    .branch-hours-time{color:var(--deep);font-weight:600;}
    .branch-foot{padding:20px 32px 28px;border-top:1.5px solid var(--g200);}
    .btn-directions{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;font-size:.84rem;font-weight:600;padding:11px 22px;border-radius:999px;text-decoration:none;box-shadow:0 6px 18px rgba(45,191,184,.28);transition:all .2s;}
    .btn-directions:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(45,191,184,.34);color:#fff;}
    .quick-actions{display:grid;grid-template-columns:1.1fr .9fr;gap:18px;margin:0 0 26px;}
    .quick-card{background:#fff;border:1px solid var(--border);border-radius:20px;padding:22px;box-shadow:0 8px 24px rgba(13,46,30,.06);}
    .quick-card h3{font-family:'DM Serif Display',serif;font-size:1.2rem;color:var(--deep);margin-bottom:10px;}
    .quick-card p{font-size:.84rem;color:var(--g600);line-height:1.7;margin-bottom:0;}
    .quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
    .quick-links a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;text-decoration:none;font-size:.8rem;font-weight:700;}
    .quick-links .primary-link{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;box-shadow:0 6px 18px rgba(45,191,184,.24);}
    .quick-links .secondary-link{background:var(--muted);color:var(--mid);border:1px solid var(--border);}
    .section-shell{background:rgba(255,255,255,.74);border:1px solid rgba(221,232,228,.9);border-radius:24px;padding:26px;box-shadow:0 10px 30px rgba(13,46,30,.06);}
    .section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;border-bottom:1px solid rgba(106,191,75,.18);padding-bottom:14px;margin-bottom:22px;}
    .section-head h2{font-family:'DM Serif Display',serif;font-size:1.28rem;color:var(--deep);display:flex;align-items:center;gap:10px;margin:0;}
    .section-head h2::before{content:'';width:10px;height:10px;border-radius:999px;background:linear-gradient(135deg,var(--gs),var(--ge));box-shadow:0 0 0 6px rgba(106,191,75,.09);}
    .section-head p{font-size:.83rem;color:var(--g600);line-height:1.7;max-width:500px;margin:0;text-align:right;}
    .note-card{margin-top:30px;background:#fff;border-radius:20px;border:1.5px solid var(--g200);padding:24px 28px;display:flex;align-items:flex-start;gap:14px;box-shadow:0 8px 24px rgba(13,46,30,.06);}
    .note-icon{font-size:1.4rem;flex-shrink:0;color:var(--mid);font-weight:700;}
    .note-title{font-weight:700;color:var(--deep);font-size:.9rem;margin-bottom:5px;}
    .note-copy{font-size:.84rem;color:var(--g600);line-height:1.7;}
    .note-link{display:inline-flex;align-items:center;gap:6px;margin-top:10px;font-size:.82rem;font-weight:700;color:var(--mid);text-decoration:none;}

    .rv{opacity:0;transform:translateY(24px);transition:opacity .55s ease,transform .55s ease;}
    .rv.on{opacity:1;transform:translateY(0);}
    .d1{transition-delay:.06s}.d2{transition-delay:.14s}.d3{transition-delay:.22s}

    @media(max-width:768px){
      .section-shell{padding:22px;}
      .section-head{align-items:flex-start;flex-direction:column;}
      .section-head p{text-align:left;}
      .quick-actions{grid-template-columns:1fr;}
      .branch-header{padding:24px 22px 18px;}
      .branch-body{padding:0 22px 20px;}
      .branch-foot{padding:16px 22px 22px;}
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
     NAVBAR
═══════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => $homeLink,
  'active' => 'locations',
  'is_logged_in' => $isLoggedIn,
  'patient_name' => $patient_name,
  'initials' => $initials,
  'show_notification_dot' => true,
]); ?>

<!-- ═══════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════ -->
<div class="page-hero">
  <div class="container" style="position:relative;z-index:1;">
    <div class="sec-eyebrow" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#a8e6c1;margin-bottom:16px;">Our Branches</div>
    <h1>Find a HealthQuarters Near You</h1>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     BRANCH CARDS
═══════════════════════════════════════════ -->
<main>
<section class="py-5 mt-2">
  <div class="container">
    <div class="section-shell rv d1">
      <div class="section-head">
        <h2>Plan Your Visit</h2>
        <p>Branch details, operating hours, and nearby service alternatives are grouped together so patients can choose the right location more easily.</p>
      </div>
    <div class="quick-actions rv d1">
      <div class="quick-card">
        <h3>Choose the branch that fits your visit</h3>
        <p>Each branch includes direct contact details, map access, and operating hours so patients can quickly decide where to go before booking or inquiring.</p>
        <div class="quick-links">
          <a class="primary-link" href="service.php">Browse Services</a>
          <a class="secondary-link" href="home_service_info.php">Need Home Service?</a>
        </div>
      </div>
      <div class="quick-card">
        <h3>Prefer not to travel?</h3>
        <p>HealthQuarters also supports patients across Albay through home service for selected diagnostics and care needs.</p>
        <div class="quick-links">
          <a class="primary-link" href="home_service_info.php">View Home Service</a>
          <a class="secondary-link" href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>">Start Booking</a>
        </div>
      </div>
    </div>
    <div class="row g-4">

      <!-- LIGAO BRANCH -->
      <div class="col-lg-4 rv d1">
        <div class="branch-card">
          <div class="branch-header">
            <div class="branch-badge" style="background:#e8f7ee;color:#2d7a4f;">Main Branch</div>
            <h3>Ligao Branch</h3>
            <p class="branch-city">P2 Tuburan, Ligao City, Albay</p>
          </div>
          <div class="branch-body">
            <div class="branch-info-row"></div>
            <div style="width:100%; height:200px; margin:15px 0; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3883.7991476244324!2d123.5536560746079!3d13.237917908984523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a109c6abb05ea7%3A0x415fe7b93a1b43dc!2sHealthquarters%20Medical%20and%20Diagnostics%20Inc.!5e0!3m2!1sen!2sph!4v1774706061576!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Tel</div>
              <div>+63 906 880 0028</div>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Email</div>
              <div>healthquartersphilippines@gmail.com</div>
            </div>
            <div class="branch-divider"></div>
            <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--g400);margin-bottom:10px;">Operating Hours</div>
            <div class="branch-hours-row"><span class="branch-hours-day">Monday – Friday</span><span class="branch-hours-time">7:00 AM – 5:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Saturday</span><span class="branch-hours-time">7:00 AM – 12:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Sunday</span><span class="branch-hours-time" style="color:var(--g400);">Closed</span></div>
          </div>
          <div class="branch-foot">
            <a href="https://www.facebook.com/healthquarters.lab" target="_blank" rel="noopener" class="btn-directions">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              Message Us on Facebook
            </a>
          </div>
        </div>
      </div>

      <!-- POLANGUI BRANCH -->
      <div class="col-lg-4 rv d2">
        <div class="branch-card">
          <div class="branch-header">
            <div class="branch-badge" style="background:#e8f7f6;color:#2dbfb8;">Branch</div>
            <h3>Polangui Branch</h3>
            <p class="branch-city">Cleto Building Ubaliw, Polangui, Albay</p>
          </div>
          <div class="branch-body">
            <div style="width:100%; height:200px; margin:15px 0; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
              <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d28434.563628844222!2d123.46994083476561!3d13.2906856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTPCsDE3JzI2LjUiTiAxMjPCsDI5JzI1LjkiRQ!5e1!3m2!1sen!2sph!4v1774706973994!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Tel</div>
              <div>+63 906 880 0028</div>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Email</div>
              <div>healthquartersphilippines@gmail.com</div>
            </div>
            <div class="branch-divider"></div>
            <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--g400);margin-bottom:10px;">Operating Hours</div>
            <div class="branch-hours-row"><span class="branch-hours-day">Monday – Friday</span><span class="branch-hours-time">7:00 AM – 5:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Saturday</span><span class="branch-hours-time">7:00 AM – 12:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Sunday</span><span class="branch-hours-time" style="color:var(--g400);">Closed</span></div>
          </div>
          <div class="branch-foot">
            <a href="https://www.facebook.com/healthquarters.polangui" target="_blank" rel="noopener" class="btn-directions">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              Message Us on Facebook
            </a>
          </div>
        </div>
      </div>

      <!-- TABACO BRANCH -->
      <div class="col-lg-4 rv d3">
        <div class="branch-card">
          <div class="branch-header">
            <div class="branch-badge" style="background:#fff8e1;color:#b7791f;">Branch</div>
            <h3>Tabaco Branch</h3>
            <p class="branch-city">AA Berces St., San Juan, Tabaco City, Albay</p>
          </div>
          <div class="branch-body">
            <div class="branch-info-row"></div>
            <div style="width:100%; height:200px; margin:15px 0; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3881.896366591691!2d123.72517447460959!3d13.35671960631887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a1adfb7d00246f%3A0x613a628926731065!2sHealthquarters%20Medical%20and%20Diagnostics%2C%20Inc!5e0!3m2!1sen!2sph!4v1774705629129!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Tel</div>
              <div>+63 906 880 0028</div>
            </div>
            <div class="branch-info-row">
              <div class="branch-info-ico">Email</div>
              <div>healthquartersphilippines@gmail.com</div>
            </div>
            <div class="branch-divider"></div>
            <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--g400);margin-bottom:10px;">Operating Hours</div>
            <div class="branch-hours-row"><span class="branch-hours-day">Monday – Friday</span><span class="branch-hours-time">7:00 AM – 5:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Saturday</span><span class="branch-hours-time">7:00 AM – 12:00 PM</span></div>
            <div class="branch-hours-row"><span class="branch-hours-day">Sunday</span><span class="branch-hours-time" style="color:var(--g400);">Closed</span></div>
          </div>
          <div class="branch-foot">
            <a href="https://www.facebook.com/profile.php?id=61582362786131" target="_blank" rel="noopener" class="btn-directions">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              Message Us on Facebook
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- Home Service note -->
    <div class="note-card rv d1">
      <div class="note-icon">Note</div>
      <div>
        <div class="note-title">Home Service Available Across All of Albay</div>
        <div class="note-copy">Can't visit a branch? Book a home service appointment and our team will come to you. We cover all 18 municipalities of Albay, Monday to Saturday, 7 AM - 5 PM.</div>
        <a href="home_service_info.php" class="note-link">Learn about Home Service -></a>
      </div>
    </div>
    </div>

  </div>
</section>
</main>

<?php hq_render_public_footer([
  'home_href' => $homeLink,
  'primary_cta_href' => 'booking.php',
  'primary_cta_label' => 'Book Home Service',
]); ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  <?php hq_render_public_nav_script(); ?>

  const io = new IntersectionObserver(es => {
    es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); } });
  }, { threshold: .1 });
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

</script>
</body>
</html>