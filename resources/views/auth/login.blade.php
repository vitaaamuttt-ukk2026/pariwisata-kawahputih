<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login {{ ucfirst($role ?? 'Admin') }} - Kawah Putih</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 50%, #6ee7b7 100%);
      position: relative;
      overflow: hidden;
    }

    .bg-gradient {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: 
        radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.1) 0%, transparent 50%);
      animation: bgMove 20s ease-in-out infinite;
    }

    @keyframes bgMove {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(-20px, -20px) scale(1.05); }
    }

    .card {
      width: 100%;
      max-width: 420px;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 24px;
      padding: 40px 36px 32px;
      box-shadow: 0 20px 60px rgba(5, 150, 105, 0.12);
      border: 1px solid rgba(255, 255, 255, 0.6);
      position: relative;
      z-index: 1;
      animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo-container { text-align: center; margin-bottom: 28px; }

    .logo {
      width: 90px; height: 90px;
      margin: 0 auto 16px;
      background: #fff;
      border-radius: 20px;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.1);
      transition: transform 0.3s ease;
    }
    .logo:hover { transform: scale(1.03); }

    h1 { font-size: 26px; font-weight: 800; color: #064e3b; margin-bottom: 6px; }
    .subtitle { font-size: 14px; color: #059669; font-weight: 600; }

    form { margin-top: 28px; }
    .field { margin-bottom: 20px; }

    label {
      display: block; font-size: 12px; font-weight: 700; color: #065f46;
      margin-bottom: 6px; letter-spacing: 0.5px; text-transform: uppercase;
    }

    .input-wrap {
      position: relative; display: flex; align-items: center;
      background: #fff; border: 2px solid #d1fae5; height: 48px;
      padding: 0 14px; gap: 10px; border-radius: 12px; transition: all 0.3s ease;
    }
    .input-wrap:focus-within {
      border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1); transform: translateY(-1px);
    }
    .input-wrap.error { border-color: #f87171; background: #fef2f2; }

    .input-wrap .material-icons-round { font-size: 18px; color: #6ee7b7; flex-shrink: 0; }
    .input-wrap input {
      flex: 1; border: none; outline: none; background: transparent;
      font-size: 14px; font-family: inherit; color: #064e3b; font-weight: 500;
    }
    .input-wrap input::placeholder { color: #99f6e4; }

    .toggle-pass {
      background: none; border: none; cursor: pointer; padding: 4px;
      color: #6ee7b7; transition: all 0.2s; border-radius: 6px;
    }
    .toggle-pass:hover { background: #ecfdf5; color: #059669; }
    .toggle-pass .material-icons-round { font-size: 18px; }

    .error-msg { color: #dc2626; font-size: 12px; margin-top: 6px; font-weight: 600; }

    .options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 13px; }
    .remember-me { display: flex; align-items: center; gap: 6px; cursor: pointer; color: #065f46; font-weight: 500; }
    .remember-me input[type="checkbox"] { width: 15px; height: 15px; accent-color: #10b981; cursor: pointer; }
    .forgot-link { color: #059669; text-decoration: none; font-weight: 600; transition: color 0.2s; }
    .forgot-link:hover { color: #047857; text-decoration: underline; }

    .btn-login {
      width: 100%; height: 50px;
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff; border: none; font-size: 15px; font-weight: 700;
      cursor: pointer; border-radius: 12px; transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .btn-login:hover {
      transform: translateY(-2px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }
    .btn-login:active { transform: translateY(0); }
    .btn-login:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    .alert {
      padding: 14px; margin-bottom: 20px; border-radius: 12px;
      font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 10px;
      animation: slideDown 0.4s ease-out;
    }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; }
    .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
    .alert .material-icons-round { font-size: 20px; flex-shrink: 0; }

    .footer { margin-top: 28px; text-align: center; padding-top: 20px; border-top: 1px solid #d1fae5; }
    .footer p { font-size: 12px; color: #065f46; margin-bottom: 6px; }
    .footer a { color: #059669; text-decoration: none; font-weight: 700; transition: color 0.2s; }
    .footer a:hover { color: #047857; text-decoration: underline; }
    .footer .copyright { font-size: 11px; color: #34d399; margin-top: 8px; }

    @media (max-width: 560px) {
      .card { padding: 36px 24px 28px; border-radius: 16px; }
      h1 { font-size: 22px; }
      .logo { width: 80px; height: 80px; }
    }
  </style>
</head>
<body>
  <div class="bg-gradient"></div>

  @php
    $currentRole = $role ?? request()->route('role') ?? 'admin';
  @endphp

  <main class="card">
    <div class="logo-container">
      <div class="logo">
        <!-- LOGO KAWAH PUTIH ASLI -->
        <svg viewBox="0 0 100 100" width="60" height="60" aria-label="Kawah Putih">
          <circle cx="50" cy="40" r="28" fill="#10b981"/>
          <path d="M22 48 Q50 28 78 48 L78 52 Q50 62 22 52Z" fill="#6ee7b7"/>
          <circle cx="50" cy="42" r="8" fill="#fff"/>
          <text x="50" y="88" text-anchor="middle" font-size="11" font-weight="800" fill="#064e3b" font-family="Plus Jakarta Sans, sans-serif">KAWAH PUTIH</text>
        </svg>
      </div>
      <h1>Selamat Datang</h1>
      <p class="subtitle">Sistem Manajemen {{ ucfirst($currentRole) }}</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success" role="alert">
        <span class="material-icons-round">check_circle</span>
        {{ session('success') }}
      </div>
    @endif

    @if(session('error') || $errors->any())
      <div class="alert alert-error" role="alert">
        <span class="material-icons-round">error</span>
        {{ session('error') ?? $errors->first() }}
      </div>
    @endif

    <form id="loginForm" action="{{ route('panel.login.post', $currentRole) }}" method="POST" novalidate>
      @csrf

      <div class="field">
        <label for="email">Email Address</label>
        <div class="input-wrap {{ $errors->has('email') ? 'error' : '' }}">
          <span class="material-icons-round">email</span>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ $currentRole }}@kawahputih.test" autocomplete="email" required>
        </div>
        @if($errors->has('email'))
          <div class="error-msg">{{ $errors->first('email') }}</div>
        @endif
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap {{ $errors->has('password') ? 'error' : '' }}">
          <span class="material-icons-round">lock</span>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required minlength="6">
          <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password">
            <span class="material-icons-round">visibility</span>
          </button>
        </div>
        @if($errors->has('password'))
          <div class="error-msg">{{ $errors->first('password') }}</div>
        @endif
      </div>

      <div class="options">
        <label class="remember-me">
          <input type="checkbox" name="remember" id="remember">
          <span>Ingat saya</span>
        </label>
        <a href="#" class="forgot-link">Lupa password?</a>
      </div>

      <button type="submit" class="btn-login" id="btnLogin">Masuk ke Dashboard</button>
    </form>

    <div class="footer">
      <p>Kembali ke <a href="{{ route('pengunjung.dashboard') }}">Portal Wisatawan</a></p>
      <p class="copyright">© <span id="year"></span> Kawah Putih Ciwidey. All rights reserved.</p>
    </div>
  </main>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    document.getElementById('togglePass').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('.material-icons-round');
      const show = passwordInput.type === 'password';
      passwordInput.type = show ? 'text' : 'password';
      icon.textContent = show ? 'visibility_off' : 'visibility';
    });

    const emailInput = document.getElementById('email');
    const rememberCheckbox = document.getElementById('remember');
    
    try {
      const saved = localStorage.getItem('rememberEmail_' + '{{ $currentRole }}');
      if (saved) { emailInput.value = saved; rememberCheckbox.checked = true; }
    } catch (e) {}

    document.getElementById('loginForm').addEventListener('submit', function() {
      try {
        if (rememberCheckbox.checked) {
          localStorage.setItem('rememberEmail_' + '{{ $currentRole }}', emailInput.value);
        } else {
          localStorage.removeItem('rememberEmail_' + '{{ $currentRole }}');
        }
      } catch (e) {}
      
      const btn = document.getElementById('btnLogin');
      btn.disabled = true;
      btn.innerHTML = '<span class="material-icons-round" style="animation: spin 1s linear infinite; font-size: 20px;">refresh</span> Memproses...';
    });
  </script>
  <style>@keyframes spin { 100% { transform: rotate(360deg); } }</style>
</body>
</html>