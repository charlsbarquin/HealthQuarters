<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
include 'db.php';
require_once __DIR__ . '/services/mail_service.php';
hq_boot_session_security();

/*
 * ─────────────────────────────────────────────────────────────
 *  SETUP — Edit these before going live
 * ─────────────────────────────────────────────────────────────
 *  1. Install PHPMailer:  composer require phpmailer/phpmailer
 *     OR download from:   github.com/PHPMailer/PHPMailer
 *     and place in a /PHPMailer/ folder next to this file.
 *
 *  2. Fill in your Gmail credentials below.
 *     Use an App Password (not your real Gmail password):
 *     myaccount.google.com → Security → App Passwords
 * ─────────────────────────────────────────────────────────────
 */
define('OTP_EXPIRY',    10);                        // minutes before OTP expires

/*
 * Step flow:
 *  step 1  →  Enter email
 *  step 2  →  Enter OTP sent to email
 *  step 3  →  Set new password
 *  done    →  Success
 *
 * Session keys:
 *  fp_user_id   — verified user id
 *  fp_email     — email the OTP was sent to
 *  fp_otp       — hashed OTP
 *  fp_otp_exp   — OTP expiry timestamp
 *  fp_verified  — true after OTP passes
 *  fp_step      — current step
 */

$step  = $_SESSION['fp_step'] ?? 1;
$error = '';
$done  = false;
$info  = '';

