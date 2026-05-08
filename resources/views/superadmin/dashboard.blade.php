@extends('layouts.superadmin')
@section('title', 'Dashboard Super Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan seluruh sistem BorangDigital')

@section('content')
<div class="grid-4">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="fas fa-users-cog"></i></div>
        <div class="stat-info">
            <h3>{{ $totalAdmin }}</h3>
            <p>Admin Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <h3>{{ $pendingAdmin }}</h3>
            <p>Menunggu Persetujuan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-info">
            <h3>{{ $aktifPelatihan }}</h3>
            <p>Pelatihan Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-info">
            <h3>{{ $totalPeserta }}</h3>
            <p>Total Peserta</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Pelatihan Terbaru -->
    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-chalkboard-teacher" style="color:#0f4c81;margin-right:8px"></i>Pelatihan Terbaru</h6>
            <a href="{{ route('superadmin.pelatihan.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pelatihan</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPelatihan as $p)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:13px">{{ $p->nama_pelatihan }}</div>
                            <div style="font-size:11px;color:#718096">{{ $p->tanggal_pelatihan }}</div>
                        </td>
                        <td class="text-sm">{{ $p->admin->nama_pimpinan ?? '-' }}</td>
                        <td>{!! $p->getStatusBadge() !!}</td>
                        <td>
                            <a href="{{ route('superadmin.pelatihan.show', $p->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#718096;padding:24px">Belum ada pelatihan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Pending -->
    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-user-clock" style="color:#d97706;margin-right:8px"></i>Pendaftaran Admin Pending</h6>
            <a href="{{ route('superadmin.admin.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pimpinan</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAdmins as $admin)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:13px">{{ $admin->nama_pimpinan }}</div>
                            <div style="font-size:11px;color:#718096">{{ $admin->email }}</div>
                        </td>
                        <td><span class="badge" style="background:#dbeafe;color:#1e40af">{{ $admin->tingkat_pimpinan }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('superadmin.admin.approve', $admin->id) }}" style="display:inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                            </form>
                            <a href="{{ route('superadmin.admin.index') }}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#718096;padding:24px">Tidak ada pendaftaran pending</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
