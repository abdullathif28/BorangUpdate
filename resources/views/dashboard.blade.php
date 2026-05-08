@extends('layouts.admin')

@section('content')

@php $user = auth()->user(); @endphp

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $user->getRoleLabel() }}</span>
                    </div>
                    <h4 class="fw-bold">Selamat Datang, {{ $user->name }}!</h4>
                    <p class="text-muted">Silakan gunakan menu di sebelah kiri untuk mengisi borang sesuai tugas Anda.</p>

                    @if($user->isIOT())
                    <div class="mt-4">
                        <a href="{{ route('page', ['page' => 'observasiImamahKajian']) }}" class="btn btn-success btn-lg">
                            <i class="ni ni-book-bookmark me-2"></i> Mulai Input Imamah
                        </a>
                    </div>
                    @elseif($user->isMOG())
                    <div class="mt-4">
                        <a href="{{ route('page', ['page' => 'observasigames']) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-gamepad me-2"></i> Mulai Input Games
                        </a>
                    </div>
                    @elseif($user->isObserver())
                    <div class="mt-4 d-flex gap-2 justify-content-center">
                        <a href="{{ route('keaktifan.index') }}" class="btn btn-primary">
                            <i class="ni ni-check-bold me-2"></i> Observasi Materi
                        </a>
                        <a href="{{ route('page', ['page' => 'observasiPendalaman']) }}" class="btn btn-warning">
                            <i class="ni ni-chat-round me-2"></i> Pendalaman
                        </a>
                    </div>
                    @endif

                    @if($user->isSubRole())
                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-muted">Token Login Anda: </small>
                        <code class="fs-5 fw-bold">{{ $user->token_login }}</code>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

