@extends('layouts.admin')

@section('content')
    
    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Observasi FGD</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 5%;">No</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 15%;">Nama</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 1</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 2</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 3</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 4</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 5</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" colspan="2" style="width: 10%; border:1px solid white">FGD 6</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%; ">Nilai</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" rowspan="2" style="width: 10%; ">Status</th>
                                    </tr>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Diskusi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">Presentasi</th>
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
                                            <td><input type="number" name="fgd_6[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_7[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_8[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_9[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_10[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_11[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_12[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td class="align-middle text-center">
                                                <button type="submit" class="btn btn-sm bg-gradient-success text-white px-3 py-1 rounded">
                                                    Simpan
                                                </button>
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white px-3 py-1 rounded">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="text-xs font-weight-bold mb-0">
                                            <td>2</td>
                                            <td>Andrian Soleh</td>
                                            <input type="hidden" name="nama[]" value="Andrian Soleh">
                                            <td><input type="number" name="fgd_1[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_2[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_3[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_4[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_5[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_6[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_7[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_8[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_9[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_10[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_11[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_12[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td class="align-middle text-center">
                                                <button type="submit" class="btn btn-sm bg-gradient-success text-white px-3 py-1 rounded">
                                                    Simpan
                                                </button>
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white px-3 py-1 rounded">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="text-xs font-weight-bold mb-0">
                                            <td>3</td>
                                            <td>Andrian Soleh</td>
                                            <input type="hidden" name="nama[]" value="Andrian Soleh">
                                            <td><input type="number" name="fgd_1[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_2[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_3[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_4[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_5[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_6[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_7[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_8[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_9[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_10[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_11[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_12[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td class="align-middle text-center">
                                                <button type="submit" class="btn btn-sm bg-gradient-success text-white px-3 py-1 rounded">
                                                    Simpan
                                                </button>
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white px-3 py-1 rounded">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="text-xs font-weight-bold mb-0">
                                            <td>4</td>
                                            <td>Andrian Soleh</td>
                                            <input type="hidden" name="nama[]" value="Andrian Soleh">
                                            <td><input type="number" name="fgd_1[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_2[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_3[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_4[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_5[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_6[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_7[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_8[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_9[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_10[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_11[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
                                            <td><input type="number" name="fgd_12[]" class="form-control form-control-sm w-75 mx-auto" placeholder="0"></td>
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
            </div>
        </div>
    @endsection

