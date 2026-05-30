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
        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->orderBy('nama')->get();

        $pesertaIds = $peserta->pluck('id');
        $imamahIds  = $imamah->pluck('id');

        $observasi = Observasi_Imamah_kajian::whereIn('peserta_id', $pesertaIds)
            ->whereIn('imamah_id', $imamahIds)
            ->get()
            ->keyBy(fn($item) => $item->imamah_id . '_' . $item->peserta_id);

        $absensiRaw = Absensi::whereIn('peserta_id', $pesertaIds)
            ->where('kategori', 'imamah')
            ->get();
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
            'nilai'     => 'nullable|array',
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

        if ($request->has('absensi')) {
            foreach ($request->input('absensi') as $materiId => $pesertaAbsensi) {
                foreach ($pesertaAbsensi as $pesertaId => $isHadir) {
                    $peserta = Peserta::find($pesertaId);
                    Absensi::updateOrCreate(
                        ['materi_id' => $materiId, 'peserta_id' => $pesertaId, 'kategori' => 'imamah'],
                        ['hadir' => $isHadir, 'peserta_nama' => $peserta?->nama ?? 'TIDAK DIKETAHUI']
                    );

                    $aspek_nilai = $request->input("nilai.{$materiId}.{$pesertaId}", []);
                    
                    $afektif      = isset($aspek_nilai['afektif']) ? count($aspek_nilai['afektif']) * 10 : 0;
                    $kognitif     = isset($aspek_nilai['kognitif']) ? count($aspek_nilai['kognitif']) * 10 : 0;
                    $psikomotorik = isset($aspek_nilai['psikomotorik']) ? count($aspek_nilai['psikomotorik']) * 10 : 0;

                    Observasi_Imamah_kajian::updateOrCreate(
                        ['imamah_id' => $materiId, 'peserta_id' => $pesertaId],
                        ['afektif' => $afektif, 'kognitif' => $kognitif, 'psikomotorik' => $psikomotorik, 'jumlah' => $afektif + $kognitif + $psikomotorik]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Observasi berhasil disimpan.');
    }
}
