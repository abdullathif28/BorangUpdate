<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta Pelatihan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #0f4c81 0%, #1a6bb5 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 20px; padding: 40px; width: 100%; max-width: 540px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .brand { text-align: center; margin-bottom: 30px; }
        .brand h2 { color: #0f4c81; font-size: 22px; font-weight: 700; }
        .brand p { color: #718096; font-size: 13px; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: 'Inter', sans-serif; transition: border-color 0.2s; }
        .form-control:focus { outline: none; border-color: #0f4c81; box-shadow: 0 0 0 3px rgba(15,76,129,0.1); }
        .btn-primary { width: 100%; padding: 12px; background: #0f4c81; color: white; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-primary:hover { background: #1a6bb5; }
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .token-box { background: #f0f9ff; border: 2px solid #0f4c81; border-radius: 10px; padding: 16px; margin-bottom: 24px; }
        .token-box .pelatihan-name { font-size: 16px; font-weight: 700; color: #0f4c81; }
        .token-box .pelatihan-meta { font-size: 12px; color: #64748b; margin-top: 4px; }
        .divider { text-align: center; color: #9ca3af; font-size: 13px; margin: 20px 0; }
        a { color: #0f4c81; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
<div class="card">
    <div class="brand">
        <h2><i class="fas fa-user-plus" style="margin-right:8px"></i>Daftar Peserta</h2>
        <p>Isi form berikut untuk mendaftarkan diri ke pelatihan</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle" style="margin-right:6px"></i>{{ session('success') }}</div>
    @endif
    @if(session('error') || isset($error) && $error)
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle" style="margin-right:6px"></i>{{ session('error') ?? $error }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
    </div>
    @endif

    @if($pelatihan)
    <div class="token-box">
        <div><i class="fas fa-check-circle" style="color:#22c55e;margin-right:6px"></i> Pelatihan ditemukan!</div>
        <div class="pelatihan-name mt-1">{{ $pelatihan->nama_pelatihan }}</div>
        <div class="pelatihan-meta">
            <i class="fas fa-map-marker-alt" style="margin-right:4px"></i>{{ $pelatihan->tempat_pelatihan }}
            &nbsp;|&nbsp;
            <i class="fas fa-calendar" style="margin-right:4px"></i>{{ \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->isoFormat('D MMM Y') }}
        </div>
    </div>
    @endif

    <form action="{{ route('daftar-peserta.store') }}" method="POST">
        @csrf

        {{-- TOKEN --}}
        <div class="form-group">
            <label><i class="fas fa-key" style="margin-right:6px;color:#0f4c81"></i>Token Pelatihan <span style="color:red">*</span></label>
            <input type="text" name="token_pendaftaran" class="form-control"
                value="{{ old('token_pendaftaran', $token ?? '') }}"
                placeholder="Masukkan token dari panitia (contoh: AB12CD34)"
                style="text-transform:uppercase;letter-spacing:2px;font-weight:600"
                required>
            <div style="font-size:11px;color:#718096;margin-top:4px">Token diberikan oleh admin/panitia pelatihan</div>
        </div>

        <div class="divider">— Data Pribadi —</div>

        <div class="form-group">
            <label>Nama Lengkap <span style="color:red">*</span></label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama sesuai kartu identitas" required>
        </div>
        <div class="form-group">
            <label>Asal Pimpinan <span style="color:red">*</span></label>
            <input type="text" name="asal_pimpinan" class="form-control" value="{{ old('asal_pimpinan') }}" placeholder="Pimpinan Daerah / Cabang" required>
        </div>
        <div class="form-group">
            <label>Alamat <span style="color:red">*</span></label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
        </div>
        <div class="form-group">
            <label>Tempat, Tanggal Lahir <span style="color:red">*</span></label>
            <input type="text" name="ttl" class="form-control" value="{{ old('ttl') }}" placeholder="Contoh: Jakarta, 1 Januari 2000" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin <span style="color:red">*</span></label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nomor HP <span style="color:red">*</span></label>
            <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="form-group">
            <label>Moto Hidup</label>
            <input type="text" name="moto_hidup" class="form-control" value="{{ old('moto_hidup') }}" placeholder="Moto/visi hidup (opsional)">
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-paper-plane" style="margin-right:8px"></i>Daftar Sekarang
        </button>
    </form>

    <div style="text-align:center;margin-top:20px;font-size:13px;color:#718096">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>
</body>
</html>
