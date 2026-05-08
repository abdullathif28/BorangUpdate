<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - BorangDigital IPM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; background: linear-gradient(135deg, #0f4c81 0%, #1a6bb5 100%); display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        .register-card { background: white; border-radius: 20px; width: 100%; max-width: 560px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .card-header { background: linear-gradient(135deg, #0f4c81, #1a6bb5); padding: 32px; color: white; text-align: center; }
        .card-header .icon { width: 60px; height: 60px; background: rgba(255,255,255,0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 16px; }
        .card-header h3 { font-size: 22px; font-weight: 800; margin-bottom: 6px; }
        .card-header p { font-size: 13px; opacity: 0.8; }
        .card-body { padding: 36px; }
        .info-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 10px; padding: 14px 16px; margin-bottom: 28px; font-size: 13px; color: #0369a1; display: flex; gap: 10px; align-items: flex-start; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d1d5db; border-radius: 9px; font-size: 14px; outline: none; transition: all 0.2s; font-family: 'Inter', sans-serif; }
        .form-control:focus { border-color: #0f4c81; box-shadow: 0 0 0 3px rgba(15,76,129,0.1); }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 16px; }
        .error { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .btn-submit { width: 100%; padding: 13px; background: #0f4c81; color: white; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; font-family: 'Inter', sans-serif; margin-top: 8px; }
        .btn-submit:hover { background: #1a6bb5; }
        .login-link { text-align: center; margin-top: 20px; font-size: 13px; color: #64748b; }
        .login-link a { color: #0f4c81; font-weight: 700; text-decoration: none; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; }
        @media(max-width:500px) { .grid-2 { grid-template-columns: 1fr; } .card-body { padding: 24px; } }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <h3>Pendaftaran Admin</h3>
            <p>Daftarkan Pimpinan Daerah/Wilayah Anda sebagai Admin BorangDigital</p>
        </div>
        <div class="card-body">
            <div class="info-box">
                <i class="fas fa-info-circle" style="margin-top:1px;flex-shrink:0"></i>
                <div>Setelah mendaftar, akun Anda akan menunggu persetujuan dari <strong>Super Admin</strong> sebelum dapat digunakan.</div>
            </div>
            @if($errors->any())
                <div class="alert-danger">
                    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('register.perform') }}">
                @csrf
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Tingkat Pimpinan <span style="color:red">*</span></label>
                        <select name="tingkat_pimpinan" class="form-control form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Wilayah" {{ old('tingkat_pimpinan') === 'Wilayah' ? 'selected' : '' }}>Pimpinan Wilayah</option>
                            <option value="Daerah" {{ old('tingkat_pimpinan') === 'Daerah' ? 'selected' : '' }}>Pimpinan Daerah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Pimpinan <span style="color:red">*</span></label>
                        <input type="text" name="nama_pimpinan" class="form-control" value="{{ old('nama_pimpinan') }}" placeholder="Cth: PD IPM Brebes" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Ketua Umum <span style="color:red">*</span></label>
                    <input type="text" name="nama_ketum" class="form-control" value="{{ old('nama_ketum') }}" placeholder="Nama lengkap ketua umum" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Email Daerah <span style="color:red">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@daerah.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP <span style="color:red">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" placeholder="08xx-xxxx-xxxx" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Pimpinan Cabang <span style="color:red">*</span></label>
                    <input type="number" name="jumlah_cabang" class="form-control" value="{{ old('jumlah_cabang') }}" placeholder="Jumlah cabang yang dimiliki" min="1" required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Password <span style="color:red">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span style="color:red">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Pendaftaran</button>
            </form>
            <div class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
        </div>
    </div>
</body>
</html>
