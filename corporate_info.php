<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/public_footer.php';
$isLoggedIn = hq_is_logged_in();
$patient_name = hq_patient_name();
$initials = hq_initials($patient_name);
$homeLink = $isLoggedIn ? 'homepage.php' : 'lp.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Corporate Service — HealthQuarters</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --gs:#6abf4b; --ge:#2dbfb8; --accent:#2dbfb8;
      --deep:#1a4d2e; --mid:#2d7a4f; --bright:#3aad6e;
      --pale:#e8f7ee; --muted:#f0faf4;
      --g100:#f7f9f8; --g200:#e8eeeb; --g400:#94a89d; --g600:#4a6057;
      --border:#dde8e4;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth;}
    body{font-family:'DM Sans',sans-serif;background:var(--muted);color:#1a2e22;}

    .topbar{background:linear-gradient(135deg,var(--gs) 0%,var(--ge) 100%);position:sticky;top:0;z-index:999;box-shadow:0 2px 20px rgba(13,46,30,.35);}
    .topbar-inner{width:100vw;margin-left:calc(-50vw + 50%);margin-right:calc(-50vw + 50%);display:flex;align-items:stretch;padding:0 24px;height:76px;position:relative;z-index:2;}
    .brand-wrap{display:flex;align-items:center;gap:12px;text-decoration:none;flex-shrink:0;padding-right:24px;border-right:1px solid rgba(255,255,255,.18);margin-right:8px;position:relative;z-index:1;}
    .brand-logo{height:62px;width:62px;object-fit:cover;border-radius:50%;border:3px solid rgba(255,255,255,.85);box-shadow:0 4px 16px rgba(0,0,0,.25);}
    .brand-name{font-family:'DM Serif Display',serif;font-size:1.95rem;color:#fff;letter-spacing:.02em;line-height:1;text-shadow:0 1px 2px rgba(0,0,0,.2);}
    .topbar-nav{display:flex;align-items:stretch;flex:1;position:relative;z-index:1;}
    .mobile-nav-toggle{display:none;align-items:center;justify-content:center;width:42px;height:42px;margin-left:auto;border-radius:12px;border:1.5px solid rgba(255,255,255,.3);background:rgba(255,255,255,.14);color:#fff;}
    .mobile-nav-panel{display:none;background:#fff;border-bottom:1px solid var(--border);box-shadow:0 12px 28px rgba(13,46,30,.08);}
    .mobile-nav-panel.open{display:block;}
    .mobile-nav-links{max-width:1180px;margin:0 auto;padding:14px 24px 18px;display:grid;gap:10px;}
    .mobile-nav-links a{display:block;padding:12px 14px;border-radius:12px;background:var(--muted);border:1px solid var(--border);color:var(--deep);text-decoration:none;font-weight:600;}
    .nav-item{position:relative;display:flex;align-items:stretch;}
    .nav-btn{display:inline-flex;align-items:center;gap:5px;padding:0 15px;height:100%;font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.9);text-decoration:none;background:transparent;border:none;cursor:pointer;transition:background .18s,color .18s;white-space:nowrap;}
    .nav-btn:hover,.nav-item.open>.nav-btn{color:#fff;background:rgba(255,255,255,.25);}
    .nav-btn.active{position:relative;color:#fff;background:rgba(255,255,255,.22);}
    .nav-btn.active::after,.nav-item.open>.nav-btn::after{content:'';position:absolute;bottom:0;left:12px;right:12px;height:3px;border-radius:2px 2px 0 0;}
    .nav-btn.active::after{background:#fff;box-shadow:0 0 8px rgba(255,255,255,.5);}
    .nav-item.open>.nav-btn::after{background:rgba(255,255,255,.6);}
    .nav-chevron{width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:2.5;transition:transform .2s;flex-shrink:0;}
    .nav-item.open .nav-chevron{transform:rotate(180deg);}
    .topbar-right{display:flex;align-items:center;gap:10px;margin-left:auto;padding-left:16px;position:relative;z-index:1;}
    .btn-signin,.btn-logout{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.35);color:#fff;font-size:.8rem;font-weight:600;padding:7px 20px;border-radius:4px;text-decoration:none;transition:all .2s;}
    .btn-signin:hover,.btn-logout:hover{background:rgba(255,255,255,.28);color:#fff;}
    .patient-chip{display:flex;align-items:center;gap:9px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.25);border-radius:50px;padding:6px 16px 6px 6px;text-decoration:none;transition:background .2s;}
    .patient-chip:hover{background:rgba(255,255,255,.22);}
    .patient-avatar{width:32px;height:32px;background:rgba(255,255,255,.9);color:var(--gs);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;}
    .patient-name{font-size:.82rem;font-weight:500;color:#fff;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .nav-dropdown{position:absolute;top:100%;left:0;background:#fff;min-width:220px;box-shadow:0 8px 32px rgba(13,46,30,.2);border:1px solid var(--border);border-top:3px solid var(--gs);border-radius:0 0 8px 8px;display:none;z-index:9999;padding:6px 0;animation:dropSlide .15s ease;}
    @keyframes dropSlide{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
    .nav-item.open .nav-dropdown{display:block;}
    .drop-link{display:block;padding:9px 18px;font-size:.84rem;font-weight:500;color:var(--deep);text-decoration:none;transition:background .14s;border-left:3px solid transparent;}
    .drop-link:hover{background:var(--pale);color:var(--mid);border-left-color:var(--bright);}
    .drop-section-head{font-size:.65rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:var(--g400);padding:10px 18px 5px;margin-top:4px;}
    .drop-divider{height:1px;background:var(--g200);margin:5px 12px;}
    .drop-services{min-width:280px;}

    .page-hero{background:linear-gradient(135deg,#0b2e1a 0%,#163d24 50%,#1f6040 100%);padding:78px 0 68px;position:relative;overflow:hidden;}
    .page-hero::before{content:'';position:absolute;top:-70px;right:-70px;width:360px;height:360px;background:radial-gradient(circle,rgba(106,191,75,.16) 0%,transparent 70%);border-radius:50%;}
    .page-hero::after{content:'';position:absolute;bottom:-60px;left:-60px;width:260px;height:260px;background:radial-gradient(circle,rgba(45,191,184,.12) 0%,transparent 70%);border-radius:50%;}
    .hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(106,191,75,.18);border:1px solid rgba(106,191,75,.35);color:#a8e6c1;font-size:.67rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;padding:5px 14px;border-radius:50px;margin-bottom:18px;}
    .page-hero h1{font-family:'DM Serif Display',serif;font-size:clamp(2rem,4.6vw,3.2rem);color:#fff;line-height:1.1;margin-bottom:14px;}
    .page-hero h1 em{font-style:italic;color:#6ee7a0;}
    .page-hero p{font-size:.95rem;color:rgba(255,255,255,.72);line-height:1.8;max-width:560px;margin:0 auto 28px;}
    .hero-actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;}
    .btn-primary{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;font-size:.9rem;font-weight:600;padding:12px 26px;border-radius:999px;text-decoration:none;box-shadow:0 6px 18px rgba(45,191,184,.28);transition:all .22s;}
    .btn-primary:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(45,191,184,.34);color:#fff;}
    .btn-ghost-page{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.22);color:#fff;font-size:.88rem;font-weight:600;padding:12px 24px;border-radius:999px;text-decoration:none;transition:all .2s;}
    .btn-ghost-page:hover{background:rgba(255,255,255,.18);color:#fff;}

    main{max-width:1180px;margin:0 auto;padding:42px 24px 80px;}
    .section-card{background:#fff;border-radius:20px;padding:34px 32px;box-shadow:0 8px 24px rgba(13,46,30,.06);height:100%;}
    .section-shell{background:rgba(255,255,255,.72);border:1px solid rgba(221,232,228,.92);border-radius:24px;padding:28px;box-shadow:0 10px 30px rgba(13,46,30,.06);}
    .section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;border-bottom:1px solid rgba(106,191,75,.18);padding-bottom:14px;margin-bottom:22px;}
    .section-head-copy{max-width:620px;}
    .sec-eyebrow{display:inline-flex;align-items:center;gap:7px;font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--mid);background:var(--pale);border:1.5px solid #a8e6c1;padding:4px 14px;border-radius:50px;margin-bottom:12px;}
    .sec-h{font-family:'DM Serif Display',serif;font-size:1.95rem;color:var(--deep);line-height:1.15;}
    .sec-h em{font-style:italic;color:var(--accent);}
    .lead-text{font-size:.9rem;color:var(--g600);line-height:1.8;}
    .feature-card{background:#fff;border-radius:18px;padding:26px 22px;box-shadow:0 8px 24px rgba(13,46,30,.06);height:100%;border-top:3px solid var(--bright);}
    .feature-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:14px;background:var(--pale);}
    .feature-card h5{font-family:'DM Serif Display',serif;font-size:1rem;color:var(--deep);margin-bottom:8px;}
    .feature-card p{font-size:.83rem;color:var(--g600);line-height:1.7;margin:0;}
    .package-card{background:linear-gradient(135deg,#fff 0%,#f7fbf8 100%);border:1px solid var(--g200);border-radius:18px;padding:26px 22px;height:100%;transition:all .2s;}
    .package-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(13,46,30,.09);}
    .package-title{font-family:'DM Serif Display',serif;font-size:1.15rem;color:var(--deep);margin-bottom:10px;}
    .package-list{padding-left:18px;margin:0;}
    .package-list li{font-size:.83rem;color:var(--g600);line-height:1.7;margin-bottom:6px;}
    .why-item{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--g200);}
    .why-item:last-child{border-bottom:none;}
    .why-check{width:24px;height:24px;min-width:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;font-size:.72rem;font-weight:700;margin-top:2px;}
    .why-item p{font-size:.86rem;color:var(--g600);line-height:1.7;margin:0;}
    .cta-card{background:linear-gradient(135deg,var(--deep),#2d7a4f);border-radius:20px;padding:40px 34px;text-align:center;}
    .cta-card h3{font-family:'DM Serif Display',serif;font-size:1.8rem;color:#fff;margin-bottom:12px;}
    .cta-card p{font-size:.92rem;color:rgba(255,255,255,.74);line-height:1.8;max-width:620px;margin:0 auto 22px;}
    .hero-quick-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:18px;max-width:1180px;margin:24px auto 0;padding:0 12px;}
    .hero-quick-card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:22px;box-shadow:0 8px 24px rgba(13,46,30,.06);}
    .hero-quick-card h3{font-family:'DM Serif Display',serif;font-size:1.2rem;color:var(--deep);margin-bottom:10px;}
    .hero-quick-card p{font-size:.84rem;color:var(--g600);line-height:1.7;margin-bottom:0;}
    .hero-quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
    .hero-quick-links a{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:999px;text-decoration:none;font-size:.8rem;font-weight:700;}
    .hero-quick-links .primary-link{background:linear-gradient(135deg,var(--gs),var(--ge));color:#fff;}
    .hero-quick-links .secondary-link{background:var(--muted);color:var(--mid);border:1px solid var(--border);}

    @media(max-width:768px){
      .topbar-inner{padding:0 16px;height:60px;}
      .brand-name{font-size:1.2rem;}
      .brand-logo{height:40px;width:40px;}
      .topbar-nav{display:none;}
      .mobile-nav-toggle{display:inline-flex;}
      .patient-name{display:none;}
      .page-hero{padding:60px 0 54px;}
      main{padding:28px 16px 60px;}
      .section-shell{padding:22px;}
      .section-head{align-items:flex-start;flex-direction:column;}
      .section-card,.cta-card{padding:26px 22px;}
      .hero-quick-grid{grid-template-columns:1fr;padding:0 16px;}
    }
    @media(max-width:480px){.brand-name{display:none;}}
  </style>
</head>
<body>
<?php hq_render_public_nav([
  'home_href' => $homeLink,
  'active' => 'services',
  'is_logged_in' => $isLoggedIn,
  'patient_name' => $patient_name,
  'initials' => $initials,
]); ?>

<div class="page-hero">
  <div class="container" style="position:relative;z-index:1;">
    <div class="hero-badge">Corporate Service</div>
    <h1>Healthy teams, <em>stronger companies</em></h1>
    <p>HealthQuarters helps businesses and institutions in Albay manage employee health through streamlined screening, diagnostics, and workplace wellness support.</p>
    <div class="hero-actions">
      <a href="corporateservice.php" class="btn-primary">Submit an Inquiry</a>
      <a href="service.php" class="btn-ghost-page">View Services</a>
    </div>
  </div>
</div>
<div class="hero-quick-grid">
  <div class="hero-quick-card">
    <h3>Start with the right corporate path</h3>
    <p>Use corporate service for APE, pre-employment screening, drug testing, and tailored wellness packages based on workforce size and schedule.</p>
    <div class="hero-quick-links">
      <a class="primary-link" href="corporateservice.php">Send Inquiry</a>
      <a class="secondary-link" href="service.php">Review Catalog</a>
    </div>
  </div>
  <div class="hero-quick-card">
    <h3>Prepare before you inquire</h3>
    <p>Having your organization name, team size, preferred timeline, and required service scope ready helps us recommend a suitable package faster.</p>
    <div class="hero-quick-links">
      <a class="secondary-link" href="locations.php">See Branches</a>
      <a class="secondary-link" href="corporateservice.php">Open Inquiry Form</a>
    </div>
  </div>
</div>

<main>
  <section class="mb-4">
    <div class="section-shell">
      <div class="section-head">
        <div class="section-head-copy">
          <div class="sec-eyebrow">Corporate Overview</div>
          <h2 class="sec-h">Corporate healthcare that feels <em>structured and easier to navigate</em></h2>
          <p class="lead-text">These sections now follow the same grouped card layout used on the rest of the patient-facing pages, making the page easier to scan for decision-makers.</p>
        </div>
      </div>
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6">
        <div class="section-card h-100">
          <div class="sec-eyebrow">Program Scope</div>
          <h2 class="sec-h">Corporate healthcare that is <em>practical and scalable</em></h2>
          <p class="lead-text" style="margin-top:18px;">Our Corporate Service program is designed for companies, schools, organizations, and government offices that need dependable diagnostics and wellness support for employees or members.</p>
          <p class="lead-text" style="margin-top:12px;">We handle one-time screenings, recurring annual checkups, and customized packages based on your workforce size and compliance requirements.</p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="section-card h-100">
          <div class="sec-eyebrow">Best For</div>
          <h2 class="sec-h">Built for <em>businesses and institutions</em></h2>
          <div style="margin-top:18px;">
            <?php foreach ([
              'Private companies and corporate offices',
              'Schools, colleges, and universities',
              'Government agencies and LGUs',
              'Factories, logistics, and field-based teams',
              'Organizations needing periodic employee screening',
            ] as $item): ?>
            <div class="why-item">
              <div class="why-check"></div>
              <p><?= htmlspecialchars($item) ?></p>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <section class="py-4">
    <div class="section-shell">
    <div class="section-head">
      <div class="section-head-copy">
        <div class="sec-eyebrow">Key Services</div>
        <h2 class="sec-h">What we can provide for your <em>organization</em></h2>
        <p class="lead-text">Core service categories are grouped into one clean block so teams can compare options faster before sending an inquiry.</p>
      </div>
    </div>
    <div class="row g-3">
      <?php foreach ([
        ['APE', 'Annual Physical Examination', 'Structured employee checkups for onboarding, compliance, and recurring wellness programs.'],
        ['LAB', 'Laboratory Testing', 'Routine and specialized lab tests for corporate health screening and monitoring.'],
        ['DRUG', 'Drug Testing', 'Support for workplace compliance and pre-employment screening requirements.'],
        ['IMG', 'Imaging Services', 'Selected diagnostic imaging support depending on package scope and availability.'],
        ['OPS', 'Branch-Based Processing', 'Flexible branch-based coordination for organized employee scheduling and faster handling.'],
        ['PKG', 'Customized Packages', 'Tailored service bundles depending on workforce size, timeline, and budget.'],
      ] as $feature): ?>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><?= htmlspecialchars($feature[0]) ?></div>
          <h5><?= htmlspecialchars($feature[1]) ?></h5>
          <p><?= htmlspecialchars($feature[2]) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    </div>
  </section>

  <section class="py-4">
    <div class="section-shell">
    <div class="section-head">
      <div class="section-head-copy">
        <div class="sec-eyebrow">Sample Packages</div>
        <h2 class="sec-h">Flexible options for different <em>corporate needs</em></h2>
        <p class="lead-text">Package examples are framed like the other service cards across the site, keeping the pricing and inquiry journey visually connected.</p>
      </div>
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="package-card">
          <div class="package-title">Pre-Employment Screening</div>
          <ul class="package-list">
            <li>Basic laboratory screening</li>
            <li>Drug testing support</li>
            <li>Branch-based scheduling</li>
            <li>Ideal for onboarding workflows</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="package-card">
          <div class="package-title">Annual Physical Exam</div>
          <ul class="package-list">
            <li>Recurring employee checkups</li>
            <li>Flexible package composition</li>
            <li>Suitable for small to large teams</li>
            <li>Can be planned per department or batch</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="package-card">
          <div class="package-title">Custom Corporate Package</div>
          <ul class="package-list">
            <li>Tailored service scope</li>
            <li>Schedule aligned to operations</li>
            <li>Optional HMO-related details</li>
            <li>Best for special or mixed requirements</li>
          </ul>
        </div>
      </div>
    </div>
    </div>
  </section>

  <section class="py-4">
    <div class="cta-card">
      <div class="sec-eyebrow" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.22);color:#a8e6c1;">Next Step</div>
      <h3>Tell us what your company needs</h3>
      <p>Send us your company details, required service type, and preferred schedule. Our team will review your request and get in touch with a suitable recommendation.</p>
      <a href="corporateservice.php" class="btn-primary">Proceed to Corporate Inquiry</a>
    </div>
  </section>
</main>

<?php hq_render_public_footer([
  'home_href' => $homeLink,
  'primary_cta_href' => 'corporateservice.php',
  'primary_cta_label' => 'Send Corporate Inquiry',
]); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php hq_render_public_nav_script(); ?>
</script>
</body>
</html>