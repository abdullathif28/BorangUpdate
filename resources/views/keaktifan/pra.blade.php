<style>
    .form-check-input:checked {
        background-color: #28a745 !important; /* Hijau */
        border-color: #28a745 !important;
    }

    .form-check-input:checked::before {
        color: white;
    }
</style>

<div class="card mb-4">
    <div class="card-header pb-0">
        <h6>Observasi Keaktifan (Pra-Materi)</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive">
            <table class="table align-items-center mb-0 text-center">
                <thead class="bg-light">
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">No</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Nama</th>
                        @foreach ($materi as $m)
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" colspan="3">{{ $m->nama_materi }}</th>
                        @endforeach
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Rata-rata</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        @foreach ($materi as $m)
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" >Afektif</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Kognitif</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Psikomotorik</th>

                          
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta as $index => $p) 
                        <tr>
                            <form action="{{ route('observasipra.store') }}" method="POST">
                                @csrf
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->nama }}</td> 
                                @foreach ($materi as $m)
                                    @php
                                        $nilai = $observasi[$p->id][$m->id]->afektif ?? []; // array of checked index
                                    @endphp
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @for ($i = 0; $i < 6; $i++)
                                                <div class="form-check">
                                                    <input class="form-check-input text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 afektif-checkbox-{{ $m->id }}" type="checkbox"
                                                        name="afektif[{{ $m->id }}][{{ $i }}]" value="1" 
                                                        {{ isset($observasi[$p->id][$m->id]->afektif[$i]) ? 'checked' : '' }}>
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @for ($i = 0; $i < 6; $i++)
                                                <div class="form-check">
                                                    <input class="form-check-input kognitif-checkbox-{{ $m->id }}" type="checkbox"
                                                        name="kognitif[{{ $m->id }}][{{ $i }}]" value="1"
                                                        {{ isset($observasi[$p->id][$m->id]->kognitif[$i]) ? 'checked' : '' }}>
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @for ($i = 0; $i < 6; $i++)
                                                <div class="form-check">
                                                    <input class="form-check-input psikomotorik-checkbox-{{ $m->id }}" type="checkbox"
                                                        name="psikomotorik[{{ $m->id }}][{{ $i }}]" value="1"
                                                        {{ isset($observasi[$p->id][$m->id]->psikomotorik[$i]) ? 'checked' : '' }}>
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    
                                    
                                @endforeach
                                <td class="rata-rata">0%</td>
                                <td>
                                    <input type="hidden" name="peserta_id" value="{{ $p->id }}">
                                    <button type="submit" class="btn btn-sm bg-gradient-success text-white px-3 py-1 rounded">Simpan</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>

            <script>
                function getScoreFromCheckboxCount(count) { 
                    if (count >= 1 && count <= 6) {
                        return 4 + count; // 1 = 5, 2 = 6, ..., 6 = 10
                    }
                    return 0;
                }
            
                function hitungRataRata() {
                    const rows = document.querySelectorAll('tbody tr');
            
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        let totalNilai = 0;
                        let jumlahMateri = 0;
            
                        for (let i = 2; i < cells.length - 2; i += 3) { // 3 kolom per materi
                            const afektifCheckboxes = cells[i].querySelectorAll('input[type="checkbox"]');
                            const kognitifCheckboxes = cells[i + 1].querySelectorAll('input[type="checkbox"]');
                            const psikomotorikCheckboxes = cells[i + 2].querySelectorAll('input[type="checkbox"]');
            
                            const afektifCount = Array.from(afektifCheckboxes).filter(cb => cb.checked).length;
                            const kognitifCount = Array.from(kognitifCheckboxes).filter(cb => cb.checked).length;
                            const psikomotorikCount = Array.from(psikomotorikCheckboxes).filter(cb => cb.checked).length;
            
                            const afektifScore = getScoreFromCheckboxCount(afektifCount);
                            const kognitifScore = getScoreFromCheckboxCount(kognitifCount);
                            const psikomotorikScore = getScoreFromCheckboxCount(psikomotorikCount);
            
                            const avgPerMateri = (afektifScore + kognitifScore + psikomotorikScore) / 3;
                            totalNilai += avgPerMateri;
                            jumlahMateri++;
                        }
            
                        const rataRata = jumlahMateri > 0 ? (totalNilai / jumlahMateri).toFixed(2) : '0.00';
                        const rataCell = row.querySelector('.rata-rata');
                        if (rataCell) rataCell.innerText = `${rataRata}%`;
                    });
                }
            
                document.addEventListener('DOMContentLoaded', hitungRataRata);
                document.addEventListener('input', hitungRataRata);
                document.addEventListener('change', hitungRataRata);
                document.addEventListener('input', function () {
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const inputs = row.querySelectorAll('.nilai');
                    let total = 0;
                    let count = 0;
                    inputs.forEach(input => {
                        const val = parseFloat(input.value);
                        if (!isNaN(val)) {
                            total += val;
                            count++;
                        }
                    });
                    const rataRata = count > 0 ? (total / count).toFixed(2) : 0;
                    const rataCell = row.querySelector('.rata-rata');
                    if (rataCell) {
                        rataCell.innerText = rataRata;
                    }
                });
            });
            </script>
            
        </div>
    </div>
</div>
