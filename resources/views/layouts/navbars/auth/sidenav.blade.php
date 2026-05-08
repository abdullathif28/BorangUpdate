<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="./img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">
                {{ auth()->user()->nama_pimpinan ?? 'BorangDigital' }}
            </span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php $role = auth()->user()->role ?? 'guest'; @endphp

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- ADMIN & SUPERADMIN: Menu Lengkap --}}
            @if(in_array($role, ['admin', 'superadmin']))
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pelatihan</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'pelatihan') ? 'active' : '' }}" href="{{ route('pelatihan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Daftar Pelatihan</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Borang</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'keaktifan') && !str_contains(request()->url(), 'imamah') && !str_contains(request()->url(), 'games') ? 'active' : '' }}" href="{{ route('keaktifan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-check-bold text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Observasi Materi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasiPendalaman') ? 'active' : '' }}" href="{{ route('page',['page' => 'observasiPendalaman']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chat-round text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pendalaman</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasiImamahKajian') ? 'active' : '' }}" href="{{ route('page', ['page' => 'observasiImamahKajian']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Imamah</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasigames') ? 'active' : '' }}" href="{{ route('page', ['page' => 'observasigames']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-gamepad text-warning text-sm"></i>
                    </div>
                    <span class="nav-link-text ms-1">Games</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'hafalan') ? 'active' : '' }}" href="{{ route('hafalan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Hafalan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'notulensi') ? 'active' : '' }}" href="{{ route('page', ['page' => 'notulensi']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-alt text-primary text-sm"></i>
                    </div>
                    <span class="nav-link-text ms-1">Notulensi</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'peserta') ? 'active' : '' }}" href="{{ route('peserta.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-bar-32 text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Data Kader</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'rekapitulasi') ? 'active' : '' }}" href="{{ route('page', ['page' => 'rekapitulasi']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Rekapitulasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'admin/tim') ? 'active' : '' }}" href="{{ route('admin.subrole.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-tag text-dark text-sm"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tim (IOT/MOG/Observer)</span>
                </a>
            </li>
            @endif

            {{-- OBSERVER: Observasi Materi & Pendalaman --}}
            @if($role === 'observer')
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Borang Saya</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'keaktifan') ? 'active' : '' }}" href="{{ route('keaktifan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-check-bold text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Observasi Materi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasiPendalaman') ? 'active' : '' }}" href="{{ route('page',['page' => 'observasiPendalaman']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chat-round text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pendalaman</span>
                </a>
            </li>
            @endif

            {{-- IOT: Imamah + Hafalan --}}
            @if($role === 'iot')
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Borang Saya</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasiImamahKajian') ? 'active' : '' }}" href="{{ route('page', ['page' => 'observasiImamahKajian']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Imamah</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'hafalan') ? 'active' : '' }}" href="{{ route('hafalan.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Hafalan</span>
                </a>
            </li>
            @endif

            {{-- MOG: Games --}}
            @if($role === 'mog')
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Borang Saya</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'observasigames') ? 'active' : '' }}" href="{{ route('page', ['page' => 'observasigames']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-gamepad text-warning text-sm"></i>
                    </div>
                    <span class="nav-link-text ms-1">Games</span>
                </a>
            </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt text-danger text-sm"></i>
                        </div>
                        <span class="nav-link-text ms-1">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="sidenav-footer mx-3">
        @php $u = auth()->user(); @endphp
        <div class="card card-plain shadow-none bg-light p-2 mb-2">
            <div class="text-center">
                <span class="badge bg-primary text-white mb-1">{{ $u->getRoleLabel() }}</span>
                <div class="text-xs font-weight-bold">{{ $u->nama_pimpinan ?? $u->name }}</div>
                @if($u->isSubRole())
                <div class="text-xs text-secondary">Token: <code>{{ $u->token_login }}</code></div>
                @if($u->pelatihanTugas)
                <div class="text-xs text-secondary mt-1" style="font-size:10px">
                    📋 {{ Str::limit($u->pelatihanTugas->nama_pelatihan, 22) }}
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</aside>
