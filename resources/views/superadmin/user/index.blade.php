@extends('layouts.superadmin')
@section('title', 'Semua User')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Semua user dalam sistem')

@section('content')
<div class="card">
    <div class="card-header">
        <h6><i class="fas fa-users" style="margin-right:8px;color:#0f4c81"></i>Semua User</h6>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Admin Induk</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td><div style="font-weight:600">{{ $u->name ?? $u->nama_pimpinan }}</div></td>
                    <td class="text-sm">{{ $u->email }}</td>
                    <td>
                        @php
                            $roleColors = ['admin'=>'#dbeafe::#1e40af','iot'=>'#f3e8ff::#7c3aed','mog'=>'#fce7f3::#be185d','observer'=>'#fef3c7::#92400e'];
                            [$bg, $clr] = explode('::', $roleColors[$u->role] ?? '#e2e8f0::#475569');
                        @endphp
                        <span class="badge" style="background:{{ $bg }};color:{{ $clr }}">{{ $u->getRoleLabel() }}</span>
                    </td>
                    <td class="text-sm">{{ $u->admin?->nama_pimpinan ?? '-' }}</td>
                    <td>
                        @if($u->status === 'approved')
                            <span class="badge badge-approved">Aktif</span>
                        @elseif($u->status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @else
                            <span class="badge badge-rejected">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.user.destroy', $u->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:40px;color:#718096">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:16px 22px">{{ $users->links() }}</div>
    @endif
</div>
@endsection
