<?php

namespace App\Http\Controllers\Keaktifan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;
use App\Models\Observasi_Proses;
use App\Models\MateriPelatihan;
use App\Models\Peserta;

class KeaktifanController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('keaktifan.keaktifan', [
                'materi'       => collect(),
                'peserta'      => collect(),
                'observasi'    => [],
                'absensi'      => [],
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $materi  = MateriPelatihan::where('pelatihan_id', $pelatihan->id)->get();
        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->get();

        $pesertaIds = $peserta->pluck('id');
        $materiIds  = $materi->pluck('id');

        $observasi = Observasi_Proses::whereIn('peserta_id', $pesertaIds)
            ->whereIn('materi_id', $materiIds)
            ->get()
            ->keyBy(fn($item) => $item->materi_id . '_' . $item->peserta_id);

        $absensiRaw = Absensi::whereIn('peserta_id', $pesertaIds)
            ->whereIn('materi_id', $materiIds)
            ->get();
        $absensi = [];
        foreach ($absensiRaw as $a) {
            $absensi[$a->materi_id . '_' . $a->peserta_id] = $a;
        }

        return view('keaktifan.keaktifan', compact('materi', 'peserta', 'observasi', 'absensi', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|exists:materi_pelatihan,id',
        ]);

        // Security: verify submitted materi_id belongs to active pelatihan
        $pelatihan = $this->getActivePelatihan();
        if ($pelatihan) {
            $valid = \App\Models\MateriPelatihan::where('id', $request->materi_id)
                ->where('pelatihan_id', $pelatihan->id)->exists();
            if (!$valid) {
                return back()->with('error', 'Data tidak valid untuk pelatihan ini.');
            }
        }

        if ($request->has('nilai')) {
            foreach ($request->nilai as $materi_id => $peserta_nilai) {
                foreach ($peserta_nilai as $peserta_id => $aspek_nilai) {
                    $existing = Observasi_Proses::where('materi_id', $materi_id)
                        ->where('peserta_id', $peserta_id)->first();

                    $oldAfektif      = $existing?->afektif ?? 0;
                    $oldKognitif     = $existing?->kognitif ?? 0;
                    $oldPsikomotorik = $existing?->psikomotorik ?? 0;

                    $newAfektif      = isset($aspek_nilai['afektif']) ? count($aspek_nilai['afektif']) * 10 : null;
                    $newKognitif     = isset($aspek_nilai['kognitif']) ? count($aspek_nilai['kognitif']) * 10 : null;
                    $newPsikomotorik = isset($aspek_nilai['psikomotorik']) ? count($aspek_nilai['psikomotorik']) * 10 : null;

                    $afektif      = $newAfektif ?? $oldAfektif;
                    $kognitif     = $newKognitif ?? $oldKognitif;
                    $psikomotorik = $newPsikomotorik ?? $oldPsikomotorik;
                    $total        = $afektif + $kognitif + $psikomotorik;

                    Observasi_Proses::updateOrCreate(
                        ['materi_id' => $materi_id, 'peserta_id' => $peserta_id],
                        ['afektif' => $afektif, 'kognitif' => $kognitif, 'psikomotorik' => $psikomotorik, 'rata_rata' => $total]
                    );
                }
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

        return redirect()->back()->with('success', 'Data observasi dan absensi berhasil disimpan.');
    }
}
