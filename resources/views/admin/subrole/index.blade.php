@extends('layouts.admin')
@section('title', 'Kelola Tim')
@section('page-title', 'Tim (IOT / MOG / Observer)')
@section('page-subtitle', 'Kelola anggota tim pelatihan Anda')

@section('content')
<div class="card">
    <div class="card-header">
        <h6><i class="fas fa-user-tag" style="margin-right:8px;color:#0f4c81"></i>Daftar Tim</h6>
        <a href="{{ route('admin.subrole.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Pelatihan Ditugaskan</th>
                    <th>Token Login</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subRoles as $i => $sr)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><div style="font-weight:600">{{ $sr->name }}</div></td>
                    <td>
                        @if($sr->role === 'iot')
                            <span class="badge" style="background:#dbeafe;color:#1e40af"><i class="fas fa-mosque"></i> IOT</span>
                        @elseif($sr->role === 'mog')
                            <span class="badge" style="background:#f3e8ff;color:#7c3aed"><i class="fas fa-gamepad"></i> MOG</span>
                        @else
                            <span class="badge" style="background:#fef3c7;color:#92400e"><i class="fas fa-eye"></i> Observer</span>
                        @endif
                    </td>
                    <td class="text-sm">{{ $sr->email }}</td>
                    <td class="text-sm">
                        @if($sr->pelatihanTugas)
                            <div style="font-weight:600;font-size:12px">{{ $sr->pelatihanTugas->nama_pelatihan }}</div>
                            <span class="badge" style="{{ $sr->pelatihanTugas->status === 'aktif' ? 'background:#d1fae5;color:#065f46' : 'background:#fef3c7;color:#92400e' }};font-size:10px">{{ strtoupper($sr->pelatihanTugas->status) }}</span>
                        @else
                            <span style="color:#94a3b8;font-size:12px">Tidak ditugaskan</span>
                        @endif
                    </td>
                    <td>
                        <code style="background:#f0f4f8;padding:4px 10px;border-radius:6px;font-size:14px;font-weight:700;letter-spacing:2px;color:#0f4c81">
                            {{ $sr->token_login }}
                        </code>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('admin.subrole.reset-token', $sr->id) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-warning" title="Reset Token"
                                    onclick="return confirm('Reset token untuk {{ $sr->name }}?')">
                                    <i class="fas fa-sync-alt"></i> Reset Token
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.subrole.destroy', $sr->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Hapus akun {{ $sr->name }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#718096">
                        <i class="fas fa-user-slash" style="font-size:36px;opacity:0.3;display:block;margin-bottom:12px"></i>
                        Belum ada anggota tim. Tambahkan IOT, MOG, atau Observer.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top:20px">
    <div class="card-body">
        <div style="display:flex;gap:16px;align-items:flex-start">
            <i class="fas fa-info-circle" style="color:#0f4c81;font-size:20px;margin-top:2px"></i>
            <div>
                <div style="font-weight:700;font-size:14px;margin-bottom:8px;color:#0f4c81">Cara Login dengan Token</div>
                <div style="font-size:13px;color:#4b5563;line-height:1.8">
                    Anggota tim (IOT, MOG, Observer) dapat login menggunakan token yang tertera di tabel.<br>
                    Cara: Buka halaman login → pilih tab <strong>"Login dengan Token"</strong> → masukkan token → klik Login.<br>
                    Token bersifat permanen sampai Anda melakukan reset.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
