<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ranking Peserta</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h2 {
            text-align: center;
        }
        p {
            text-align: center;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .hijau {
            background-color: #ffffffff;
        }
        .kuning {
            background-color: #fff9c4;
        }
        .merah {
            background-color: #ffcdd2;
        }
    </style>
</head>
<body>

    <h2>Ranking Peserta Pelatihan</h2>
    @if($pelatihan)
        <p>{{ $pelatihan->nama_pelatihan }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Delegasi</th>
                <th>Total Nilai</th>
                <th>Rata-rata</th>
                <th>Predikat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $index => $p)
                @php
                    $ranking  = $index + 1;
                    $rata     = $p->rata_akhir ?? 0;
                    $predikat = $p->predikat_akhir ?? 'E';
                    $ket      = in_array($predikat, ['A', 'B', 'C']) ? 'Lulus' : 'Tidak Lulus';

                    if ($ranking <= 10) {
                        $warna = 'hijau';
                    } elseif ($ranking <= 25) {
                        $warna = 'kuning';
                    } else {
                        $warna = 'merah';
                    }
                @endphp
                <tr class="{{ $warna }}">
                    <td>{{ $ranking }}</td>
                    <td style="text-align:left;">{{ $p->nama }}</td>
                    <td>{{ $p->asal_pimpinan }}</td>
                    <td>{{ $p->nilai_akhir ?? 0 }}</td>
                    <td>{{ $rata }}</td>
                    <td>{{ $predikat }}</td>
                    <td>{{ $ket }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>