<?php

namespace App\Http\Controllers\Keaktifan;

use App\Http\Controllers\Controller;
use App\Models\Pasca;
use App\Models\Peserta;
use App\Models\Materi;
use App\Models\MateriPelatihan;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;

class ObservasiPascaController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();
        $materi  = $pelatihan ? MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get() : collect();
        $peserta = $pelatihan ? Peserta::where('pelatihan_id', $pelatihan->id)->get() : collect();

        $pesertaIds = $peserta->pluck('id');
        $materiIds  = $materi->pluck('id');

        $observasi = Pasca::whereIn('peserta_id', $pesertaIds)
            ->whereIn('materi_id', $materiIds)
            ->get()
            ->groupBy(['peserta_id', 'materi_id']);

        return view('keaktifan.pasca', compact('peserta', 'materi', 'observasi', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'peserta_id' => 'required|exists:peserta,id',
        'afektif' => 'required|array',
        'psikomotorik' => 'required|array',
        'kognitif' => 'required|array',
    ]);

    foreach ($request->afektif as $materiId => $afektifChecks) {
        // Skor berdasarkan jumlah centang + base nilai 4
        $afektifScore = 4 + count($afektifChecks ?? []);
        $psikomotorikScore = 4 + count($request->psikomotorik[$materiId] ?? []);
        $kognitifScore = 4 + count($request->kognitif[$materiId] ?? []);

        // Rata-rata dari 3 skor
        $rataRata = round(($afektifScore + $psikomotorikScore + $kognitifScore) / 3, 2);

        Pasca::updateOrCreate(
            [
                'peserta_id' => $request->peserta_id,
                'materi_id' => $materiId
            ],
            [
                'afektif' => $afektifScore,
                'psikomotorik' => $psikomotorikScore,
                'kognitif' => $kognitifScore,
                // 'rata_rata' => $rataRata 
            ]
        );
    }

    return redirect()->back()->with('success', 'Data berhasil disimpan ke tabel observasi_pra.');
}
}
