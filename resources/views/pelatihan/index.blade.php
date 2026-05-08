@extends('layouts.admin')
@section('title', 'Daftar Pelatihan')
@section('page-title', 'Daftar Pelatihan')
@section('page-subtitle', 'Kelola pelatihan daerah Anda')

@section('content')
<div class="card">
    <div class="card-header">
        <h6><i class="fas fa-chalkboard-teacher" style="margin-right:8px;color:#0f4c81"></i>Daftar Pelatihan</h6>
        <a href="{{ route('pelatihan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Pelatihan</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Pelatihan</th><th>Tanggal</th><th>Tempat</th><th>Peserta</th><th>Token</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pelatihan as $i => $p)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div style="font-weight:600">{{ $p->nama_pelatihan }}</div>
                        <div style="font-size:11px;color:#718096">{{ $p->penyelenggara }}</div>
                    </td>
                    <td class="text-sm">{{ \Carbon\Carbon::parse($p->tanggal_pelatihan)->format('d M Y') }}</td>
                    <td class="text-sm">{{ $p->tempat_pelatihan }}</td>
                    <td style="text-align:center;font-weight:700;color:#0f4c81">{{ $p->pesertas->count() }}</td>
                    <td>{!! $p->getStatusBadge() !!}</td>
                    <td style="font-size:11px;font-family:monospace;font-weight:700;color:#0f4c81">
                        @if($p->token_pendaftaran) 🔑 {{ $p->token_pendaftaran }} @else — @endif
                        @if($p->id == ($pelatihanAktifId ?? null))<br><span class="badge" style="background:#d1fae5;color:#065f46;font-size:10px">✓ Aktif</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-2" style="flex-wrap:wrap">
                            <a href="{{ route('pelatihan.show', $p->id) }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a>
                            @if($p->isAktif())
                            <form method="POST" action="{{ route('pelatihan.set-aktif') }}">
                                @csrf
                                <input type="hidden" name="pelatihan_id" value="{{ $p->id }}">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Pilih</button>
                            </form>
                            @else
                            <span style="font-size:11px;color:#94a3b8">
                                @if($p->isPending()) Pending @elseif($p->isSelesai()) Selesai @else Ditolak @endif
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#718096">
                        <i class="fas fa-chalkboard-teacher" style="font-size:36px;opacity:0.3;display:block;margin-bottom:12px"></i>
                        Belum ada pelatihan. <a href="{{ route('pelatihan.create') }}">Buat pelatihan pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="alert alert-info" style="margin-top:20px">
    <i class="fas fa-info-circle"></i>
    <div>
        <strong>Info:</strong> Pelatihan yang baru dibuat berstatus <em>Menunggu Konfirmasi</em>. 
        Borang baru dapat diisi setelah Super Admin mengaktifkan pelatihan tersebut.
    </div>
</div>
@endsection
