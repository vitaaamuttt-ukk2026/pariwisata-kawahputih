<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login {{ ucfirst($role ?? 'Admin') }} - Kawah Putih</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Open Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      background: linear-gradient(rgba(255,255,255,.25), rgba(255,255,255,.25)),
        url('https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=1920&q=80') center/cover no-repeat fixed,
        linear-gradient(135deg, #8fd3d1, #cfe9e4);
    }

    .role-nav {
      position: fixed;
      top: 20px;
      right: 24px;
      text-align: right;
      font-family: 'Montserrat', sans-serif;
    }
    .role-nav h4 { font-size: 15px; margin-bottom: 6px; color: #1c1c1c; font-weight: 700; }
    .role-nav ul { list-style: none; display: flex; gap: 8px; justify-content: flex-end; }
    .role-nav a {
      display: inline-block;
      border: 2px solid #1c1c1c;
      background: rgba(255,255,255,.7);
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: 700;
      font-size: 13px;
      text-decoration: none;
      color: #1c1c1c;
      transition: .2s;
    }
    .role-nav a.active,
    .role-nav a:hover { background: #1c1c1c; color: #fff; }

    .card {
      width: 100%;
      max-width: 520px;
      background: rgba(255,255,255,.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-radius: 16px;
      padding: 48px 56px 32px;
      text-align: center;
      box-shadow: 0 10px 40px rgba(0,0,0,.15);
    }

    .logo {
      width: 100px; height: 100px;
      margin: 0 auto 20px;
      background: #fff;
      border-radius: 22px;
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,.12);
    }

    h1 {
      font-family: 'Montserrat', sans-serif;
      font-size: 24px;
      font-weight: 800;
      color: #111;
      line-height: 1.2;
    }
    h1 small { display: block; font-size: 16px; font-weight: 700; margin-top: 2px; color: #2f7d6d; }

    form { margin-top: 36px; text-align: left; }

    label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .3px;
      margin-bottom: 6px;
      text-transform: uppercase;
      color: #333;
    }

    .field { margin-bottom: 22px; }

    .input-wrap {
      position: relative;
      display: flex;
      align-items: center;
      background: #fff;
      border: 3px solid #111;
      height: 50px;
      padding: 0 12px;
      gap: 10px;
      border-radius: 8px;
      transition: .2s;
    }
    .input-wrap:focus-within { outline: 3px solid #2eb67d; outline-offset: 2px; border-color: #2eb67d; }
    .input-wrap.error { border-color: #d93025; outline: 3px solid #fdecea; outline-offset: 2px; }

    .input-wrap svg { flex-shrink: 0; width: 18px; height: 18px; color: #777; pointer-events: none; }
    
    .input-wrap input {
      flex: 1;
      border: none;
      outline: none;
      background: transparent;
      font-size: 14px;
      font-family: inherit;
      height: 100%;
      color: #111;
      cursor: text; /* Memastikan kursor tetap teks */
    }
    
    .toggle-pass { background: none; border: none; cursor: pointer; display: flex; padding: 4px; }
    .toggle-pass svg { width: 20px; height: 20px; color: #555; }

    .error-msg { color: #d93025; font-size: 12px; margin-top: 5px; min-height: 16px; font-weight: 600; }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      margin-bottom: 28px;
    }
    .options label {
      display: flex; align-items: center; gap: 8px;
      text-transform: none; font-weight: 400; margin: 0; cursor: pointer;
    }
    .options a { color: #0a9a5c; text-decoration: none; font-weight: 600; }
    .options a:hover { text-decoration: underline; }

    .btn-login {
      width: 100%;
      height: 48px;
      background: #2f7d6d;
      color: #fff;
      border: 3px solid #111;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: .2s;
      font-family: 'Montserrat', sans-serif;
      border-radius: 8px;
    }
    .btn-login:hover { background: #111; color: #fff; border-color: #111; }
    .btn-login:disabled { opacity: .6; cursor: not-allowed; }

    .alert {
      display: none;
      background: #fdecea;
      color: #b3261e;
      border: 1px solid #f5c2be;
      padding: 12px;
      font-size: 13px;
      margin-bottom: 18px;
      border-radius: 8px;
      font-weight: 600;
    }
    .alert.show { display: block; }

    .footer { margin-top: 28px; font-size: 12px; color: #333; }
    .footer a { color: #0a9a5c; text-decoration: none; font-weight: 600; }
    .footer hr { width: 100px; border: 0; border-top: 1px solid #333; margin: 0 auto 12px; }

    @media (max-width: 560px) {
      .card { padding: 36px 24px 24px; }
      .role-nav { position: static; margin-bottom: 16px; text-align: center; }
      .role-nav ul { justify-content: center; }
      body { flex-direction: column; }
    }
    input[type="checkbox"] { accent-color: #2f7d6d; width: 16px; height: 16px; cursor: pointer; }
  </style>
</head>
<body>

  @php
      $currentRole = request()->route('role') ?? 'admin';
  @endphp

  <!-- Pilih peran -->
  <nav class="role-nav" aria-label="Pilih peran login">
    <h4>Login sebagai</h4>
    <ul>
      <li>
        <a href="{{ route('panel.login', 'admin') }}" class="{{ $currentRole === 'admin' ? 'active' : '' }}">Admin</a>
      </li>
      <li>
        <a href="{{ route('panel.login', 'pengelola') }}" class="{{ $currentRole === 'pengelola' ? 'active' : '' }}">Pengelola</a>
      </li>
    </ul>
  </nav>

  <main class="card">
    <div class="logo">
      <svg viewBox="0 0 100 100" width="80" height="80" aria-label="Kawah Putih">
        <circle cx="50" cy="40" r="28" fill="#2f7d6d"/>
        <path d="M22 48 Q50 28 78 48 L78 52 Q50 62 22 52Z" fill="#8fd3d1"/>
        <circle cx="50" cy="42" r="8" fill="#fff"/>
        <text x="50" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#0f3d36" font-family="Montserrat, sans-serif">Kawah Putih</text>
      </svg>
    </div>

    <h1>Sign in Tourism Booking <small>Management System</small></h1>

    <form id="loginForm" action="{{ route('panel.login.post', $currentRole) }}" method="POST" novalidate>
      @csrf

      @if($errors->has('email'))
        <div class="alert show" role="alert">
          {{ $errors->first('email') }}
        </div>
      @endif

      <div class="field">
        <label for="email">Email Address</label>
        <div class="input-wrap {{ $errors->has('email') ? 'error' : '' }}">
          <!-- SVG YANG SUDAH DIPERBAIKI (TIDAK TERPOTONG) -->
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <rect x="3" y="5" width="18" height="14" rx="2"/>
            <path d="M3 7l9 6 9-6"/>
          </svg>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ $currentRole }}@kawahputih.test" autocomplete="email" required>
        </div>
        <div class="error-msg">{{ $errors->first('email') }}</div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap {{ $errors->has('password') ? 'error' : '' }}">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <rect x="5" y="11" width="14" height="9" rx="2"/>
            <path d="M8 11V8a4 4 0 018 0v3"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="••••••••••••" autocomplete="current-password" required minlength="6">
          <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        <div class="error-msg">{{ $errors->first('password') }}</div>
      </div>

      <div class="options">
        <label>
          <input type="checkbox" name="remember" id="remember"> Remember me
        </label>
        <a href="#">Forgot Password?</a>
      </div>

      <button type="submit" class="btn-login" id="btnLogin">Login</button>
    </form>

    <div class="footer">
      <hr>
      <p>Kembali ke <a href="{{ route('pengunjung.dashboard') }}">Portal Wisatawan</a></p>
      <p style="margin-top:6px">&copy; <span id="year"></span> Kawah Putih Ciwidey. All rights reserved.</p>
    </div>
  </main>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    // Tampilkan / sembunyikan password
    document.getElementById('togglePass').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const show = passwordInput.type === 'password';
      passwordInput.type = show ? 'text' : 'password';
      
      this.innerHTML = show 
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    });

    // Ingat email di localStorage
    const emailInput = document.getElementById('email');
    const rememberCheckbox = document.getElementById('remember');
    
    try {
      const saved = localStorage.getItem('rememberEmail');
      if (saved) { 
        emailInput.value = saved; 
        rememberCheckbox.checked = true; 
      }
    } catch (e) {}

    // Simpan email saat form disubmit
    document.getElementById('loginForm').addEventListener('submit', function() {
      try {
        if (rememberCheckbox.checked) {
          localStorage.setItem('rememberEmail', emailInput.value);
        } else {
          localStorage.removeItem('rememberEmail');
        }
      } catch (e) {}
      
      const btn = document.getElementById('btnLogin');
      btn.disabled = true;
      btn.textContent = 'Memproses...';
    });
  </script>
</body>
</html>