@extends('layouts.admin')

@section('content')

@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan ?? collect(), 'pelatihan' => $pelatihan ?? null])

@if(!isset($pelatihan) || !$pelatihan)
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:40px;text-align:center;color:#718096;margin-bottom:20px">
    <i class="fas fa-exclamation-triangle" style="font-size:36px;opacity:0.4;display:block;margin-bottom:12px;color:#f59e0b"></i>
    <p style="font-size:14px">Pilih pelatihan terlebih dahulu untuk melihat data borang.</p>
</div>
@else


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

    /* Clean Underlined Tabs */
    .modern-tabs {
        display: flex;
        gap: 2rem;
        border-bottom: 1px solid var(--dash-border);
        margin-bottom: 2rem;
        padding-left: 0;
        list-style: none;
        overflow-x: auto;
    }
    
    .modern-tabs .nav-item {
        margin-bottom: -1px;
    }

    .modern-tabs .nav-link {
        color: var(--dash-text-light);
        font-weight: 500;
        padding: 1rem 0.25rem;
        border-bottom: 2px solid transparent;
        transition: all 0.2s ease;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .modern-tabs .nav-link:hover {
        color: #0f172a;
        border-color: #cbd5e1;
    }
    
    .modern-tabs .nav-link.active {
        color: var(--dash-primary);
        border-color: var(--dash-primary);
    }

    /* Flat Card Design */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid var(--dash-border);
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    /* Modern Table */
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
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
    }

    .table-custom th:last-child {
        border-right: none;
    }

    .table-custom td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        border-right: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #475569;
    }

    .table-custom td:last-child {
        border-right: none;
    }

    .table-custom tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Subtle Headers for Assessment Categories */
    .th-afektif { background-color: #f0fdf4 !important; color: #166534 !important; }
    .th-kognitif { background-color: #eff6ff !important; color: #1e40af !important; }
    .th-psikomotorik { background-color: #fefce8 !important; color: #854d0e !important; }

    /* Custom Checkbox */
    .custom-cb {
        width: 18px;
        height: 18px;
        cursor: pointer;
        border-color: #cbd5e1;
    }
    .custom-cb:checked {
        background-color: var(--dash-primary);
        border-color: var(--dash-primary);
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .icon-box {
        background: var(--dash-primary-light);
        color: var(--dash-primary);
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="dashboard-card mb-5">
    <div class="card-body p-4 p-md-5">
        
        <div class="d-flex align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1" style="color: #0f172a;">Observasi Pendalaman</h5>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">Kelola dan catat hasil observasi peserta pada setiap sesi pendalaman.</p>
            </div>
        </div>
        
        <!-- Nav Materi (Underline UI) -->
        <ul class="nav modern-tabs" id="materi-tabs" role="tablist">
            @foreach($materi as $index => $materiItem)  
            <li class="nav-item">
                <a class="nav-link @if($index == 0) active @endif" 
                   id="materi-tab-{{ $materiItem->id }}" 
                   data-bs-toggle="tab" 
                   href="#materi-{{ $materiItem->id }}" 
                   role="tab">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                    {{ $materiItem->nama_materi }}
                </a>
            </li>
            @endforeach
        </ul>

        <!-- Tab Content per Materi -->
        <div class="tab-content" id="materi-tab-content">
            @foreach($materi as $index => $materiItem)
            <div class="tab-pane fade @if($index == 0) show active @endif" 
                 id="materi-{{ $materiItem->id }}" 
                 role="tabpanel">
                 
                <!-- Judul / Header Sesi -->
                <div class="section-header">
                    <div class="icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold" style="color: #0f172a;">{{ $materiItem->nama_materi }}</h5>
                        <div class="text-muted" style="font-size: 0.875rem;">Lembar Penilaian Keaktifan Peserta</div>
                    </div>
                </div>



                <form method="POST" action="{{ route('observasiPendalaman.store') }}">
                    @csrf
                    <input type="hidden" name="materi_id" value="{{ $materiItem->id }}">
                    
                    <div class="border rounded-3 overflow-hidden mb-4">
                        <div class="table-responsive">
                            <table class="table-custom text-center align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle border-bottom-0">No</th>
                                        <th rowspan="2" class="text-start align-middle border-bottom-0" style="min-width: 150px;">Nama Peserta</th>
                                        <th rowspan="2" class="align-middle border-bottom-0">Absensi</th>
                                        <!-- Clean Subtle Colored Headers -->
                                        <th colspan="4" class="th-afektif border-bottom">Afektif</th>
                                        <th colspan="2" class="th-kognitif border-bottom">Kognitif</th>
                                        <th colspan="4" class="th-psikomotorik border-bottom">Psikomotorik</th>
                                        <th rowspan="2" class="align-middle border-bottom-0 bg-light">Total</th>
                                    </tr>
                                    <tr>
                                        <!-- Afektif -->
                                        <th class="th-afektif border-top-0">1</th>
                                        <th class="th-afektif border-top-0">2</th>
                                        <th class="th-afektif border-top-0">3</th>
                                        <th class="th-afektif border-top-0">4</th>
                                        <!-- Kognitif -->
                                        <th class="th-kognitif border-top-0">1</th>
                                        <th class="th-kognitif border-top-0">2</th>
                                        <!-- Psikomotorik -->
                                        <th class="th-psikomotorik border-top-0">1</th>
                                        <th class="th-psikomotorik border-top-0">2</th>
                                        <th class="th-psikomotorik border-top-0">3</th>
                                        <th class="th-psikomotorik border-top-0">4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $indexPeserta => $p)
                                    <tr>
                                        <td class="text-muted">{{ $indexPeserta + 1 }}</td>
                                        <td class="text-start fw-medium text-dark">{{ $p->nama }}</td>
                                        <td>
                                            <input type="hidden" name="absensi[{{ $materiItem->id }}][{{ $p->id }}]" value="0">
                                            <input type="checkbox"
                                                class="form-check-input custom-cb checkbox-absensi materi-{{ $materiItem->id }} peserta-{{ $p->id }}"
                                                name="absensi[{{ $materiItem->id }}][{{ $p->id }}]"
                                                value="1"
                                                @if(isset($absensi[$materiItem->id . '_' . $p->id]) && $absensi[$materiItem->id . '_' . $p->id]->hadir)
                                                    checked
                                                @endif
                                            >
                                        </td>

                                        @php $kategori = ['afektif']; @endphp
                                        @foreach($kategori as $kat)
                                            <!-- Afektif -->
                                            @for($i = 0; $i < 4; $i++)
                                            <td>
                                                <input type="checkbox"
                                                    class="form-check-input custom-cb checkbox-afektif materi-{{ $materiItem->id }} peserta-{{ $p->id }}"
                                                    name="nilai[{{ $materiItem->id }}][{{ $p->id }}][afektif][]"
                                                    value="1"
                                                    @if(isset($observasi[$materiItem->id . '_' . $p->id]) && $i < ($observasi[$materiItem->id . '_' . $p->id]->afektif ?? 0) / 10)
                                                        checked
                                                    @endif
                                                >
                                            </td>
                                            @endfor

                                            {{-- Kognitif --}}
                                            @for($i = 0; $i < 2; $i++)
                                            <td>
                                                <input type="checkbox"
                                                    class="form-check-input custom-cb checkbox-kognitif materi-{{ $materiItem->id }} peserta-{{ $p->id }}"
                                                    name="nilai[{{ $materiItem->id }}][{{ $p->id }}][kognitif][]"
                                                    value="1"
                                                    @if(isset($observasi[$materiItem->id . '_' . $p->id]) && $i < ($observasi[$materiItem->id . '_' . $p->id]->kognitif ?? 0) / 10)
                                                        checked
                                                    @endif
                                                >
                                            </td>
                                            @endfor

                                            {{-- Psikomotorik --}}
                                            @for($i = 0; $i < 4; $i++)
                                            <td>
                                                <input type="checkbox"
                                                    class="form-check-input custom-cb checkbox-psikomotorik materi-{{ $materiItem->id }} peserta-{{ $p->id }}"
                                                    name="nilai[{{ $materiItem->id }}][{{ $p->id }}][psikomotorik][]"
                                                    value="1"
                                                    @if(isset($observasi[$materiItem->id . '_' . $p->id]) && $i < ($observasi[$materiItem->id . '_' . $p->id]->psikomotorik ?? 0) / 10)
                                                        checked
                                                    @endif
                                                >
                                            </td>
                                            @endfor
                                        @endforeach
                                        <td class="bg-light fw-bold" style="color: #0f172a;">
                                            <span id="avg-{{ $materiItem->id }}-{{ $p->id }}">0</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-medium d-flex align-items-center" style="border-radius: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Simpan Penilaian
                        </button>
                    </div>

                </form>
    
            </div>
            @endforeach
        </div>
    </div>
</div>

@endif

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const peserta = @json($peserta);
    const materi = @json($materi);

    peserta.forEach(p => {
        materi.forEach(m => {
            const aspekList = ['afektif', 'kognitif', 'psikomotorik'];

            const getCheckedCount = (aspek) => {
                return document.querySelectorAll(`.checkbox-${aspek}.materi-${m.id}.peserta-${p.id}:checked`).length;
            };

            const updateTotal = () => {
                let total = 0;
                aspekList.forEach(aspek => {
                    const count = getCheckedCount(aspek);
                    total += count * 10;
                });

                const totalEl = document.getElementById(`avg-${m.id}-${p.id}`);
                if (totalEl) {
                    totalEl.innerText = total;
                }
            };

            aspekList.forEach(aspek => {
                const checkboxes = document.querySelectorAll(`.checkbox-${aspek}.materi-${m.id}.peserta-${p.id}`);
                checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
            });

            updateTotal(); // Initialize saat pertama kali
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data Anda telah berhasil disimpan dengan baik.',
            showConfirmButton: false,
            timer: 3000,
            position: 'top-end',
            toast: true
        });
    @endif
});
</script>
@endpush