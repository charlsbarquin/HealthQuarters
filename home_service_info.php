<?php
// home_service_info.php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/public_footer.php';
$isLoggedIn   = hq_is_logged_in();
$patient_name = hq_patient_name();
$initials     = hq_initials($patient_name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Home Service — HealthQuarters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --gs:#6abf4b; --ge:#2dbfb8; --accent:#2dbfb8;
      --deep:#1a4d2e; --mid:#2d7a4f; --bright:#3aad6e;
      --pale:#e8f7ee; --muted:#f0faf4;
      --g100:#f7f9f8; --g200:#e8eeeb; --g400:#94a89d; --g600:#4a6057;
      --border:#dde8e4;
      /* body accent shades */
      --body-bg:#eaf6f0;
      --section-alt:#dff2ea;
      --card-bg:#f5fbf7;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth;}
    body{font-family:'DM Sans',sans-serif;background:var(--body-bg);color:#1a2e22;}

    /* ═══════════════════════════════════════
       NAVBAR — identical to lp.php
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
    .nav-btn:hover,.nav-item.open>.nav-btn{color:#fff;background:rgba(0,0,0,.16);}

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
    .patient-chip{display:flex;align-items:center;gap:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25);border-radius:50px;padding:6px 16px 6px 6px;text-decoration:none;transition:background .2s;}
    .patient-chip:hover{background:rgba(255,255,255,.22);}
    .patient-avatar{width:32px;height:32px;background:rgba(255,255,255,.9);color:var(--gs);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;}
    .patient-name{font-size:.82rem;font-weight:500;color:#fff;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .btn-logout{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.35);color:#fff;font-size:.8rem;font-weight:600;padding:7px 20px;border-radius:4px;text-decoration:none;transition:all .2s;}
    .btn-logout:hover{background:rgba(255,255,255,.28);color:#fff;}

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
       HERO
    ═══════════════════════════════════════ */
    .page-hero {
      background: linear-gradient(135deg, #0b2e1a 0%, #163d24 40%, #1f6040 100%);
      padding: 80px 0 72px; position: relative; overflow: hidden;
    }
    .page-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:400px; height:400px; background:radial-gradient(circle,rgba(106,191,75,.18) 0%,transparent 70%); border-radius:50%; }
    .page-hero::after  { content:''; position:absolute; bottom:-60px; left:-60px; width:280px; height:280px; background:radial-gradient(circle,rgba(45,191,184,.14) 0%,transparent 70%); border-radius:50%; }
    .hero-badge { display:inline-flex; align-items:center; gap:7px; background:rgba(106,191,75,.2); border:1.5px solid rgba(106,191,75,.35); color:#a8e6c1; font-size:.67rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; padding:5px 14px; border-radius:50px; margin-bottom:18px; }
    .page-hero h1 { font-family:'DM Serif Display',serif; font-size:clamp(2rem,4.5vw,3.2rem); color:#fff; line-height:1.12; margin-bottom:18px; }
    .page-hero h1 em { font-style:italic; color:#6ee7a0; }
    .page-hero p { font-size:.95rem; color:rgba(255,255,255,.72); line-height:1.8; max-width:520px; margin-bottom:32px; }
    .btn-book {
      display:inline-flex; align-items:center; gap:9px;
      background:linear-gradient(135deg,var(--gs),var(--ge));
      color:#fff; font-size:.92rem; font-weight:600; padding:14px 32px;
      border-radius:999px; text-decoration:none;
      box-shadow:0 6px 18px rgba(45,191,184,.28); transition:all .22s;
    }
    .btn-book:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(45,191,184,.34); color:#fff; }
    .btn-outline-hero {
      display:inline-flex; align-items:center; gap:8px;
      background:rgba(255,255,255,.1); border:1.5px solid rgba(255,255,255,.25);
      color:#fff; font-size:.88rem; font-weight:600; padding:12px 26px;
      border-radius:999px; text-decoration:none; transition:all .2s; margin-left:12px;
    }
    .btn-outline-hero:hover { background:rgba(255,255,255,.2); color:#fff; }

    /* ═══════════════════════════════════════
       SECTION HELPERS
    ═══════════════════════════════════════ */
    .sec-eyebrow { display:inline-flex; align-items:center; gap:7px; font-size:.68rem; font-weight:700; letter-spacing:.14em; text-transform:uppercase; color:var(--mid); background:var(--pale); border:1.5px solid #a8e6c1; padding:4px 14px; border-radius:50px; margin-bottom:12px; }
    .sec-h { font-family:'DM Serif Display',serif; font-size:2rem; color:var(--deep); line-height:1.15; }
    .sec-h em { font-style:italic; color:var(--accent); }

    /* Section background alternation */
    .section-white { background:#fff; }
    .section-tinted { background:var(--section-alt); }
    .section-plain  { background:var(--body-bg); }
    .section-shell{background:rgba(255,255,255,.72);border:1px solid rgba(221,232,228,.92);border-radius:24px;padding:28px;box-shadow:0 10px 30px rgba(13,46,30,.06);}
    .section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;border-bottom:1px solid rgba(106,191,75,.18);padding-bottom:14px;margin-bottom:24px;}
    .section-head-copy{max-width:560px;}
    .section-head-copy p{font-size:.88rem;color:var(--g600);line-height:1.75;margin:12px 0 0;}

    /* ═══════════════════════════════════════
       SERVICE CARDS
    ═══════════════════════════════════════ */
    .svc-card {
      background:#fff; border-radius:18px; padding:26px 22px;
      box-shadow:0 8px 24px rgba(13,46,30,.06); height:100%;
      border-top: 3px solid transparent;
      transition:all .25s;
    }
    .svc-card:hover { transform:translateY(-5px); box-shadow:0 14px 36px rgba(26,77,46,.13); border-top-color:var(--bright); }
    .svc-ico { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin-bottom:16px; }
    .svc-card h5 { font-family:'DM Serif Display',serif; font-size:1rem; color:var(--deep); margin-bottom:7px; }
    .svc-card p { font-size:.83rem; color:var(--g600); line-height:1.65; margin:0; }

    /* ═══════════════════════════════════════
       HOW IT WORKS STEPS
    ═══════════════════════════════════════ */
    .step-card {
      background:#fff; border-radius:18px; padding:28px 24px;
      box-shadow:0 8px 24px rgba(13,46,30,.06); height:100%;
      position:relative; overflow:hidden;
      border-left: 4px solid var(--bright);
    }
    .step-num { position:absolute; top:12px; right:18px; font-family:'DM Serif Display',serif; font-size:4rem; color:rgba(26,77,46,.05); line-height:1; }
    .step-circle { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--gs),var(--ge)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:1rem; margin-bottom:16px; }
    .step-card h5 { font-family:'DM Serif Display',serif; font-size:1rem; color:var(--deep); margin-bottom:8px; }
    .step-card p { font-size:.83rem; color:var(--g600); line-height:1.65; margin:0; }

    /* ═══════════════════════════════════════
       STATS BAR
    ═══════════════════════════════════════ */
    .stats-bar { background:linear-gradient(135deg,var(--deep),#2d7a4f); border-radius:12px; padding:36px 40px; }
    .stat-item { text-align:center; padding:0 24px; }
    .stat-num { font-family:'DM Serif Display',serif; font-size:2.4rem; color:#6ee7a0; line-height:1; margin-bottom:6px; }
    .stat-label { font-size:.78rem; color:rgba(255,255,255,.6); letter-spacing:.04em; }

    /* ═══════════════════════════════════════
       CTA SECTION
    ═══════════════════════════════════════ */
    .cta-section {
      background: linear-gradient(135deg, var(--deep) 0%, #2d7a4f 100%);
      border-radius: 12px; padding: 56px 48px; text-align: center;
      position: relative; overflow: hidden;
    }
    .cta-section::before { content:''; position:absolute; top:-60px; right:-60px; width:260px; height:260px; background:radial-gradient(circle,rgba(106,191,75,.15) 0%,transparent 70%); border-radius:50%; }
    .cta-section h2 { font-family:'DM Serif Display',serif; font-size:2rem; color:#fff; margin-bottom:12px; position:relative; z-index:1; }
    .cta-section p { font-size:.92rem; color:rgba(255,255,255,.72); max-width:440px; margin:0 auto 28px; line-height:1.75; position:relative; z-index:1; }
    .cta-section .btn-book { position:relative; z-index:1; }
    .hero-quick-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:18px;max-width:1180px;margin:24px auto 0;padding:0 12px;}
    .hero-quick-card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:22px;box-shadow:0 8px 24px rgba(13,46,30,.06);}
    .hero-quick-card h3{font-family:'DM Serif Display',serif;font-size:1.2rem;color:var(--deep);margin-bottom:10px;}
    .hero-quick-card p{font-size:.84rem;color:var(--g600);line-height:1.7;margin-bottom:0;}
    .hero-quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
    .hero-quick-links a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;text-decoration:none;font-size:.8rem;font-weight:700;}
    .hero-quick-links .primary-link{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;}
    .hero-quick-links .secondary-link{background:var(--muted);color:var(--mid);border:1px solid var(--border);}

    /* ═══════════════════════════════════════
       REVEAL ANIMATION
    ═══════════════════════════════════════ */
    .rv{opacity:0;transform:translateY(24px);transition:opacity .55s ease,transform .55s ease;}
    .rv.on{opacity:1;transform:translateY(0);}
    .d1{transition-delay:.06s}.d2{transition-delay:.14s}.d3{transition-delay:.22s}.d4{transition-delay:.30s}

    @media(max-width:768px) {
      .page-hero{padding:56px 0 52px;}
      .stats-bar{padding:28px 20px;}
      .cta-section{padding:36px 24px;}
      .hero-quick-grid{grid-template-columns:1fr;padding:0 16px;}
      .section-shell{padding:22px;}
      .section-head{align-items:flex-start;flex-direction:column;}
      .mobile-nav-toggle{display:inline-flex;}
    }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVBAR — identical to lp.php
═══════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => $isLoggedIn ? 'homepage.php' : 'lp.php',
  'active' => 'services',
  'is_logged_in' => $isLoggedIn,
  'patient_name' => $patient_name,
  'initials' => $initials,
]); ?>

<!-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ -->
<div class="page-hero">
  <div class="container" style="position:relative;z-index:1;">
    <div class="hero-badge">Home Service</div>
    <h1>Quality healthcare,<br><em>at your doorstep</em></h1>
    <p>HealthQuarters sends licensed health professionals directly to your home — no traffic, no waiting. We cover all 18 municipalities of Albay, Mon–Sat from 7 AM to 5 PM.</p>
    <div>
      <a href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>" class="btn-book">
        Book a Home Service →
      </a>
      <?php if(!$isLoggedIn): ?>
        <a href="login.php" class="btn-outline-hero">Already have an account?</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<div class="hero-quick-grid rv d1">
  <div class="hero-quick-card">
    <h3>Best for patients who need care at home</h3>
    <p>Use home service when travel is difficult, when a patient needs follow-up support, or when you want selected diagnostics performed more conveniently.</p>
    <div class="hero-quick-links">
      <a class="primary-link" href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>">Start Home Booking</a>
      <a class="secondary-link" href="service.php">View Related Services</a>
    </div>
  </div>
  <div class="hero-quick-card">
    <h3>Before you book</h3>
    <p>Prepare your address, preferred schedule, and the service details you need so the request can be reviewed and confirmed faster.</p>
    <div class="hero-quick-links">
      <a class="secondary-link" href="locations.php">See Branches</a>
      <a class="secondary-link" href="<?= $isLoggedIn ? 'profile.php' : 'login.php' ?>"><?= $isLoggedIn ? 'Open My Account' : 'Sign In' ?></a>
    </div>
  </div>
</div>

<main>

<!-- ═══════════════════════════════════════════
     SERVICES OFFERED
═══════════════════════════════════════════ -->
<section class="py-5 section-white">
  <div class="container">
    <div class="section-shell rv d1">
      <div class="section-head">
        <div class="section-head-copy">
          <div class="sec-eyebrow">What We Offer</div>
          <h2 class="sec-h">Services Available <em>Through Home Visit</em></h2>
          <p>All services are performed by licensed professionals using clinic-grade equipment in a safer, more convenient home setting.</p>
        </div>
      </div>
    <div class="row g-4">
      <?php
      $services = [
        ['LAB','Blood Collection / Lab Test','CBC, blood chemistry, hepatitis screening, lipid profile, and more — collected right at your home.','#fdecea'],
        ['CHK','General Check-up','Vital signs, physical assessment, and health screening by a licensed professional.','#e8f7ee'],
        ['WND','Wound Care / Dressing','Professional wound cleaning, dressing changes, and post-operative care.','#e8f7f6'],
        ['IV','IV Therapy / Infusion','Intravenous fluid therapy and medication administration under proper medical supervision.','#fff8e1'],
        ['POST','Post-Surgery Care','Monitoring, medication, and recovery assistance following surgical procedures.','#f0f0ff'],
        ['ELD','Elderly Care','Dedicated care services for senior patients — monitoring, medication reminders, and mobility assistance.','#e8f0fe'],
        ['PED','Pediatric Visit','Child health monitoring, immunization tracking, and developmental assessments.','#e8f7ee'],
        ['MON','COVID-19 Monitoring','Vital sign monitoring, antigen testing, and recovery assistance for COVID-19 patients.','#fdecea'],
      ];
      foreach($services as $s): ?>
      <div class="col-lg-3 col-md-6 rv d2">
        <div class="svc-card">
          <div class="svc-ico" style="background:<?= $s[3] ?>"><?= $s[0] ?></div>
          <h5><?= $s[1] ?></h5>
          <p><?= $s[2] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════ -->
<section class="py-4 section-tinted">
  <div class="container rv d1">
    <div class="stats-bar">
      <div class="row g-4 align-items-center justify-content-center">
        <div class="col-6 col-md-3">
          <div class="stat-item"><div class="stat-num">18</div><div class="stat-label">Municipalities Covered in Albay</div></div>
        </div>
        <div class="col-6 col-md-3" style="border-left:1px solid rgba(255,255,255,.12);border-right:1px solid rgba(255,255,255,.12);">
          <div class="stat-item"><div class="stat-num">6</div><div class="stat-label">Days Available (Mon–Sat)</div></div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item"><div class="stat-num">24h</div><div class="stat-label">Result Turnaround Time</div></div>
        </div>
        <div class="col-6 col-md-3" style="border-left:1px solid rgba(255,255,255,.12);">
          <div class="stat-item"><div class="stat-num">7–5</div><div class="stat-label">AM–PM Service Hours</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════ -->
<section class="py-5 section-plain">
  <div class="container">
    <div class="section-shell rv d1">
      <div class="section-head">
        <div class="section-head-copy">
          <div class="sec-eyebrow">The Process</div>
          <h2 class="sec-h">How Home Service <em>Works</em></h2>
          <p>The booking journey is organized into clear steps so patients understand what happens before, during, and after the home visit.</p>
        </div>
      </div>
    <div class="row g-4">
      <?php
      $steps = [
        ['Register or Sign In','Create a free account on HealthQuarters or log in if you already have one.'],
        ['Book Your Appointment','Choose your service, preferred date, time slot, and your home address in Albay.'],
        ['Await Confirmation','Our team reviews your request and confirms your booking within 24–48 hours via email.'],
        ['We Come to You','A licensed health professional arrives at your home at the scheduled time with all necessary equipment.'],
        ['Receive Your Results','Lab results are processed and released within 24 hours. Results can be viewed in your account.'],
      ];
      foreach($steps as $i => $step): ?>
      <div class="col-lg col-md-4 rv d<?= min($i+2,4) ?>">
        <div class="step-card">
          <div class="step-num"><?= $i+1 ?></div>
          <div class="step-circle"><?= $i+1 ?></div>
          <h5><?= $step[0] ?></h5>
          <p><?= $step[1] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     CTA
═══════════════════════════════════════════ -->
<section class="py-5 section-tinted">
  <div class="container rv d1">
    <div class="cta-section">
      <div style="font-size:2.5rem;margin-bottom:14px;position:relative;z-index:1;">HS</div>
      <h2>Ready to book your home visit?</h2>
      <p>Sign up for free and schedule your first home service appointment today. Quality care — delivered right to your door.</p>
      <a href="<?= $isLoggedIn ? 'booking.php' : 'signup.php' ?>" class="btn-book">
        <?= $isLoggedIn ? 'Book Now →' : 'Get Started — Sign Up Free →' ?>
      </a>
    </div>
  </div>
</section>

</main>

<?php hq_render_public_footer([
  'home_href' => $isLoggedIn ? 'homepage.php' : 'lp.php',
  'primary_cta_href' => 'booking.php',
  'primary_cta_label' => 'Start Booking',
]); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  <?php hq_render_public_nav_script(); ?>

  /* Scroll reveal */
  const io = new IntersectionObserver(es => {
    es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); } });
  }, { threshold: .1 });
  document.querySelectorAll('.rv').forEach(el => io.observe(el));
</script>
</body>
</html>