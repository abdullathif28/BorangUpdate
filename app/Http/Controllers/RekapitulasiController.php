<?php

namespace App\Http\Controllers;

use App\Models\games;
use App\Models\Imamah_kajian;
use App\Models\MateriPelatihan;
use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\AyatPelatihan;
use App\Models\ObservasiPendalaman;
use App\Traits\PelatihanContext;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('rekapitulasi.rekapitulasi', [
                'peserta'        => collect(),
                'materiList'     => collect(),
                'pendalamanList' => collect(),
                'imamahList'     => collect(),
                'gamesList'      => collect(),
                'pelatihan'      => null,
                'allPelatihan'   => $allPelatihan,
            ]);
        }

        $peserta = Peserta::with([
            'observasiProses',
            'observasiPendalaman',
            'observasiImamah',
            'observasiGames',
            'hafalanNilai',
            'kultum',
        ])->where('pelatihan_id', $pelatihan->id)->get();

        $materiList     = MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get()->keyBy('id');
        $imamahList     = Imamah_kajian::where('pelatihan_id', $pelatihan->id)->get();
        $gamesList      = games::where('pelatihan_id', $pelatihan->id)->get();
        $pendalamanList = ObservasiPendalaman::whereIn('peserta_id', $peserta->pluck('id'))->get()
            ->keyBy(fn($item) => $item->materi_id . '_' . $item->peserta_id);

        $peserta->map(function ($p) use ($materiList, $imamahList, $gamesList) {
            $p->observasi_proses_sum     = $p->observasiProses->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);
            $p->observasi_pendalaman_sum = $p->observasiPendalaman->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);
            $p->observasi_imamah_sum     = $p->observasiImamah->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);
            $p->observasi_games_sum      = $p->observasiGames->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);
            $p->hafalan_score            = $p->hafalanScore();

            $totalObservasi =
                $p->observasiProses->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiPendalaman->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiImamah->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiGames->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);

            $p->nilai_akhir =
                ($p->pretest ?? 0) +
                ($p->posttest ?? 0) +
                $p->hafalan_score +
                $totalObservasi;

            $totalMateri =
                count($materiList) +
                count($materiList) + // Karena pendalaman juga menggunakan materiList di view
                count($imamahList) +
                count($gamesList);
            
            $p->rata_akhir = round($p->nilai_akhir / ($totalMateri + 3), 2);

            $p->predikat_akhir = 'E';
            if ($p->rata_akhir >= 90) $p->predikat_akhir = 'A';
            elseif ($p->rata_akhir >= 75) $p->predikat_akhir = 'B';
            elseif ($p->rata_akhir >= 65) $p->predikat_akhir = 'C';
            elseif ($p->rata_akhir >= 55) $p->predikat_akhir = 'D';

            return $p;
        });

        $peserta = $peserta->sortByDesc(fn($p) => $p->rata_akhir)->values();

        return view('rekapitulasi.rekapitulasi', compact(
            'peserta', 'materiList', 'pendalamanList', 'imamahList', 'gamesList', 'pelatihan', 'allPelatihan'
        ));
    }

    public function store(Request $request)
    {
        if (!$request->has('pretest') || !is_array($request->pretest)) {
            return redirect()->back()->with('error', 'Tidak ada data yang disimpan.');
        }

        foreach ($request->pretest as $id => $nilaiPre) {
            $peserta = Peserta::find($id);
            if ($peserta) {
                $peserta->pretest  = is_numeric($nilaiPre) ? (float) $nilaiPre : 0;
                $peserta->posttest = is_numeric($request->posttest[$id] ?? null) ? (float) $request->posttest[$id] : 0;
                $peserta->save();
            }
        }
        return redirect()->back()->with('success', 'Rekapitulasi berhasil disimpan!');
    }

    public function exportRanking()
    {
        $pelatihan = $this->getActivePelatihan();

        if (!$pelatihan) {
            return redirect()->back()->with('error', 'Tidak ada pelatihan aktif.');
        }

        $peserta = Peserta::with([
            'observasiProses',
            'observasiPendalaman',
            'observasiImamah',
            'observasiGames',
            'hafalanNilai',
        ])->where('pelatihan_id', $pelatihan->id)->get();

        $materiList = \App\Models\MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get();
        $imamahList = \App\Models\Imamah_kajian::where('pelatihan_id', $pelatihan->id)->get();
        $gamesList  = \App\Models\games::where('pelatihan_id', $pelatihan->id)->get();

        $peserta->map(function ($p) use ($materiList, $imamahList, $gamesList) {
            $p->hafalan_score = $p->hafalanScore();
            $totalObservasi =
                $p->observasiProses->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiPendalaman->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiImamah->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif) +
                $p->observasiGames->sum(fn($o) => $o->afektif + $o->psikomotorik + $o->kognitif);

            $p->nilai_akhir = ($p->pretest ?? 0) + ($p->posttest ?? 0) + $p->hafalan_score + $totalObservasi;

            $totalMateri = (count($materiList) * 2) + count($imamahList) + count($gamesList);
            $p->rata_akhir = round($p->nilai_akhir / ($totalMateri + 3), 2);

            $p->predikat_akhir = 'E';
            if ($p->rata_akhir >= 90) $p->predikat_akhir = 'A';
            elseif ($p->rata_akhir >= 75) $p->predikat_akhir = 'B';
            elseif ($p->rata_akhir >= 65) $p->predikat_akhir = 'C';
            elseif ($p->rata_akhir >= 55) $p->predikat_akhir = 'D';

            return $p;
        });

        $peserta = $peserta->sortByDesc(fn($p) => $p->rata_akhir)->values();

        $pdf = Pdf::loadView('rekapitulasi.rangking_pdf', compact('peserta', 'pelatihan'));
        return $pdf->download('ranking_peserta_' . time() . '.pdf');
    }

    public function exportRaport($id)
    {
        $pelatihan = $this->getActivePelatihan();
        $peserta   = Peserta::with([
            'pelatihan',
            'observasiProses',
            'observasiPendalaman',
            'observasiImamah',
            'observasiGames',
            'hafalanNilai.ayatPelatihan',
        ])->findOrFail($id);

        if (!$pelatihan) {
            $pelatihan = $peserta->pelatihan;
        }

        $materiList   = $pelatihan ? MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get() : collect();
        $nilaiHafalan = $peserta->hafalanScore();

        $total = ($peserta->pretest ?? 0)
            + ($peserta->posttest ?? 0)
            + ($peserta->observasiProsesAverage() ?? 0)
            + ($peserta->observasiPendalamanAverage() ?? 0)
            + ($peserta->observasiImamahAverage() ?? 0)
            + ($peserta->observasiGamesAverage() ?? 0)
            + $nilaiHafalan;

        $jumlahKomponen = 7;
        $rata           = round($total / $jumlahKomponen, 2);
        $predikat       = match(true) {
            $rata >= 85 => 'A',
            $rata >= 75 => 'B',
            $rata >= 65 => 'C',
            default     => 'D',
        };
        $keterangan = match($predikat) {
            'A' => 'Istimewa',
            'B' => 'Baik',
            'C' => 'Cukup',
            default => 'Perlu Bimbingan',
        };

        $peserta->rata       = $rata;
        $peserta->predikat   = $predikat;
        $peserta->keterangan = $keterangan;

        $pdf = Pdf::loadView('rekapitulasi.raport', compact('peserta', 'materiList', 'pelatihan', 'nilaiHafalan'));
        return $pdf->download("raport_{$peserta->nama}.pdf");
    }
}