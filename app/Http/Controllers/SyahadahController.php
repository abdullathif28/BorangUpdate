<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\MateriPelatihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SyahadahController extends Controller
{
    public function export($peserta_id)
    {
        $peserta = Peserta::with([
            'pelatihan',
            'hafalanNilai',
            'kultum',
            'observasiProses',
            'observasiPendalaman',
            'observasiImamah',
            'observasiGames',
        ])->findOrFail($peserta_id);

        $pelatihan  = $peserta->pelatihan;
        $materiList = $pelatihan ? MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get() : collect();

        // Hitung nilai-nilai — hafalan now from HafalanNilai
        $nilaiHafalan       = $peserta->hafalanScore();
        $nilaiObsProses     = $peserta->observasiProsesAverage() ?? 0;
        $nilaiPendalaman    = $peserta->observasiPendalamanAverage() ?? 0;
        $nilaiImamah        = $peserta->observasiImamahAverage() ?? 0;
        $nilaiGames         = $peserta->observasiGamesAverage() ?? 0;
        $nilaiPretest       = $peserta->pretest ?? 0;
        $nilaiPosttest      = $peserta->posttest ?? 0;

        $nilaiKultum = 0;
        if ($peserta->kultum->isNotEmpty()) {
            $k = $peserta->kultum->first();
            $nilaiKultum = round(($k->penguasaan_materi + $k->kesesuaian_tema + $k->kefasihan + $k->adab_sikap + $k->daya_tarik) / 5, 1);
        }

        // Rata-rata keseluruhan
        $components = array_filter([
            $nilaiPretest, $nilaiPosttest, $nilaiHafalan,
            $nilaiObsProses, $nilaiPendalaman, $nilaiImamah,
            $nilaiGames, $nilaiKultum,
        ], fn($v) => $v > 0);

        $rataRata = count($components) > 0 ? round(array_sum($components) / count($components), 1) : 0;
        $predikat = $peserta->predikatRaport();
        $keterangan = $peserta->keteranganBimbingan();

        $pdf = Pdf::loadView('syahadah.certificate', compact(
            'peserta', 'pelatihan', 'materiList',
            'nilaiHafalan', 'nilaiObsProses', 'nilaiPendalaman',
            'nilaiImamah', 'nilaiGames', 'nilaiKultum',
            'nilaiPretest', 'nilaiPosttest',
            'rataRata', 'predikat', 'keterangan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("syahadah_{$peserta->nama}.pdf");
    }

    public function preview($peserta_id)
    {
        $peserta = Peserta::with([
            'pelatihan', 'hafalan', 'kultum',
            'observasiProses', 'observasiPendalaman',
            'observasiImamah', 'observasiGames',
        ])->findOrFail($peserta_id);

        $pelatihan  = $peserta->pelatihan;
        $materiList = $pelatihan ? MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get() : collect();

        $nilaiHafalan    = $peserta->hafalanScore();
        $nilaiObsProses  = $peserta->observasiProsesAverage() ?? 0;
        $nilaiPendalaman = $peserta->observasiPendalamanAverage() ?? 0;
        $nilaiImamah     = $peserta->observasiImamahAverage() ?? 0;
        $nilaiGames      = $peserta->observasiGamesAverage() ?? 0;
        $nilaiPretest    = $peserta->pretest ?? 0;
        $nilaiPosttest   = $peserta->posttest ?? 0;

        $nilaiKultum = 0;
        if ($peserta->kultum->isNotEmpty()) {
            $k = $peserta->kultum->first();
            $nilaiKultum = round(($k->penguasaan_materi + $k->kesesuaian_tema + $k->kefasihan + $k->adab_sikap + $k->daya_tarik) / 5, 1);
        }

        $components = array_filter([
            $nilaiPretest, $nilaiPosttest, $nilaiHafalan,
            $nilaiObsProses, $nilaiPendalaman, $nilaiImamah,
            $nilaiGames, $nilaiKultum,
        ], fn($v) => $v > 0);

        $rataRata   = count($components) > 0 ? round(array_sum($components) / count($components), 1) : 0;
        $predikat   = $peserta->predikatRaport();
        $keterangan = $peserta->keteranganBimbingan();

        return view('syahadah.certificate', compact(
            'peserta', 'pelatihan', 'materiList',
            'nilaiHafalan', 'nilaiObsProses', 'nilaiPendalaman',
            'nilaiImamah', 'nilaiGames', 'nilaiKultum',
            'nilaiPretest', 'nilaiPosttest',
            'rataRata', 'predikat', 'keterangan'
        ));
    }
}
