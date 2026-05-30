<?php

namespace App\Http\Controllers;

use App\Models\AyatPelatihan;
use App\Models\HafalanNilai;
use App\Models\Peserta;
use App\Models\Pelatihan;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;

class HafalanController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('hafalan.index', [
                'peserta'       => collect(),
                'ayat'          => collect(),
                'hafalanData'   => [],
                'pelatihan'     => null,
                'allPelatihan'  => $allPelatihan,
            ]);
        }

        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->orderBy('nama')->get();
        $ayat    = AyatPelatihan::where('pelatihan_id', $pelatihan->id)->orderBy('urutan')->get();

        // Build lookup: [peserta_id][ayat_id] => HafalanNilai
        $hafalanRaw  = HafalanNilai::whereIn('peserta_id', $peserta->pluck('id'))
            ->whereIn('ayat_pelatihan_id', $ayat->pluck('id'))
            ->get();

        $hafalanData = [];
        foreach ($hafalanRaw as $h) {
            $hafalanData[$h->peserta_id][$h->ayat_pelatihan_id] = $h;
        }

        return view('hafalan.index', compact('peserta', 'ayat', 'hafalanData', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
    {
        $pelatihan = $this->getActivePelatihan();
        if (!$pelatihan) {
            return redirect()->back()->with('error', 'Tidak ada pelatihan aktif.');
        }

        $ayat   = AyatPelatihan::where('pelatihan_id', $pelatihan->id)->orderBy('urutan')->get();
        $jumlah = $ayat->count();

        if ($jumlah === 0) {
            return redirect()->back()->with('error', 'Tidak ada ayat terdaftar untuk pelatihan ini.');
        }

        $nilaiPerAyat = $jumlah > 0 ? round(100 / $jumlah, 4) : 0;

        // Security: only allow peserta_ids that belong to active pelatihan
        $validPesertaIds = \App\Models\Peserta::where('pelatihan_id', $pelatihan->id)
            ->pluck('id')->toArray();

        // hafal[peserta_id][ayat_id] = "1" or not present
        $hafalInput = $request->input('hafal', []);

        foreach ($request->input('peserta_ids', []) as $pesertaId) {
            if (!in_array($pesertaId, $validPesertaIds)) continue; // skip invalid ids
            foreach ($ayat as $a) {
                $hafal = isset($hafalInput[$pesertaId][$a->id]);
                HafalanNilai::updateOrCreate(
                    [
                        'peserta_id'        => $pesertaId,
                        'ayat_pelatihan_id' => $a->id,
                    ],
                    [
                        'hafal' => $hafal,
                        'nilai' => $hafal ? $nilaiPerAyat : 0,
                    ]
                );
            }
        }

        return redirect()->route('hafalan.index')->with('success', 'Data hafalan berhasil disimpan!');
    }

    // Keep for compatibility — not actively used
    public function create()
    {
        return redirect()->route('hafalan.index');
    }

    public function edit($id)
    {
        return redirect()->route('hafalan.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('hafalan.index');
    }

    public function destroy($id)
    {
        $hafalan = HafalanNilai::findOrFail($id);
        $hafalan->delete();
        return redirect()->route('hafalan.index')->with('success', 'Data hafalan dihapus.');
    }

    // Legacy stub
    public function storeBulk(Request $request)
    {
        return $this->store($request);
    }
}
