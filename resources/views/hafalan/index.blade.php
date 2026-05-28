@extends('layouts.admin')
@section('title', 'Hafalan')
@section('page-title', 'Hafalan')
@section('page-subtitle', 'Penilaian hafalan ayat per peserta')

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
        padding-bottom: 0.5rem;
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

    /* Sticky First Column (Nama Peserta) */
    .table-custom th:nth-child(1), 
    .table-custom td:nth-child(1) {
        position: sticky;
        left: 0;
        background-color: #ffffff; 
        z-index: 2;
        min-width: 240px;
        box-shadow: 2px 0 5px -2px rgba(0,0,0,0.08); /* Bayangan pemisah area sticky */
    }
    
    .table-custom th:nth-child(1) {
        background-color: var(--dash-bg);
        z-index: 3; 
    }

    /* Custom Checkbox */
    .custom-cb {
        width: 20px;
        height: 20px;
        cursor: pointer;
        border-color: #cbd5e1;
    }
    .custom-cb:checked {
        background-color: var(--dash-primary);
        border-color: var(--dash-primary);
    }
    .custom-cb:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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

    /* Empty States */
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
    
    .empty-state-neutral {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        color: #64748b;
        margin-bottom: 20px;
    }

    /* Action Buttons in Table */
    .btn-action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }
</style>

@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan, 'pelatihan' => $pelatihan ?? null])

@if(!$pelatihan)
<div class="empty-state">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #f59e0b; opacity: 0.8; margin-bottom: 16px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
    <h5 class="fw-bold mb-2">Perhatian</h5>
    <p class="mb-0" style="font-size: 15px;">Silakan pilih pelatihan terlebih dahulu untuk melihat data hafalan peserta.</p>
</div>
@elseif($ayat->isEmpty())
<div class="empty-state-neutral">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8; margin-bottom: 16px;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
    <h5 class="fw-bold mb-2 text-dark">Data Ayat Kosong</h5>
    <p class="mb-1" style="font-size: 15px;">Pelatihan ini belum memiliki daftar ayat hafalan.</p>
    <small>Silakan tambahkan referensi ayat saat mendaftarkan / mengedit pelatihan ini.</small>
</div>
@elseif($peserta->isEmpty())
<div class="empty-state-neutral">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8; margin-bottom: 16px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
    <h5 class="fw-bold mb-2 text-dark">Data Peserta Kosong</h5>
    <p class="mb-0" style="font-size: 15px;">Belum ada peserta yang terdaftar di pelatihan ini.</p>
</div>
@else

@php
    $jumlahAyat = $ayat->count();
    $nilaiPerAyat = $jumlahAyat > 0 ? round(100 / $jumlahAyat, 4) : 0;
@endphp

<!-- Modern Info Banner -->
<div class="alert d-flex align-items-center mb-4" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 0.75rem; padding: 1rem 1.25rem;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-3 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
    <div>
        Pelatihan ini mengujikan <strong class="text-dark">{{ $jumlahAyat }} ayat</strong>. 
        Setiap ayat yang diselesaikan bernilai <strong class="text-dark">{{ $nilaiPerAyat }} poin</strong> (Skor Maksimal: 100).
        Klik tombol <i class="fas fa-lock text-warning mx-1"></i> (Edit) pada baris peserta untuk mulai menilai.
    </div>
</div>

