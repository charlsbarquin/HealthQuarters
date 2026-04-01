<?php require __DIR__ . '/includes/homepage/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>HealthQuarters — Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --gs: #6abf4b; --ge: #2dbfb8; --accent: #2dbfb8;
      --deep: #1a4d2e; --mid: #2d7a4f; --bright: #3aad6e;
      --pale: #e8f7ee; --muted: #f0faf4;
      --g100: #f7f9f8; --g200: #e8eeeb; --g400: #94a89d; --g600: #4a6057;
      --border: #dde8e4;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { font-family: 'DM Sans', sans-serif; background: #f4faf6; color: #1a2e22; -webkit-font-smoothing: antialiased; overflow-x: hidden; }

    /* ═══════════════════════════════════════
       MAIN NAVBAR — matches lp.php style
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
    .brand-wrap { display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0; padding-right: 24px; border-right: 1px solid rgba(255,255,255,.18); margin-right: 8px; position: relative; z-index: 1; }
    .brand-logo { height: 62px; width: 62px; object-fit: cover; border-radius: 50%; border: 3px solid rgba(255,255,255,.85); box-shadow: 0 4px 16px rgba(0,0,0,.25); }
    .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.95rem; color: #fff; letter-spacing: .02em; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,.2); }

    /* Nav */
    .topbar-nav { display: flex; align-items: stretch; flex: 1; position: relative; z-index: 1; }
    .mobile-nav-toggle { display:none; margin-left:auto; align-items:center; justify-content:center; width:42px; height:42px; border-radius:12px; border:1.5px solid rgba(255,255,255,.28); background:rgba(255,255,255,.14); color:#fff; }
    .mobile-nav-panel { display:none; background:#fff; border-bottom:1px solid var(--border); box-shadow:0 10px 28px rgba(13,46,30,.1); }
    .mobile-nav-panel.open { display:block; }
    .mobile-nav-links { max-width:1280px; margin:0 auto; padding:14px 24px 18px; display:grid; gap:10px; }
    .mobile-nav-links a { display:block; padding:12px 14px; border-radius:12px; text-decoration:none; color:var(--deep); background:var(--muted); border:1px solid var(--border); font-weight:600; }
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
    .nav-btn:hover, .nav-item.open > .nav-btn { color: #fff; background: rgba(255,255,255,.25); }
    .nav-btn.active {
      position: relative; color: #fff; background: rgba(255,255,255,.22);
    }
    .nav-btn.active::after {
      content: ''; position: absolute; bottom: 0; left: 12px; right: 12px;
      height: 3px; background: #fff; border-radius: 2px 2px 0 0;
      box-shadow: 0 0 8px rgba(255,255,255,.5);
    }
    .nav-item.open > .nav-btn::after {
      content: ''; position: absolute; bottom: 0; left: 12px; right: 12px;
      height: 3px; background: rgba(255,255,255,.6); border-radius: 2px 2px 0 0;
    }

    /* Right side — patient chip + logout */
    .topbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; padding-left: 16px; position: relative; z-index: 1; }

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
      border: 1px solid var(--border); border-top: 3px solid var(--gs);
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

    /* Nav chevron */
    .nav-chevron { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.5; fill: none; }

    /* ═══════════════════════════════════════
       HERO CAROUSEL
    ═══════════════════════════════════════ */
    .hero-wrap { position: relative; background: #040f08; }
    #heroCarousel .carousel-control-prev,
    #heroCarousel .carousel-control-next { display: none !important; }
    #heroCarousel .carousel-item img { width: 100%; height: 520px; object-fit: cover; object-position: center; display: block; }

    .hero-scrim {
      position: absolute; inset: 0; pointer-events: none; z-index: 2;
      background:
        linear-gradient(to top, rgba(3,12,7,.92) 0%, rgba(3,12,7,.55) 38%, rgba(3,12,7,.1) 62%, transparent 80%),
        linear-gradient(to right, rgba(3,12,7,.65) 0%, transparent 55%);
    }

    /* Tagline overlay */
    .hero-tagline-wrap {
      position: absolute; bottom: 96px; left: 0; right: 0; z-index: 8;
      padding: 0 36px 0 44px; pointer-events: none;
    }
    .hero-eyebrow {
      display: inline-block;
      font-size: .6rem; font-weight: 800; letter-spacing: .2em; text-transform: uppercase;
      color: #6ee7a0; background: rgba(106,191,75,.12);
      border: 1px solid rgba(106,191,75,.3); border-radius: 3px;
      padding: 4px 10px; margin-bottom: 14px;
    }
    .hero-headline {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2rem, 5vw, 3.4rem);
      color: #fff; line-height: 1.08; letter-spacing: -.01em;
      text-shadow: 0 2px 24px rgba(0,0,0,.55);
      margin-bottom: 0; max-width: 640px;
    }
    .hero-headline .hl {
      font-style: italic; color: #6ee7a0; position: relative; display: inline-block;
      text-shadow: 0 0 40px rgba(106,191,75,.55), 0 2px 24px rgba(0,0,0,.4);
    }
    .hero-headline .hl::after {
      content: ''; position: absolute; bottom: 2px; left: 0; right: 0;
      height: 3px; background: linear-gradient(90deg, #6abf4b, #2dbfb8); border-radius: 2px;
      transform: scaleX(0); transform-origin: left;
      animation: lineReveal 0.8s cubic-bezier(.22,1,.36,1) 1.2s forwards;
    }
    @keyframes lineReveal { to { transform: scaleX(1); } }
    .hero-sub {
      margin-top: 12px; font-size: .88rem; color: rgba(255,255,255,.62);
      max-width: 480px; line-height: 1.65; text-shadow: 0 1px 6px rgba(0,0,0,.4);
    }
    .hero-tagline-wrap .hero-eyebrow  { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .3s both; }
    .hero-tagline-wrap .hero-headline { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .45s both; }
    .hero-tagline-wrap .hero-sub      { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .6s both; }
    @keyframes taglineUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

    /* Carousel indicators */
    #heroCarousel .carousel-indicators { bottom: 82px; z-index: 6; gap: 5px; }
    #heroCarousel .carousel-indicators [data-bs-target] { width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,.35); border: 2px solid rgba(255,255,255,.5); margin: 0; }
    #heroCarousel .carousel-indicators .active { background: var(--bright); border-color: var(--bright); }

    /* CTA strip */
    .hero-cta-bar {
      position: absolute; bottom: 0; left: 0; right: 0; z-index: 10;
      background: linear-gradient(135deg, rgba(26,77,46,.92) 0%, rgba(26,105,82,.92) 50%, rgba(20,90,100,.92) 100%);
      backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
      border-top: 1px solid rgba(106,191,75,.25);
    }
    .hero-cta-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; display: flex; align-items: stretch; }
    .hero-cta-btn {
      flex: 1; display: flex; align-items: center; justify-content: center;
      gap: 10px; padding: 17px 16px; text-decoration: none; color: #fff;
      border-right: 1px solid rgba(106,191,75,.18); transition: background .2s;
    }
    .hero-cta-btn:last-child { border-right: none; }
    .hero-cta-btn:hover { background: rgba(106,191,75,.18); color: #fff; }
    .hero-cta-btn.hs-btn   { background: rgba(106,191,75,.22); border-right-color: rgba(106,191,75,.25); }
    .hero-cta-btn.hs-btn:hover   { background: rgba(106,191,75,.38); }
    .hero-cta-btn.corp-btn { background: rgba(45,191,184,.16); border-right-color: rgba(45,191,184,.22); }
    .hero-cta-btn.corp-btn:hover { background: rgba(45,191,184,.32); }
    .hero-cta-btn.svc-btn  { background: rgba(58,173,110,.14); }
    .hero-cta-btn.svc-btn:hover  { background: rgba(58,173,110,.28); }
    .hero-cta-btn.loc-btn  { background: rgba(45,191,184,.08); }
    .hero-cta-btn.loc-btn:hover  { background: rgba(45,191,184,.22); }
    .cta-text { text-align: center; }
    .cta-sub  { font-size: .6rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: #a8e6c1; display: block; margin-bottom: 3px; }
    .cta-main { font-family: 'DM Serif Display', serif; font-size: .96rem; display: block; }

    /* ═══════════════════════════════════════
       PAGE BODY
    ═══════════════════════════════════════ */
    .page-body { max-width: 1320px; margin: 0 auto; padding: 34px 24px 56px; }
    .dashboard-grid { display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:18px; margin-bottom:30px; }
    .dashboard-card {
      background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%);
      border:1px solid var(--border); border-radius:18px; padding:20px 20px 18px;
      box-shadow:0 10px 28px rgba(13,46,30,.07);
      min-height:168px; display:flex; flex-direction:column;
    }
    .dashboard-label { font-size:.68rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--g400); }
    .dashboard-value { font-family:'DM Serif Display', serif; font-size:2.15rem; color:var(--deep); line-height:1; margin:12px 0 8px; }
    .dashboard-detail { font-size:.82rem; color:var(--g600); line-height:1.65; min-height:54px; }
    .dashboard-link { display:inline-flex; margin-top:auto; padding-top:14px; color:var(--mid); font-size:.78rem; font-weight:700; text-decoration:none; }
    .patient-overview {
      display:grid; grid-template-columns: minmax(0, 1.2fr) minmax(320px, .8fr); gap:20px; margin-bottom:28px;
    }
    .patient-highlights { display:grid; grid-template-columns: minmax(0, 1.08fr) minmax(320px, .92fr); gap:20px; margin-bottom:28px; }
    .overview-panel, .quick-panel {
      background:linear-gradient(180deg, #ffffff 0%, #fbfefd 100%);
      border:1px solid var(--border); border-radius:20px; padding:24px 24px 22px;
      box-shadow:0 10px 28px rgba(13,46,30,.07);
    }
    .panel-head { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px; }
    .panel-head > div { min-width:0; }
    .panel-kicker {
      display:inline-flex; align-items:center; padding:4px 10px; margin-bottom:10px;
      border-radius:999px; background:var(--muted); border:1px solid var(--border);
      font-size:.62rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; color:var(--mid);
    }
    .overview-title { font-family:'DM Serif Display', serif; font-size:1.4rem; color:var(--deep); margin-bottom:8px; line-height:1.15; }
    .overview-sub { font-size:.84rem; color:var(--g600); line-height:1.72; max-width:62ch; }
    .panel-note {
      min-width:108px; padding:10px 12px; border-radius:14px; background:var(--muted); border:1px solid var(--border);
      text-align:left;
    }
    .panel-note strong { display:block; font-family:'DM Serif Display', serif; font-size:1.15rem; color:var(--deep); line-height:1; }
    .panel-note span { display:block; margin-top:4px; font-size:.7rem; color:var(--g600); line-height:1.45; }
    .mini-timeline { display:flex; flex-direction:column; gap:12px; margin-top:6px; }
    .mini-item {
      display:flex; align-items:flex-start; gap:14px; padding:14px 0; border-top:1px solid var(--g200);
    }
    .mini-item:first-child { border-top:none; padding-top:0; }
    .mini-dot { width:12px; height:12px; border-radius:50%; background:linear-gradient(135deg,var(--gs),var(--ge)); margin-top:5px; flex-shrink:0; box-shadow:0 0 0 4px rgba(45,191,184,.12); }
    .mini-title { font-size:.88rem; font-weight:700; color:var(--deep); }
    .mini-sub { font-size:.78rem; color:var(--g600); margin-top:4px; line-height:1.6; }
    .quick-links { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:6px; }
    .quick-link {
      display:block; padding:16px 16px 15px; background:var(--muted); border:1px solid var(--border);
      border-radius:14px; text-decoration:none; color:var(--deep); transition:.2s;
    }
    .quick-link:hover { border-color:var(--bright); transform:translateY(-2px); color:var(--deep); box-shadow:0 8px 22px rgba(13,46,30,.08); }
    .quick-link strong { display:block; font-size:.86rem; margin-bottom:6px; }
    .quick-link span { font-size:.76rem; color:var(--g600); line-height:1.55; }
    .next-step-list, .activity-list, .appt-card-list { display:flex; flex-direction:column; gap:14px; margin-top:6px; }
    .next-step-card, .activity-card, .appt-card {
      background:var(--muted); border:1px solid var(--border); border-radius:16px; padding:16px 16px 15px;
    }
    .next-step-card strong, .activity-card strong, .appt-card strong { display:block; color:var(--deep); font-size:.9rem; line-height:1.35; }
    .next-step-card span, .activity-card span, .appt-card span { display:block; color:var(--g600); font-size:.78rem; line-height:1.62; margin-top:5px; }
    .step-badge, .activity-kind, .appt-flag {
      display:inline-flex; align-items:center; gap:6px; padding:4px 9px; border-radius:50px;
      background:#fff; border:1px solid var(--border); font-size:.64rem; font-weight:800; letter-spacing:.06em; text-transform:uppercase; color:var(--mid);
      margin-bottom:10px;
    }
    .activity-meta, .appt-flags { display:flex; gap:8px; flex-wrap:wrap; margin-top:10px; }
    .summary-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px; margin-top:6px; }
    .summary-card { background:var(--muted); border:1px solid var(--border); border-radius:16px; padding:16px 15px; min-height:132px; }
    .summary-card .num { font-family:'DM Serif Display', serif; font-size:1.55rem; color:var(--deep); line-height:1; margin:8px 0 7px; }
    .summary-card .lbl { font-size:.68rem; font-weight:800; letter-spacing:.09em; text-transform:uppercase; color:var(--g400); margin-bottom:4px; }
    .summary-card .txt { font-size:.77rem; color:var(--g600); line-height:1.58; }
    .appt-card-list { gap:14px; }
    .appt-card {
      background:#fff;
      border:1px solid var(--border);
      border-radius:16px;
      padding:16px;
    }
    .appt-card-header { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; margin-bottom:10px; }
    .appt-meta { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:12px; margin-top:12px; }
    .appt-meta-block { padding:12px 13px; border-radius:14px; background:var(--muted); border:1px solid var(--border); }
    .appt-meta-label { display:block; font-size:.64rem; font-weight:800; letter-spacing:.09em; text-transform:uppercase; color:var(--g400); margin-bottom:5px; }
    .appt-meta-value { display:block; font-size:.8rem; color:var(--deep); font-weight:700; line-height:1.45; }
    .appt-status { font-size:.68rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; color:var(--mid); background:var(--pale); padding:5px 10px; border-radius:50px; white-space:nowrap; }
    .activity-card { text-decoration:none; color:inherit; }
    .activity-card:hover, .appt-card:hover, .next-step-card:hover, .result-doc:hover { border-color:var(--bright); transform:translateY(-2px); box-shadow:0 10px 24px rgba(13,46,30,.08); }
    .activity-card-top { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; margin-bottom:6px; }
    .activity-time { display:inline-flex; align-items:center; padding:4px 8px; border-radius:999px; background:#fff; border:1px solid var(--border); font-size:.65rem; font-weight:700; color:var(--g600); white-space:nowrap; }
    .activity-empty, .appt-empty {
      border:1px dashed rgba(148,168,157,.45);
      border-radius:16px;
      padding:18px;
      background:#fff;
    }
    .result-doc-list { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:14px; margin-top:16px; }
    .result-doc { background:#fff; border:1px solid var(--border); border-radius:16px; padding:16px 16px 15px; text-decoration:none; color:inherit; transition:.2s; }
    .result-doc strong { display:block; color:var(--deep); font-size:.88rem; }
    .result-doc small { display:block; color:var(--g400); font-size:.74rem; line-height:1.55; margin-top:6px; }

    .sec-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid var(--gs); padding-bottom: 8px; margin-bottom: 20px; }
    .sec-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: var(--deep); display: flex; align-items: center; gap: 8px; }
    .sec-header h2::before { content: ''; width: 4px; height: 20px; background: linear-gradient(var(--gs), var(--ge)); border-radius: 2px; display: inline-block; }
    .see-all { font-size: .78rem; font-weight: 600; color: var(--mid); text-decoration: none; transition: color .15s; }
    .see-all:hover { color: var(--bright); text-decoration: underline; }

    /* ═══════════════════════════════════════
       WHY CHOOSE US
    ═══════════════════════════════════════ */
    .why-section { padding: 28px 0 32px; }
    .why-card {
      background: #fff; border: 1px solid var(--border); border-radius: 6px;
      padding: 22px 20px; height: 100%; border-top: 3px solid var(--bright);
      transition: box-shadow .2s, transform .2s;
    }
    .why-card:hover { box-shadow: 0 6px 24px rgba(13,46,30,.1); transform: translateY(-3px); }
    .why-card h4 { font-family: 'DM Serif Display', serif; font-size: .98rem; color: var(--deep); margin-bottom: 7px; }
    .why-card p  { font-size: .82rem; color: var(--g600); line-height: 1.65; margin: 0; }

    /* ═══════════════════════════════════════
       TWO-COLUMN LAYOUT
    ═══════════════════════════════════════ */
    .two-col-wide { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding: 0 0 32px; }

    /* ═══════════════════════════════════════
       HOME SERVICE BLOCK
    ═══════════════════════════════════════ */
    .hs-block {
      background: linear-gradient(135deg, #0b2e1a 0%, #163d24 50%, #1f6040 100%);
      border-radius: 8px; padding: 32px 32px 28px; position: relative; overflow: hidden; height: 100%;
    }
    .hs-block::after { content: ''; position: absolute; top:-60px; right:-60px; width:240px; height:240px; background:radial-gradient(circle,rgba(106,191,75,.14) 0%,transparent 70%); border-radius:50%; }
    .hs-block-label { font-size: .63rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #a8e6c1; display: block; margin-bottom: 10px; position: relative; z-index: 1; }
    .hs-block h3 { font-family: 'DM Serif Display', serif; font-size: 1.55rem; color: #fff; margin-bottom: 10px; line-height: 1.18; position: relative; z-index: 1; }
    .hs-block h3 em { font-style: italic; color: #6ee7a0; }
    .hs-block p  { font-size: .84rem; color: rgba(255,255,255,.72); line-height: 1.75; margin-bottom: 18px; max-width: 440px; position: relative; z-index: 1; }
    .hs-pills  { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px; position: relative; z-index: 1; }
    .hs-pill   { font-size: .75rem; color: rgba(255,255,255,.78); background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.15); border-radius: 50px; padding: 5px 12px; }
    .hs-stats  { display: flex; gap: 0; border-top: 1px solid rgba(255,255,255,.1); border-bottom: 1px solid rgba(255,255,255,.1); padding: 14px 0; margin: 18px 0; position: relative; z-index: 1; }
    .hs-stat   { flex: 1; text-align: center; border-right: 1px solid rgba(255,255,255,.1); }
    .hs-stat:last-child { border-right: none; }
    .hs-stat-n { font-family: 'DM Serif Display', serif; font-size: 1.8rem; color: #6ee7a0; line-height: 1; margin-bottom: 4px; }
    .hs-stat-l { font-size: .68rem; color: rgba(255,255,255,.55); }
    .btn-book {
      display: inline-flex; align-items: center; gap: 8px;
      background: linear-gradient(135deg, var(--gs), var(--ge));
      color: #fff; font-size: .84rem; font-weight: 600;
      padding: 10px 24px; border-radius: 4px; text-decoration: none;
      box-shadow: 0 4px 16px rgba(45,191,184,.35); transition: all .2s;
      position: relative; z-index: 1;
    }
    .btn-book:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

    /* ═══════════════════════════════════════
       CORPORATE BLOCK
    ═══════════════════════════════════════ */
    .corp-overview { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 28px 28px 24px; height: 100%; }
    .corp-overview h3 { font-family: 'DM Serif Display', serif; font-size: 1.35rem; color: var(--deep); margin-bottom: 10px; line-height: 1.2; }
    .corp-overview p  { font-size: .84rem; color: var(--g600); line-height: 1.75; margin-bottom: 16px; }
    .corp-check { display: flex; align-items: flex-start; gap: 9px; font-size: .83rem; color: var(--g600); margin-bottom: 8px; }
    .corp-check::before { content: '✓'; color: var(--bright); font-weight: 700; flex-shrink: 0; margin-top: 1px; }
    .corp-pkg-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 0; }
    .corp-pkg { background: var(--muted); border: 1px solid var(--border); border-radius: 6px; padding: 16px 16px 14px; transition: border-color .2s, box-shadow .2s; }
    .corp-pkg:hover { border-color: var(--bright); box-shadow: 0 4px 14px rgba(13,46,30,.09); }
    .corp-pkg-price { font-family: 'DM Serif Display', serif; font-size: 1.3rem; color: var(--mid); line-height: 1; margin-bottom: 4px; }
    .corp-pkg-price span { font-family: 'DM Sans', sans-serif; font-size: .7rem; color: var(--g400); }
    .corp-pkg-name { font-size: .84rem; font-weight: 600; color: var(--deep); margin-bottom: 6px; }
    .corp-pkg-desc { font-size: .75rem; color: var(--g600); line-height: 1.55; margin-bottom: 10px; }
    .corp-pkg-btn { display: inline-block; background: var(--mid); color: #fff; font-size: .74rem; font-weight: 600; padding: 6px 14px; border-radius: 4px; text-decoration: none; transition: background .18s; }
    .corp-pkg-btn:hover { background: var(--deep); color: #fff; }

    /* ═══════════════════════════════════════
       SCROLL REVEAL
    ═══════════════════════════════════════ */
    .rv { opacity: 0; transform: translateY(18px); transition: opacity .55s ease, transform .55s ease; }
    .rv.on { opacity: 1; transform: translateY(0); }
    .d1{transition-delay:.05s} .d2{transition-delay:.12s} .d3{transition-delay:.19s} .d4{transition-delay:.26s}

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media(max-width:1024px) { .two-col-wide { grid-template-columns: 1fr; } }
    @media(max-width:1024px) {
      .dashboard-grid { grid-template-columns:repeat(2, minmax(0, 1fr)); }
      .patient-overview, .patient-highlights, .summary-grid { grid-template-columns:1fr; }
    }
    @media(max-width:768px) {
      .topbar-inner { padding: 0 16px; height: 60px; }
      .brand-name { font-size: 1.2rem; }
      .brand-logo { height: 40px; width: 40px; }
      .nav-btn { padding: 0 10px; font-size: .74rem; }
      #heroCarousel .carousel-item img { height: 300px; }
      .hero-tagline-wrap { bottom: 106px; padding: 0 20px; }
      .hero-headline { font-size: 1.7rem; }
      .hero-cta-inner { flex-direction: column; }
      .hero-cta-btn { border-right: none; border-bottom: 1px solid rgba(255,255,255,.08); }
      .page-body { padding: 20px 16px 32px; }
      .corp-pkg-grid { grid-template-columns: 1fr; }
      .patient-name { display: none; }
      .result-doc-list { grid-template-columns:1fr; }
      .dashboard-grid, .quick-links, .appt-meta { grid-template-columns:1fr; }
      .overview-panel, .quick-panel, .dashboard-card { padding:20px 18px; }
      .panel-head, .activity-card-top, .appt-card-header { flex-direction:column; }
      .panel-note { width:100%; }
      .topbar-right { gap:8px; padding-left:10px; }
      .nav-icon-btn { width:40px; height:40px; border-radius:12px; }
      .btn-logout { padding:9px 14px; border-radius:12px; }
    }
    @media(max-width:480px) {
      .brand-name { display: none; }
      .topbar-nav { display: none; }
      .mobile-nav-toggle { display:inline-flex; }
    }
    @media(max-width:1024px) {
      .footer-grid { grid-template-columns:1fr 1fr; }
    }
    @media(max-width:768px) {
      .footer-inner { padding:32px 16px 16px; }
      .footer-grid { grid-template-columns:1fr; }
      .footer-bottom { flex-direction:column; }
    }

    /* Navbar utility actions */
    .nav-icon-btn {
      position: relative; display:inline-flex; align-items:center; justify-content:center;
      width:44px; height:44px; border-radius:14px; text-decoration:none;
      background:rgba(255,255,255,.16); border:1.5px solid rgba(255,255,255,.28); color:#fff;
      box-shadow:0 8px 24px rgba(13,46,30,.15); transition:background .2s, transform .2s, border-color .2s;
    }
    .nav-icon-btn:hover { background:rgba(255,255,255,.24); border-color:rgba(255,255,255,.45); color:#fff; transform:translateY(-1px); }
    .nav-icon-btn svg { width:18px; height:18px; stroke:currentColor; stroke-width:2.2; fill:none; }
    .nav-badge {
      position:absolute; top:-5px; right:-5px; min-width:20px; height:20px; padding:0 5px;
      border-radius:999px; background:#e05252; color:#fff; border:2px solid rgba(32,120,85,.95);
      display:flex; align-items:center; justify-content:center; font-size:.63rem; font-weight:800; line-height:1;
      box-shadow:0 6px 16px rgba(224,82,82,.35);
    }
    .nav-badge.hidden { display:none; }
    .patient-chip {
      position: relative;
      box-shadow:0 8px 22px rgba(13,46,30,.14);
      transition: background .2s, transform .2s, border-color .2s;
    }
    .patient-chip:hover { transform:translateY(-1px); border-color:rgba(255,255,255,.42); }
    .btn-logout {
      border-radius:14px;
      padding:10px 18px;
      font-weight:700;
      box-shadow:0 8px 22px rgba(13,46,30,.14);
    }
    .btn-logout:hover { transform:translateY(-1px); }

/* ═══════════════════════════════════════
       FEEDBACK FORM
    ═══════════════════════════════════════ */
    .feedback-section { background: linear-gradient(135deg, var(--deep) 0%, #2d7a4f 100%); padding: 48px 0 52px; }
    .feedback-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
    .feedback-card { background: #fff; border-radius: 8px; padding: 36px 40px; max-width: 620px; margin: 0 auto; box-shadow: 0 12px 44px rgba(26,77,46,.22); }
    .feedback-card-head { text-align: center; margin-bottom: 24px; }
    .feedback-card-head .eyebrow { font-size: .66rem; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; color: var(--mid); display: block; margin-bottom: 6px; }
    .feedback-card h3 { font-family: 'DM Serif Display', serif; font-size: 1.5rem; color: var(--deep); margin-bottom: 4px; }
    .fb-sub { font-size: .84rem; color: var(--g400); }
    .fb-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 16px; }
    .fb-field label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--deep); }
    .fb-field input, .fb-field textarea { padding: 10px 13px; border: 1.5px solid var(--g200); border-radius: 5px; font-family: 'DM Sans', sans-serif; font-size: .9rem; color: #1e302a; background: var(--g100); outline: none; transition: border-color .2s; }
    .fb-field input:focus, .fb-field textarea:focus { border-color: var(--bright); background: #fff; }
    .fb-field textarea { min-height: 100px; resize: vertical; }
    .star-rating { display: flex; flex-direction: row-reverse; gap: 4px; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 1.7rem; cursor: pointer; color: #d1d5db; transition: color .14s; font-weight: 400; text-transform: none; letter-spacing: 0; }
    .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #f5c518; }
    .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--gs), var(--ge)); border: none; border-radius: 4px; font-family: 'DM Sans', sans-serif; font-size: .92rem; font-weight: 600; color: #fff; cursor: pointer; transition: opacity .2s; }
    .btn-submit:hover { opacity: .88; }
    .pending-note { font-size: .72rem; color: var(--g400); text-align: center; margin-top: 10px; }

/* ── Inquire Now button ── */
    .btn-inquire-now {
      display: inline-flex; align-items: center; gap: 8px;
      background: linear-gradient(135deg, var(--gs), var(--ge));
      color: #fff; font-size: .9rem; font-weight: 600;
      padding: 12px 28px; border-radius: 5px; text-decoration: none;
      box-shadow: 0 4px 16px rgba(45,191,184,.3);
      transition: opacity .2s, transform .2s;
      margin-top: 4px;
    }
    .btn-inquire-now:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

    /* Footer */
    .site-footer {
      background: linear-gradient(135deg, #0f2a1c 0%, #1a4d2e 48%, #17595a 100%);
      color: rgba(255,255,255,.82);
    }
    .footer-inner { max-width:1320px; margin:0 auto; padding:40px 24px 18px; }
    .footer-grid { display:grid; grid-template-columns:1.35fr .9fr .9fr .95fr; gap:22px; }
    .footer-brand, .footer-col {
      background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:22px;
      box-shadow:0 14px 36px rgba(0,0,0,.18);
    }
    .footer-brand { padding:24px 22px; }
    .footer-col { padding:22px 20px; }
    .footer-brand-head { display:flex; align-items:center; gap:14px; margin-bottom:14px; }
    .footer-logo { width:58px; height:58px; border-radius:50%; object-fit:cover; border:2px solid rgba(255,255,255,.7); }
    .footer-brand h3 { font-family:'DM Serif Display', serif; font-size:1.4rem; color:#fff; margin:0; }
    .footer-brand p { font-size:.84rem; line-height:1.72; color:rgba(255,255,255,.74); margin:0 0 16px; }
    .footer-badges { display:flex; flex-wrap:wrap; gap:8px; }
    .footer-badge {
      display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px; font-size:.68rem; font-weight:700;
      letter-spacing:.05em; text-transform:uppercase; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.14); color:#d8f6e2;
    }
    .footer-col h4 { font-size:.78rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:#a8e6c1; margin-bottom:14px; }
    .footer-links, .footer-meta { display:flex; flex-direction:column; gap:10px; }
    .footer-links a, .footer-meta a {
      color:rgba(255,255,255,.82); text-decoration:none; font-size:.84rem; line-height:1.5; transition:color .18s, transform .18s;
    }
    .footer-links a:hover, .footer-meta a:hover { color:#fff; transform:translateX(2px); }
    .footer-meta span { font-size:.82rem; color:rgba(255,255,255,.74); line-height:1.6; }
    .footer-bottom {
      margin-top:22px; padding-top:16px; border-top:1px solid rgba(255,255,255,.12);
      display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; font-size:.76rem; color:rgba(255,255,255,.62);
    }
    .footer-bottom a { color:#d8f6e2; text-decoration:none; }
    .footer-bottom a:hover { color:#fff; }

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
        <a class="nav-btn active" href="homepage.php">Home</a>
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

    <!-- Patient chip + Logout -->
    <div class="topbar-right">
      <a href="profile.php?tab=inbox" class="nav-icon-btn" aria-label="Open notifications">
        <svg viewBox="0 0 24 24"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"/><path d="M10 17a2 2 0 0 0 4 0"/></svg>
        <span class="nav-badge <?= $unreadCount > 0 ? '' : 'hidden' ?>" id="navNotifBadge"><?= $unreadCount > 99 ? '99+' : (int) $unreadCount ?></span>
      </a>
      <a href="profile.php" class="patient-chip">
        <div class="patient-avatar"><?= htmlspecialchars($initials) ?></div>
        <span class="patient-name"><?= htmlspecialchars($patient_name) ?></span>
      </a>
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
    <a href="profile.php">My Profile</a>
    <a href="profile.php?tab=inbox">Notifications<?= $unreadCount > 0 ? ' (' . (int) $unreadCount . ')' : '' ?></a>
    <a href="booking.php">Book Home Service</a>
    <a href="corporateservice.php">Corporate Inquiry</a>
    <a href="locations.php">Locations</a>
    <a href="about_us.php">About Us</a>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     HERO CAROUSEL
═══════════════════════════════════════════ -->
<div class="hero-wrap">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active"><img src="image/HQlogo.png" alt="HealthQuarters"></div>
      <div class="carousel-item"><img src="image/Mobile2.jpg" alt="Promotion"></div>
      <div class="carousel-item"><img src="image/Mobile.jpg" alt="Student Promo"></div>
      <div class="carousel-item"><img src="image/SeniorDeal.jpg" alt="Senior Deal"></div>
    </div>
  </div>

  <div class="hero-scrim"></div>

  <!-- Tagline overlay -->
  <div class="hero-tagline-wrap">
    <span class="hero-eyebrow">✦ Trusted Healthcare Partner</span>
    <h1 class="hero-headline">
      Holistic care for<br>
      <span class="hl">Everyone</span>
    </h1>
    <p class="hero-sub">Doctor appointments and lab tests — simplified. Enjoy fast results, student discounts, and care you can count on.</p>
  </div>

  <!-- CTA strip -->
  <div class="hero-cta-bar">
    <div class="hero-cta-inner">
      <a href="home_service_info.php" class="hero-cta-btn hs-btn">
        <div class="cta-text">
          <span class="cta-sub">Book a</span>
          <span class="cta-main">Home Service</span>
        </div>
      </a>
      <a href="corporate_info.php" class="hero-cta-btn corp-btn">
        <div class="cta-text">
          <span class="cta-sub">Inquire about</span>
          <span class="cta-main">Corporate Service</span>
        </div>
      </a>
      <a href="service.php" class="hero-cta-btn svc-btn">
        <div class="cta-text">
          <span class="cta-sub">View</span>
          <span class="cta-main">Services &amp; Prices</span>
        </div>
      </a>
      <a href="about_us.php" class="hero-cta-btn loc-btn">
        <div class="cta-text">
          <span class="cta-sub">Learn</span>
          <span class="cta-main">About Us</span>
        </div>
      </a>
    </div>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     PAGE BODY
═══════════════════════════════════════════ -->
<div class="page-body">

  <section class="rv d1" style="margin-bottom:28px;">
    <div class="sec-header">
      <h2>Patient Dashboard</h2>
      <a href="profile.php" class="see-all">Open Full Profile</a>
    </div>
    <div class="dashboard-grid">
      <?php foreach (array_slice($dashboardCards, 0, 6) as $card): ?>
        <div class="dashboard-card">
          <div class="dashboard-label"><?= htmlspecialchars($card['label']) ?></div>
          <div class="dashboard-value"><?= htmlspecialchars($card['value']) ?></div>
          <div class="dashboard-detail"><?= htmlspecialchars($card['detail']) ?></div>
          <a href="<?= htmlspecialchars($card['link']) ?>" class="dashboard-link">View details</a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="patient-overview">
      <div class="overview-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Patient Home</div>
            <div class="overview-title">Welcome back, <?= htmlspecialchars($patient_name) ?></div>
            <div class="overview-sub">
              <?= $nextAppointment ? 'Your next home service appointment is already queued below. Keep your profile updated so the team can confirm schedules faster.' : 'You do not have a confirmed upcoming home service appointment yet. You can book a service, check your inbox, or review your requests from one place.' ?>
            </div>
          </div>
          <div class="panel-note">
            <strong><?= (int) count($activeAppointments) ?></strong>
            <span>Active requests in your dashboard</span>
          </div>
        </div>
        <div class="mini-timeline">
          <?php if (!empty($activeAppointments)): ?>
            <?php foreach (array_slice($activeAppointments, 0, 3) as $appt): ?>
              <a class="mini-item" href="patient_appointment.php?id=<?= (int) ($appt['id'] ?? 0) ?>" style="text-decoration:none;color:inherit;">
                <div class="mini-dot"></div>
                <div>
                  <div class="mini-title"><?= htmlspecialchars($appt['service_type'] ?? 'Appointment') ?></div>
                  <div class="mini-sub">
                    <?= htmlspecialchars(date('M j, Y', strtotime($appt['appointment_date'] ?? 'now'))) ?> at <?= htmlspecialchars($appt['preferred_time'] ?? '—') ?>
                    • <?= htmlspecialchars(hq_normalize_appointment_status($appt['status'] ?? 'Pending')) ?>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="mini-item">
              <div class="mini-dot"></div>
              <div>
                <div class="mini-title">No active requests</div>
                <div class="mini-sub">Book a home service or open your profile to track requests and notifications.</div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="quick-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Shortcuts</div>
            <div class="overview-title" style="font-size:1.15rem;">Quick Links</div>
            <div class="overview-sub">Jump straight to the most common patient actions.</div>
          </div>
        </div>
        <div class="quick-links">
          <?php foreach ($quickLinks as $link): ?>
            <a class="quick-link" href="<?= htmlspecialchars($link['href']) ?>">
              <strong><?= htmlspecialchars($link['label']) ?></strong>
              <span>Open this section quickly</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="patient-highlights">
      <div class="overview-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Suggested Actions</div>
            <div class="overview-title">What to do next</div>
            <div class="overview-sub">Recommended actions based on your latest appointments, submissions, and profile status.</div>
          </div>
        </div>
        <div class="next-step-list">
          <?php foreach ($nextSteps as $step): ?>
            <a class="next-step-card" href="<?= htmlspecialchars($step['href']) ?>" style="text-decoration:none;">
              <div class="step-badge"><?= htmlspecialchars($step['badge']) ?></div>
              <strong><?= htmlspecialchars($step['title']) ?></strong>
              <span><?= htmlspecialchars($step['detail']) ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="quick-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Overview</div>
            <div class="overview-title" style="font-size:1.15rem;">Account Snapshot</div>
            <div class="overview-sub">A quick view of your patient account activity and saved requests.</div>
          </div>
        </div>
        <div class="summary-grid">
          <div class="summary-card">
            <div class="lbl">Upcoming</div>
            <div class="num"><?= (int) count($appointmentCards) ?></div>
            <div class="txt">Tracked appointment entries in your account.</div>
          </div>
          <div class="summary-card">
            <div class="lbl">Corporate</div>
            <div class="num" style="font-size:1rem;"><?= (int) count($corpInquiries) ?></div>
            <div class="txt">Corporate inquiries saved under your account.</div>
          </div>
          <div class="summary-card">
            <div class="lbl">Inbox</div>
            <div class="num" style="font-size:1rem;"><?= (int) $unreadCount ?></div>
            <div class="txt">Unread patient notifications waiting for review.</div>
          </div>
        </div>
        <div class="result-doc-list">
          <a class="result-doc" href="profile.php?tab=appointments">
            <strong>Open appointment tracking</strong>
            <small>Review schedules, preparation notes, and reschedule updates in one place.</small>
          </a>
          <a class="result-doc" href="profile.php?tab=inbox">
            <strong>Open notification inbox</strong>
            <small>Review booking, corporate, and account updates in one place.</small>
          </a>
        </div>
      </div>
    </div>
    <div class="patient-highlights">
      <div class="overview-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Schedules</div>
            <div class="overview-title">Appointment Tracking</div>
            <div class="overview-sub">See your active schedule, preparation reminders, and tracking flags at a glance.</div>
          </div>
          <div class="panel-note">
            <strong><?= (int) count($appointmentCards) ?></strong>
            <span>Tracked appointments</span>
          </div>
        </div>
        <div class="appt-card-list">
          <?php if (!empty($appointmentCards)): ?>
            <?php foreach ($appointmentCards as $card): ?>
              <div class="appt-card">
                <div class="appt-card-header">
                  <div>
                    <strong><?= htmlspecialchars($card['service']) ?></strong>
                    <span><?= htmlspecialchars($card['date']) ?> at <?= htmlspecialchars($card['time']) ?></span>
                  </div>
                  <span class="appt-status"><?= htmlspecialchars($card['status']) ?></span>
                </div>
                <div class="appt-meta">
                  <div class="appt-meta-block">
                    <span class="appt-meta-label">Schedule</span>
                    <span class="appt-meta-value"><?= htmlspecialchars($card['date']) ?> at <?= htmlspecialchars($card['time']) ?></span>
                  </div>
                  <div class="appt-meta-block">
                    <span class="appt-meta-label">Preparation</span>
                    <span class="appt-meta-value"><?= htmlspecialchars(!empty($card['prep_note']) ? $card['prep_note'] : 'No preparation reminder on file.') ?></span>
                  </div>
                </div>
                <?php if (!empty($card['flags'])): ?>
                  <div class="appt-flags">
                    <?php foreach ($card['flags'] as $flag): ?><span class="appt-flag"><?= htmlspecialchars($flag) ?></span><?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <a href="patient_appointment.php?id=<?= (int) ($card['id'] ?? 0) ?>" class="dashboard-link" style="margin-top:10px;">Open detail</a>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="appt-card appt-empty">
              <strong>No active tracked appointments</strong>
              <span>Once you book a service, the dashboard will show preparation notes, status, and tracking here.</span>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="quick-panel">
        <div class="panel-head">
          <div>
            <div class="panel-kicker">Updates</div>
            <div class="overview-title" style="font-size:1.15rem;">Recent Activity</div>
            <div class="overview-sub">Your latest patient-facing changes, notifications, and submission updates.</div>
          </div>
        </div>
        <div class="activity-list">
          <?php foreach ($recentActivity as $item): ?>
            <a class="activity-card" href="<?= htmlspecialchars($item['href']) ?>">
              <div class="activity-card-top">
                <div class="activity-kind"><?= htmlspecialchars($item['kind']) ?></div>
                <?php if (!empty($item['date'])): ?><span class="activity-time"><?= htmlspecialchars(hq_time_ago($item['date'])) ?></span><?php endif; ?>
              </div>
              <strong><?= htmlspecialchars($item['title']) ?></strong>
              <span><?= htmlspecialchars($item['detail']) ?></span>
            </a>
          <?php endforeach; ?>
          <?php if (empty($recentActivity)): ?>
            <div class="activity-card activity-empty">
              <strong>No recent activity yet</strong>
              <span>New appointment changes, notifications, and inquiry updates will appear here.</span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY CHOOSE US -->
  <section class="why-section">
    <div class="sec-header rv d1">
      <h2>Why Choose HealthQuarters?</h2>
      <a href="about_us.php" class="see-all">Learn More About Us</a>
    </div>
    <div class="row g-3">
      <div class="col-lg-2 col-md-4 col-sm-6 rv d2">
        <div class="why-card">
          <h4>Easy Online Booking</h4>
          <p>Book walk-in or home service appointments anytime, anywhere.</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6 rv d2">
        <div class="why-card">
          <h4>Trusted &amp; Accredited</h4>
          <p>Licensed professionals and DOH-compliant laboratory procedures.</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6 rv d3">
        <div class="why-card">
          <h4>Fast Results</h4>
          <p>Results within 24–48 hours. Urgent processing available on request.</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6 rv d3">
        <div class="why-card">
          <h4>Affordable Packages</h4>
          <p>Student, senior, and corporate rates to fit every budget.</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6 rv d4">
        <div class="why-card">
          <h4>Home Service</h4>
          <p>Mobile health team covers all municipalities in Albay, Mon–Sat.</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6 rv d4">
        <div class="why-card">
          <h4>Corporate Solutions</h4>
          <p>APE packages and mass drug testing for businesses and agencies.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HOME SERVICE + CORPORATE -->
  <div class="two-col-wide">

    <div class="rv d1">
      <div class="sec-header" style="margin-bottom:16px;">
        <h2>Home Service</h2>
        <a href="booking.php" class="see-all">Book Now</a>
      </div>
      <div class="hs-block">
        <span class="hs-block-label">Home Service Program</span>
        <h3>Lab tests &amp; check-ups<br><em>at your doorstep</em></h3>
        <p>HealthQuarters sends licensed health professionals directly to your home — no traffic, no waiting. We cover all municipalities of Albay, Mon–Sat, 7 AM to 5 PM.</p>
        <div class="hs-stats">
          <div class="hs-stat"><div class="hs-stat-n">18</div><div class="hs-stat-l">Municipalities</div></div>
          <div class="hs-stat"><div class="hs-stat-n">6</div><div class="hs-stat-l">Days a Week</div></div>
          <div class="hs-stat"><div class="hs-stat-n">24h</div><div class="hs-stat-l">Turnaround</div></div>
        </div>
        <div class="hs-pills">
          <span class="hs-pill">Blood Collection</span>
          <span class="hs-pill">Ultrasound</span>
          <span class="hs-pill">ECG</span>
          <span class="hs-pill">Urinalysis</span>
          <span class="hs-pill">General Check-up</span>
          <span class="hs-pill">IV Therapy</span>
          <span class="hs-pill">Wound Care</span>
          <span class="hs-pill">Pediatric Visit</span>
        </div>
        <a href="booking.php" class="btn-book">
          Book a Home Service
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>

    <div class="rv d2">
      <div class="sec-header" style="margin-bottom:16px;">
        <h2>Corporate Service</h2>
        <a href="corporateservice.php" class="see-all">View All Packages</a>
      </div>
      <div class="corp-overview">
        <h3>Healthy employees,<br>stronger companies</h3>
        <p>HealthQuarters provides customized Annual Physical Examination (APE) packages, DOLE-compliant drug testing, and pre-employment clearance for businesses across Albay.</p>
        <div class="corp-check">Annual Physical Examination (APE)</div>
        <div class="corp-check">DOLE-compliant Drug Testing</div>
        <div class="corp-check">Pre-employment Clearance Bundles</div>
        <div class="corp-check">Group Booking &amp; On-site Service</div>
        <div class="corp-check" style="margin-bottom:20px;">Customized Pricing for Large Groups</div>
        <a href="corporate_info.php" class="btn-inquire-now">
          Inquire Now
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>

</div><!-- /page-body -->


<!-- FEEDBACK FORM -->
<section class="feedback-section" id="leave-feedback">
  <div class="feedback-inner">
    <div class="feedback-card rv d1">
      <div class="feedback-card-head">
        <span class="eyebrow">Share Your Experience</span>
        <h3>Leave Us a Testimonial</h3>
        <p class="fb-sub">Your feedback helps us improve and helps others make informed decisions.</p>
      </div>

      <form method="POST" action="submit_testimonial.php">
        <?= hq_csrf_input('testimonial_submit') ?>
        <input type="hidden" name="submit_feedback" value="1">
        <div class="fb-field">
          <label>Your Name <span style="color:var(--bright);">*</span></label>
          <input type="text" name="feedback_name" placeholder="e.g. Juan Dela Cruz" required maxlength="80"
            value="<?= htmlspecialchars($patient_name) ?>">
        </div>
        <div class="fb-field">
          <label>Rating <span style="color:var(--bright);">*</span></label>
          <div class="star-rating">
            <input type="radio" id="s5" name="feedback_rating" value="5" checked><label for="s5">★</label>
            <input type="radio" id="s4" name="feedback_rating" value="4"><label for="s4">★</label>
            <input type="radio" id="s3" name="feedback_rating" value="3"><label for="s3">★</label>
            <input type="radio" id="s2" name="feedback_rating" value="2"><label for="s2">★</label>
            <input type="radio" id="s1" name="feedback_rating" value="1"><label for="s1">★</label>
          </div>
        </div>
        <div class="fb-field">
          <label>Your Message <span style="color:var(--bright);">*</span></label>
          <textarea name="feedback_message" placeholder="Tell us about your experience with HealthQuarters..." required maxlength="400"></textarea>
        </div>
        <button type="submit" class="btn-submit">Submit Testimonial</button>
        <p class="pending-note">Submissions are reviewed before appearing publicly.</p>
      </form>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-brand-head">
          <img src="image/HQlogo.png" alt="HealthQuarters" class="footer-logo">
          <div>
            <h3>HealthQuarters</h3>
            <div style="font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#a8e6c1;">Patient Portal</div>
          </div>
        </div>
        <p>Manage appointments, corporate inquiries, patient updates, and testimonials from one cleaner, more convenient dashboard experience.</p>
        <div class="footer-badges">
          <span class="footer-badge">Home Service</span>
          <span class="footer-badge">Corporate Packages</span>
          <span class="footer-badge">3 Branches in Albay</span>
        </div>
      </div>

      <div class="footer-col">
        <h4>Quick Access</h4>
        <div class="footer-links">
          <a href="homepage.php">Dashboard Home</a>
          <a href="profile.php">My Profile</a>
          <a href="profile.php?tab=inbox">Notifications</a>
          <a href="booking.php">Book Home Service</a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Patient Services</h4>
        <div class="footer-links">
          <a href="service.php">Laboratory Services</a>
          <a href="home_service_info.php">Home Service Information</a>
          <a href="corporate_info.php">Corporate Packages</a>
          <a href="locations.php">Branch Locations</a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Contact</h4>
        <div class="footer-meta">
          <span>HealthQuarters serves Ligao, Polangui, and Tabaco with patient-first care and scheduling support.</span>
          <a href="about_us.php#contact">View contact information</a>
          <a href="about_us.php">Learn more about HealthQuarters</a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> HealthQuarters. All rights reserved.</span>
      <span>Need updates fast? Open your <a href="profile.php?tab=inbox">notification inbox</a>.</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  /* Navbar dropdown toggle */
  function toggleNav(id, e) {
    e.stopPropagation();
    const item = document.getElementById(id);
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }
  document.addEventListener('click', () => {
    document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
  });
  document.querySelectorAll('.nav-dropdown').forEach(d => d.addEventListener('click', e => e.stopPropagation()));

  /* Hover open for desktop */
  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('mouseenter', () => {
      if (window.innerWidth > 768 && item.querySelector('.nav-dropdown')) {
        document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
        item.classList.add('open');
      }
    });
    item.addEventListener('mouseleave', () => {
      if (window.innerWidth > 768) item.classList.remove('open');
    });
  });

  /* Scroll reveal */
  const io = new IntersectionObserver(es => {
    es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); } });
  }, { threshold: 0.08 });
  document.querySelectorAll('.rv').forEach(el => io.observe(el));

  /* Notification badge refresh */
  function checkUnread() {
    fetch('notifications_api.php?action=get_unread_count')
      .then(r => r.json())
      .then(data => {
        const count = data.count ?? 0;
        const badge = document.getElementById('navNotifBadge');
        if (badge) {
          badge.textContent = count > 99 ? '99+' : count;
          badge.classList.toggle('hidden', count <= 0);
        }
      })
      .catch(() => {});
  }
  checkUnread();
  setInterval(checkUnread, 30000);

</script>
</body>
</html>