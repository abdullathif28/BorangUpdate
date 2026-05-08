@extends('layouts.superadmin')
@section('title', 'Edit Pelatihan')
@section('page-title', 'Edit Pelatihan')
@section('page-subtitle', $pelatihan->nama_pelatihan)

@section('content')
<div class="card" style="max-width:700px">
    <div class="card-header">
        <h6><i class="fas fa-edit" style="margin-right:8px;color:#0f4c81"></i>Edit Pelatihan</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('superadmin.pelatihan.update', $pelatihan->id) }}">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="form-label">Nama Pelatihan <span style="color:red">*</span></label>
                    <input type="text" name="nama_pelatihan" class="form-control" value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Penyelenggara <span style="color:red">*</span></label>
                    <input type="text" name="penyelenggara" class="form-control" value="{{ old('penyelenggara', $pelatihan->penyelenggara) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Nama LFP</label>
                    <input type="text" name="nama_lfp" class="form-control" value="{{ old('nama_lfp', $pelatihan->nama_lfp) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Email LFP</label>
                    <input type="email" name="email_lfp" class="form-control" value="{{ old('email_lfp', $pelatihan->email_lfp) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Nama MoT</label>
                    <input type="text" name="nama_mot" class="form-control" value="{{ old('nama_mot', $pelatihan->nama_mot) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">NBA MoT</label>
                    <input type="text" name="nba_mot" class="form-control" value="{{ old('nba_mot', $pelatihan->nba_mot) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Nama Asisten MoT</label>
                    <input type="text" name="nama_asisten_mot" class="form-control" value="{{ old('nama_asisten_mot', $pelatihan->nama_asisten_mot) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">HP Asisten MoT</label>
                    <input type="text" name="hp_asisten_mot" class="form-control" value="{{ old('hp_asisten_mot', $pelatihan->hp_asisten_mot) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Nama Ketua Umum</label>
                    <input type="text" name="nama_ketum" class="form-control" value="{{ old('nama_ketum', $pelatihan->nama_ketum) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">NBA Ketua Umum</label>
                    <input type="text" name="nba_ketum" class="form-control" value="{{ old('nba_ketum', $pelatihan->nba_ketum) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Tanggal Pelatihan <span style="color:red">*</span></label>
                    <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ old('tanggal_pelatihan', $pelatihan->tanggal_pelatihan) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label class="form-label">Tempat Pelatihan <span style="color:red">*</span></label>
                    <input type="text" name="tempat_pelatihan" class="form-control" value="{{ old('tempat_pelatihan', $pelatihan->tempat_pelatihan) }}" required>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('superadmin.pelatihan.show', $pelatihan->id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