// ── Helper: send OTP email ────────────────────────────────────
function sendOtpEmail(string $toEmail, string $toName, string $otp): bool {
    $htmlBody = "
        <div style='font-family:DM Sans,sans-serif;max-width:480px;margin:auto;padding:32px;background:#fff;border-radius:16px;border:1px solid #e8eeeb;'>
          <div style='text-align:center;margin-bottom:24px;'>
            <div style='display:inline-block;background:linear-gradient(135deg,#6abf4b,#2dbfb8);border-radius:50%;width:56px;height:56px;line-height:56px;font-size:24px;color:#fff;'>KEY</div>
          </div>
          <h2 style='font-family:serif;color:#1a2e22;text-align:center;margin:0 0 8px;'>Password Reset OTP</h2>
          <p style='color:#94a89d;text-align:center;font-size:14px;margin:0 0 28px;'>Hi {$toName}, use the code below to reset your password.</p>
          <div style='background:#f0faf4;border-radius:12px;padding:20px;text-align:center;margin-bottom:24px;'>
            <span style='font-size:36px;font-weight:800;letter-spacing:10px;color:#1a4d2e;'>{$otp}</span>
          </div>
          <p style='color:#94a89d;font-size:13px;text-align:center;margin:0;'>
            This code expires in <strong>" . OTP_EXPIRY . " minutes</strong>.<br>
            If you did not request this, please ignore this email.
          </p>
        </div>";
    $altBody = "Your HealthQuarters password reset OTP is: {$otp}. It expires in " . OTP_EXPIRY . " minutes.";

    return hq_send_mail_with_profile(
        'forgot_password',
        $toEmail,
        $toName,
        'Your HealthQuarters Password Reset OTP',
        $htmlBody,
        $altBody
    ) === true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    hq_require_csrf('forgot_password_' . (string) $_POST['action']);

    // ── STEP 1: Find account & send OTP ──────────────────────
    if ($_POST['action'] === 'send_otp') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        try {
            $stmt = $conn->prepare("SELECT user_id, fullname FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $error = "No account found with that email address.";
            } else {
                // Generate 6-digit OTP
                $otp    = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $sent   = sendOtpEmail($email, $user['fullname'], $otp);

                if (!$sent) {
                    $error = "Failed to send OTP email. Please check your mail configuration.";
                } else {
                    $_SESSION['fp_user_id'] = $user['user_id'];
                    $_SESSION['fp_email']   = $email;
                    $_SESSION['fp_name']    = $user['fullname'];
                    $_SESSION['fp_otp']     = password_hash($otp, PASSWORD_DEFAULT);
                    $_SESSION['fp_otp_exp'] = time() + (OTP_EXPIRY * 60);
                    $_SESSION['fp_step']    = 2;
                    header("Location: forgot_password.php");
                    exit;
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }

    // ── STEP 2: Verify OTP ────────────────────────────────────
    elseif ($_POST['action'] === 'verify_otp') {
        $entered = trim(str_replace(' ', '', $_POST['otp'] ?? ''));

        if (empty($_SESSION['fp_otp']) || empty($_SESSION['fp_otp_exp'])) {
            $error = "Session expired. Please start over.";
            unset($_SESSION['fp_step']);
            $step = 1;
        } elseif (time() > $_SESSION['fp_otp_exp']) {
            $error = "Your OTP has expired. Please request a new one.";
            unset($_SESSION['fp_otp'], $_SESSION['fp_otp_exp'], $_SESSION['fp_step']);
            $step = 1;
        } elseif (!password_verify($entered, $_SESSION['fp_otp'])) {
            $error = "Incorrect OTP. Please try again.";
            $step  = 2;
        } else {
            // OTP correct — clear it and advance
            unset($_SESSION['fp_otp'], $_SESSION['fp_otp_exp']);
            $_SESSION['fp_verified'] = true;
            $_SESSION['fp_step']     = 3;
            header("Location: forgot_password.php");
            exit;
        }
    }

    // ── Resend OTP ────────────────────────────────────────────
    elseif ($_POST['action'] === 'resend_otp') {
        if (!empty($_SESSION['fp_user_id']) && !empty($_SESSION['fp_email'])) {
            $otp  = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $sent = sendOtpEmail($_SESSION['fp_email'], $_SESSION['fp_name'] ?? '', $otp);

            if ($sent) {
                $_SESSION['fp_otp']     = password_hash($otp, PASSWORD_DEFAULT);
                $_SESSION['fp_otp_exp'] = time() + (OTP_EXPIRY * 60);
                $_SESSION['fp_step']    = 2;
                $info = "A new OTP has been sent to your email.";
                $step = 2;
            } else {
                $error = "Failed to resend OTP. Please try again.";
                $step  = 2;
            }
        } else {
            header("Location: forgot_password.php?restart=1");
            exit;
        }
    }

    // ── STEP 3: Save new password ─────────────────────────────
    elseif ($_POST['action'] === 'reset_password') {
        if (empty($_SESSION['fp_verified'])) {
            header("Location: forgot_password.php");
            exit;
        }

        $newPass  = $_POST['new_password']     ?? '';
        $confPass = $_POST['confirm_password'] ?? '';

        if (strlen($newPass) < 8) {
            $error = "Password must be at least 8 characters.";
            $step  = 3;
        } elseif ($newPass !== $confPass) {
            $error = "Passwords do not match.";
            $step  = 3;
        } else {
            try {
                $hashed = password_hash($newPass, PASSWORD_DEFAULT);
                $stmt   = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
                $stmt->execute([$hashed, $_SESSION['fp_user_id']]);

                unset($_SESSION['fp_user_id'], $_SESSION['fp_email'], $_SESSION['fp_name'],
                      $_SESSION['fp_verified'], $_SESSION['fp_step']);
                $done = true;
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
                $step  = 3;
            }
        }
    }
}

// GET handling
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['restart'])) {
        unset($_SESSION['fp_user_id'], $_SESSION['fp_email'], $_SESSION['fp_name'],
              $_SESSION['fp_otp'],    $_SESSION['fp_otp_exp'], $_SESSION['fp_verified'],
              $_SESSION['fp_step']);
        header("Location: forgot_password.php");
        exit;
    }
    $step = $_SESSION['fp_step'] ?? 1;
}

