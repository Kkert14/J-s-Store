<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>J's Store — Sign In</title>
  <link rel="icon" href="<?= base_url('favicon.ico') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body.login-page {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f5f4f0;
      font-family: 'DM Sans', sans-serif;
    }

    /* subtle dot grid background */
    body.login-page::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: radial-gradient(circle, #c8c5bc 1px, transparent 1px);
      background-size: 28px 28px;
      opacity: 0.5;
      pointer-events: none;
    }

    .login-wrap {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }

    /* brand header above card */
    .brand-header {
      text-align: center;
      margin-bottom: 28px;
    }

    .brand-logo {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      object-fit: cover;
      display: inline-block;
      margin-bottom: 12px;
      border: 1px solid #e4e1d8;
    }

    .brand-name {
      display: block;
      font-family: 'DM Serif Display', serif;
      font-size: 26px;
      color: #1a1916;
      letter-spacing: -0.3px;
      line-height: 1;
      margin-bottom: 6px;
    }

    .brand-sub {
      font-size: 13px;
      color: #8c8a82;
      font-weight: 400;
    }

    /* card */
    .login-card {
      background: #ffffff;
      border: 1px solid #e4e1d8;
      border-radius: 18px;
      padding: 32px 30px 28px;
    }

    /* section label */
    .section-label {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #b0ad a5;
      color: #b0ada5;
      margin-bottom: 20px;
    }

    /* alerts */
    .alert-lockout,
    .alert-error {
      padding: 12px 14px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .alert-lockout {
      background: #fef9ec;
      border: 1px solid #f0d98a;
      color: #7a6018;
    }

    .alert-error {
      background: #fef2f2;
      border: 1px solid #fcc;
      color: #991b1b;
    }

    .alert-unlocked {
      background: #f0fdf4;
      border: 1px solid #86efac;
      color: #166534;
    }

    /* field group */
    .field + .field { margin-top: 14px; }

    .field label {
      display: block;
      font-size: 12px;
      font-weight: 500;
      color: #6b6960;
      margin-bottom: 6px;
      letter-spacing: 0.01em;
    }

    .field-input-wrap {
      position: relative;
    }

    .field-input-wrap .field-icon {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: #bbb9b0;
      font-size: 14px;
      pointer-events: none;
    }

    .field input {
      width: 100%;
      height: 42px;
      padding: 0 14px 0 38px;
      background: #fafaf8;
      border: 1px solid #e4e1d8;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: #1a1916;
      transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
      outline: none;
      -webkit-appearance: none;
    }

    .field input::placeholder { color: #c4c1b8; }

    .field input:focus {
      background: #fff;
      border-color: #1a1916;
      box-shadow: 0 0 0 3px rgba(26,25,22,0.07);
    }

    /* divider */
    .row-divider {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 22px;
    }

    /* remember me — override icheck defaults */
    .icheck-dark > input:first-child:checked + label::before,
    .icheck-dark > input:first-child:checked + input[type="hidden"] + label::before {
      background-color: #1a1916;
      border-color: #1a1916;
    }

    .icheck-dark label {
      font-size: 13px;
      color: #6b6960;
      font-family: 'DM Sans', sans-serif;
    }

    /* sign-in button */
    .btn-signin {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 0 20px;
      height: 42px;
      background: #1a1916;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.15s, transform 0.1s;
      white-space: nowrap;
    }

    .btn-signin:hover:not(:disabled) { background: #2d2c29; }
    .btn-signin:active:not(:disabled) { transform: scale(0.98); }
    .btn-signin:disabled { opacity: 0.4; cursor: not-allowed; }

    /* footer */
    .login-footer {
      text-align: center;
      margin-top: 22px;
      font-size: 12px;
      color: #b0ada5;
    }

    @media (max-width: 440px) {
      .login-card { padding: 26px 20px 22px; }
    }
  </style>
</head>

<body class="hold-transition login-page">

  <div class="login-wrap">

    <div class="brand-header">
      <img src="<?= base_url('assets/img/J_icon.png') ?>" class="brand-logo" alt="Ian's Store logo">
      <span class="brand-name">J's Store</span>
      <span class="brand-sub">Point of Sale System</span>
    </div>

    <div class="login-card">

      <?php $lockoutTime = $lockout ?? 0; ?>

      <?php if ($lockoutTime > 0): ?>
        <div class="alert-lockout" id="lockout-alert">
          <strong>Too many attempts.</strong> Please wait <span id="lockout-timer"></span> before trying again.
        </div>
      <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <form action="<?= base_url('/auth') ?>" method="post" autocomplete="on">
        <?= csrf_field() ?>

        <div class="field">
          <label for="name">Name</label>
          <div class="field-input-wrap">
            <i class="fas fa-user field-icon"></i>
            <input type="text"
                   id="name"
                   name="name"
                   placeholder="Your name"
                   autocomplete="name"
                   required>
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="field-input-wrap">
            <i class="fas fa-lock field-icon"></i>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="••••••••"
                   autocomplete="current-password"
                   required>
          </div>
        </div>

        <div class="row-divider">
          <div class="icheck-dark">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>

          <button type="submit"
                  class="btn-signin"
                  id="signInBtn"
                  <?= ($lockoutTime > 0) ? 'disabled' : '' ?>>
            Sign in <i class="fas fa-arrow-right"></i>
          </button>
        </div>

      </form>
    </div>

    <p class="login-footer">J's Store &copy; <?= date('Y') ?></p>

  </div>

  <script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>"></script>

  <?php if ($lockoutTime > 0): ?>
  <script>
    let secondsLeft = <?= $lockoutTime ?>;
    const timerDisplay = document.getElementById('lockout-timer');
    const signInBtn    = document.getElementById('signInBtn');
    const alertBox     = document.getElementById('lockout-alert');

    function updateTimer() {
      if (secondsLeft > 0) {
        let minutes = Math.floor(secondsLeft / 60);
        let seconds = secondsLeft % 60;
        timerDisplay.textContent = minutes + ' min ' + (seconds < 10 ? '0' : '') + seconds + 's';
        secondsLeft--;
        setTimeout(updateTimer, 1000);
      } else {
        signInBtn.disabled = false;
        alertBox.className = 'alert-unlocked';
        alertBox.innerHTML = '<strong>You can now try again.</strong>';
      }
    }

    updateTimer();
  </script>
  <?php endif; ?>

</body>
</html>