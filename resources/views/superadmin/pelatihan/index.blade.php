@extends('layouts.superadmin')
@section('title', 'Kelola Pelatihan')
@section('page-title', 'Kelola Pelatihan')
@section('page-subtitle', 'Konfirmasi dan kelola seluruh pelatihan')

@section('content')
<div class="card">
    <div class="card-header">
        <h6><i class="fas fa-chalkboard-teacher" style="margin-right:8px;color:#0f4c81"></i>Daftar Pelatihan</h6>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelatihan</th>
                    <th>Admin</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Peserta</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelatihan as $i => $p)
                <tr>
                    <td>{{ $pelatihan->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600">{{ $p->nama_pelatihan }}</div>
                        <div style="font-size:11px;color:#718096">{{ $p->penyelenggara }}</div>
                    </td>
                    <td>
                        <div style="font-size:13px;font-weight:600">{{ $p->admin->nama_pimpinan ?? '-' }}</div>
                        <div style="font-size:11px;color:#718096">{{ $p->admin->tingkat_pimpinan ?? '' }}</div>
                    </td>
                    <td class="text-sm">{{ \Carbon\Carbon::parse($p->tanggal_pelatihan)->format('d M Y') }}</td>
                    <td class="text-sm">{{ $p->tempat_pelatihan }}</td>
                    <td style="text-align:center;font-weight:700;color:#0f4c81">{{ $p->pesertas->count() }}</td>
                    <td>{!! $p->getStatusBadge() !!}</td>
                    <td>
                        <div class="d-flex gap-2" style="flex-wrap:wrap">
                            <a href="{{ route('superadmin.pelatihan.show', $p->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($p->status === 'pending')
                                <form method="POST" action="{{ route('superadmin.pelatihan.approve', $p->id) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Aktifkan</button>
                                </form>
                                <button class="btn btn-sm btn-danger" onclick="showRejectPelatihan({{ $p->id }}, '{{ $p->nama_pelatihan }}')">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            @elseif($p->status === 'aktif')
                                <form method="POST" action="{{ route('superadmin.pelatihan.tutup', $p->id) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-warning" onclick="return confirm('Tutup pelatihan ini?')">
                                        <i class="fas fa-lock"></i> Tutup
                                    </button>
                                </form>
                            @elseif($p->status === 'selesai' || $p->status === 'ditolak')
                                <form method="POST" action="{{ route('superadmin.pelatihan.buka', $p->id) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Buka kembali pelatihan ini?')">
                                        <i class="fas fa-lock-open"></i> Buka
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('superadmin.pelatihan.destroy', $p->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pelatihan ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#718096">
                        <i class="fas fa-chalkboard-teacher" style="font-size:36px;opacity:0.3;display:block;margin-bottom:12px"></i>
                        Belum ada pelatihan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pelatihan->hasPages())
    <div style="padding:16px 22px;border-top:1px solid #f0f4f8">{{ $pelatihan->links() }}</div>
    @endif
</div>

<!-- Modal Tolak Pelatihan -->
<div id="rejectPelatihanModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center">
    <div style="background:white;border-radius:14px;padding:28px;width:440px;max-width:95%">
        <h6 style="font-size:16px;font-weight:700;margin-bottom:4px;color:#0f4c81">Tolak Pelatihan</h6>
        <p id="rejectPelatihanName" style="font-size:13px;color:#718096;margin-bottom:20px"></p>
        <form id="rejectPelatihanForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Alasan penolakan..."></textarea>
            </div>
            <div class="d-flex gap-2" style="justify-content:flex-end">
                <button type="button" onclick="hideRejectPelatihan()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Pelatihan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showRejectPelatihan(id, name) {
    document.getElementById('rejectPelatihanName').textContent = 'Pelatihan: ' + name;
    document.getElementById('rejectPelatihanForm').action = '/superadmin/pelatihan/' + id + '/reject';
    document.getElementById('rejectPelatihanModal').style.display = 'flex';
}
function hideRejectPelatihan() {
    document.getElementById('rejectPelatihanModal').style.display = 'none';
}
</script>
@endpush
