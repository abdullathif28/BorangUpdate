<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Imamah_kajian;
use App\Models\Observasi_Imamah_kajian;
use App\Models\Peserta;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ObservasiImamahKajianController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('imamah', [
                'imamah'       => collect(),
                'peserta'      => collect(),
                'observasi'    => [],
                'absensi'      => [],
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $imamah  = Imamah_kajian::where('pelatihan_id', $pelatihan->id)->get();
        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->get();

        $pesertaIds = $peserta->pluck('id');
        $imamahIds  = $imamah->pluck('id');

        $observasi = Observasi_Imamah_kajian::whereIn('peserta_id', $pesertaIds)
            ->whereIn('imamah_id', $imamahIds)
            ->get()
            ->keyBy(fn($item) => $item->imamah_id . '_' . $item->peserta_id);

        $absensiRaw = Absensi::whereIn('peserta_id', $pesertaIds)->get();
        $absensi = [];
        foreach ($absensiRaw as $a) {
            $absensi[$a->materi_id . '_' . $a->peserta_id] = $a;
        }

        return view('imamah', compact('imamah', 'peserta', 'observasi', 'absensi', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imamah_id' => 'required|exists:imamah_kajian,id',
            'nilai'     => 'required|array',
        ]);

        // Security: verify submitted imamah_id belongs to active pelatihan
        $pelatihan = $this->getActivePelatihan();
        if ($pelatihan) {
            $valid = \App\Models\Imamah_kajian::where('id', $request->imamah_id)
                ->where('pelatihan_id', $pelatihan->id)->exists();
            if (!$valid) {
                return back()->with('error', 'Data tidak valid untuk pelatihan ini.');
            }
        }

        foreach ($request->nilai as $imamah_id => $peserta_nilai) {
            foreach ($peserta_nilai as $peserta_id => $aspek_nilai) {
                $existing        = Observasi_Imamah_kajian::where('imamah_id', $imamah_id)->where('peserta_id', $peserta_id)->first();
                $oldAfektif      = $existing?->afektif ?? 0;
                $oldKognitif     = $existing?->kognitif ?? 0;
                $oldPsikomotorik = $existing?->psikomotorik ?? 0;

                $newAfektif      = isset($aspek_nilai['afektif']) ? count($aspek_nilai['afektif']) * 10 : null;
                $newKognitif     = isset($aspek_nilai['kognitif']) ? count($aspek_nilai['kognitif']) * 10 : null;
                $newPsikomotorik = isset($aspek_nilai['psikomotorik']) ? count($aspek_nilai['psikomotorik']) * 10 : null;

                $afektif      = $newAfektif ?? $oldAfektif;
                $kognitif     = $newKognitif ?? $oldKognitif;
                $psikomotorik = $newPsikomotorik ?? $oldPsikomotorik;

                Observasi_Imamah_kajian::updateOrCreate(
                    ['imamah_id' => $imamah_id, 'peserta_id' => $peserta_id],
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
