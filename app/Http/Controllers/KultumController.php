<?php

namespace App\Http\Controllers;

use App\Models\Kultum;
use App\Models\Peserta;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;

class KultumController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('kultum', [
                'peserta'      => collect(),
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $peserta = Peserta::with('kultum')->where('pelatihan_id', $pelatihan->id)->get();
        return view('kultum', compact('peserta', 'pelatihan', 'allPelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peserta'        => 'required|exists:peserta,id',
            'penguasaan_materi' => 'required|array',
            'kesesuaian_tema'   => 'required|array',
            'kefasihan'         => 'required|array',
            'adab_sikap'        => 'required|array',
            'daya_tarik'        => 'required|array',
        ]);

        Kultum::create([
            'id_peserta'        => $request->id_peserta,
            'penguasaan_materi' => array_sum($request->penguasaan_materi),
            'kesesuaian_tema'   => array_sum($request->kesesuaian_tema),
            'kefasihan'         => array_sum($request->kefasihan),
            'adab_sikap'        => array_sum($request->adab_sikap),
            'daya_tarik'        => array_sum($request->daya_tarik),
        ]);

        return redirect()->back()->with('success', 'Data kultum berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penguasaan_materi' => 'required|numeric',
            'kesesuaian_tema'   => 'required|numeric',
            'kefasihan'         => 'required|numeric',
            'adab_sikap'        => 'required|numeric',
            'daya_tarik'        => 'required|numeric',
        ]);

        Kultum::findOrFail($id)->update($request->only([
            'penguasaan_materi', 'kesesuaian_tema', 'kefasihan', 'adab_sikap', 'daya_tarik',
        ]));

        return redirect()->back()->with('success', 'Data kultum berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kultum::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data kultum berhasil dihapus.');
    }
}
