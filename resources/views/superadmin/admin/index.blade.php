@extends('layouts.superadmin')
@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')
@section('page-subtitle', 'Manajemen seluruh admin daerah/wilayah')

@section('content')
<div class="card">
    <div class="card-header">
        <h6><i class="fas fa-users-cog" style="margin-right:8px;color:#0f4c81"></i>Daftar Admin</h6>
        <div class="d-flex gap-2">
            <span style="font-size:12px;color:#718096">Total: {{ $admins->total() }} admin</span>
        </div>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pimpinan</th>
                    <th>Tingkat</th>
                    <th>Ketua Umum</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Jml Cabang</th>
                    <th>Pelatihan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $i => $admin)
                <tr>
                    <td>{{ $admins->firstItem() + $i }}</td>
                    <td>
                        <div style="font-weight:600">{{ $admin->nama_pimpinan }}</div>
                        <div style="font-size:11px;color:#718096">Daftar: {{ $admin->created_at->format('d/m/Y') }}</div>
                    </td>
                    <td><span class="badge" style="background:#dbeafe;color:#1e40af">{{ $admin->tingkat_pimpinan }}</span></td>
                    <td class="text-sm">{{ $admin->nama_ketum ?? '-' }}</td>
                    <td class="text-sm">{{ $admin->email }}</td>
                    <td class="text-sm">{{ $admin->nomor_hp ?? '-' }}</td>
                    <td style="text-align:center">{{ $admin->jumlah_cabang ?? '-' }}</td>
                    <td style="text-align:center">
                        <span style="font-weight:700;color:#0f4c81">{{ $admin->pelatihan->count() }}</span>
                    </td>
                    <td>
                        @if($admin->status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($admin->status === 'approved')
                            <span class="badge badge-approved">Aktif</span>
                        @else
                            <span class="badge badge-rejected">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            @if($admin->status === 'pending')
                            <form method="POST" action="{{ route('superadmin.admin.approve', $admin->id) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success" title="Setujui">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $admin->id }}, '{{ $admin->nama_pimpinan }}')" title="Tolak">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                            @elseif($admin->status === 'approved')
                            <form method="POST" action="{{ route('superadmin.admin.reject', $admin->id) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="catatan" value="Akses dicabut oleh Super Admin">
                                <button class="btn btn-sm btn-warning" title="Nonaktifkan"
                                    onclick="return confirm('Nonaktifkan admin ini?')">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('superadmin.admin.edit', $admin->id) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('superadmin.admin.destroy', $admin->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Hapus admin ini? Data sub-role akan ikut terhapus.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:40px;color:#718096">
                        <i class="fas fa-users" style="font-size:36px;opacity:0.3;display:block;margin-bottom:12px"></i>
                        Belum ada admin terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($admins->hasPages())
    <div style="padding:16px 22px;border-top:1px solid #f0f4f8">
        {{ $admins->links() }}
    </div>
    @endif
</div>

<!-- Modal Tolak -->
<div id="rejectModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;display:none;align-items:center;justify-content:center">
    <div style="background:white;border-radius:14px;padding:28px;width:440px;max-width:95%">
        <h6 style="font-size:16px;font-weight:700;margin-bottom:4px;color:#0f4c81">Tolak Pendaftaran</h6>
        <p id="rejectName" style="font-size:13px;color:#718096;margin-bottom:20px"></p>
        <form id="rejectForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Catatan Penolakan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Alasan penolakan..."></textarea>
            </div>
            <div class="d-flex gap-2" style="justify-content:flex-end">
                <button type="button" onclick="hideRejectModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showRejectModal(id, name) {
    document.getElementById('rejectName').textContent = 'Admin: ' + name;
    document.getElementById('rejectForm').action = '/superadmin/admin/' + id + '/reject';
    document.getElementById('rejectModal').style.display = 'flex';
}
function hideRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endpush
