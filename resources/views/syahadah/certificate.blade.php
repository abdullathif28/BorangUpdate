<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4 landscape; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', serif;
            width: 297mm; height: 210mm;
            background: white;
            position: relative;
            overflow: hidden;
        }

        /* BORDER ORNAMENT */
        .outer-border {
            position: absolute; inset: 8mm;
            border: 4px solid #0f4c81;
            border-radius: 2px;
        }
        .inner-border {
            position: absolute; inset: 11mm;
            border: 1.5px solid #b8960c;
            border-radius: 2px;
        }
        .corner {
            position: absolute; width: 20mm; height: 20mm;
        }
        .corner-tl { top: 8mm; left: 8mm; border-top: 6px solid #b8960c; border-left: 6px solid #b8960c; }
        .corner-tr { top: 8mm; right: 8mm; border-top: 6px solid #b8960c; border-right: 6px solid #b8960c; }
        .corner-bl { bottom: 8mm; left: 8mm; border-bottom: 6px solid #b8960c; border-left: 6px solid #b8960c; }
        .corner-br { bottom: 8mm; right: 8mm; border-bottom: 6px solid #b8960c; border-right: 6px solid #b8960c; }

        /* BACKGROUND WATERMARK */
        .watermark {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            font-size: 120pt; color: rgba(30, 58, 95, 0.04);
            font-weight: 900; white-space: nowrap; letter-spacing: -5px;
            pointer-events: none; z-index: 0;
        }

        /* CONTENT */
        .content {
            position: absolute; inset: 14mm;
            display: flex; flex-direction: column;
            z-index: 1;
        }

        /* HEADER */
        .header {
            display: flex; align-items: center; gap: 16px;
            padding-bottom: 8px; border-bottom: 2px solid #0f4c81;
            margin-bottom: 10px;
        }
        .header-logo-left, .header-logo-right {
            width: 50px; height: 50px; flex-shrink: 0;
            background: #0f4c81; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px; font-weight: 900;
        }
        .header-text { flex: 1; text-align: center; }
        .header-text .org { font-size: 9pt; color: #555; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 3px; }
        .header-text h1 { font-size: 22pt; color: #0f4c81; font-weight: 900; letter-spacing: 3px; line-height: 1; }
        .header-text .sub { font-size: 8pt; color: #777; margin-top: 3px; }
        .header-text .event { font-size: 9pt; color: #b8960c; font-weight: 700; margin-top: 2px; }

        /* BODY */
        .body { display: flex; gap: 14mm; flex: 1; }

        /* LEFT - MAIN CERT */
        .cert-main { flex: 1.2; }
        .diberikan { font-size: 9pt; color: #555; text-align: center; margin-bottom: 6px; letter-spacing: 1px; text-transform: uppercase; }
        .nama-peserta {
            font-size: 22pt; color: #0f4c81; text-align: center; font-weight: 900;
            border-bottom: 2px solid #b8960c; padding-bottom: 4px; margin-bottom: 6px;
            font-style: italic;
        }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 16px; margin-bottom: 10px; }
        .info-item { font-size: 8pt; color: #333; }
        .info-item span { color: #555; }
        .telah-text { font-size: 8.5pt; color: #333; text-align: center; line-height: 1.5; margin-bottom: 8px; }
        .telah-text strong { color: #0f4c81; font-size: 9pt; }

        /* RIGHT - NILAI */
        .cert-nilai { width: 90mm; }
        .nilai-title { font-size: 8pt; color: #0f4c81; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        .nilai-table { width: 100%; border-collapse: collapse; font-size: 7.5pt; }
        .nilai-table tr td { padding: 2.5px 4px; }
        .nilai-table tr td:first-child { color: #444; }
        .nilai-table tr td:last-child { text-align: center; font-weight: 700; width: 28px; }
        .nilai-table tr:nth-child(even) td { background: #f8f9fa; }
        .nilai-separator { height: 1px; background: #eee; margin: 5px 0; }
        .nilai-total { display: flex; justify-content: space-between; align-items: center; margin-top: 5px; padding: 5px 6px; background: #0f4c81; border-radius: 4px; }
        .nilai-total .label { color: rgba(255,255,255,0.85); font-size: 8pt; font-weight: 600; }
        .nilai-total .angka { color: #f5d078; font-size: 13pt; font-weight: 900; }
        .predikat-box {
            text-align: center; margin-top: 6px;
            padding: 6px; border: 2px solid #b8960c; border-radius: 6px;
            background: #fffbeb;
        }
        .predikat-box .pred { font-size: 22pt; font-weight: 900; color: #0f4c81; line-height: 1; }
        .predikat-box .ket { font-size: 7.5pt; color: #92400e; font-weight: 600; }

        /* FOOTER / SIGNATURE */
        .footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 8px; padding-top: 6px; border-top: 1px solid #eee; }
        .sign-block { text-align: center; }
        .sign-block .ttd-label { font-size: 7.5pt; color: #555; }
        .sign-block .ttd-line { width: 100px; border-bottom: 1px solid #333; margin: 20px auto 3px; }
        .sign-block .ttd-name { font-size: 8pt; font-weight: 700; color: #0f4c81; }
        .sign-block .ttd-role { font-size: 7pt; color: #777; }
        .cert-number { text-align: center; }
        .cert-number .no { font-size: 7pt; color: #888; }
        .cert-number .tanggal { font-size: 7pt; color: #888; }

        .valid-stamp {
            width: 60px; height: 60px; border: 3px solid #0f4c81;
            border-radius: 50%; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            font-size: 6pt; color: #0f4c81; font-weight: 700;
            text-align: center; letter-spacing: 0.5px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <!-- BORDER DECORATIONS -->
    <div class="outer-border"></div>
    <div class="inner-border"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>
    <div class="watermark">IPM</div>

    <div class="content">
        <!-- HEADER -->
        <div class="header">
            <div class="header-logo-left">IPM</div>
            <div class="header-text">
                <div class="org">Ikatan Pelajar Muhammadiyah</div>
                <h1>SYAHADAH</h1>
                <div class="sub">Sertifikat Penghargaan Pelatihan Kader</div>
                <div class="event">{{ $pelatihan->nama_pelatihan ?? 'Pelatihan Kader' }} &bull; {{ $pelatihan->penyelenggara ?? '' }}</div>
            </div>
            <div class="header-logo-right">LFP</div>
        </div>

        <div class="body">
            <!-- KIRI: MAIN CERTIFICATE -->
            <div class="cert-main">
                <div class="diberikan">Diberikan kepada</div>
                <div class="nama-peserta">{{ $peserta->nama }}</div>
                <div class="info-grid">
                    <div class="info-item"><span>Asal Pimpinan</span><br><strong>{{ $peserta->asal_pimpinan }}</strong></div>
                    <div class="info-item"><span>Jenis Kelamin</span><br><strong>{{ $peserta->jenis_kelamin }}</strong></div>
                    <div class="info-item"><span>Tanggal Lahir</span><br><strong>{{ $peserta->ttl }}</strong></div>
                    <div class="info-item"><span>No. HP</span><br><strong>{{ $peserta->nomor_hp }}</strong></div>
                </div>
                <div class="telah-text">
                    Telah mengikuti dan <strong>dinyatakan LULUS</strong> dalam kegiatan<br>
                    <strong>{{ $pelatihan->nama_pelatihan ?? 'Pelatihan Kader IPM' }}</strong><br>
                    yang diselenggarakan oleh <strong>{{ $pelatihan->penyelenggara ?? '-' }}</strong><br>
                    pada tanggal <strong>{{ isset($pelatihan->tanggal_pelatihan) ? \Carbon\Carbon::parse($pelatihan->tanggal_pelatihan)->isoFormat('D MMMM Y') : '-' }}</strong>
                    di <strong>{{ $pelatihan->tempat_pelatihan ?? '-' }}</strong>
                </div>
                @if($peserta->moto_hidup)
                <div style="text-align:center;font-style:italic;font-size:8pt;color:#777;border-top:1px dashed #ddd;padding-top:5px;margin-top:4px">
                    "{{ $peserta->moto_hidup }}"
                </div>
                @endif
            </div>

            <!-- KANAN: NILAI -->
            <div class="cert-nilai">
                <div class="nilai-title">Rekap Nilai Peserta</div>
                <table class="nilai-table">
                    <tr>
                        <td>Pretest</td>
                        <td>{{ $nilaiPretest ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Posttest</td>
                        <td>{{ $nilaiPosttest ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Hafalan Al-Qur'an</td>
                        <td>{{ $nilaiHafalan ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Observasi Materi</td>
                        <td>{{ $nilaiObsProses ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Observasi Pendalaman</td>
                        <td>{{ $nilaiPendalaman ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Imamah & Kajian</td>
                        <td>{{ $nilaiImamah ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Games / Outbound</td>
                        <td>{{ $nilaiGames ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Kultum</td>
                        <td>{{ $nilaiKultum ?: '-' }}</td>
                    </tr>
                </table>
                <div class="nilai-total">
                    <span class="label">Rata-rata Nilai</span>
                    <span class="angka">{{ $rataRata }}</span>
                </div>
                <div class="predikat-box">
                    <div class="pred">{{ $predikat }}</div>
                    <div class="ket">{{ $keterangan }}</div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <div class="sign-block">
                <div class="ttd-label">Ketua Umum Penyelenggara</div>
                <div class="ttd-line"></div>
                <div class="ttd-name">{{ $pelatihan->nama_ketum ?? '________________________' }}</div>
                <div class="ttd-role">{{ $pelatihan->penyelenggara ?? '' }}</div>
            </div>

            <div class="cert-number">
                <div class="valid-stamp">
                    <div>Valid</div>
                    <div style="font-size:8pt;color:#b8960c">✓</div>
                    <div>IPM</div>
                </div>
                <div class="no" style="margin-top:4px">No: BD/{{ date('Y') }}/{{ str_pad($peserta->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div class="tanggal">{{ now()->isoFormat('D MMMM Y') }}</div>
            </div>

            <div class="sign-block">
                <div class="ttd-label">MOT (Master of Training)</div>
                <div class="ttd-line"></div>
                <div class="ttd-name">{{ $pelatihan->nama_mot ?? '________________________' }}</div>
                <div class="ttd-role">NBA: {{ $pelatihan->nba_mot ?? '-' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
