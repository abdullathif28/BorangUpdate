@extends('layouts.admin')

@section('content')
    
    <div class="container mt-5">
        <div class="row justify-content-center"> 
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $pelatihan->nama_pelatihan }} - Detail Pelatihan</div>

                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <th>Nama LFP / Korps Fasilitator Daerah</th>
                                    <td>{{ $pelatihan->nama_lfp }}</td>
                                </tr>
                                <tr>
                                    <th>Email LFP / Korps Fasilitator Daerah</th>
                                    <td>{{ $pelatihan->email_lfp }}</td> 
                                </tr>
                                <tr>
                                    <th>Nama MoT</th>
                                    <td>{{ $pelatihan->nama_mot }}</td>
                                </tr>
                                <tr>
                                    <th>NBA MoT</th>
                                    <td>{{ $pelatihan->nba_mot }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Asisten MoT</th>
                                    <td>{{ $pelatihan->nama_asisten_mot }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor HP Asisten MoT</th>
                                    <td>{{ $pelatihan->hp_asisten_mot }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pelatihan</th>
                                    <td>{{ $pelatihan->nama_pelatihan }}</td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara Pelatihan</th>
                                    <td>{{ $pelatihan->penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ketua Umum Penyelenggara</th>
                                    <td>{{ $pelatihan->nama_ketum }}</td>
                                </tr>
                                <tr>
                                    <th>NBA Ketua Umum Penyelenggara</th>
                                    <td>{{ $pelatihan->nba_ketum }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pelatihan</th>
                                    <td>{{ $pelatihan->tanggal_pelatihan }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Pelatihan</th>
                                    <td>{{ $pelatihan->tempat_pelatihan }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Materi</th>
                                    <td>{{ $pelatihan->jumlah_materi }} Materi</td>
                                </tr>
                                <tr>
                                    <th>Token Pendaftaran Peserta</th>
                                    <td>
                                        @if($pelatihan->token_pendaftaran)
                                        <span style="font-family:monospace;font-size:18px;font-weight:800;color:#0f4c81;letter-spacing:3px">{{ $pelatihan->token_pendaftaran }}</span>
                                        <div style="font-size:11px;color:#718096;margin-top:4px">
                                            Link daftar: <a href="{{ url('/daftar-peserta?token='.$pelatihan->token_pendaftaran) }}" target="_blank">{{ url('/daftar-peserta?token='.$pelatihan->token_pendaftaran) }}</a>
                                        </div>
                                        @else
                                        <span style="color:#94a3b8">Belum ada token</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah FGD</th>
                                    <td>{{ $pelatihan->jumlah_fgd }} FGD</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Hafalan</th>
                                    <td>{{ $pelatihan->jumlah_hafalan }} Ayat</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Kajian</th>
                                    <td>{{ $pelatihan->jumlah_kajian }} Kajian</td>
                                </tr>
                            </tbody>
                        </table>

                        <h5>Daftar FGD:</h5>
                        <ul>
                            @foreach($pelatihan->fgd as $fgd)
                                <li>{{ $fgd->nama_fgd }}</li>
                            @endforeach
                        </ul>

                        <h5>Daftar Ayat Hafalan:</h5>
                        <ul>
                            @forelse($pelatihan->ayatPelatihan->sortBy('urutan') as $ayat)
                                <li><strong>{{ $ayat->urutan }}.</strong> {{ $ayat->nama_ayat }}</li>
                            @empty
                                <li style="color:#94a3b8">Belum ada ayat hafalan</li>
                            @endforelse
                        </ul>

                        <h5>Daftar Materi:</h5>
                        <ul>
                            @foreach($pelatihan->materi as $m)
                                <li>{{ $m->nama_materi }}</li>
                            @endforeach
                        </ul>

                        <h5>Daftar Kajian/Imamah:</h5>
                        <ul>
                            @foreach($pelatihan->imamahKajian as $k)
                                <li>{{ $k->nama_kajian }}</li>
                            @endforeach
                        </ul>

                        <h5>Daftar Games:</h5>
                        <ul>
                            @foreach($pelatihan->games as $g)
                                <li>{{ $g->nama_games }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endsection

