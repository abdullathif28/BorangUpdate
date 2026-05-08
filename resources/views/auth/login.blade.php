<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BorangDigital IPM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; background: #0f4c81; }
        .left-panel { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 60px; color: white; position: relative; overflow: hidden; }
        .left-panel::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, #0f4c81 0%, #1a6bb5 60%); }
        .left-content { position: relative; z-index: 1; }
        .brand { display: flex; align-items: center; gap: 16px; margin-bottom: 60px; }
        .brand-icon { width: 52px; height: 52px; background: #22c55e; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; color: white; }
        .brand h2 { font-size: 22px; font-weight: 800; margin: 0; }
        .brand small { font-size: 12px; opacity: 0.7; display: block; }
        .hero-text h1 { font-size: 38px; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
        .hero-text h1 span { color: #22c55e; }
        .hero-text p { font-size: 15px; opacity: 0.75; line-height: 1.7; max-width: 400px; }
        .features { margin-top: 48px; display: flex; flex-direction: column; gap: 16px; }
        .feature-item { display: flex; align-items: center; gap: 14px; }
        .feature-icon { width: 38px; height: 38px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .feature-text h6 { font-size: 14px; font-weight: 600; margin: 0; }
        .feature-text small { font-size: 12px; opacity: 0.6; }
        
        /* Adjusted right panel width from 480px to 550px */
        .right-panel { width: 550px; background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 60px; }
        /* Adjusted max-width from 380px to 440px */
        .login-box { width: 100%; max-width: 440px; }
        
        .login-header { margin-bottom: 32px; }
        .login-header h3 { font-size: 32px; font-weight: 800; color: #0f4c81; margin-bottom: 6px; }
        .login-header p { font-size: 15px; color: #64748b; }
        .tabs { display: flex; background: #e2e8f0; border-radius: 10px; padding: 5px; margin-bottom: 28px; }
        .tab-btn { flex: 1; padding: 12px; border: none; background: transparent; border-radius: 8px; font-size: 14.5px; font-weight: 600; color: #64748b; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif; }
        .tab-btn.active { background: white; color: #0f4c81; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 14.5px; font-weight: 600; color: #374151; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; }
        .form-control { width: 100%; padding: 14px 16px 14px 45px; border: 1.5px solid #d1d5db; border-radius: 10px; font-size: 15px; outline: none; transition: all 0.2s; background: white; font-family: 'Inter', sans-serif; }
        .form-control:focus { border-color: #0f4c81; box-shadow: 0 0 0 3px rgba(15,76,129,0.1); }
        .token-input { text-align: center; font-size: 22px; font-weight: 800; letter-spacing: 6px; color: #0f4c81; padding: 16px; text-transform: uppercase; }
        .btn-submit { width: 100%; padding: 15px; background: #0f4c81; color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 8px; }
        .btn-submit:hover { background: #1a6bb5; }
        .alert { padding: 14px 18px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .divider { text-align: center; margin: 24px 0; position: relative; }
        .divider::before { content: ''; position: absolute; left: 0; right: 0; top: 50%; height: 1px; background: #cbd5e1; }
        .divider span { background: #f8fafc; padding: 0 12px; font-size: 13px; color: #64748b; position: relative; font-weight: 500; }
        .register-link { text-align: center; margin-top: 24px; font-size: 14.5px; color: #64748b; }
        .register-link a { color: #0f4c81; font-weight: 700; text-decoration: none; }
        @media (max-width: 900px) { .left-panel { display: none; } .right-panel { width: 100%; padding: 30px; } }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="left-content">
            <div class="brand">
                <div class="brand-icon"><i class="fas fa-graduation-cap"></i></div>
                <div><h2>Borang Digital</h2><small>Sistem Manajemen Penilaian Pelatihan</small></div>
            </div>
            <div class="hero-text">
                <h1>Kelola Penilaian<br>Pelatihan <span>IPM</span><br>Lebih Mudah</h1>
                <p>Platform digital untuk mengelola borang pelatihan kader IPM secara efisien, terstruktur, dan real-time.</p>
            </div>
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-clipboard-check"></i></div>
                    <div class="feature-text"><h6>Observasi Digital</h6><small>Input penilaian langsung dari perangkat apapun</small></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="feature-text"><h6>Rekapitulasi Otomatis</h6><small>Nilai terakumulasi dan raport siap cetak</small></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-users-cog"></i></div>
                    <div class="feature-text"><h6>Multi-Role System</h6><small>Admin, IOT, MOG, Observer</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-panel">
        <div class="login-box">
            <div class="login-header">
                <h3>Selamat Datang</h3>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
            @if($errors->has('email'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}</div>@endif
            @if($errors->has('token_login'))<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('token_login') }}</div>@endif
            
            <div class="tabs">
                <button class="tab-btn active" id="btn-email" onclick="switchTab('email')"><i class="fas fa-envelope"></i> Email & Password</button>
                <button class="tab-btn" id="btn-token" onclick="switchTab('token')"><i class="fas fa-key"></i> Login Token</button>
            </div>
            
            <div id="tab-email" class="tab-content active">
                <form method="POST" action="{{ route('login.perform') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt"></i> Masuk</button>
                </form>
            </div>
            
            <div id="tab-token" class="tab-content">
                <form method="POST" action="{{ route('login.perform') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" style="text-align:center;display:block">Masukkan Token Login</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="text" name="token_login" class="form-control token-input" placeholder="XXXXXXXX" maxlength="8" autocomplete="off">
                        </div>
                        <div style="text-align:center;margin-top:10px;font-size:13px;color:#94a3b8">Token diberikan oleh Admin Daerah/Wilayah Anda</div>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-key"></i> Login dengan Token</button>
                </form>
            </div>
            
            <div class="divider"><span>atau</span></div>
            <div class="register-link">Daftar sebagai Admin Daerah/Wilayah? <a href="{{ route('register') }}">Daftar di sini</a></div>
        </div>
    </div>
    <script>
        function switchTab(tab) {
            ['email','token'].forEach(t => {
                document.getElementById('tab-'+t).classList.remove('active');
                document.getElementById('btn-'+t).classList.remove('active');
            });
            document.getElementById('tab-'+tab).classList.add('active');
            document.getElementById('btn-'+tab).classList.add('active');
        }
        var tokenInput = document.querySelector('[name="token_login"]');
        if(tokenInput) tokenInput.addEventListener('input', function(){ this.value = this.value.toUpperCase(); });
    </script>
</body>
</html>
