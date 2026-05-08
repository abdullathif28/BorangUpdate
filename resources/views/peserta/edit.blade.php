@extends('layouts.admin')
@section('title', 'Edit Peserta')
@section('page-title', 'Edit Peserta')
@section('page-subtitle', 'Perbarui data peserta')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header">
        <h6><i class="fas fa-edit" style="margin-right:8px;color:#0f4c81"></i>Edit: {{ $peserta->nama }}</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Pelatihan</label>
                <input type="text" class="form-control" value="{{ $peserta->pelatihan?->nama_pelatihan ?? '-' }}" disabled>
                <div style="font-size:11px;color:#718096;margin-top:3px">Pelatihan tidak dapat diubah</div>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $peserta->nama) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Asal Pimpinan <span style="color:red">*</span></label>
                <input type="text" name="asal_pimpinan" class="form-control" value="{{ old('asal_pimpinan', $peserta->asal_pimpinan) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat <span style="color:red">*</span></label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $peserta->alamat) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tempat, Tanggal Lahir <span style="color:red">*</span></label>
                <input type="text" name="ttl" class="form-control" value="{{ old('ttl', $peserta->ttl) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin <span style="color:red">*</span></label>
                <select name="jenis_kelamin" class="form-control form-select" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp', $peserta->nomor_hp) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Moto Hidup</label>
                <input type="text" name="moto_hidup" class="form-control" value="{{ old('moto_hidup', $peserta->moto_hidup) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
