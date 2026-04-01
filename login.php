<?php require __DIR__ . '/includes/login/request.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - HealthQuarters</title>
  <?php require __DIR__ . '/partials/auth_assets.php'; ?>

  <style>
    :root {
      --grad-start: #6abf4b;
      --grad-end:   #2dbfb8;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      background: linear-gradient(135deg, var(--grad-start) 0%, var(--grad-end) 100%);
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh; margin: 0;
    }
    .login-card {
      max-width: 420px; width: 100%; padding: 2.5rem;
      background: #fff; border-radius: 20px;
      box-shadow: 0 20px 60px rgba(26,77,46,0.18);
    }
    .login-card h2 {
      font-family: 'DM Serif Display', serif;
      font-size: 1.9rem; color: #1a2e22;
      text-align: center; margin-bottom: 8px;
    }
    .subtitle {
      text-align: center; font-size: 0.85rem;
      color: #94a89d; margin-bottom: 28px;
    }
    .form-label {
      font-size: 0.78rem; font-weight: 600;
      letter-spacing: 0.04em; text-transform: uppercase; color: #1a4d2e;
    }
    .form-control {
      font-family: 'DM Sans', sans-serif; font-size: 0.92rem;
      border: 2px solid #e8eeeb; border-radius: 10px;
      padding: 11px 14px; background: #f7f9f8;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
      border-color: #3aad6e;
      box-shadow: 0 0 0 4px rgba(58,173,110,0.14);
      background: #fff; outline: none;
    }

    /* Password wrapper */
    .pass-wrap { position: relative; }
    .pass-wrap .form-control { padding-right: 46px; }
    .pass-toggle {
      position: absolute; right: 13px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: #94a89d; padding: 0; font-size: 17px; line-height: 1;
      transition: color 0.2s;
    }
    .pass-toggle:hover { color: #2d7a4f; }

    .btn-login {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, var(--grad-start) 0%, var(--grad-end) 100%);
      border: none; border-radius: 50px; color: #fff;
      font-family: 'DM Sans', sans-serif; font-size: 0.95rem;
      font-weight: 600; letter-spacing: 0.03em;
      box-shadow: 0 4px 16px rgba(45,191,184,0.28);
      transition: all 0.22s; cursor: pointer;
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(45,191,184,0.38);
    }
    .forgot-link {
      display: block; text-align: right;
      font-size: 0.8rem; color: #2dbfb8;
      font-weight: 600; text-decoration: none;
      margin-top: -8px; margin-bottom: 20px;
    }
    .forgot-link:hover { text-decoration: underline; }
    .register-link {
      text-align: center; font-size: 0.85rem;
      color: #94a89d; margin-top: 18px;
    }
    .register-link a {
      color: #2dbfb8; font-weight: 600; text-decoration: none;
    }
    .register-link a:hover { text-decoration: underline; }
    .logo-wrap {
      display: flex; justify-content: center; margin-bottom: 20px;
    }
    .logo-wrap img {
      height: 60px; width: 60px; border-radius: 50%;
      border: 2.5px solid #a8e6c1;
      box-shadow: 0 4px 14px rgba(26,77,46,0.15); object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <?php require __DIR__ . '/partials/auth_logo.php'; ?>

    <h2>Welcome Back!</h2>
    <p class="subtitle">Sign in to your HealthQuarters account</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center" style="font-size:0.85rem; border-radius:10px;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <?= hq_csrf_input('login') ?>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" required
               class="form-control" placeholder="Enter your Email">
      </div>

      <div class="mb-1">
        <label for="password" class="form-label">Password</label>
        <div class="pass-wrap">
          <input type="password" name="password" id="password" required
                 class="form-control" placeholder="Enter Password">
          <button type="button" class="pass-toggle" onclick="togglePassword()" tabindex="-1" id="toggleBtn">
            <i class="bi bi-eye" id="toggleIcon"></i>
          </button>
        </div>
      </div>

      <a href="forgot_psword.php" class="forgot-link">Forgot password?</a>

      <button type="submit" class="btn-login">Sign In</button>
    </form>

    <p class="register-link">
      Don't have an account? <a href="signup.php">Register</a>
    </p>

  </div>

  <?php require __DIR__ . '/partials/bootstrap_bundle_532.php'; ?>
  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const icon  = document.getElementById('toggleIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    }
  </script>
</body>
</html>