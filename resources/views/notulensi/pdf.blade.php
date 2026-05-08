<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notulensi {{ $notulensi->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 40px;
            line-height: 1.6;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .org-info {
            text-align: center;
            flex-grow: 1;
        }

        .org-info h2, .org-info p {
            margin: 0;
            line-height: 1.2;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            margin-top: 30px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        p {
            margin: 4px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
            word-break: break-word;
        }

        .label {
            font-weight: bold;
            width: 150px;
        }
    </style>
</head>
<body>

    <div class="header">
        {{-- <img src="{{ public_path('apple-icon.png') }}" alt="Logo" class="logo"> --}}
        <div class="org-info">
            <h2>Ikatan Pelajar Muhammadiyah</h2>
            <p>Pimpinan Daerah Kabupaten Brebes</p>
            <p>Jl. Contoh Alamat No. 123, Brebes</p>
        </div>
    </div>

    <h1>Notulensi Pelatihan</h1>
    <h2>{{ $notulensi->pelatihan->nama_pelatihan }}</h2>

    <table class="info-table">
        <tr><td class="label">Pengampu</td><td>{{ $notulensi->pengampu }}</td></tr>
        <tr><td class="label">Moderator</td><td>{{ $notulensi->moderator }}</td></tr>
        <tr><td class="label">Notulis</td><td>{{ $notulensi->notulis }}</td></tr>
        <tr><td class="label">Tanggal</td><td>{{ $notulensi->tanggal }}</td></tr>
        <tr><td class="label">Waktu Mulai</td><td>{{ $notulensi->waktu_mulai }}</td></tr>
        <tr><td class="label">Waktu Selesai</td><td>{{ $notulensi->waktu_selesai }}</td></tr>
        <tr><td class="label">Jumlah Peserta</td><td>{{ $notulensi->jumlah_peserta }}</td></tr>
        <tr><td class="label">Kondisi Peserta</td><td>{{ $notulensi->kondisi_peserta }}</td></tr>
    </table>

    <div class="section">
        <h2>Pokok Materi</h2>
        <p>{{ $notulensi->pokok_materi }}</p>
    </div>

    <div class="section">
        <h2>Jalannya Materi</h2>
        <p>{{ $notulensi->jalannya_materi }}</p>
    </div>

    <div class="section">
        <h2>Pembahasan</h2>
        <p>{{ $notulensi->pokok_pembahasan }}</p>
    </div>

    @if($notulensi->notulensi_pertanyaan->count())
    <div class="section">
        <h2>Pertanyaan dan Jawaban</h2>
        <table>
            <thead>
                <tr>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notulensi->notulensi_pertanyaan as $pertanyaan)
                <tr>
                    <td>{{ $pertanyaan->pertanyaan }}</td>
                    <td>{{ $pertanyaan->jawaban ?? 'Belum dijawab' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</body>
</html>
