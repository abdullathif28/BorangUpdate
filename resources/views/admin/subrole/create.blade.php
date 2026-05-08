@extends('layouts.admin')
@section('title', 'Tambah Anggota Tim')
@section('page-title', 'Tambah Anggota Tim')
@section('page-subtitle', 'Buat akun IOT, MOG, atau Observer dan tugaskan ke pelatihan')

@section('content')
<div class="card" style="max-width:580px">
    <div class="card-header">
        <h6><i class="fas fa-user-plus" style="margin-right:8px;color:#0f4c81"></i>Form Tambah Anggota Tim</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        @if($pelatihan->isEmpty())
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle" style="margin-right:6px"></i>
            Anda belum memiliki pelatihan yang aktif. <a href="{{ route('pelatihan.create') }}">Daftarkan pelatihan</a> terlebih dahulu sebelum menambah anggota tim.
        </div>
        @else

        <form method="POST" action="{{ route('admin.subrole.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Pelatihan yang Ditugaskan <span style="color:red">*</span></label>
                <select name="pelatihan_id" class="form-control form-select" required>
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($pelatihan as $p)
                    <option value="{{ $p->id }}" {{ old('pelatihan_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_pelatihan }} — {{ $p->penyelenggara }}
                    </option>
                    @endforeach
                </select>
                <div style="font-size:11px;color:#718096;margin-top:3px">Anggota tim ini hanya bisa mengakses data pelatihan yang dipilih</div>
                @error('pelatihan_id')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama anggota tim" required>
                @error('name')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email <span style="color:red">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@example.com" required>
                @error('email')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Role <span style="color:red">*</span></label>
                <select name="role" class="form-control form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="iot" {{ old('role') === 'iot' ? 'selected' : '' }}>🕌 IOT – Imam of Trainer (Akses: Imamah + Hafalan)</option>
                    <option value="mog" {{ old('role') === 'mog' ? 'selected' : '' }}>🎮 MOG – Master of Games (Akses: Games)</option>
                    <option value="observer" {{ old('role') === 'observer' ? 'selected' : '' }}>👁 Observer (Akses: Observasi Materi & Pendalaman)</option>
                </select>
                @error('role')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:14px;margin-bottom:20px">
                <div style="font-size:13px;color:#0369a1">
                    <i class="fas fa-key" style="margin-right:6px"></i>
                    <strong>Token Login</strong> akan digenerate otomatis. Bagikan ke anggota tim untuk login.
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Buat Akun</button>
                <a href="{{ route('admin.subrole.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection
