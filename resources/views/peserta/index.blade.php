@extends('layouts.admin')
@section('title', 'Data Kader/Peserta')
@section('page-title', 'Data Kader / Peserta')
@section('page-subtitle', 'Kelola data peserta per pelatihan')

@section('content')

{{-- Selector Pelatihan --}}
@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan, 'pelatihan' => $pelatihan ?? null])

@if(!$pelatihan)
<div class="card" style="text-align:center;padding:40px;color:#718096">
    <i class="fas fa-exclamation-triangle" style="font-size:36px;opacity:0.4;display:block;margin-bottom:12px;color:#f59e0b"></i>
    <p>Pilih pelatihan terlebih dahulu untuk melihat data peserta.</p>
</div>
@else

{{-- Token Info --}}
@if($pelatihan->token_pendaftaran)
<div class="card mb-3" style="background:linear-gradient(135deg,#0f4c81,#1a6bb5);color:white;padding:18px 22px">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
            <div style="font-size:12px;opacity:0.8">Token Pendaftaran Peserta Mandiri</div>
            <div style="font-size:22px;font-weight:800;letter-spacing:4px;font-family:monospace">{{ $pelatihan->token_pendaftaran }}</div>
            <div style="font-size:11px;opacity:0.7">Bagikan token ini ke peserta untuk daftar mandiri via: <strong>{{ url('/daftar-peserta?token='.$pelatihan->token_pendaftaran) }}</strong></div>
        </div>
        <div>
            <a href="{{ url('/daftar-peserta?token='.$pelatihan->token_pendaftaran) }}" target="_blank" class="btn btn-sm" style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.4)">
                <i class="fas fa-external-link-alt"></i> Buka Link Daftar
            </a>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <h6><i class="fas fa-users" style="margin-right:8px;color:#0f4c81"></i>
            Peserta: {{ $pelatihan->nama_pelatihan }}
            <span class="badge" style="background:#dbeafe;color:#1e40af;font-size:11px;margin-left:8px">{{ $peserta->count() }} peserta</span>
        </h6>
        <a href="{{ route('peserta.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Peserta
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Asal Pimpinan</th>
                    <th>Jenis Kelamin</th>
                    <th>No. HP</th>
                    <th>Nilai Rata-rata</th>
                    <th>Predikat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta as $i => $p)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div style="font-weight:600">{{ $p->nama }}</div>
                        <div style="font-size:11px;color:#718096">{{ $p->ttl }}</div>
                    </td>
                    <td class="text-sm">{{ $p->asal_pimpinan }}</td>
                    <td>
                        <span class="badge" style="{{ $p->jenis_kelamin === 'Laki-laki' ? 'background:#dbeafe;color:#1e40af' : 'background:#fce7f3;color:#be185d' }}">
                            {{ $p->jenis_kelamin }}
                        </span>
                    </td>
                    <td class="text-sm">{{ $p->nomor_hp }}</td>
                    <td style="font-weight:700;color:#0f4c81;text-align:center">
                        {{ $p->averageRaportScore() ?: '-' }}
                    </td>
                    <td style="text-align:center">
                        @php $pred = $p->predikatRaport(); @endphp
                        @if($p->averageRaportScore() > 0)
                        <span class="badge" style="{{ in_array($pred,['A','B']) ? 'background:#d1fae5;color:#065f46' : (($pred==='C')?'background:#fef3c7;color:#92400e':'background:#fee2e2;color:#991b1b') }}">
                            {{ $pred }} — {{ $p->keteranganBimbingan() }}
                        </span>
                        @else
                        <span style="color:#94a3b8;font-size:12px">Belum ada nilai</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2" style="flex-wrap:wrap">
                            <a href="{{ route('peserta.edit', $p->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('syahadah.export', $p->id) }}" class="btn btn-sm btn-primary" title="Cetak Syahadah" target="_blank">
                                <i class="fas fa-certificate"></i>
                            </a>
                            <a href="{{ route('raport.export', $p->id) }}" class="btn btn-sm btn-secondary" title="Cetak Raport" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <form method="POST" action="{{ route('peserta.destroy', $p->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus peserta {{ $p->nama }}?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#718096">
                        <i class="fas fa-users" style="font-size:36px;opacity:0.3;display:block;margin-bottom:12px"></i>
                        Belum ada peserta terdaftar di pelatihan ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@x-alert-script
@endsection
