<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\games;
use App\Models\Observasi_games;
use App\Models\Peserta;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ObservasigamesController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('observasi-games', [
                'games'        => collect(),
                'peserta'      => collect(),
                'observasi'    => [],
                'absensi'      => [],
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $games   = games::where('pelatihan_id', $pelatihan->id)->get();
        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->get();

        $pesertaIds = $peserta->pluck('id');
        $gamesIds   = $games->pluck('id');

        $observasi = Observasi_games::whereIn('peserta_id', $pesertaIds)
            ->whereIn('games_id', $gamesIds)
            ->get()
            ->keyBy(fn($item) => $item->games_id . '_' . $item->peserta_id);

        $absensiRaw = Absensi::whereIn('peserta_id', $pesertaIds)->get();
        $absensi = [];
        foreach ($absensiRaw as $a) {
            $absensi[$a->materi_id . '_' . $a->peserta_id] = $a;
        }

        return view('observasi-games', compact('games', 'peserta', 'observasi', 'absensi', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'games_id' => 'required|exists:games,id',
            'nilai'    => 'required|array',
        ]);

        // Security: verify submitted games_id belongs to active pelatihan
        $pelatihan = $this->getActivePelatihan();
        if ($pelatihan) {
            $valid = \App\Models\games::where('id', $request->games_id)
                ->where('pelatihan_id', $pelatihan->id)->exists();
            if (!$valid) {
                return back()->with('error', 'Data tidak valid untuk pelatihan ini.');
            }
        }

        foreach ($request->nilai as $games_id => $peserta_nilai) {
            foreach ($peserta_nilai as $peserta_id => $aspek_nilai) {
                $existing        = Observasi_games::where('games_id', $games_id)->where('peserta_id', $peserta_id)->first();
                $oldAfektif      = $existing?->afektif ?? 0;
                $oldKognitif     = $existing?->kognitif ?? 0;
                $oldPsikomotorik = $existing?->psikomotorik ?? 0;

                $newAfektif      = isset($aspek_nilai['afektif']) ? count($aspek_nilai['afektif']) * 10 : null;
                $newKognitif     = isset($aspek_nilai['kognitif']) ? count($aspek_nilai['kognitif']) * 10 : null;
                $newPsikomotorik = isset($aspek_nilai['psikomotorik']) ? count($aspek_nilai['psikomotorik']) * 10 : null;

                $afektif      = $newAfektif ?? $oldAfektif;
                $kognitif     = $newKognitif ?? $oldKognitif;
                $psikomotorik = $newPsikomotorik ?? $oldPsikomotorik;

                Observasi_games::updateOrCreate(
                    ['games_id' => $games_id, 'peserta_id' => $peserta_id],
                    ['afektif' => $afektif, 'kognitif' => $kognitif, 'psikomotorik' => $psikomotorik, 'jumlah' => $afektif + $kognitif + $psikomotorik]
                );
            }
        }

        if ($request->has('absensi')) {
            foreach ($request->input('absensi') as $materiId => $pesertaAbsensi) {
                foreach ($pesertaAbsensi as $pesertaId => $isHadir) {
                    $peserta = Peserta::find($pesertaId);
                    Absensi::updateOrCreate(
                        ['materi_id' => $materiId, 'peserta_id' => $pesertaId],
                        ['hadir' => $isHadir, 'peserta_nama' => $peserta?->nama ?? 'TIDAK DIKETAHUI']
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Observasi berhasil disimpan.');
    }
}
