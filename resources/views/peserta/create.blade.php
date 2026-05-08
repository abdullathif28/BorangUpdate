@extends('layouts.admin')
@section('title', 'Tambah Peserta')
@section('page-title', 'Tambah Peserta')
@section('page-subtitle', 'Tambahkan peserta ke pelatihan secara manual')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header">
        <h6><i class="fas fa-user-plus" style="margin-right:8px;color:#0f4c81"></i>Form Tambah Peserta</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('peserta.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Pelatihan <span style="color:red">*</span></label>
                <select name="pelatihan_id" class="form-control form-select" required>
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($allPelatihan as $p)
                    <option value="{{ $p->id }}" {{ (old('pelatihan_id', $pelatihanAktif?->id) == $p->id) ? 'selected' : '' }}>
                        {{ $p->nama_pelatihan }} ({{ $p->status }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Asal Pimpinan <span style="color:red">*</span></label>
                <input type="text" name="asal_pimpinan" class="form-control" value="{{ old('asal_pimpinan') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat <span style="color:red">*</span></label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tempat, Tanggal Lahir <span style="color:red">*</span></label>
                <input type="text" name="ttl" class="form-control" value="{{ old('ttl') }}" placeholder="Jakarta, 1 Januari 2000" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin <span style="color:red">*</span></label>
                <select name="jenis_kelamin" class="form-control form-select" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor HP <span style="color:red">*</span></label>
                <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Moto Hidup</label>
                <input type="text" name="moto_hidup" class="form-control" value="{{ old('moto_hidup') }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
