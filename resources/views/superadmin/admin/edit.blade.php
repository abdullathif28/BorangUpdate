@extends('layouts.superadmin')
@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('page-subtitle', 'Perbarui data admin daerah/wilayah')

@section('content')
<div class="card" style="max-width:560px">
    <div class="card-header">
        <h6><i class="fas fa-user-edit" style="margin-right:8px;color:#0f4c81"></i>Edit: {{ $admin->nama_pimpinan }}</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('superadmin.admin.update', $admin->id) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Pimpinan <span style="color:red">*</span></label>
                <input type="text" name="nama_pimpinan" class="form-control" value="{{ old('nama_pimpinan', $admin->nama_pimpinan) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email <span style="color:red">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tingkat Pimpinan</label>
                <input type="text" name="tingkat_pimpinan" class="form-control" value="{{ old('tingkat_pimpinan', $admin->tingkat_pimpinan) }}" placeholder="Wilayah / Daerah">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Ketua Umum</label>
                <input type="text" name="nama_ketum" class="form-control" value="{{ old('nama_ketum', $admin->nama_ketum) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp', $admin->nomor_hp) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah Cabang</label>
                <input type="number" name="jumlah_cabang" class="form-control" value="{{ old('jumlah_cabang', $admin->jumlah_cabang) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('superadmin.admin.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
