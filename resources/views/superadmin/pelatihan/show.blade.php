@extends('layouts.superadmin')
@section('title', 'Detail Pelatihan')
@section('page-title', 'Detail Pelatihan')
@section('page-subtitle', $pelatihan->nama_pelatihan)

@section('content')
<div style="display:flex;gap:20px;align-items:flex-start;margin-bottom:20px">
    <a href="{{ route('superadmin.pelatihan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('superadmin.pelatihan.edit', $pelatihan->id) }}" class="btn btn-info btn-sm">
        <i class="fas fa-edit"></i> Edit Pelatihan
    </a>
    {!! $pelatihan->getStatusBadge() !!}
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-header"><h6>Informasi Pelatihan</h6></div>
        <div class="card-body">
            <table style="width:100%;font-size:13.5px">
                <tr><td style="color:#718096;padding:5px 0;width:45%">Nama Pelatihan</td><td style="font-weight:600">{{ $pelatihan->nama_pelatihan }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Penyelenggara</td><td>{{ $pelatihan->penyelenggara }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Tanggal</td><td>{{ \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->isoFormat('D MMMM Y') }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Tempat</td><td>{{ $pelatihan->tempat_pelatihan }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Nama MOT</td><td>{{ $pelatihan->nama_mot }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Nama Ketum</td><td>{{ $pelatihan->nama_ketum }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Jumlah Materi</td><td>{{ $pelatihan->jumlah_materi }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Jumlah Kajian</td><td>{{ $pelatihan->jumlah_kajian }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Jumlah Games</td><td>{{ $pelatihan->jumlah_games ?? '-' }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Jumlah Peserta</td><td><strong>{{ $pelatihan->pesertas->count() }}</strong></td></tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h6>Admin Pengelola</h6></div>
        <div class="card-body">
            @if($pelatihan->admin)
            <table style="width:100%;font-size:13.5px">
                <tr><td style="color:#718096;padding:5px 0;width:45%">Nama Pimpinan</td><td style="font-weight:600">{{ $pelatihan->admin->nama_pimpinan }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Tingkat</td><td>{{ $pelatihan->admin->tingkat_pimpinan }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">Email</td><td>{{ $pelatihan->admin->email }}</td></tr>
                <tr><td style="color:#718096;padding:5px 0">No. HP</td><td>{{ $pelatihan->admin->nomor_hp }}</td></tr>
            </table>
            @else
            <p style="color:#718096;font-size:13px">Data admin tidak ditemukan</p>
            @endif
        </div>
        <div class="card-header" style="border-top:1px solid #f0f4f8"><h6>Kontrol Akses</h6></div>
        <div class="card-body">
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                @if($pelatihan->status === 'pending')
                    <form method="POST" action="{{ route('superadmin.pelatihan.approve', $pelatihan->id) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success"><i class="fas fa-check"></i> Aktifkan Pelatihan</button>
                    </form>
                @elseif($pelatihan->status === 'aktif')
                    <form method="POST" action="{{ route('superadmin.pelatihan.tutup', $pelatihan->id) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-warning" onclick="return confirm('Tutup pelatihan ini?')">
                            <i class="fas fa-lock"></i> Tutup Akses
                        </button>
                    </form>
                @elseif($pelatihan->status === 'selesai' || $pelatihan->status === 'ditolak')
                    <form method="POST" action="{{ route('superadmin.pelatihan.buka', $pelatihan->id) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-success" onclick="return confirm('Buka kembali pelatihan ini?')">
                            <i class="fas fa-lock-open"></i> Buka Kembali
                        </button>
                    </form>
                @endif
            </div>
            @if($pelatihan->catatan_superadmin)
            <div class="alert alert-warning" style="margin-top:12px">{{ $pelatihan->catatan_superadmin }}</div>
            @endif
        </div>
    </div>
</div>

<!-- Materi -->
@if($pelatihan->materi->isNotEmpty())
<div class="card" style="margin-top:20px">
    <div class="card-header"><h6>Daftar Materi</h6></div>
    <div class="card-body" style="padding:0">
        <table>
            <thead><tr><th>#</th><th>Nama Materi</th></tr></thead>
            <tbody>
                @foreach($pelatihan->materi as $i => $m)
                <tr><td>{{ $i+1 }}</td><td>{{ $m->nama_materi }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
