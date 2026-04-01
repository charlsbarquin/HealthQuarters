<?php

function hq_render_public_nav(array $options = []): void
{
    $homeHref = (string) ($options['home_href'] ?? 'lp.php');
    $active = (string) ($options['active'] ?? '');
    $isLoggedIn = !empty($options['is_logged_in']);
    $patientName = (string) ($options['patient_name'] ?? 'Patient');
    $initials = (string) ($options['initials'] ?? 'P');
    $showAccountActions = array_key_exists('show_account_actions', $options) ? (bool) $options['show_account_actions'] : true;
    $showNotificationDot = !empty($options['show_notification_dot']);
    $profileHref = (string) ($options['profile_href'] ?? 'profile.php');
    $loginHref = (string) ($options['login_href'] ?? 'login.php');
    $signupHref = (string) ($options['signup_href'] ?? 'signup.php');

    $navItems = [
        ['id' => 'home', 'label' => 'Home', 'href' => $homeHref],
        ['id' => 'services', 'label' => 'Services', 'href' => null],
        ['id' => 'locations', 'label' => 'Locations', 'href' => 'locations.php'],
        ['id' => 'about', 'label' => 'About Us', 'href' => null],
    ];
    ?>
<nav class="topbar">
  <div class="topbar-inner">
    <a class="brand-wrap" href="<?= htmlspecialchars($homeHref) ?>">
      <img src="image/Healthquarterlogo.png" class="brand-logo" alt="HealthQuarters">
      <span class="brand-name">HealthQuarters</span>
    </a>

    <div class="topbar-nav">
      <?php foreach ($navItems as $item): ?>
        <?php if ($item['id'] === 'services'): ?>
          <div class="nav-item" id="navServices">
            <button class="nav-btn<?= $active === 'services' ? ' active' : '' ?>" onclick="toggleNav('navServices',event)">
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
        <?php elseif ($item['id'] === 'about'): ?>
          <div class="nav-item" id="navAbout">
            <button class="nav-btn<?= $active === 'about' ? ' active' : '' ?>" onclick="toggleNav('navAbout',event)">
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
        <?php else: ?>
          <div class="nav-item">
            <a class="nav-btn<?= $active === $item['id'] ? ' active' : '' ?>" href="<?= htmlspecialchars((string) $item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <button class="mobile-nav-toggle" type="button" onclick="toggleMobileNav()" aria-label="Open navigation">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>

    <?php if ($showAccountActions): ?>
      <div class="topbar-right">
        <?php if ($isLoggedIn): ?>
          <a href="<?= htmlspecialchars($profileHref) ?>" class="patient-chip">
            <?php if ($showNotificationDot): ?>
              <span class="chip-dot" id="chipDot"></span>
            <?php endif; ?>
            <div class="patient-avatar"><?= htmlspecialchars($initials) ?></div>
            <span class="patient-name"><?= htmlspecialchars($patientName) ?></span>
          </a>
          <a href="logout.php" class="btn-logout">Logout</a>
        <?php else: ?>
          <a href="<?= htmlspecialchars($loginHref) ?>" class="btn-signin">Sign In</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</nav>

<div class="mobile-nav-panel" id="mobileNavPanel">
  <div class="mobile-nav-links">
    <a href="<?= htmlspecialchars($homeHref) ?>">Home</a>
    <a href="service.php">Services</a>
    <a href="home_service_info.php">Home Service</a>
    <a href="corporate_info.php">Corporate Service</a>
    <a href="locations.php">Locations</a>
    <a href="about_us.php">About Us</a>
    <?php if ($showAccountActions): ?>
      <?php if ($isLoggedIn): ?>
        <a href="<?= htmlspecialchars($profileHref) ?>">My Profile</a>
      <?php else: ?>
        <a href="<?= htmlspecialchars($loginHref) ?>">Sign In</a>
        <a href="<?= htmlspecialchars($signupHref) ?>">Create Account</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
    <?php
}

function hq_render_public_nav_script(): void
{
    ?>
function toggleMobileNav() {
  document.getElementById('mobileNavPanel')?.classList.toggle('open');
}
function toggleNav(id, e) {
  e.stopPropagation();
  const item = document.getElementById(id);
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
document.addEventListener('click', () => {
  document.querySelectorAll('.nav-item.open').forEach(el => el.classList.remove('open'));
  document.getElementById('mobileNavPanel')?.classList.remove('open');
});
document.querySelectorAll('.nav-dropdown').forEach(d => d.addEventListener('click', e => e.stopPropagation()));
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
    <?php
}