// Mask email for display  e.g.  j***@gmail.com
function maskEmail(string $email): string {
    [$local, $domain] = explode('@', $email);
    return substr($local, 0, 1) . str_repeat('*', max(2, strlen($local) - 1)) . '@' . $domain;
}
$maskedEmail = isset($_SESSION['fp_email']) ? maskEmail($_SESSION['fp_email']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - HealthQuarters</title>
  <?php require __DIR__ . '/partials/auth_assets.php'; ?>
  <style>
    :root {
      --grad-start: #6abf4b;
      --grad-end:   #2dbfb8;
      --green-deep: #1a4d2e;
      --green-mid:  #2d7a4f;
      --green-pale: #e8f7ee;
      --gray:       #94a89d;
      --gray-200:   #e8eeeb;
    }
    *, *::before, *::after { box-sizing:border-box; }
    body {
      font-family:'DM Sans',sans-serif;
      background:linear-gradient(135deg,var(--grad-start) 0%,var(--grad-end) 100%);
      display:flex; justify-content:center; align-items:center;
      min-height:100vh; margin:0; padding:20px;
    }
    .card {
      max-width:440px; width:100%; padding:2.5rem;
      background:#fff; border-radius:20px; border:none;
      box-shadow:0 20px 60px rgba(26,77,46,0.18);
      animation:fadeUp 0.35s ease;
    }
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(16px); }
      to   { opacity:1; transform:translateY(0); }
    }

    /* Logo */
    .logo-wrap { display:flex; justify-content:center; margin-bottom:20px; }
    .logo-wrap img {
      height:60px; width:60px; border-radius:50%;
      border:2.5px solid #a8e6c1;
      box-shadow:0 4px 14px rgba(26,77,46,0.15); object-fit:cover;
    }

    /* Step progress */
    .steps-outer { margin-bottom:36px; }
    .steps { display:flex; align-items:flex-start; justify-content:center; }
    .step-item { display:flex; flex-direction:column; align-items:center; gap:6px; }
    .step-dot {
      width:34px; height:34px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      font-size:0.8rem; font-weight:700;
      background:var(--gray-200); color:var(--gray);
      transition:all 0.3s; flex-shrink:0;
    }
    .step-dot.active {
      background:linear-gradient(135deg,var(--grad-start),var(--grad-end));
      color:#fff; box-shadow:0 3px 12px rgba(45,191,184,0.4);
    }
    .step-dot.done { background:var(--green-pale); color:#3aad6e; }
    .step-lbl {
      font-size:0.62rem; font-weight:700; text-transform:uppercase;
      letter-spacing:0.06em; color:var(--gray); white-space:nowrap;
    }
    .step-dot.active + .step-lbl,
    .step-item:has(.step-dot.active) .step-lbl { color:var(--green-mid); }
    .step-line {
      flex:1; height:2px; background:var(--gray-200);
      max-width:72px; margin-top:17px; transition:background 0.4s;
    }
    .step-line.done {
      background:linear-gradient(to right,var(--grad-start),var(--grad-end));
    }

    /* Headings */
    h2 {
      font-family:'DM Serif Display',serif;
      font-size:1.75rem; color:#1a2e22;
      text-align:center; margin-bottom:6px;
    }
    .subtitle {
      text-align:center; font-size:0.85rem;
      color:var(--gray); margin-bottom:24px; line-height:1.55;
    }
    .subtitle strong { color:var(--green-deep); }

    /* Form */
    .form-label {
      font-size:0.75rem; font-weight:700;
      letter-spacing:0.05em; text-transform:uppercase;
      color:var(--green-deep); margin-bottom:6px; display:block;
    }
    .form-control {
      font-family:'DM Sans',sans-serif; font-size:0.92rem;
      border:2px solid var(--gray-200); border-radius:10px;
      padding:11px 14px; background:#f7f9f8; width:100%;
      transition:border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
      border-color:#3aad6e;
      box-shadow:0 0 0 4px rgba(58,173,110,0.14);
      background:#fff; outline:none;
    }

    /* OTP input group */
    .otp-group {
      display:flex; gap:10px; justify-content:center; margin-bottom:6px;
    }
    .otp-digit {
      width:48px; height:56px; text-align:center;
      font-size:1.4rem; font-weight:700; color:var(--green-deep);
      border:2px solid var(--gray-200); border-radius:10px;
      background:#f7f9f8; outline:none; transition:border-color 0.2s, box-shadow 0.2s;
      caret-color:transparent;
    }
    .otp-digit:focus {
      border-color:#3aad6e;
      box-shadow:0 0 0 4px rgba(58,173,110,0.14);
      background:#fff;
    }
    .otp-digit.filled { border-color:#3aad6e; background:#f0faf4; }
    /* Hidden real input for form submission */
    #otpHidden { display:none; }

    /* Countdown */
    .otp-footer {
      display:flex; justify-content:space-between;
      align-items:center; margin-top:10px; font-size:0.8rem;
    }
    .countdown { color:var(--gray); }
    .countdown span { color:var(--green-mid); font-weight:700; }
    .resend-btn {
      background:none; border:none; cursor:pointer;
      color:#2dbfb8; font-weight:700; font-size:0.8rem;
      padding:0; font-family:'DM Sans',sans-serif;
      transition:opacity 0.2s;
    }
    .resend-btn:disabled { color:var(--gray); cursor:not-allowed; }

    /* Password wrapper */
    .pass-wrap { position:relative; }
    .pass-wrap .form-control { padding-right:46px; }
    .pass-toggle {
      position:absolute; right:13px; top:50%; transform:translateY(-50%);
      background:none; border:none; cursor:pointer;
      color:var(--gray); padding:0; font-size:17px; line-height:1;
      transition:color 0.2s;
    }
    .pass-toggle:hover { color:var(--green-mid); }

    /* Strength meter */
    .strength-wrap { margin-top:8px; }
    .strength-bar { height:4px; border-radius:2px; background:var(--gray-200); overflow:hidden; margin-bottom:5px; }
    .strength-fill { height:100%; border-radius:2px; width:0%; transition:width 0.35s, background 0.35s; }
    .strength-label { font-size:0.72rem; color:var(--gray); }
    .match-msg { font-size:0.73rem; margin-top:5px; min-height:16px; }

    /* Buttons */
    .btn-grad {
      width:100%; padding:13px;
      background:linear-gradient(135deg,var(--grad-start) 0%,var(--grad-end) 100%);
      border:none; border-radius:50px; color:#fff;
      font-family:'DM Sans',sans-serif; font-size:0.95rem;
      font-weight:600; letter-spacing:0.03em;
      box-shadow:0 4px 16px rgba(45,191,184,0.28);
      transition:all 0.22s; cursor:pointer; margin-top:6px;
    }
    .btn-grad:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(45,191,184,0.38); }

    /* Alerts */
    .alert-err {
      background:#fdecea; color:#c0392b;
      border:1px solid #f5c6cb; border-radius:10px;
      padding:11px 16px; font-size:0.84rem;
      margin-bottom:18px; text-align:center;
    }
    .alert-info {
      background:var(--green-pale); color:var(--green-mid);
      border:1px solid #a8e6c1; border-radius:10px;
      padding:11px 16px; font-size:0.84rem;
      margin-bottom:18px; text-align:center;
    }

    /* Footer link */
    .foot-link { text-align:center; font-size:0.84rem; color:var(--gray); margin-top:18px; }
    .foot-link a { color:#2dbfb8; font-weight:600; text-decoration:none; }
    .foot-link a:hover { text-decoration:underline; }

    /* Success */
    .success-icon {
      width:74px; height:74px; border-radius:50%;
      background:linear-gradient(135deg,var(--grad-start),var(--grad-end));
      display:flex; align-items:center; justify-content:center;
      margin:0 auto 20px; font-size:32px; color:#fff;
      box-shadow:0 6px 22px rgba(45,191,184,0.38);
    }
  </style>
</head>
<body>
<div class="card">
  <?php require __DIR__ . '/partials/auth_logo.php'; ?>

  <?php if ($done): ?>
  <!-- ══════════════════ SUCCESS ══════════════════ -->
  <div class="success-icon">OK</div>
  <h2>Password Updated!</h2>
  <p class="subtitle">Your password has been changed successfully.<br>You can now sign in with your new password.</p>
  <a href="login.php" class="btn-grad" style="display:block;text-align:center;text-decoration:none;line-height:1.6;">
    Back to Sign In
  </a>

  <?php else: ?>

  <!-- Step progress bar -->
  <div class="steps-outer">
    <div class="steps">
      <div class="step-item">
        <div class="step-dot <?= $step === 1 ? 'active' : 'done' ?>"><?= $step === 1 ? '1' : 'OK' ?></div>
        <span class="step-lbl">Email</span>
      </div>
      <div class="step-line <?= $step > 1 ? 'done' : '' ?>"></div>
      <div class="step-item">
        <div class="step-dot <?= $step === 2 ? 'active' : ($step > 2 ? 'done' : '') ?>">
          <?= $step > 2 ? 'OK' : '2' ?>
        </div>
        <span class="step-lbl">OTP</span>
      </div>
      <div class="step-line <?= $step > 2 ? 'done' : '' ?>"></div>
      <div class="step-item">
        <div class="step-dot <?= $step === 3 ? 'active' : '' ?>">3</div>
        <span class="step-lbl">New Password</span>
      </div>
    </div>
  </div>

  <?php if (!empty($error)): ?>
    <div class="alert-err"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if (!empty($info)): ?>
    <div class="alert-info"><?= htmlspecialchars($info) ?></div>
  <?php endif; ?>


  <?php if ($step === 1): ?>
  <!-- ══════════════════ STEP 1: Enter Email ══════════════════ -->
  <h2>Forgot Password?</h2>
  <p class="subtitle">Enter your registered email address and we'll send you a one-time code.</p>

  <form method="POST">
    <?= hq_csrf_input('forgot_password_send_otp') ?>
    <input type="hidden" name="action" value="send_otp">
    <div class="mb-4">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" name="email" id="email" required
             class="form-control" placeholder="you@email.com"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>
    <button type="submit" class="btn-grad">Send OTP</button>
  </form>

  <p class="foot-link">Remember your password? <a href="login.php">Sign In</a></p>


  <?php elseif ($step === 2): ?>
  <!-- ══════════════════ STEP 2: Enter OTP ══════════════════ -->
  <h2>Check Your Email</h2>
  <p class="subtitle">
    We sent a 6-digit code to<br>
    <strong><?= htmlspecialchars($maskedEmail) ?></strong>
  </p>

  <form method="POST" id="otpForm">
    <?= hq_csrf_input('forgot_password_verify_otp') ?>
    <input type="hidden" name="action" value="verify_otp">
    <input type="hidden" name="otp" id="otpHidden">

    <div class="otp-group" id="otpGroup">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      <input class="otp-digit" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
    </div>

    <div class="otp-footer">
      <span class="countdown">Expires in <span id="countdownTimer"><?= OTP_EXPIRY ?>:00</span></span>
      <button type="button" class="resend-btn" id="resendBtn" disabled onclick="resendOtp()">Resend OTP</button>
    </div>

    <button type="submit" class="btn-grad" style="margin-top:20px;">Verify OTP</button>
  </form>

  <p class="foot-link"><a href="forgot_password.php?restart=1">← Start over</a></p>


  <?php elseif ($step === 3): ?>
  <!-- ══════════════════ STEP 3: New Password ══════════════════ -->
  <h2>New Password</h2>
  <p class="subtitle">Choose a strong new password for your account.</p>

  <form method="POST">
    <?= hq_csrf_input('forgot_password_reset_password') ?>
    <input type="hidden" name="action" value="reset_password">

    <div class="mb-3">
      <label for="new_password" class="form-label">New Password</label>
      <div class="pass-wrap">
        <input type="password" name="new_password" id="new_password" required
               class="form-control" placeholder="Min. 8 characters"
               oninput="checkStrength(this.value)">
        <button type="button" class="pass-toggle" onclick="togglePass('new_password',this)" tabindex="-1">Show</button>
      </div>
      <div class="strength-wrap">
        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
        <div class="strength-label" id="strengthLabel">Enter a password</div>
      </div>
    </div>

    <div class="mb-4">
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <div class="pass-wrap">
        <input type="password" name="confirm_password" id="confirm_password" required
               class="form-control" placeholder="Re-enter your password"
               oninput="checkMatch()">
        <button type="button" class="pass-toggle" onclick="togglePass('confirm_password',this)" tabindex="-1">Show</button>
      </div>
      <div class="match-msg" id="matchMsg"></div>
    </div>

    <button type="submit" class="btn-grad">Update Password</button>
  </form>

  <p class="foot-link"><a href="forgot_password.php?restart=1">← Start over</a></p>

  <?php endif; ?>
  <?php endif; ?>

</div>

<?php require __DIR__ . '/partials/bootstrap_bundle_532.php'; ?>
<script>
const forgotPasswordResendCsrf = <?= json_encode(hq_csrf_token('forgot_password_resend_otp')) ?>;
// ── Resend OTP via fetch (avoids nested form bug) ────────────
function resendOtp() {
  const btn = document.getElementById('resendBtn');
  if (btn) { btn.disabled = true; btn.textContent = 'Sending...'; }

  fetch('forgot_password.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=resend_otp&_csrf=' + encodeURIComponent(forgotPasswordResendCsrf)
  })
  .then(r => r.text())
  .then(() => {
    // Reload the page to show the info message and reset the timer
    window.location.href = 'forgot_password.php';
  })
  .catch(() => {
    if (btn) { btn.disabled = false; btn.textContent = 'Resend OTP'; }
    alert('Failed to resend OTP. Please try again.');
  });
}

// ── OTP digit boxes ───────────────────────────────────────────
const digits   = document.querySelectorAll('.otp-digit');
const otpHidden = document.getElementById('otpHidden');

digits.forEach((box, i) => {
  box.addEventListener('input', e => {
    const val = e.target.value.replace(/\D/g,'');
    e.target.value = val;
    if (val && i < digits.length - 1) digits[i + 1].focus();
    syncOtp();
    updateFilled();
  });
  box.addEventListener('keydown', e => {
    if (e.key === 'Backspace' && !box.value && i > 0) {
      digits[i - 1].focus();
      digits[i - 1].value = '';
      syncOtp();
      updateFilled();
    }
  });
  box.addEventListener('paste', e => {
    e.preventDefault();
    const paste = (e.clipboardData || window.clipboardData)
                  .getData('text').replace(/\D/g,'').slice(0, 6);
    paste.split('').forEach((ch, j) => {
      if (digits[j]) digits[j].value = ch;
    });
    digits[Math.min(paste.length, digits.length - 1)].focus();
    syncOtp();
    updateFilled();
  });
});

function syncOtp() {
  if (otpHidden) otpHidden.value = [...digits].map(d => d.value).join('');
}
function updateFilled() {
  digits.forEach(d => d.classList.toggle('filled', d.value !== ''));
}

// Auto-submit when all 6 filled
function checkAutoSubmit() {
  if ([...digits].every(d => d.value !== '')) {
    syncOtp();
    document.getElementById('otpForm')?.submit();
  }
}
digits.forEach(d => d.addEventListener('input', checkAutoSubmit));

// Focus first box on load
if (digits.length) digits[0].focus();

// ── Countdown timer ───────────────────────────────────────────
const timerEl   = document.getElementById('countdownTimer');
const resendBtn = document.getElementById('resendBtn');

if (timerEl) {
  let totalSec = <?= OTP_EXPIRY ?> * 60;

  const tick = setInterval(() => {
    totalSec--;
    if (totalSec <= 0) {
      clearInterval(tick);
      timerEl.textContent = '0:00';
      if (resendBtn) resendBtn.disabled = false;
      return;
    }
    const m = Math.floor(totalSec / 60);
    const s = String(totalSec % 60).padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;

    // Enable resend after 60s
    if (totalSec <= (<?= OTP_EXPIRY ?> * 60 - 60) && resendBtn) {
      resendBtn.disabled = false;
    }
  }, 1000);
}

// ── Password strength meter ───────────────────────────────────
function checkStrength(val) {
  const fill  = document.getElementById('strengthFill');
  const label = document.getElementById('strengthLabel');
  if (!fill) return;
  let score = 0;
  if (val.length >= 8)           score++;
  if (/[A-Z]/.test(val))         score++;
  if (/[0-9]/.test(val))         score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [
    { pct:'25%',  color:'#ef4444', text:'Weak'   },
    { pct:'50%',  color:'#f5c842', text:'Fair'   },
    { pct:'75%',  color:'#6abf4b', text:'Good'   },
    { pct:'100%', color:'#2dbfb8', text:'Strong' },
  ];
  const lvl = score > 0 ? levels[score-1] : { pct:'0%', color:'#e8eeeb', text:'Enter a password' };
  fill.style.width = lvl.pct; fill.style.background = lvl.color;
  label.textContent = lvl.text; label.style.color = lvl.color;
}

// ── Confirm match ─────────────────────────────────────────────
function checkMatch() {
  const p1  = document.getElementById('new_password')?.value     || '';
  const p2  = document.getElementById('confirm_password')?.value || '';
  const msg = document.getElementById('matchMsg');
  if (!msg || !p2) { if (msg) msg.innerHTML=''; return; }
  msg.innerHTML = p1 === p2
    ? '<span style="color:#3aad6e;">OK Passwords match</span>'
    : '<span style="color:#ef4444;">NO Passwords do not match</span>';
}

// ── Toggle password visibility ────────────────────────────────
function togglePass(id, btn) {
  const input = document.getElementById(id);
  if (!input) return;
  input.type = input.type === 'password' ? 'text' : 'password';
  btn.textContent = input.type === 'password' ? 'Show' : 'Hide';
}
</script>
</body>
</html>