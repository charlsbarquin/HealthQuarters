<?php

function hq_render_public_footer(array $options = []): void
{
    $homeHref = (string) ($options['home_href'] ?? 'lp.php');
    $primaryCtaHref = (string) ($options['primary_cta_href'] ?? 'service.php');
    $primaryCtaLabel = (string) ($options['primary_cta_label'] ?? 'Explore Services');
    ?>
<style>
  .site-footer{
    background:linear-gradient(135deg,#0f2a1c 0%,#1a4d2e 48%,#17595a 100%);
    color:rgba(255,255,255,.82);
  }
  .footer-inner{max-width:1280px;margin:0 auto;padding:38px 24px 18px;}
  .footer-grid{display:grid;grid-template-columns:1.3fr .9fr .9fr;gap:20px;}
  .footer-card{
    background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:22px;
    padding:22px 20px;box-shadow:0 14px 36px rgba(0,0,0,.18);
  }
  .footer-card h3,.footer-card h4{margin:0 0 12px;}
  .footer-card h3{font-family:'DM Serif Display',serif;font-size:1.3rem;color:#fff;}
  .footer-card h4{font-size:.78rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#a8e6c1;}
  .footer-card p,.footer-card a,.footer-card span{font-size:.82rem;line-height:1.65;color:rgba(255,255,255,.76);text-decoration:none;}
  .footer-links{display:flex;flex-direction:column;gap:10px;}
  .footer-links a:hover{color:#fff;}
  .footer-bottom{margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.12);font-size:.76rem;color:rgba(255,255,255,.62);display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;}
  @media(max-width:680px){
    .footer-grid{grid-template-columns:1fr;}
    .footer-inner{padding:30px 16px 16px;}
  }
</style>
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-card">
        <h3>HealthQuarters</h3>
        <p>HealthQuarters brings together diagnostics, home service scheduling, corporate support, and patient guidance in one cleaner digital experience.</p>
      </div>
      <div class="footer-card">
        <h4>Quick Access</h4>
        <div class="footer-links">
          <a href="<?= htmlspecialchars($homeHref) ?>">Home</a>
          <a href="service.php">Services</a>
          <a href="locations.php">Locations</a>
          <a href="about_us.php">About Us</a>
        </div>
      </div>
      <div class="footer-card">
        <h4>Explore</h4>
        <div class="footer-links">
          <a href="<?= htmlspecialchars($primaryCtaHref) ?>"><?= htmlspecialchars($primaryCtaLabel) ?></a>
          <a href="home_service_info.php">Home Service Information</a>
          <a href="corporate_info.php">Corporate Service Information</a>
          <a href="about_us.php#contact">Contact HealthQuarters</a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> HealthQuarters. All rights reserved.</span>
      <span>Designed for clearer patient and service journeys across the site.</span>
    </div>
  </div>
</footer>
    <?php
}
