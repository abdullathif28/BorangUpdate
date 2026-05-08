@extends('layouts.admin')

@section('content')

<style>
    /* Modern Dashboard Styling */
    :root {
        --dash-primary: #2563eb;
        --dash-primary-light: #eff6ff;
        --dash-border: #e2e8f0;
        --dash-bg: #f8fafc;
        --dash-text: #334155;
        --dash-text-light: #64748b;
    }

    /* Flat Card Design */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid var(--dash-border);
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Modern Table */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 0.5rem; /* Ruang untuk scrollbar */
    }
    
    /* Custom Scrollbar agar selalu terlihat */
    .table-responsive::-webkit-scrollbar {
        height: 10px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 6px;
        margin: 0 1rem;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 6px;
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        white-space: nowrap; /* Mencegah teks bertumpuk ke bawah */
    }

    .table-custom th {
        background-color: var(--dash-bg);
        color: var(--dash-text);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem;
        border-bottom: 1px solid var(--dash-border);
        border-right: 1px solid var(--dash-border);
        vertical-align: middle;
    }

    .table-custom th:last-child {
        border-right: none;
    }

    .table-custom td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #475569;
        font-size: 0.875rem;
    }

    .table-custom td:last-child {
        border-right: none;
    }

    .table-custom tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Sticky First Columns (Fixed Overlap) */
    .table-custom th:nth-child(1), 
    .table-custom td:nth-child(1) {
        position: sticky;
        left: 0;
        background-color: #ffffff; /* Pastikan background putih agar tidak transparan saat scroll */
        z-index: 2;
        width: 50px;
        min-width: 50px;
    }
    
    .table-custom th:nth-child(2), 
    .table-custom td:nth-child(2) {
        position: sticky;
        left: 50px; /* Mengikuti lebar kolom 1 */
        background-color: #ffffff;
        z-index: 2;
        min-width: 200px;
        box-shadow: 2px 0 5px -2px rgba(0,0,0,0.08); /* Bayangan pemisah area sticky */
    }

    /* Tumpuk header sticky di atas baris data sticky */
    .table-custom th:nth-child(1), 
    .table-custom th:nth-child(2) {
        background-color: var(--dash-bg);
        z-index: 3; 
    }

    /* Mini Input for Pretest/Posttest */
    .input-mini {
        width: 70px !important;
        text-align: center;
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        transition: all 0.2s;
        margin: 0 auto;
    }
    .input-mini:focus {
        border-color: var(--dash-primary);
        box-shadow: 0 0 0 3px var(--dash-primary-light);
        outline: none;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--dash-border);
        background-color: #ffffff;
    }

    /* Empty State */
    .empty-state {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        color: #b45309;
        margin-bottom: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
</style>

@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan ?? collect(), 'pelatihan' => $pelatihan ?? null])

@if(!isset($pelatihan) || !$pelatihan)
<div class="empty-state">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #f59e0b; opacity: 0.8; margin-bottom: 16px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
    <h5 class="fw-bold mb-2">Perhatian</h5>
    <p class="mb-0" style="font-size: 15px;">Silakan pilih pelatihan terlebih dahulu pada menu di atas untuk melihat data borang rekapitulasi.</p>
