<?php require __DIR__ . '/includes/signup/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up — HealthQuarters</title>
  <?php require __DIR__ . '/partials/auth_assets.php'; ?>
  <style>
    :root {
      --grad-start: #6abf4b;
      --grad-end:   #2dbfb8;
      --green-deep: #1a4d2e;
      --green-mid:  #2d7a4f;
      --gray:       #94a89d;
      --gray-200:   #e8eeeb;
    }
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: linear-gradient(135deg, var(--grad-start) 0%, var(--grad-end) 100%);
      display: flex; justify-content: center; align-items: flex-start;
      min-height: 100vh; margin: 0; padding: 32px 16px;
    }
    .signup-card {
      background: #fff; padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(26,77,46,0.18);
      width: 100%; max-width: 440px;
    }
    .logo-wrap { display: flex; justify-content: center; margin-bottom: 18px; }
    .logo-wrap img {
      height: 58px; width: 58px; border-radius: 50%;
      border: 2.5px solid #a8e6c1;
      box-shadow: 0 4px 14px rgba(26,77,46,0.15); object-fit: cover;
    }
    .signup-card h2 {
      font-family: 'DM Serif Display', serif;
      font-size: 1.85rem; color: #1a2e22;
      text-align: center; margin-bottom: 6px;
    }
    .subtitle { text-align: center; font-size: 0.85rem; color: var(--gray); margin-bottom: 26px; }
    .form-label {
      font-size: 0.78rem; font-weight: 600;
      letter-spacing: 0.04em; text-transform: uppercase;
      color: var(--green-deep); margin-bottom: 5px; display: block;
    }
    .form-control, select.form-control {
      font-family: 'DM Sans', sans-serif; font-size: 0.92rem;
      border: 2px solid var(--gray-200); border-radius: 10px;
      padding: 11px 14px; background: #f7f9f8; width: 100%;
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none; appearance: none; -webkit-appearance: none;
    }
    .form-control:focus, select.form-control:focus {
      border-color: #3aad6e;
      box-shadow: 0 0 0 4px rgba(58,173,110,0.14);
      background: #fff;
    }
    select.form-control {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%234a6057' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
    }
    .pass-wrap { position: relative; }
    .pass-wrap .form-control { padding-right: 46px; }
    .pass-toggle {
      position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--gray); padding: 0; font-size: 17px; line-height: 1; transition: color 0.2s;
    }
    .pass-toggle:hover { color: var(--green-mid); }
    .btn-register {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, var(--grad-start) 0%, var(--grad-end) 100%);
      border: none; border-radius: 50px; color: #fff;
      font-family: 'DM Sans', sans-serif; font-size: 0.95rem;
      font-weight: 600; letter-spacing: 0.03em;
      box-shadow: 0 4px 16px rgba(45,191,184,0.28);
      transition: all 0.22s; cursor: pointer; margin-top: 8px;
    }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,191,184,0.38); }
    .btn-register:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    .back-link {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 0.82rem; font-weight: 600; color: var(--gray);
      text-decoration: none; margin-bottom: 18px; transition: color 0.2s;
    }
    .back-link:hover { color: #2dbfb8; }
    .login-link { text-align: center; font-size: 0.85rem; color: var(--gray); margin-top: 16px; }
    .login-link a { color: #2dbfb8; font-weight: 600; text-decoration: none; }
    .login-link a:hover { text-decoration: underline; }
    .alert-err {
      background: #fdecea; color: #c0392b;
      border: 1px solid #f5c6cb; border-radius: 10px;
      padding: 11px 16px; font-size: 0.84rem;
      margin-bottom: 18px; text-align: center;
    }
    .alert-ok {
      background: #e8f7ee; color: #2d7a4f;
      border: 1px solid #a8e6c1; border-radius: 10px;
      padding: 11px 16px; font-size: 0.84rem;
      margin-bottom: 18px; text-align: center;
    }

    /* ── OTP Boxes ── */
    .otp-row { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
    .otp-box {
      width: 48px; height: 56px; text-align: center;
      font-size: 1.4rem; font-weight: 700;
      border: 2px solid var(--gray-200); border-radius: 10px;
      background: #f7f9f8; outline: none;
      font-family: 'DM Sans', sans-serif; color: #1a4d2e;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .otp-box:focus { border-color: #3aad6e; box-shadow: 0 0 0 4px rgba(58,173,110,0.14); background: #fff; }
    .otp-box.filled { border-color: #3aad6e; background: #f0faf4; }
    .otp-box.shake  { animation: shake 0.4s ease; border-color: #e05252 !important; background: #fdecea !important; }
    @keyframes shake {
      0%,100%{transform:translateX(0)}
      20%{transform:translateX(-6px)}
      40%{transform:translateX(6px)}
      60%{transform:translateX(-4px)}
      80%{transform:translateX(4px)}
    }

    /* ── Toast ── */
    .toast-wrap {
      position: fixed; top: 28px; left: 50%;
      transform: translateX(-50%) translateY(-120px);
      z-index: 9999;
      transition: transform 0.45s cubic-bezier(.34,1.56,.64,1);
      pointer-events: none;
    }
    .toast-wrap.show { transform: translateX(-50%) translateY(0); }
    .toast-inner {
      background: #fff; border-radius: 50px;
      padding: 14px 22px 14px 16px;
      box-shadow: 0 12px 40px rgba(26,77,46,0.22), 0 2px 8px rgba(26,77,46,0.1);
      display: flex; align-items: center; gap: 12px;
      min-width: 300px; max-width: 90vw;
      border: 1.5px solid #a8e6c1;
      position: relative; overflow: hidden;
    }
    .toast-icon {
      width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
      background: linear-gradient(135deg, #6abf4b, #2dbfb8);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 12px rgba(45,191,184,0.3);
    }
    .toast-icon svg { width: 18px; height: 18px; stroke: #fff; stroke-width: 2.5; fill: none; }
    .toast-title { font-family: 'DM Serif Display', serif; font-size: 0.95rem; color: #1a2e22; margin-bottom: 1px; }
    .toast-sub { font-size: 0.74rem; color: var(--gray); }
    .toast-progress {
      position: absolute; bottom: 0; left: 0; height: 3px; width: 100%;
      background: linear-gradient(90deg, #6abf4b, #2dbfb8);
      transform-origin: left;
      animation: shrink 2.4s linear forwards;
    }
    @keyframes shrink { from{transform:scaleX(1)} to{transform:scaleX(0)} }

    /* ── Verify screen icon ── */
    .verify-icon {
      width: 68px; height: 68px; border-radius: 50%; margin: 0 auto 16px;
      background: linear-gradient(135deg, #6abf4b, #2dbfb8);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 20px rgba(45,191,184,0.3);
    }
  </style>
</head>
<body>

  <!-- ── Success toast ── -->
  <?php if ($success): ?>
  <div class="toast-wrap" id="successToast">
    <div class="toast-inner">
      <div class="toast-icon">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <div class="toast-title">Account Created!</div>
        <div class="toast-sub">Redirecting you to sign in…</div>
      </div>
      <div class="toast-progress"></div>
    </div>
  </div>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => document.getElementById('successToast').classList.add('show'), 80);
      setTimeout(() => window.location.href = 'login.php', 2500);
    });
  </script>
  <?php endif; ?>


  <?php if ($stage === 'form'): ?>
  <!-- ══════════════════════════════════════
       STAGE 1 — Registration Form
  ══════════════════════════════════════ -->
  <div class="signup-card">
    <?php require __DIR__ . '/partials/auth_logo.php'; ?>
    <h2>Create Account</h2>
    <p class="subtitle">Join HealthQuarters and manage your health with ease</p>
    <a href="lp.php" class="back-link">← Go back</a>

    <?php if (!empty($error)): ?>
      <div class="alert-err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="signupForm">
      <?= hq_csrf_input('signup_send_otp') ?>
      <input type="hidden" name="send_otp" value="1">

      <div class="mb-3">
        <label class="form-label">Full Name <span style="color:#3aad6e;">*</span></label>
        <input type="text" name="fullname" class="form-control"
               placeholder="Enter your full name" required
               value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address <span style="color:#3aad6e;">*</span></label>
        <input type="email" name="email" class="form-control"
               placeholder="Enter your email" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Password <span style="color:#3aad6e;">*</span></label>
        <div class="pass-wrap">
          <input type="password" name="password" id="password"
                 class="form-control" placeholder="Min. 8 characters" required>
          <button type="button" class="pass-toggle" tabindex="-1"
                  onclick="togglePass('password','icon1')">
            <i class="bi bi-eye" id="icon1"></i>
          </button>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password <span style="color:#3aad6e;">*</span></label>
        <div class="pass-wrap">
          <input type="password" name="confirm_password" id="confirm_password"
                 class="form-control" placeholder="Re-enter your password" required
                 oninput="checkMatch()">
          <button type="button" class="pass-toggle" tabindex="-1"
                  onclick="togglePass('confirm_password','icon2')">
            <i class="bi bi-eye" id="icon2"></i>
          </button>
        </div>
        <div id="matchMsg" style="font-size:0.73rem;margin-top:5px;min-height:16px;"></div>
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control"
               placeholder="House no., Street, Barangay, City, Province"
               value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Contact Number <span style="color:#3aad6e;">*</span></label>
        <input type="text" name="contact_number" class="form-control"
               placeholder="09XXXXXXXXX" required
               value="<?= htmlspecialchars($_POST['contact_number'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Date of Birth <span style="color:#3aad6e;">*</span></label>
        <input type="date" name="dob" class="form-control" required
               value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Gender <span style="color:#3aad6e;">*</span></label>
        <select name="gender" class="form-control" required>
          <option value="" disabled <?= empty($_POST['gender']) ? 'selected' : '' ?>>Select gender</option>
          <option value="Male"   <?= ($_POST['gender'] ?? '') === 'Male'   ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= ($_POST['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
        </select>
      </div>

      <button type="submit" class="btn-register" id="submitBtn">
        Continue — Verify Email
      </button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Sign in</a></p>
  </div>


  <?php else: ?>
  <!-- ══════════════════════════════════════
       STAGE 2 — OTP Verification
  ══════════════════════════════════════ -->
  <div class="signup-card" style="max-width:420px;">
    <?php require __DIR__ . '/partials/auth_logo.php'; ?>

    <div class="verify-icon">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
        <rect x="2" y="4" width="20" height="16" rx="2"/>
        <polyline points="2,4 12,13 22,4"/>
      </svg>
    </div>

    <h2 style="text-align:center;margin-bottom:6px;">Check Your Email</h2>
    <p class="subtitle">
      We sent a 6-digit code to<br>
      <strong style="color:#1a4d2e;"><?= htmlspecialchars($pendingEmail) ?></strong>
    </p>

    <?php if (!empty($error)): ?>
      <div class="alert-err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($resendSent): ?>
      <div class="alert-ok">OK A new verification code has been sent to your email.</div>
    <?php endif; ?>

    <form method="POST" id="otpForm">
      <?= hq_csrf_input('signup_verify_otp') ?>
      <input type="hidden" name="verify_otp" value="1">

      <label class="form-label" style="text-align:center;display:block;margin-bottom:14px;">
        Enter Verification Code
      </label>

      <div class="otp-row" id="otpBoxes">
        <?php for ($i = 0; $i < 6; $i++): ?>
          <input type="text" name="otp_digit[]"
                 maxlength="1" inputmode="numeric" pattern="[0-9]"
                 class="otp-box" autocomplete="off">
        <?php endfor; ?>
      </div>

      <!-- Countdown -->
      <p style="text-align:center;font-size:0.82rem;color:#94a89d;margin-bottom:18px;">
        Code expires in <span id="countdown" style="font-weight:700;color:#1a4d2e;">10:00</span>
      </p>

      <button type="submit" class="btn-register" id="verifyBtn">
        Verify &amp; Create Account
      </button>
    </form>

    <p style="text-align:center;margin-top:16px;font-size:0.84rem;color:#94a89d;">
      Didn't receive it?
      <form method="POST" style="display:inline;" id="resendForm">
        <?= hq_csrf_input('signup_resend_otp') ?>
        <input type="hidden" name="resend_otp" value="1">
        <button type="submit" id="resendBtn"
                style="background:none;border:none;color:#2dbfb8;font-size:0.84rem;
                       font-weight:600;cursor:pointer;padding:0;font-family:'DM Sans',sans-serif;">
          Resend code
        </button>
      </form>
    </p>

    <p style="text-align:center;margin-top:10px;">
      <a href="signup.php?reset=1"
         style="font-size:0.8rem;color:#94a89d;text-decoration:none;">
        ← Use a different email
      </a>
    </p>
  </div>

  <script>
    /* ── OTP box behaviour ── */
    const boxes = document.querySelectorAll('.otp-box');

    boxes.forEach((box, idx) => {
      // Auto-advance on valid digit
      box.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;
        if (val) {
          e.target.classList.add('filled');
          if (idx < 5) boxes[idx + 1].focus();
        } else {
          e.target.classList.remove('filled');
        }
      });

      // Backspace goes to previous box
      box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && idx > 0) boxes[idx - 1].focus();
        if (e.key === 'ArrowLeft'  && idx > 0) { e.preventDefault(); boxes[idx - 1].focus(); }
        if (e.key === 'ArrowRight' && idx < 5) { e.preventDefault(); boxes[idx + 1].focus(); }
      });

      // Paste — fill all boxes from clipboard
      box.addEventListener('paste', e => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData)
          .getData('text').replace(/\D/g, '').slice(0, 6);
        pasted.split('').forEach((ch, i) => {
          if (boxes[i]) { boxes[i].value = ch; boxes[i].classList.add('filled'); }
        });
        const nextFocus = Math.min(pasted.length, 5);
        boxes[nextFocus].focus();
      });
    });

    // Focus first box on load
    boxes[0].focus();

    /* ── OTP form submission ── */
    document.getElementById('otpForm').addEventListener('submit', function(e) {
      const code = [...boxes].map(b => b.value).join('');
      if (code.length < 6 || !/^\d{6}$/.test(code)) {
        e.preventDefault();
        boxes.forEach(b => { b.classList.add('shake'); b.classList.remove('filled'); });
        boxes.forEach(b => b.addEventListener('animationend', () => b.classList.remove('shake'), { once: true }));
        boxes[0].focus();
        return;
      }
      document.getElementById('verifyBtn').disabled = true;
      document.getElementById('verifyBtn').textContent = 'Verifying…';
    });

    /* ── Resend button cooldown ── */
    document.getElementById('resendForm').addEventListener('submit', function() {
      const btn = document.getElementById('resendBtn');
      btn.disabled = true;
      btn.textContent = 'Sending…';
    });

    /* ── Countdown timer ── */
    let seconds = 600;
    const countdownEl = document.getElementById('countdown');
    const verifyBtn   = document.getElementById('verifyBtn');

    const tick = setInterval(() => {
      seconds--;
      if (seconds <= 0) {
        clearInterval(tick);
        countdownEl.textContent = 'Expired';
        countdownEl.style.color = '#e05252';
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Code Expired — Resend to continue';
        return;
      }
      const m = Math.floor(seconds / 60);
      const s = seconds % 60;
      countdownEl.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }, 1000);
  </script>
  <?php endif; ?>

  <?php require __DIR__ . '/partials/bootstrap_bundle_532.php'; ?>
  <script>
    function togglePass(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    }
    function checkMatch() {
      const p1  = document.getElementById('password')?.value;
      const p2  = document.getElementById('confirm_password')?.value;
      const msg = document.getElementById('matchMsg');
      if (!msg || p2 === undefined) return;
      msg.innerHTML = p1 === p2
        ? '<span style="color:#3aad6e;">OK Passwords match</span>'
        : '<span style="color:#ef4444;">NO Passwords do not match</span>';
    }
    document.getElementById('signupForm')?.addEventListener('submit', function() {
      const btn = document.getElementById('submitBtn');
      btn.disabled = true;
      btn.textContent = 'Sending verification code…';
    });
  </script>
</body>
</html>