<div class="dashboard-card mb-5">
    <div class="section-header flex-column flex-sm-row gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 d-flex align-items-center justify-content-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            </div>
            <div>
                <h6 class="mb-0 fw-bold fs-5 text-dark">Hafalan — {{ $pelatihan->nama_pelatihan }}</h6>
                <small class="text-muted">Lembar observasi dan validasi hafalan ayat peserta.</small>
            </div>
        </div>
        <button type="submit" form="hafalanForm" class="btn btn-primary d-flex align-items-center gap-2 fw-medium px-4 w-100 w-sm-auto justify-content-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
            Simpan Semua
        </button>
    </div>
    
    <div class="card-body p-0">
        <!-- Hint scroll -->
        <div class="d-block d-md-none text-center py-2 bg-light border-bottom text-muted" style="font-size: 0.75rem;">
            <i class="bi bi-arrows-collapse me-1"></i> Geser tabel ke kiri/kanan untuk melihat semua ayat
        </div>

        <form action="{{ route('hafalan.store') }}" method="POST" id="hafalanForm">
            @csrf
            @foreach($peserta as $p)
                <input type="hidden" name="peserta_ids[]" value="{{ $p->id }}">
            @endforeach

            <div class="table-responsive">
                <table class="table-custom align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-start" style="vertical-align: bottom; border-bottom-width: 2px;">Data Peserta</th>
                            <th colspan="{{ $jumlahAyat }}" class="text-center bg-primary bg-opacity-10 text-primary border-bottom">Ayat Hafalan (Centang = Valid)</th>
                            <th rowspan="2" class="text-center bg-light" style="vertical-align: bottom; border-bottom-width: 2px;">Total Nilai</th>
                            <th rowspan="2" class="text-center" style="vertical-align: bottom; border-bottom-width: 2px;">Aksi</th>
                        </tr>
                        <tr>
                            @foreach($ayat as $a)
                            <!-- Menghilangkan Str::limit agar nama ayat tampil utuh -->
                            <th class="text-center bg-primary bg-opacity-10 text-dark border-top-0" style="min-width: 140px;">
                                {{ $a->nama_ayat }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peserta as $p)
                        <tr id="row-{{ $p->id }}">
                            <td class="text-start">
                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $p->nama }}</div>
                                <div class="text-muted mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-map-marker-alt me-1 opacity-50"></i> {{ $p->asal_pimpinan }}
                                </div>
                            </td>
                            
                            @foreach($ayat as $a)
                            <td class="text-center">
                                <input type="checkbox"
                                    name="hafal[{{ $p->id }}][{{ $a->id }}]"
                                    class="form-check-input custom-cb surat-checkbox"
                                    data-peserta="{{ $p->id }}"
                                    data-nilai="{{ $nilaiPerAyat }}"
                                    value="1"
                                    disabled
                                    {{ isset($hafalanData[$p->id][$a->id]) && $hafalanData[$p->id][$a->id]->hafal ? 'checked' : '' }}>
                            </td>
                            @endforeach
                            
                            <td class="text-center bg-light">
                                <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill shadow-sm" id="total-{{ $p->id }}">
                                    @php
                                        $total = 0;
                                        foreach($ayat as $a) {
                                            if(isset($hafalanData[$p->id][$a->id]) && $hafalanData[$p->id][$a->id]->hafal) {
                                                $total += $nilaiPerAyat;
                                            }
                                        }
                                    @endphp
                                    {{ round($total, 1) }}
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-action-icon edit-btn shadow-sm" data-id="{{ $p->id }}" title="Buka/Kunci Edit Data">
                                    <i class="fas fa-lock" style="font-size: 0.85rem;"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Footer form (optional, for redundancy/easy access at bottom) -->
            <div class="card-footer bg-white border-top px-4 py-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 fw-medium px-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Simpan Semua Data
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@x-alert-script
@endsection

@push('scripts')
<script>
const nilaiPerAyat = {{ $nilaiPerAyat ?? 0 }};

function updateTotal(pesertaId) {
    const checkboxes = document.querySelectorAll(`.surat-checkbox[data-peserta="${pesertaId}"]`);
    let total = 0;
    checkboxes.forEach(cb => { if (cb.checked) total += nilaiPerAyat; });
    
    const span = document.getElementById(`total-${pesertaId}`);
    if (span) span.textContent = Math.round(total * 10) / 10;
}

document.querySelectorAll('.surat-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
        updateTotal(this.dataset.peserta);
    });
});

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const row = document.getElementById(`row-${id}`);
        const checkboxes = row.querySelectorAll('.surat-checkbox');
        
        // Cek status disabled dari checkbox pertama
        const isDisabled = checkboxes[0]?.disabled ?? true;
        
        // Toggle disable/enable
        checkboxes.forEach(cb => cb.disabled = !isDisabled);
        
        // Ubah icon gembok terbuka/tertutup
        this.innerHTML = isDisabled ? '<i class="fas fa-lock-open"></i>' : '<i class="fas fa-lock"></i>';
        
        // Ubah style tombol (Merah saat terbuka/aktif edit, Kuning saat terkunci)
        this.classList.toggle('btn-warning', !isDisabled);
        this.classList.toggle('btn-danger', isDisabled);
        
        // Ubah warna latar belakang baris yang sedang diedit agar lebih jelas
        if (isDisabled) {
            row.style.backgroundColor = '#fffbeb'; // Highlight row
        } else {
            row.style.backgroundColor = ''; // Remove highlight
        }
    });
});

// Pastikan semua checkbox di-enable sebelum form dikirim, 
// agar checkbox dari baris yang terkunci nilainya tetap terkirim ke server 
// dan tidak dianggap 'kosong' (yang menyebabkan nilainya terhapus/menjadi 0).
document.getElementById('hafalanForm').addEventListener('submit', function() {
    document.querySelectorAll('.surat-checkbox').forEach(cb => {
        cb.disabled = false;
    });
});
</script>
@endpush