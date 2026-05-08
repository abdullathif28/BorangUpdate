@extends('layouts.admin')

@section('content')
    
    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Observasi Rencana Tindak Lanjut</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 5%;">No</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 15%;">Nama</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="4" style="width: 10%; border:1px solid white">Aspek</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%; ">Nilai</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%; ">Aksi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%; ">Status</th>
                                    </tr>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Penerapan Materi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Komitmen Diri</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Impact </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Laporan</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('keaktifan.store') }}" method="POST">
                                        @csrf
                                        <tr class="text-xs font-weight-bold mb-0">
                                            <td>1</td>
                                            <td>Andrian Soleh</td>
                                            <input type="hidden" name="nama[]" value="Andrian Soleh">
                                            <td><input type="number" name="fgd_1[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_2[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_3[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_4[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_5[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                           
                                          
                                           
                                            <td class="align-middle text-center">
                                                <button type="submit" class="btn btn-sm bg-gradient-success text-white px-3 py-1 rounded">
                                                    Simpan
                                                </button>
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white px-3 py-1 rounded">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                       
                                        
                                        
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Observasi Rencana Tindak Lanjut</h6>
                        <p class="text-s font-weight-bold mb-0">Indikator Ketercapaian</p>

                    </div>
            </div>
        </div>
    @endsection

