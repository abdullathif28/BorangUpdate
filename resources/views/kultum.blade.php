@extends('layouts.admin')

@section('content')

@include('components.pelatihan-selector', ['allPelatihan' => $allPelatihan ?? collect(), 'pelatihan' => $pelatihan ?? null])

@if(!isset($pelatihan) || !$pelatihan)
<div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:40px;text-align:center;color:#718096;margin-bottom:20px">
    <i class="fas fa-exclamation-triangle" style="font-size:36px;opacity:0.4;display:block;margin-bottom:12px;color:#f59e0b"></i>
    <p style="font-size:14px">Pilih pelatihan terlebih dahulu untuk melihat data borang.</p>
</div>
@else

    
    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Imamah</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 5%;">No</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 15%;">Nama</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="5" style="width: 10%; border: 1px solid white ">Aspek Penilaian</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%;">Nilai</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%;">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%; border: 1px solid white">Penguasaan Materi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Kesesuaian Tema</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Kefasihan</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Adab & Sikap</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Daya Tarik</th>
                                
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    @foreach($peserta as $index => $peserta)
                                        <tr>
                                            <form action="{{ route('kultum.store') }}" method="POST" class="form-nilai"> 
                                                @csrf
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $peserta->nama }}</td>
                                                <input type="hidden" name="id_peserta" value="{{ $peserta->id }}">
                                
                                                @foreach(['penguasaan_materi', 'kesesuaian_tema', 'kefasihan', 'adab_sikap', 'daya_tarik'] as $aspek)
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="\" name="{{ $aspek }}" value="1" data-id="{{ $peserta->id }}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                
                                                <td>
                                                    <input type="text" readonly class="form-control text-center" id="nilai-akhir-{{ $peserta->id }}" value="0">
                                                    <input type="hidden" name="total_nilai" id="hidden-nilai-{{ $peserta->id }}" value="0">
                                                </td>
                                
                                                <td>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.checkbox-penilaian');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const id = this.dataset.id;
                updateTotal(id);
            });
        });

        function updateTotal(id) {
            const aspek = ['penguasaan_materi', 'kesesuaian_tema', 'kefasihan', 'adab_sikap', 'daya_tarik'];
            let total = 0;

            aspek.forEach(a => {
                const cb = document.querySelector(`input[name='${a}'][data-id='${id}']`);
                if (cb && cb.checked) {
                    total += parseInt(cb.value);
                }
            });

            document.getElementById(`nilai-akhir-${id}`).value = total;
            document.getElementById(`hidden-nilai-${id}`).value = total;
        }
    });
</script>
@endif
@endsection