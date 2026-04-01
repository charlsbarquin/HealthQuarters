<?php require __DIR__ . '/includes/lp/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="description" content="HealthQuarters - Your trusted healthcare partner in Albay. Home service lab tests, corporate wellness packages, imaging, blood tests & more.">
  <title>HealthQuarters — Your Trusted Healthcare Partner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
       MAIN NAVBAR — with animated beam
    ═══════════════════════════════════════ */
    .topbar {
      background: linear-gradient(135deg, var(--gs) 0%, var(--ge) 100%);
      position: sticky; top: 0; z-index: 999;
      box-shadow: 0 2px 20px rgba(13,46,30,.35);
    }

    /* Beam sweep across the navbar */
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
    .mobile-nav-toggle {
      display: none; align-items: center; justify-content: center;
      width: 42px; height: 42px; margin-left: auto;
      border-radius: 12px; border: 1.5px solid rgba(255,255,255,.3);
      background: rgba(255,255,255,.14); color: #fff;
    }
    .mobile-nav-panel { display: none; background: #fff; border-bottom: 1px solid var(--border); box-shadow: 0 12px 28px rgba(13,46,30,.08); }
    .mobile-nav-panel.open { display: block; }
    .mobile-nav-links { max-width: 1280px; margin: 0 auto; padding: 14px 24px 18px; display: grid; gap: 10px; }
    .mobile-nav-links a { display: block; padding: 12px 14px; border-radius: 12px; background: var(--muted); border: 1px solid var(--border); color: var(--deep); text-decoration: none; font-weight: 600; }
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
    /* Sign In */
    .topbar-right { display: flex; align-items: center; margin-left: auto; padding-left: 16px; position: relative; z-index: 1; }
    .btn-signin {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.35);
      color: #fff; font-size: .8rem; font-weight: 600; padding: 7px 20px;
      border-radius: 4px; text-decoration: none; transition: all .2s;
    }
    .btn-signin:hover { background: rgba(255,255,255,.28); color: #fff; }

    /* ── DROPDOWNS ── */
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
    .nav-chevron { width: 10px; height: 10px; fill: none; stroke: currentColor; stroke-width: 2.5; transition: transform .2s; flex-shrink: 0; }
    .nav-item.open .nav-chevron { transform: rotate(180deg); }


    /* ═══════════════════════════════════════
       HERO CAROUSEL — new tagline overlay
    ═══════════════════════════════════════ */
    .hero-wrap { position: relative; background: #040f08; }
    #heroCarousel .carousel-control-prev,
    #heroCarousel .carousel-control-next { display: none !important; }
    #heroCarousel .carousel-item img { width: 100%; height: 520px; object-fit: cover; object-position: center; display: block; }

    /* Deep scrim — gradient from bottom, darker than before */
    .hero-scrim {
      position: absolute; inset: 0; pointer-events: none; z-index: 2;
      background:
        linear-gradient(to top,  rgba(3,12,7,.92) 0%, rgba(3,12,7,.55) 38%, rgba(3,12,7,.1) 62%, transparent 80%),
        linear-gradient(to right, rgba(3,12,7,.65) 0%, transparent 55%);
    }

    /* ── HERO TAGLINE OVERLAY (screenshot-style) ── */
    .hero-tagline-wrap {
      position: absolute;
      bottom: 96px;   /* sit just above the CTA bar */
      left: 0; right: 0;
      z-index: 8;
      padding: 0 36px 0 44px;
      pointer-events: none;
    }

    /* "A Trusted Healthcare Partner" eyebrow */
    .hero-eyebrow {
      display: inline-block;
      font-size: .6rem; font-weight: 800; letter-spacing: .2em; text-transform: uppercase;
      color: #6ee7a0;
      background: rgba(106,191,75,.12);
      border: 1px solid rgba(106,191,75,.3);
      border-radius: 3px;
      padding: 4px 10px;
      margin-bottom: 14px;
    }

    /* Main headline — big, bold, serif — mirrors screenshot */
    .hero-headline {
      font-family: 'DM Serif Display', serif;
      font-size: clamp(2rem, 5vw, 3.4rem);
      color: #fff;
      line-height: 1.08;
      letter-spacing: -.01em;
      text-shadow: 0 2px 24px rgba(0,0,0,.55);
      margin-bottom: 0;
      max-width: 640px;
    }

    /* The highlighted/italic keyword — green glow, italic like screenshot */
    .hero-headline .hl {
      font-style: italic;
      color: #6ee7a0;
      position: relative;
      display: inline-block;
      /* subtle glow behind the text */
      text-shadow:
        0 0 40px rgba(106,191,75,.55),
        0 2px 24px rgba(0,0,0,.4);
    }

    /* Animated underline beneath the keyword */
    .hero-headline .hl::after {
      content: '';
      position: absolute;
      bottom: 2px; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, #6abf4b, #2dbfb8);
      border-radius: 2px;
      transform: scaleX(0);
      transform-origin: left;
      animation: lineReveal 0.8s cubic-bezier(.22,1,.36,1) 1.2s forwards;
    }
    @keyframes lineReveal { to { transform: scaleX(1); } }

    /* Sub-tagline text below headline */
    .hero-sub {
      margin-top: 12px;
      font-size: .88rem;
      color: rgba(255,255,255,.62);
      max-width: 480px;
      line-height: 1.65;
      text-shadow: 0 1px 6px rgba(0,0,0,.4);
    }

    /* Fade-up entrance animation */
    .hero-tagline-wrap .hero-eyebrow { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .3s both; }
    .hero-tagline-wrap .hero-headline { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .45s both; }
    .hero-tagline-wrap .hero-sub { animation: taglineUp .7s cubic-bezier(.22,1,.36,1) .6s both; }
    @keyframes taglineUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

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
      border-right: 1px solid rgba(106,191,75,.18);
      transition: background .2s;
    }
    .hero-cta-btn:last-child { border-right: none; }
    .hero-cta-btn:hover { background: rgba(106,191,75,.18); color: #fff; }
    .hero-cta-btn.hs-btn { background: rgba(106,191,75,.22); border-right-color: rgba(106,191,75,.25); }
    .hero-cta-btn.hs-btn:hover { background: rgba(106,191,75,.38); }
    .hero-cta-btn.corp-btn { background: rgba(45,191,184,.16); border-right-color: rgba(45,191,184,.22); }
    .hero-cta-btn.corp-btn:hover { background: rgba(45,191,184,.32); }
    .hero-cta-btn.svc-btn { background: rgba(58,173,110,.14); }
    .hero-cta-btn.svc-btn:hover { background: rgba(58,173,110,.28); }
    .hero-cta-btn.loc-btn { background: rgba(45,191,184,.08); }
    .hero-cta-btn.loc-btn:hover { background: rgba(45,191,184,.22); }
    .cta-text { text-align: center; }
    .cta-sub { font-size: .6rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: #a8e6c1; display: block; margin-bottom: 3px; }
    .cta-main { font-family: 'DM Serif Display', serif; font-size: .96rem; display: block; }


    /* ═══════════════════════════════════════
       PAGE BODY
    ═══════════════════════════════════════ */
    .page-body { max-width: 1320px; margin: 0 auto; padding: 52px 28px 0; }
    .page-section { margin-bottom: 34px; }
    .page-section:last-child { margin-bottom: 0; }
    .section-shell {
      position: relative;
      background:
        linear-gradient(180deg, rgba(255,255,255,.96) 0%, rgba(248,252,249,.92) 100%);
      border: 1px solid rgba(221,232,228,.95);
      border-radius: 28px;
      padding: 32px;
      box-shadow: 0 20px 48px rgba(13,46,30,.08);
      overflow: hidden;
    }
    .section-shell::before {
      content: '';
      position: absolute;
      inset: 0 0 auto 0;
      height: 4px;
      background: linear-gradient(90deg, var(--gs), var(--ge));
      opacity: .95;
    }
    .section-stack { display: grid; gap: 28px; }
    .hero-summary-grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(320px, .75fr); gap: 24px; margin-bottom: 0; align-items: stretch; }
    .hero-summary-card, .contact-cta-card {
      background: linear-gradient(180deg, #ffffff 0%, #f8fcf9 100%);
      border: 1px solid rgba(221,232,228,.95);
      border-radius: 22px;
      padding: 26px;
      box-shadow: 0 14px 30px rgba(13,46,30,.07);
      height: 100%;
    }
    .hero-summary-card h3, .contact-cta-card h3 { font-family: 'DM Serif Display', serif; color: var(--deep); margin-bottom: 10px; font-size: 1.28rem; }
    .hero-summary-card p, .contact-cta-card p { color: var(--g600); font-size: .84rem; line-height: 1.72; margin-bottom: 0; }
    .cta-duo { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 18px; }
    .cta-primary, .cta-secondary {
      display: inline-flex; align-items: center; gap: 8px; text-decoration: none; border-radius: 999px; padding: 11px 18px; font-size: .82rem; font-weight: 700;
    }
    .cta-primary { background: linear-gradient(135deg, var(--gs), var(--ge)); color: #fff; box-shadow: 0 6px 18px rgba(45,191,184,.28); }
    .cta-secondary { background: var(--pale); color: var(--mid); border: 1px solid #a8e6c1; }
    .hero-mini-metrics { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 22px; }
    .hero-mini-metric { background: var(--muted); border: 1px solid var(--border); border-radius: 18px; padding: 16px; }
    .hero-mini-metric strong { display: block; font-family: 'DM Serif Display', serif; font-size: 1.45rem; color: var(--deep); line-height: 1; margin-bottom: 5px; }
    .hero-mini-metric span { display: block; font-size: .74rem; color: var(--g600); line-height: 1.45; }
    .service-discovery-grid, .trust-grid, .journey-grid, .location-grid, .faq-grid, .why-grid, .testimonial-grid { display: grid; gap: 20px; }
    .service-discovery-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .trust-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .journey-grid { grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); }
    .location-grid { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
    .faq-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
    .why-grid { grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); }
    .testimonial-grid { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
    .service-item, .trust-item, .journey-item, .location-card, .faq-item {
      background: linear-gradient(180deg, #ffffff 0%, #fbfdfc 100%);
      border: 1px solid rgba(221,232,228,.95);
      border-radius: 20px;
      padding: 22px;
      box-shadow: 0 12px 26px rgba(13,46,30,.06);
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    a.service-item, .trust-item, .journey-item, .location-card, .faq-item, .why-card, .testi-card { display:block; height:100%; text-decoration:none; }
    a.service-item:hover, .trust-item:hover, .journey-item:hover, .location-card:hover, .faq-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 30px rgba(13,46,30,.09);
      border-color: rgba(106,191,75,.28);
    }
    .service-icon, .journey-step {
      width: 44px; height: 44px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(106,191,75,.16), rgba(45,191,184,.16)); color: var(--mid); font-weight: 800; margin-bottom: 14px;
    }
    .service-item h4, .trust-item h4, .journey-item h4, .location-card h4, .faq-item h4 {
      font-family: 'DM Serif Display', serif; font-size: 1rem; color: var(--deep); margin-bottom: 8px;
    }
    .service-item p, .trust-item p, .journey-item p, .faq-item p { font-size: .8rem; color: var(--g600); line-height: 1.65; margin: 0; }
    .trust-stat { font-family: 'DM Serif Display', serif; font-size: 1.8rem; color: var(--deep); line-height: 1; margin-bottom: 6px; }
    .location-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
    .location-chip { display: inline-flex; align-items: center; padding: 4px 9px; border-radius: 999px; background: var(--muted); border: 1px solid var(--border); font-size: .68rem; font-weight: 700; color: var(--mid); }
    .sticky-mobile-cta {
      display: none; position: fixed; left: 12px; right: 12px; bottom: 12px; z-index: 1000;
      background: rgba(13,40,24,.92); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.08);
      border-radius: 18px; padding: 10px; box-shadow: 0 14px 34px rgba(13,46,30,.22);
    }
    .sticky-mobile-cta-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .sticky-mobile-cta a { display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; padding: 12px; font-size: .8rem; font-weight: 700; text-decoration: none; }
    .sticky-mobile-cta .cta-book { background: linear-gradient(135deg, var(--gs), var(--ge)); color: #fff; }
    .sticky-mobile-cta .cta-inquire { background: rgba(255,255,255,.12); color: #fff; border: 1px solid rgba(255,255,255,.12); }

    .sec-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 18px; border-bottom: 1px solid rgba(106,191,75,.18); padding-bottom: 14px; margin-bottom: 24px; }
    .sec-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.24rem; color: var(--deep); display: flex; align-items: center; gap: 10px; }
    .sec-header h2::before { content: ''; width: 10px; height: 10px; background: linear-gradient(135deg, var(--gs), var(--ge)); border-radius: 999px; display: inline-block; box-shadow: 0 0 0 6px rgba(106,191,75,.09); }
    .see-all { font-size: .78rem; font-weight: 600; color: var(--mid); text-decoration: none; transition: color .15s; }
    .see-all:hover { color: var(--bright); text-decoration: underline; }


    /* ═══════════════════════════════════════
       WHY CHOOSE US
    ═══════════════════════════════════════ */
    .why-section { padding: 0; }
    .why-card {
      background: linear-gradient(180deg, #ffffff 0%, #fbfdfc 100%);
      border: 1px solid rgba(221,232,228,.95); border-radius: 20px;
      padding: 24px 20px;
      border-top: 4px solid var(--bright);
      transition: box-shadow .2s, transform .2s;
    }
    .why-card:hover { box-shadow: 0 6px 24px rgba(13,46,30,.1); transform: translateY(-3px); }
    .why-card h4 { font-family: 'DM Serif Display', serif; font-size: .98rem; color: var(--deep); margin-bottom: 7px; }
    .why-card p { font-size: .82rem; color: var(--g600); line-height: 1.65; margin: 0; }


    /* ═══════════════════════════════════════
       TWO-COLUMN LAYOUTS
    ═══════════════════════════════════════ */
    .two-col { display: grid; grid-template-columns: 1fr 340px; gap: 24px; padding: 0 0 32px; }
    .two-col-wide { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 26px; padding: 0; align-items: stretch; }


    /* ═══════════════════════════════════════
       HOME SERVICE SECTION
    ═══════════════════════════════════════ */
    .hs-block { background: linear-gradient(135deg, #0b2e1a 0%, #163d24 50%, #1f6040 100%); border-radius: 22px; padding: 34px 32px 30px; position: relative; overflow: hidden; height: 100%; display: flex; flex-direction: column; box-shadow: inset 0 1px 0 rgba(255,255,255,.08); }
    .hs-block::after { content: ''; position: absolute; top:-60px; right:-60px; width:240px; height:240px; background:radial-gradient(circle,rgba(106,191,75,.14) 0%,transparent 70%); border-radius:50%; }
    .hs-block-label { font-size: .63rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #a8e6c1; display: block; margin-bottom: 10px; position: relative; z-index: 1; }
    .hs-block h3 { font-family: 'DM Serif Display', serif; font-size: 1.55rem; color: #fff; margin-bottom: 10px; line-height: 1.18; position: relative; z-index: 1; }
    .hs-block h3 em { font-style: italic; color: #6ee7a0; }
    .hs-block p { font-size: .84rem; color: rgba(255,255,255,.72); line-height: 1.75; margin-bottom: 18px; max-width: 440px; position: relative; z-index: 1; }
    .hs-pills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px; position: relative; z-index: 1; }
    .hs-pill { font-size: .75rem; color: rgba(255,255,255,.78); background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.15); border-radius: 50px; padding: 5px 12px; }
    .hs-stats { display: flex; gap: 0; border-top: 1px solid rgba(255,255,255,.1); border-bottom: 1px solid rgba(255,255,255,.1); padding: 14px 0; margin: 18px 0; position: relative; z-index: 1; }
    .hs-stat { flex: 1; text-align: center; border-right: 1px solid rgba(255,255,255,.1); }
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
       CORPORATE SECTION
    ═══════════════════════════════════════ */
    .corp-overview { background: linear-gradient(180deg, #ffffff 0%, #fbfdfc 100%); border: 1px solid rgba(221,232,228,.95); border-radius: 22px; padding: 30px 28px; height: 100%; border-top: 4px solid var(--bright); position: relative; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 14px 30px rgba(13,46,30,.06); }
.corp-overview::after { content: ''; position: absolute; bottom: -40px; right: -40px; width: 160px; height: 160px; background: radial-gradient(circle, rgba(58,173,110,.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
    .corp-overview h3 { font-family: 'DM Serif Display', serif; font-size: 1.35rem; color: var(--deep); margin-bottom: 10px; line-height: 1.2; }
    .corp-overview p { font-size: .84rem; color: var(--g600); line-height: 1.75; margin-bottom: 16px; }
    .corp-check { display: flex; align-items: flex-start; gap: 9px; font-size: .83rem; color: var(--g600); margin-bottom: 8px; }
    .corp-check::before { content: ''; color: var(--bright); font-weight: 700; flex-shrink: 0; margin-top: 1px; }
    .corp-overview .btn-inquire-now { margin-top: auto; align-self: flex-start; }
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
       TESTIMONIALS
    ═══════════════════════════════════════ */
    .testi-section { padding: 0; }
    .testi-card { background: linear-gradient(180deg, #ffffff 0%, #fbfdfc 100%); border: 1px solid rgba(221,232,228,.95); border-radius: 20px; padding: 20px; border-top: 3px solid var(--gs); transition: box-shadow .2s, transform .2s; }
    .testi-card:hover { box-shadow: 0 6px 20px rgba(13,46,30,.09); }
    .testi-text { font-style: italic; color: var(--g600); font-size: .8rem; line-height: 1.65; margin-bottom: 10px; position: relative; padding-top: 16px; }
    .testi-text::before { content: '"'; font-family: Georgia, serif; font-size: 2.2rem; color: var(--pale); position: absolute; top: -4px; left: 0; line-height: 1; }
    .testi-name { font-family: 'DM Serif Display', serif; color: var(--accent); font-size: .9rem; }
    .testi-stars { color: var(--mid); font-size: .78rem; font-weight: 700; margin-top: 6px; }
    .testi-date { font-size: .67rem; color: var(--g400); margin-top: 2px; }
    .no-testi { text-align: center; padding: 36px; color: var(--g400); font-size: .88rem; }


    /* ═══════════════════════════════════════
       FEEDBACK FORM
    ═══════════════════════════════════════ */
    .feedback-section { background: linear-gradient(135deg, var(--deep) 0%, #2d7a4f 100%); padding: 48px 0 52px; }
    .feedback-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
    .feedback-card { background: #fff; border-radius: 18px; padding: 36px 40px; max-width: 760px; margin: 0 auto; box-shadow: 0 12px 44px rgba(26,77,46,.22); }
    .feedback-card-head { text-align: center; margin-bottom: 24px; }
    .feedback-card-head .eyebrow { font-size: .66rem; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; color: var(--mid); display: block; margin-bottom: 6px; }
    .feedback-card h3 { font-family: 'DM Serif Display', serif; font-size: 1.5rem; color: var(--deep); margin-bottom: 4px; }
    .fb-sub { font-size: .84rem; color: var(--g400); }
    .fb-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 16px; }
    .fb-field label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--deep); }
    .fb-field input, .fb-field textarea { padding: 10px 13px; border: 1.5px solid var(--g200); border-radius: 5px; font-family: 'DM Sans', sans-serif; font-size: .9rem; color: #1e302a; background: var(--g100); outline: none; transition: border-color .2s; }
    .fb-field input:focus, .fb-field textarea:focus { border-color: var(--bright); background: #fff; }
    .fb-field textarea { min-height: 100px; resize: vertical; }
    .rating-scale { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
    .rating-choice input { display: none; }
    .rating-choice span {
      display: flex; align-items: center; justify-content: center;
      border: 1.5px solid var(--g200); border-radius: 12px;
      padding: 12px 8px; background: var(--g100); color: var(--deep);
      font-size: .85rem; font-weight: 700; cursor: pointer; transition: all .18s;
    }
    .rating-choice input:checked + span,
    .rating-choice span:hover {
      background: var(--pale);
      border-color: var(--bright);
      color: var(--mid);
    }
    .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--gs), var(--ge)); border: none; border-radius: 4px; font-family: 'DM Sans', sans-serif; font-size: .92rem; font-weight: 600; color: #fff; cursor: pointer; transition: opacity .2s; }
    .btn-submit:hover { opacity: .88; }
    .alert-fb { border-radius: 6px; padding: 12px 16px; font-size: .86rem; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
    .alert-fb-success { background: var(--pale); border: 1px solid #9fe3c5; color: var(--mid); }
    .alert-fb-error { background: #fdecea; border: 1px solid #f5b4b4; color: #e05252; }
    .pending-note { font-size: .72rem; color: var(--g400); text-align: center; margin-top: 10px; }


    /* ═══════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════ */
    .site-footer { background: #0d2818; padding: 40px 0 0; }
    .footer-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
    .footer-top { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 32px 36px; padding-bottom: 32px; border-bottom: 1px solid rgba(255,255,255,.07); }
    .footer-brand-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; text-decoration: none; }
    .footer-logo { height: 42px; width: 42px; border-radius: 50%; border: 2px solid rgba(255,255,255,.2); }
    .footer-brand-name { font-family: 'DM Serif Display', serif; font-size: 1.2rem; color: #fff; }
    .footer-social-row { display: flex; gap: 8px; }
    .footer-social-btn { width: 32px; height: 32px; border-radius: 4px; border: 1px solid rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.55); text-decoration: none; transition: all .18s; }
    .footer-social-btn:hover { background: rgba(255,255,255,.1); color: #fff; border-color: rgba(255,255,255,.3); }
    .footer-col-head { font-size: .65rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.3); margin-bottom: 14px; padding-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,.07); }
    .footer-link { display: block; font-size: .82rem; color: rgba(255,255,255,.52); text-decoration: none; margin-bottom: 8px; transition: color .16s; }
    .footer-link:hover { color: #a8e6c1; }
    .footer-contact-row { margin-bottom: 12px; }
    .footer-contact-label { font-size: .63rem; font-weight: 700; text-transform: uppercase; letter-spacing: .09em; color: rgba(255,255,255,.3); display: block; margin-bottom: 2px; }
    .footer-contact-val { font-size: .81rem; color: rgba(255,255,255,.62); line-height: 1.55; }
    .footer-contact-val a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .15s; }
    .footer-contact-val a:hover { color: #a8e6c1; }
    .footer-bottom { padding: 16px 24px; }
    .footer-bottom p { font-size: .72rem; color: rgba(255,255,255,.2); text-align: center; }
    .footer-bottom a { color: rgba(255,255,255,.2); text-decoration: none; margin: 0 6px; transition: color .15s; }
    .footer-bottom a:hover { color: rgba(255,255,255,.45); }


    /* ═══════════════════════════════════════
       SCROLL REVEAL
    ═══════════════════════════════════════ */
    .rv { opacity: 0; transform: translateY(18px); transition: opacity .55s ease, transform .55s ease; }
    .rv.on { opacity: 1; transform: translateY(0); }
    .d1{transition-delay:.05s} .d2{transition-delay:.12s} .d3{transition-delay:.19s} .d4{transition-delay:.26s}


    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media(max-width:1024px) {
      .two-col { grid-template-columns: 1fr; }
      .two-col-wide { grid-template-columns: 1fr; }
      .footer-top { grid-template-columns: 1fr 1fr; }
      .hero-summary-grid { grid-template-columns: 1fr; }
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
      .page-body { padding: 24px 16px 0; }
      .section-shell { padding: 24px 18px; border-radius: 22px; }
      .corp-pkg-grid { grid-template-columns: 1fr; }
      .footer-top { grid-template-columns: 1fr; }
      .feedback-card { padding: 24px 20px; }
      .two-col { gap: 16px; }
      .hero-mini-metrics { grid-template-columns: 1fr; }
      .section-stack, .two-col-wide { gap: 18px; }
      .sec-header { align-items: flex-start; flex-direction: column; }
    }
    @media(max-width:480px) {
      .brand-name { display: none; }
      .topbar-nav { display: none; }
      .mobile-nav-toggle { display: inline-flex; }
      .rating-scale { grid-template-columns: 1fr; }
      .sticky-mobile-cta { display: block; }
      body { padding-bottom: 92px; }
    }

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

  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     MAIN NAVBAR (with beam effect via CSS ::before / ::after)
═══════════════════════════════════════════ -->
<?php hq_render_public_nav([
  'home_href' => 'lp.php',
  'active' => 'home',
  'is_logged_in' => false,
]); ?>


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

  <!-- Dual-sided scrim -->
  <div class="hero-scrim"></div>

  <!-- ── TAGLINE OVERLAY (screenshot-inspired) ── -->
  <div class="hero-tagline-wrap">
    <span class="hero-eyebrow">Trusted Healthcare Partner</span>
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
      <a href="locations.php" class="hero-cta-btn loc-btn">
        <div class="cta-text">
          <span class="cta-sub">Find a</span>
          <span class="cta-main">Branch Near You</span>
        </div>
      </a>
    </div>
  </div>
</div>

<div class="sticky-mobile-cta">
  <div class="sticky-mobile-cta-inner">
    <a href="signup.php" class="cta-book">Book Home Service</a>
    <a href="corporate_info.php" class="cta-inquire">Corporate Inquiry</a>
  </div>
</div>

<!-- ═══════════════════════════════════════════
     PAGE BODY
═══════════════════════════════════════════ -->
<div class="page-body">

  <section class="page-section rv d1">
    <div class="section-shell">
    <div class="hero-summary-grid">
      <div class="hero-summary-card">
        <h3>Healthcare that feels clear, fast, and approachable</h3>
        <p>HealthQuarters helps patients across Albay book services, understand preparation steps, manage schedules, and stay updated from one clear experience.</p>
        <div class="cta-duo">
          <a href="signup.php" class="cta-primary">Start Booking</a>
          <a href="service.php" class="cta-secondary">Explore Services</a>
        </div>
        <div class="hero-mini-metrics">
          <div class="hero-mini-metric"><strong>3</strong><span>Branches serving Ligao, Polangui, and Tabaco</span></div>
          <div class="hero-mini-metric"><strong>18</strong><span>Municipalities covered by home service support</span></div>
          <div class="hero-mini-metric"><strong>24-48h</strong><span>Typical turnaround for booking follow-up and patient updates</span></div>
        </div>
      </div>
      <div class="contact-cta-card">
        <h3>Need help choosing the right service?</h3>
        <p>Use the quick links below to start the right path whether you are booking a home service, looking for a branch, or asking about a company package.</p>
        <div class="cta-duo">
          <a href="home_service_info.php" class="cta-primary">Home Service Info</a>
          <a href="locations.php" class="cta-secondary">Find a Branch</a>
        </div>
        <div class="cta-duo">
          <a href="corporate_info.php" class="cta-secondary">Corporate Packages</a>
          <a href="#landing-faq" class="cta-secondary">Read FAQs</a>
        </div>
      </div>
    </div>
    </div>
  </section>

  <section class="page-section rv d1">
    <div class="section-shell">
    <div class="sec-header">
      <h2>Service Discovery</h2>
      <a href="service.php" class="see-all">View Full Service List</a>
    </div>
    <div class="service-discovery-grid">
      <a class="service-item" href="service.php#hematology">
        <div class="service-icon">H</div>
        <h4>Hematology</h4>
        <p>Blood count, platelet, ESR, and related screening tests for routine monitoring and physician requests.</p>
      </a>
      <a class="service-item" href="service.php#chemistry">
        <div class="service-icon">C</div>
        <h4>Blood Chemistry</h4>
        <p>FBS, lipid profile, HbA1c, electrolytes, and other chemistry tests with preparation guidance.</p>
      </a>
      <a class="service-item" href="service.php#ultrasound">
        <div class="service-icon">I</div>
        <h4>Imaging</h4>
        <p>Ultrasound studies including whole abdomen, pelvic, thyroid, breast, and focused organ scans.</p>
      </a>
      <a class="service-item" href="service.php#other">
        <div class="service-icon">O</div>
        <h4>Other Services</h4>
        <p>Drug test, ECG, chest X-ray, and related support services for individual and organizational needs.</p>
      </a>
    </div>
    </div>
  </section>

  <section class="page-section rv d2">
    <div class="section-shell">
    <div class="sec-header">
      <h2>Why Patients Trust Us</h2>
      <a href="about_us.php" class="see-all">About HealthQuarters</a>
    </div>
    <div class="trust-grid">
      <div class="trust-item"><div class="trust-stat">3</div><h4>Accessible Branches</h4><p>Patients can choose from three branch locations across Albay.</p></div>
      <div class="trust-item"><div class="trust-stat">18</div><h4>Municipality Coverage</h4><p>Home service support helps extend access across the province.</p></div>
      <div class="trust-item"><div class="trust-stat">24h+</div><h4>Fast Result Release</h4><p>Many routine diagnostics are released quickly once processed.</p></div>
      <div class="trust-item"><div class="trust-stat">1</div><h4>Unified Experience</h4><p>Booking, inquiries, updates, and testimonials all connect through one system.</p></div>
    </div>
    </div>
  </section>

  <section class="page-section rv d2">
    <div class="section-shell">
    <div class="sec-header">
      <h2>How It Works</h2>
      <a href="signup.php" class="see-all">Get Started</a>
    </div>
    <div class="journey-grid">
      <div class="journey-item"><div class="journey-step">1</div><h4>Choose a Service</h4><p>Review available diagnostics, home service options, or corporate packages.</p></div>
      <div class="journey-item"><div class="journey-step">2</div><h4>Submit Your Request</h4><p>Book online or send an inquiry with your preferred schedule and details.</p></div>
      <div class="journey-item"><div class="journey-step">3</div><h4>Receive Confirmation</h4><p>Receive your booking confirmation, reminders, and updates from the HealthQuarters team.</p></div>
      <div class="journey-item"><div class="journey-step">4</div><h4>Track Your Requests</h4><p>Patients can later track appointments, inquiries, and account activity in their portal.</p></div>
    </div>
    </div>
  </section>

  <!-- WHY CHOOSE -->
  <section class="why-section page-section">
    <div class="section-shell">
    <div class="sec-header rv d1">
      <h2>Why Choose HealthQuarters?</h2>
      <a href="about_us.php" class="see-all">Learn More About Us</a>
    </div>
    <div class="why-grid">
      <div class="why-card rv d2">
        <h4>Easy Online Booking</h4>
        <p>Book walk-in or home service appointments anytime, anywhere.</p>
      </div>
      <div class="why-card rv d2">
        <h4>Trusted &amp; Accredited</h4>
        <p>Licensed professionals and DOH-compliant laboratory procedures.</p>
      </div>
      <div class="why-card rv d3">
        <h4>Fast Results</h4>
        <p>Results within 24-48 hours. Urgent processing available on request.</p>
      </div>
      <div class="why-card rv d3">
        <h4>Affordable Packages</h4>
        <p>Student, senior, and corporate rates to fit every budget.</p>
      </div>
      <div class="why-card rv d4">
        <h4>Home Service</h4>
        <p>Mobile health team covers all municipalities in Albay, Mon-Sat.</p>
      </div>
      <div class="why-card rv d4">
        <h4>Corporate Solutions</h4>
        <p>APE packages and mass drug testing for businesses and agencies.</p>
      </div>
    </div>
    </div>
  </section>

  <!-- HOME SERVICE + CORPORATE -->
  <div class="page-section section-shell">
  <div class="two-col-wide">

    <div class="rv d1">
      <div class="sec-header" style="margin-bottom:16px;">
        <h2>Home Service</h2>
        <a href="home_service_info.php" class="see-all">Learn More</a>
      </div>
      <div class="hs-block">
        <span class="hs-block-label">Home Service Program</span>
        <h3>Lab tests &amp; check-ups<br><em>at your doorstep</em></h3>
        <p>HealthQuarters sends licensed health professionals directly to your home for a smoother, lower-stress experience. We cover all municipalities of Albay, Mon-Sat, 7 AM to 5 PM.</p>
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
        <a href="signup.php" class="btn-book">
          Book Now - Sign Up Free
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <p style="margin-top:10px;font-size:.72rem;color:rgba(255,255,255,.38);">Already have an account? <a href="login.php" style="color:#a8e6c1;text-decoration:none;">Sign in instead</a></p>
      </div>
    </div>

    <div class="rv d2">
      <div class="sec-header" style="margin-bottom:16px;">
        <h2>Corporate Service</h2>
        <a href="corporate_info.php" class="see-all">View All Packages</a>
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

  </div>
  </div>

  <!-- TESTIMONIALS -->
  <section class="testi-section page-section">
    <div class="section-shell">
    <div class="sec-header rv d1">
      <h2>Trusted by Our Patients</h2>
      <a href="#leave-feedback" class="see-all">Share Your Experience</a>
    </div>
    <?php if(empty($testimonials)): ?>
      <div class="no-testi rv d2">No testimonials yet. Be the first to share your experience below!</div>
    <?php else: ?>
      <div class="testimonial-grid">
        <?php foreach($testimonials as $t):
          $stars   = intval($t['rating'] ?? 5);
          $starStr = $stars . ' / 5 Rating';
          $dateStr = isset($t['created_at']) ? date('M j, Y', strtotime($t['created_at'])) : '';
        ?>
        <div class="testi-card rv d2">
          <p class="testi-text"><?= htmlspecialchars($t['message']) ?></p>
          <div class="testi-stars"><?= $starStr ?></div>
          <div class="testi-name"><?= htmlspecialchars($t['name']) ?></div>
          <div class="testi-date"><?= $dateStr ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    </div>
  </section>

</div><!-- /page-body -->

<section class="page-body page-section rv d2" style="padding-bottom:32px;">
  <div class="section-shell">
  <div class="sec-header">
    <h2>Branches and Contact Points</h2>
    <a href="locations.php" class="see-all">See All Locations</a>
  </div>
  <div class="location-grid">
    <div class="location-card">
      <h4>Ligao Branch</h4>
      <p>Convenient for patients in and around Ligao City who need accessible branch-based diagnostics and support.</p>
      <div class="location-meta">
        <span class="location-chip">Ligao City</span>
        <span class="location-chip">Diagnostics</span>
      </div>
    </div>
    <div class="location-card">
      <h4>Polangui Branch</h4>
      <p>Supports patients in central Albay with diagnostics, appointments, and follow-up coordination.</p>
      <div class="location-meta">
        <span class="location-chip">Polangui</span>
        <span class="location-chip">Patient Support</span>
      </div>
    </div>
    <div class="location-card">
      <h4>Tabaco Branch</h4>
      <p>Branch-based option for patients in Tabaco City looking for trusted diagnostics and service support.</p>
      <div class="location-meta">
        <span class="location-chip">Tabaco City</span>
        <span class="location-chip">Branch Services</span>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="page-body page-section rv d3" id="landing-faq" style="padding-top:0;padding-bottom:40px;">
  <div class="section-shell">
  <div class="sec-header">
    <h2>Frequently Asked Questions</h2>
    <a href="service.php" class="see-all">Explore Services</a>
  </div>
  <div class="faq-grid">
    <div class="faq-item">
      <h4>How do I start booking?</h4>
      <p>Create an account first, then choose a service, branch, date, and preferred schedule online.</p>
    </div>
    <div class="faq-item">
      <h4>Can I request home service online?</h4>
      <p>Yes. The system guides patients through booking details and the team reviews submitted requests.</p>
    </div>
    <div class="faq-item">
      <h4>Will I see preparation reminders?</h4>
      <p>Yes. Patients can later receive reminders for fasting and other preparation steps through the portal.</p>
    </div>
    <div class="faq-item">
      <h4>Can companies inquire here too?</h4>
      <p>Yes. Corporate packages are available for APE, drug testing, and wider health program needs.</p>
    </div>
  </div>
  </div>
</section>

<section class="page-body rv d3" style="padding-top:0;padding-bottom:36px;">
  <div class="contact-cta-card" style="max-width:none;">
    <h3>Ready to take the next step?</h3>
    <p>Start as a patient, explore services, or move straight to a corporate inquiry depending on what you need today.</p>
    <div class="cta-duo">
      <a href="signup.php" class="cta-primary">Create an Account</a>
      <a href="login.php" class="cta-secondary">Sign In</a>
      <a href="corporate_info.php" class="cta-secondary">Corporate Packages</a>
      <a href="https://www.facebook.com/healthquartersdiagnostic/" target="_blank" class="cta-secondary">Message on Facebook</a>
    </div>
  </div>
</section>


<!-- FEEDBACK FORM -->
<section class="feedback-section" id="leave-feedback">
  <div class="feedback-inner">
    <div class="feedback-card rv d1">
      <div class="feedback-card-head">
        <span class="eyebrow">Share Your Experience</span>
        <h3>Leave Us a Testimonial</h3>
        <p class="fb-sub">Your feedback helps us improve and helps others make informed decisions.</p>
      </div>

      <?php if($feedbackSuccess): ?>
        <div class="alert-fb alert-fb-success">Thank you! Your testimonial has been submitted and will appear after review.</div>
      <?php endif; ?>
      <?php if($feedbackError): ?>
        <div class="alert-fb alert-fb-error">Please fill in all fields before submitting.</div>
      <?php endif; ?>

      <form method="POST" action="submit_testimonial.php">
        <?= hq_csrf_input('testimonial_submit') ?>
        <input type="hidden" name="submit_feedback" value="1">
        <div class="fb-field">
          <label>Your Name <span style="color:var(--bright);">*</span></label>
          <input type="text" name="feedback_name" placeholder="e.g. Juan Dela Cruz" required maxlength="80">
        </div>
        <div class="fb-field">
          <label>Rating <span style="color:var(--bright);">*</span></label>
          <div class="rating-scale">
            <label class="rating-choice"><input type="radio" name="feedback_rating" value="1"><span>1</span></label>
            <label class="rating-choice"><input type="radio" name="feedback_rating" value="2"><span>2</span></label>
            <label class="rating-choice"><input type="radio" name="feedback_rating" value="3"><span>3</span></label>
            <label class="rating-choice"><input type="radio" name="feedback_rating" value="4"><span>4</span></label>
            <label class="rating-choice"><input type="radio" name="feedback_rating" value="5" checked><span>5</span></label>
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


<!-- FOOTER -->
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-top">

      <div>
        <a class="footer-brand-row" href="lp.php">
          <img src="image/Healthquarterlogo.png" class="footer-logo" alt="HealthQuarters">
          <span class="footer-brand-name">HealthQuarters</span>
        </a>
        <p style="font-size:.8rem;color:rgba(255,255,255,.38);margin-bottom:14px;">Holistic Care for Everyone</p>
        <div class="footer-social-row">
          <a class="footer-social-btn" href="https://www.facebook.com/healthquarters.lab" target="_blank" rel="noopener" title="Facebook">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
        </div>
      </div>

      <div>
        <div class="footer-col-head">About HealthQuarters</div>
        <a class="footer-link" href="about_us.php#profile">Profile</a>
        <a class="footer-link" href="about_us.php#mission">Mission &amp; Vision</a>
        <a class="footer-link" href="about_us.php#milestones">Milestones</a>
        <a class="footer-link" href="about_us.php#orgchart">Organizational Chart</a>
        <a class="footer-link" href="locations.php">Locations</a>
      </div>

      <div>
        <div class="footer-col-head">Services</div>
        <a class="footer-link" href="service.php#packages">Health Packages</a>
        <a class="footer-link" href="service.php#hematology">Hematology</a>
        <a class="footer-link" href="service.php#ultrasound">Ultrasound</a>
        <a class="footer-link" href="home_service_info.php">Home Service</a>
        <a class="footer-link" href="corporate_info.php">Corporate Service</a>
        <a class="footer-link" href="service.php">Full Price List</a>
      </div>

      <div>
        <div class="footer-col-head">Contact</div>
        <div class="footer-contact-row">
          <span class="footer-contact-label">Telephone</span>
          <div class="footer-contact-val"><a href="tel:09068800028">+63 906 880 0028</a><br><span style="font-size:.72rem;color:rgba(255,255,255,.28);">Mon–Sat, 7:00 AM – 5:00 PM</span></div>
        </div>
        <div class="footer-contact-row">
          <span class="footer-contact-label">Email Address</span>
          <div class="footer-contact-val"><a href="mailto:healthquartersphilippines@gmail.com">healthquartersphilippines@gmail.com</a></div>
        </div>
        <div class="footer-contact-row">
          <span class="footer-contact-label">Facebook</span>
          <div class="footer-contact-val"><a href="https://www.facebook.com/healthquarters.lab" target="_blank" rel="noopener">facebook.com/healthquarters.lab</a></div>
        </div>
        <div class="footer-contact-row">
          <span class="footer-contact-label">Branches</span>
          <div class="footer-contact-val">Ligao City · Polangui · Tabaco City<br><a href="locations.php" style="font-size:.74rem;">View all locations</a></div>
        </div>
      </div>

    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  <?php hq_render_public_nav_script(); ?>

  /* Scroll reveal */
  const io = new IntersectionObserver(es => {
    es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); } });
  }, { threshold: 0.08 });
  document.querySelectorAll('.rv').forEach(el => io.observe(el));
</script>
</body>
</html>