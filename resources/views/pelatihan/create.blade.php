@extends('layouts.admin')
@section('title', 'Daftar Pelatihan Baru')
@section('page-title', 'Daftar Pelatihan Baru')
@section('page-subtitle', 'Isi formulir berikut untuk mendaftarkan pelatihan')

@section('content')
<div class="card" style="max-width:860px">
    <div class="card-header">
        <h6><i class="fas fa-plus-circle" style="margin-right:8px;color:#0f4c81"></i>Form Pendaftaran Pelatihan</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('pelatihan.store') }}" method="POST">
            @csrf

            <h6 class="text-muted mb-3" style="font-size:12px;text-transform:uppercase;letter-spacing:1px">Informasi LFP</h6>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nama LFP / Korps Fasilitator Daerah <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lfp" class="form-control" value="{{ old('nama_lfp') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Email LFP <span class="text-danger">*</span></label>
                    <input type="email" name="email_lfp" class="form-control" value="{{ old('email_lfp') }}" required>
                </div>
            </div>

            <h6 class="text-muted mb-3 mt-3" style="font-size:12px;text-transform:uppercase;letter-spacing:1px">Informasi MOT</h6>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nama MoT <span class="text-danger">*</span></label>
                    <input type="text" name="nama_mot" class="form-control" value="{{ old('nama_mot') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>NBA MoT <span class="text-danger">*</span></label>
                    <input type="text" name="nba_mot" class="form-control" value="{{ old('nba_mot') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Nama Asisten MoT <span class="text-danger">*</span></label>
                    <input type="text" name="nama_asisten_mot" class="form-control" value="{{ old('nama_asisten_mot') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Nomor HP Asisten MoT <span class="text-danger">*</span></label>
                    <input type="text" name="hp_asisten_mot" class="form-control" value="{{ old('hp_asisten_mot') }}" required>
                </div>
            </div>

            <h6 class="text-muted mb-3 mt-3" style="font-size:12px;text-transform:uppercase;letter-spacing:1px">Detail Pelatihan</h6>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Nama Pelatihan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pelatihan" class="form-control" value="{{ old('nama_pelatihan') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Penyelenggara <span class="text-danger">*</span></label>
                    <input type="text" name="penyelenggara" class="form-control" value="{{ old('penyelenggara') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Nama Ketua Umum <span class="text-danger">*</span></label>
                    <input type="text" name="nama_ketum" class="form-control" value="{{ old('nama_ketum') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>NBA Ketua Umum <span class="text-danger">*</span></label>
                    <input type="text" name="nba_ketum" class="form-control" value="{{ old('nba_ketum') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Tanggal Pelatihan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ old('tanggal_pelatihan') }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Tempat Pelatihan <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_pelatihan" class="form-control" value="{{ old('tempat_pelatihan') }}" required>
                </div>
            </div>

            {{-- MATERI --}}
            <div class="border rounded p-3 mb-3" style="background:#f8fafc">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <label class="mb-0 fw-600">Jumlah Materi</label>
                    <select name="jumlah_materi" id="jumlah_materi" class="form-control" style="width:100px" required>
                        @for($i=1;$i<=12;$i++)<option value="{{ $i }}" {{ old('jumlah_materi')==$i?'selected':'' }}>{{ $i }}</option>@endfor
                    </select>
                    <button type="button" class="btn btn-sm btn-primary" id="generate-materi">
                        <i class="fas fa-magic"></i> Generate Materi
                    </button>
                </div>
                <div id="form-materi"></div>
            </div>

            {{-- FGD --}}
            <div class="form-group">
                <label>Jumlah FGD <span class="text-danger">*</span></label>
                <select name="jumlah_fgd" class="form-control" style="width:150px" required>
                    @for($i=1;$i<=10;$i++)<option value="{{ $i }}" {{ old('jumlah_fgd')==$i?'selected':'' }}>{{ $i }} FGD</option>@endfor
                </select>
            </div>

            {{-- AYAT HAFALAN (dinamis) --}}
            <div class="border rounded p-3 mb-3" style="background:#f0fdf4">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <label class="mb-0 fw-600">Jumlah Hafalan (Ayat)</label>
                    <select name="jumlah_hafalan" id="jumlah_hafalan" class="form-control" style="width:100px" required>
                        @for($i=1;$i<=10;$i++)<option value="{{ $i }}" {{ old('jumlah_hafalan')==$i?'selected':'' }}>{{ $i }}</option>@endfor
                    </select>
                    <button type="button" class="btn btn-sm btn-success" id="generate-ayat">
                        <i class="fas fa-magic"></i> Generate Ayat
                    </button>
                </div>
                <div style="font-size:12px;color:#15803d;margin-bottom:8px">
                    <i class="fas fa-info-circle"></i> Nilai hafalan dinormalisasi jadi 100 poin (tiap ayat = 100÷jumlah ayat poin)
                </div>
                <div id="form-ayat"></div>
            </div>

            {{-- KAJIAN/IMAMAH --}}
            <div class="border rounded p-3 mb-3" style="background:#f8fafc">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <label class="mb-0 fw-600">Jumlah Kajian/Imamah</label>
                    <select name="jumlah_kajian" id="jumlah_kajian" class="form-control" style="width:100px" required>
                        @for($i=1;$i<=15;$i++)<option value="{{ $i }}" {{ old('jumlah_kajian')==$i?'selected':'' }}>{{ $i }}</option>@endfor
                    </select>
                    <button type="button" class="btn btn-sm btn-primary" id="generate-kajian">
                        <i class="fas fa-magic"></i> Generate Kajian
                    </button>
                </div>
                <div id="form-kajian"></div>
            </div>

            {{-- GAMES --}}
            <div class="border rounded p-3 mb-3" style="background:#f8fafc">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <label class="mb-0 fw-600">Jumlah Games</label>
                    <select name="jumlah_games" id="jumlah_games" class="form-control" style="width:100px" required>
                        @for($i=1;$i<=10;$i++)<option value="{{ $i }}" {{ old('jumlah_games')==$i?'selected':'' }}>{{ $i }}</option>@endfor
                    </select>
                    <button type="button" class="btn btn-sm btn-primary" id="generate-games">
                        <i class="fas fa-magic"></i> Generate Games
                    </button>
                </div>
                <div id="form-games"></div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Daftar Pelatihan</button>
                <a href="{{ route('pelatihan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function generateFields(containerId, count, nameAttr, labelPrefix) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    for (let i = 1; i <= count; i++) {
        container.innerHTML += `
            <div class="form-group">
                <label>${labelPrefix} ${i}</label>
                <input type="text" name="${nameAttr}[]" class="form-control" placeholder="${labelPrefix} ${i}" required>
            </div>`;
    }
}

document.getElementById('generate-materi').addEventListener('click', () =>
    generateFields('form-materi', document.getElementById('jumlah_materi').value, 'nama_materi', 'Nama Materi'));

document.getElementById('generate-ayat').addEventListener('click', function() {
    const jumlah = document.getElementById('jumlah_hafalan').value;
    generateFields('form-ayat', jumlah, 'nama_ayat', 'Nama Ayat/Surah');
    const nilaiPerAyat = Math.round(100 / jumlah * 100) / 100;
    const info = document.createElement('div');
    info.style.cssText = 'font-size:12px;color:#0369a1;margin-top:4px;padding:6px 10px;background:#e0f2fe;border-radius:6px';
    info.innerHTML = `<i class="fas fa-calculator"></i> Nilai per ayat: <strong>${nilaiPerAyat} poin</strong> (total = 100 poin)`;
    document.getElementById('form-ayat').prepend(info);
});

document.getElementById('generate-kajian').addEventListener('click', () =>
    generateFields('form-kajian', document.getElementById('jumlah_kajian').value, 'nama_kajian', 'Nama Kajian'));

document.getElementById('generate-games').addEventListener('click', () =>
    generateFields('form-games', document.getElementById('jumlah_games').value, 'nama_games', 'Nama Games'));
</script>
@endpush
