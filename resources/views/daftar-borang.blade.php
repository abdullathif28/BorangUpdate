@extends('layouts.admin')

@section('content')
    
    <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daftar Borang</h6>
                        <a href="{{ route('pendaftaran') }}" class="btn btn-sm bg-gradient-danger text-white">
                            Pendaftaran
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        {{-- <div class="table-responsive p-0">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 1</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 2</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 3</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 4</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 5</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Materi 6</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($peserta as $index => $item)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-sm font-weight-bold mb-0">{{ $item->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->materi_1 }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <button class="btn btn-sm bg-gradient-success text-white px-2 py-1 rounded">
                                                    {{ $item->materi_2 }}
                                                </button>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-sm bg-gradient-info text-white px-2 py-1 rounded">
                                                    {{ $item->materi_3 }}
                                                </button>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('observasi.edit', $item->id) }}" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Edit
                                                </a>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->materi_5 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->materi_6 }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div> --}}
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 5%;">No</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 15%;">Nama Pelatihan</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10%;">Waktu</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10%;">Ketua Umum</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10%;">MOT</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7" style="width: 10%;">Materi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"  style="width: 10%;">Aksi</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"  style="width: 10%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-xs font-weight-bold mb-0">
                                        <td class="text-xs font-weight-bold mb-0">1</td>
                                        <td class="text-xs font-weight-bold mb-0">Taruna Melati 2</td>
                                        <td>11 - 14 Maret 2024</td>
                                        <td class="text-xs font-weight-bold mb-0">Dhita Aprilia</td>
                                        <td class="text-xs font-weight-bold mb-0">Azkyah Imarotul</td>
                                        <td class="text-xs font-weight-bold mb-0">7</td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-sm bg-gradient-danger text-white px-2 py-1 rounded">
                                                Review
                                              </button>
                                        </td>
                                    </tr>
                                    <tr class="text-xs font-weight-bold mb-0">
                                        <td>2</td>
                                        <td>Taruna Melati 2</td>
                                        <td>20 - 23 Februari 2025</td>
                                        <td class="text-xs font-weight-bold mb-0">Andrian Soleh</td>
                                        <td class="text-xs font-weight-bold mb-0">Doni Agustia</td>
                                        <td class="text-xs font-weight-bold mb-0">6</td>
                                        <td class="align-middle text-center">
                                            <button class="btn btn-sm bg-gradient-danger text-white px-2 py-1 rounded">
                                                Review
                                              </button>
                                             
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    @endsection