</div>
@else

    <form action="{{ route('rekapitulasi.store') }}" method="POST">
        @csrf
        <div class="dashboard-card mb-5">
            <!-- Header yang rapi dengan tombol di kanan -->
            <div class="section-header flex-column flex-sm-row gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 d-flex align-items-center justify-content-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-5 text-dark">Rekapitulasi Nilai Peserta</h6>
                        <small class="text-muted">Kelola nilai Pretest, Posttest, dan pantau rekap total.</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 fw-medium px-4 w-100 w-sm-auto justify-content-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan Rekap
                </button>
            </div>
            
            <div class="card-body p-0">
                <!-- Hint scroll untuk mobile/layar kecil -->
                <div class="d-block d-md-none text-center py-2 bg-light border-bottom text-muted" style="font-size: 0.75rem;">
                    <i class="bi bi-arrows-collapse me-1"></i> Geser tabel ke kiri/kanan untuk melihat semua kolom
                </div>

                <div class="table-responsive">
                    <table class="table-custom text-center align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-start">Nama Peserta</th>
                                <th class="text-start">Delegasi</th>
                                <th class="bg-primary bg-opacity-10 text-primary">Pretest</th>
                                <th class="bg-primary bg-opacity-10 text-primary">Posttest</th>

                                <!-- Kategori Penilaian -->
                                @foreach ($materiList as $materi)
                                    <th>{{ $materi->nama_materi }}</th>
                                @endforeach

                                @foreach ($materiList as $pendalaman)
                                    <th>{{ $pendalaman->nama_materi }}</th>
                                @endforeach

                                @foreach ($imamahList as $imamah)
                                    <th>{{ $imamah->nama_kajian }}</th>
                                @endforeach

                                @foreach ($gamesList as $games)
                                    <th>{{ $games->nama_games }}</th>
                                @endforeach

                                <!-- Rekap Akhir -->
                                <th class="bg-light">Jumlah</th>
                                <th class="bg-light">Rata-rata</th>
                                <th class="bg-light">Predikat</th>
                                <th class="bg-light">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($peserta as $p)
                                @php
                                    // Use model helper (consistent with raport export)
                                    $rata = $p->averageRaportScore();
                                    $predikat = $p->predikatRaport();
                                    $keterangan = in_array($predikat, ['A', 'B', 'C']) ? 'Lulus' : 'Tidak Lulus';
                                    
                                    // Warna Badge dinamis
                                    $badgePredikat = match($predikat) {
                                        'A' => 'bg-success',
                                        'B' => 'bg-primary',
                                        'C' => 'bg-info text-dark',
                                        default => 'bg-danger'
                                    };
                                    $badgeKeterangan = $keterangan == 'Lulus' ? 'bg-success' : 'bg-danger';
                                @endphp
                                <tr>
                                    <td class="text-center text-muted fw-medium">{{ $loop->iteration }}</td>
                                    <td class="text-start fw-bold text-dark">{{ $p->nama }}</td>
                                    <td class="text-start text-muted">{{ $p->asal_pimpinan }}</td>
                                    
                                    <!-- Input Pretest & Posttest -->
                                    <td class="bg-primary bg-opacity-10">
                                        <input type="number" name="pretest[{{ $p->id }}]" class="input-mini" value="{{ $p->pretest ?? 0 }}">
                                    </td>
                                    <td class="bg-primary bg-opacity-10">
                                        <input type="number" name="posttest[{{ $p->id }}]" class="input-mini" value="{{ $p->posttest ?? 0 }}">
                                    </td>

                                    {{-- Materi --}}
                                    @foreach ($materiList as $materi)
                                        @php
                                            $obs = $p->observasiProses->where('materi_id', $materi->id)->first();
                                        @endphp
                                        <td>{{ $obs ? $obs->afektif + $obs->psikomotorik + $obs->kognitif : 0 }}</td>
                                    @endforeach

                                    {{-- Pendalaman --}}
                                    @foreach ($materiList as $materi)
                                         @php
                                            $obs = $p->observasiPendalaman->firstWhere('materi_id', $materi->id);
                                        @endphp
                                        <td>
                                            {{ $obs ? $obs->afektif + $obs->psikomotorik + $obs->kognitif : 0 }}
                                        </td>
                                    @endforeach

                                    {{-- Imamah --}}
                                    @foreach ($imamahList as $materi)
                                        @php
                                            $obs = $p->observasiImamah->where('imamah_id', $materi->id)->first();
                                        @endphp
                                        <td>{{ $obs ? $obs->afektif + $obs->psikomotorik + $obs->kognitif : 0 }}</td>
                                    @endforeach

                                    {{-- Games --}}
                                    @foreach ($gamesList as $materi)
                                        @php
                                            $obs = $p->observasiGames->where('games_id', $materi->id)->first();
                                        @endphp
                                        <td>{{ $obs ? $obs->afektif + $obs->psikomotorik + $obs->kognitif : 0 }}</td>
                                    @endforeach

                                    {{-- Rekap Akhir --}}
                                    <td class="bg-light fw-bold text-dark">{{ $p->totalRaportScore() }}</td>
                                    <td class="bg-light fw-bold text-primary">{{ $rata }}</td>
                                    <td class="bg-light">
                                        <span class="badge {{ $badgePredikat }} rounded-pill px-3">{{ $predikat }}</span>
                                    </td>
                                    <td class="bg-light">
                                        <span class="badge {{ $badgeKeterangan }} px-2 py-1">{{ $keterangan }}</span>
                                    </td> 
                                    
                                    {{-- Aksi --}}
                                    <td class="text-center">
                                        <a href="{{ route('raport.export', $p->id) }}" target="_blank" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 shadow-sm">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                            PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top px-4 py-3">
                <div class="d-flex align-items-center text-muted" style="font-size: 0.875rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2 text-warning"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>Nilai <strong>Pretest & Posttest</strong> dapat diubah langsung di tabel, kemudian pastikan untuk klik tombol <strong class="text-dark">Simpan Rekap</strong>. Kolom lainnya dapat digeser (scroll) ke arah kanan.</span>
                </div>
            </div>
        </div>
    </form>
    
@endif
@endsection