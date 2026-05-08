<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport Peserta - {{ $peserta->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 40px;
        }
        h2, h4, h3 {
            text-align: center;
            margin: 0;
            text-transform: uppercase;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h3>Laporan Hasil Belajar</h3>
    <h4>{{ $pelatihan->nama_pelatihan}}</h4> 
    <h4>{{ $pelatihan->penyelenggara }}</h4>
    {{-- <td>{{ $pelatihan->tanggal_pelatihan }}</td> --}}
{{-- <h4>Tanggal Kegiatan: {{ $p->pelatihan->tanggal_pelatihan ? \Carbon\Carbon::parse($p->pelatihan->tanggal_pelatihan)->format('d-m-Y') : '-' }}</h4> --}}
    <div class="info">
        <p><strong>Nama:</strong> {{ $peserta->nama }}</p>
        <p><strong>Delegasi:</strong> {{ $peserta->asal_pimpinan }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Materi</th>
                <th>Nilai</th>
                {{-- <th>Predikat</th> --}}
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($materiList as $materi)
                <tr class="text-align left">
                    <td>{{ $no++ }}</td>
                    <td>{{ $materi->nama_materi }}</td>
                    @php
                        $obs = $peserta->observasiProses->where('materi_id', $materi->id)->first();
                    @endphp
                    <td>{{ $obs ? $obs->afektif + $obs->psikomotorik + $obs->kognitif : 0 }}</td>
                    
                </tr>
            @endforeach
           

            <tr>
                <td>{{ $no++ }}</td>
                <td>Observasi Pendalaman</td>
                <td>{{ $peserta->observasiPendalamanAverage() }}</td>
                
            </tr>
            <tr>
                <td>{{ $no++ }}</td>
                <td>Observasi Imamah</td>
                <td>{{ $peserta->observasiImamahAverage() }}</td>
               
            </tr>
            <tr>
                <td>{{ $no++ }}</td>
                <td>Observasi Games</td>
                <td>{{ $peserta->observasiGamesAverage() }}</td>
                
            </tr>
            <tr>
                <td colspan="2"><strong>Jumlah</strong></td>
                 <td>{{ $peserta->totalRaportScore() }}</td>
                 
            </tr>
            <tr>
                <td colspan="2"><strong>Rata-rata</strong></td>
                <td>{{ $peserta->averageRaportScore() }}</td>
                
            </tr>
            <tr>
                <td colspan="2"><strong>Predikat</strong></td>
                 <td>{{ $peserta->predikatRaport() }}</td>
                
            </tr>
            <tr>
                <td colspan="2"><strong>Keterangan</strong></td>
                <td><strong>{{ $peserta->keteranganBimbingan() }}</strong></td>
               
            </tr>
        </tbody>
    </table>
  <p style="text-align: right;">
    Brebes, {{ \Carbon\Carbon::now()->format('d M Y') }}
</p>
    
    <table style="border: none;">
         <tr>
            <td style="border: none; text-align:center;" colspan="2">Mengetahui,</td>
        </tr>
        <tr>
            <td style="border: none; text-align: center;">
               Ketua Umum<br>
                Pimpinan Pelatihan<br><br><br><br>
                ({{ $pelatihan->nama_ketum }})
                {{-- (___________________) --}}
            </td>
            <td style="border: none; text-align: center;">
                Master of Training<br>
                <br><br><br><br>
                ({{ $pelatihan->nama_mot }})
            </td>
        </tr>
        
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
    </div>
</body>
</html>
