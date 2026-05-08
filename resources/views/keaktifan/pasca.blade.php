<div class="card mb-4">
    <div class="card-header pb-0">
        <h6>Observasi Keaktifan (Pasca Materi)</h6>
    </div>
<div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive">
        <table class="table align-items-center mb-0 text-center align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Noo</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Nama</th>
                    @foreach ($materi as $m)
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" colspan="3">{{ $m->nama_materi }}</th>
                    @endforeach
                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Rata-rata</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    @foreach ($materi as $m)
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Afektif</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Kognitif</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Psikomotorik</th>
                    @endforeach
                </tr>
            </thead>
            <tbody> 
                @foreach ($peserta as $index => $p)
                        <tr>
                            <form action="{{ route('observasipasca.store') }}" method="POST">
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
            document.addEventListener('DOMContentLoaded', function () {
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
        
            // Tetap aktifkan live update jika ada perubahan nilai
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
@endif
@endsection