<?php

namespace App\Http\Controllers\Keaktifan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MateriPelatihan;
use App\Models\ObservasiPra;
use App\Models\Peserta;
use App\Traits\PelatihanContext;

class ObservasiPraController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();
        $materi  = $pelatihan ? \App\Models\MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get() : collect();
        $peserta = $pelatihan ? \App\Models\Peserta::where('pelatihan_id', $pelatihan->id)->get() : collect();

        $pesertaIds = $peserta->pluck('id');
        $materiIds  = $materi->pluck('id');

        $observasipra = \App\Models\Observasi_Proses::whereIn('peserta_id', $pesertaIds)
            ->whereIn('materi_id', $materiIds)
            ->get()
            ->groupBy('peserta_id')
            ->map(fn($items) => $items->keyBy('materi_id'));

        return view('keaktifan.keaktifan', compact('peserta', 'materi', 'observasipra', 'pelatihan', 'allPelatihan'));
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

        ObservasiPra::updateOrCreate(
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
