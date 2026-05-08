@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', ($admin->nama_pimpinan ?? '-') . ' - ' . ($admin->tingkat_pimpinan ?? '-'))

@section('content')

@if($admin->status === 'approved')
<div class="grid-4">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-info"><h3>{{ $totalPelatihan }}</h3><p>Total Pelatihan</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info"><h3>{{ $aktifPelatihan }}</h3><p>Pelatihan Aktif</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
        <div class="stat-info"><h3>{{ $pendingPelatihan }}</h3><p>Menunggu Konfirmasi</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger"><i class="fas fa-users"></i></div>
        <div class="stat-info"><h3>{{ $totalPeserta }}</h3><p>Total Peserta</p></div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-chalkboard-teacher" style="margin-right:8px;color:#0f4c81"></i>Pelatihan Saya</h6>
            <a href="{{ route('pelatihan.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div style="padding:0">
            <table>
                <thead>
                    <tr><th>Nama Pelatihan</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($recentPelatihan as $p)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:13px">{{ $p->nama_pelatihan }}</div>
                            <div style="font-size:11px;color:#718096">{{ $p->tempat_pelatihan }}</div>
                        </td>
                        <td class="text-sm">{{ \Carbon\Carbon::parse($p->tanggal_pelatihan)->format('d M Y') }}</td>
                        <td>{!! $p->getStatusBadge() !!}</td>
                        <td>
                            <a href="{{ route('pelatihan.show', $p->id) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;padding:24px;color:#718096">Belum ada pelatihan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6><i class="fas fa-user-tag" style="margin-right:8px;color:#0f4c81"></i>Tim Saya</h6>
            <a href="{{ route('admin.subrole.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        <div style="padding:22px">
            <p style="font-size:13px;color:#718096;margin-bottom:16px">
                Total: <strong>{{ $totalSubRole }}</strong> anggota tim
            </p>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                <a href="{{ route('admin.subrole.index') }}" class="btn btn-outline">
                    <i class="fas fa-mosque"></i> IOT
                </a>
                <a href="{{ route('admin.subrole.index') }}" class="btn btn-outline">
                    <i class="fas fa-gamepad"></i> MOG
                </a>
                <a href="{{ route('admin.subrole.index') }}" class="btn btn-outline">
                    <i class="fas fa-clipboard-list"></i> Observer
                </a>
            </div>
        </div>
    </div>
</div>

@else
<div class="alert alert-warning" style="font-size:15px">
    <i class="fas fa-clock" style="font-size:24px"></i>
    <div>
        <strong>Akun Anda sedang dalam proses review</strong><br>
        <span style="font-size:13px">Pendaftaran Anda sedang menunggu persetujuan Super Admin. Anda akan mendapat notifikasi setelah disetujui.</span>
    </div>
</div>
@endif
@endsection
