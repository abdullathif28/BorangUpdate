<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notulensi;
use App\Models\NotulensiPertanyaan;
use App\Models\Pelatihan;
use App\Models\MateriPelatihan;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotulensiController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $pelatihan    = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('notulensi.index', [
                'notulensi'    => collect(),
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $notulensi = Notulensi::with(['pelatihan', 'materi'])
            ->where('pelatihan_id', $pelatihan->id)
            ->paginate(10);

        return view('notulensi.index', compact('notulensi', 'pelatihan', 'allPelatihan'));
    }

    public function create()
    {
        $allPelatihan   = $this->getAccessiblePelatihan();
        $pelatihanAktif = $this->getActivePelatihan();

        $materi = $pelatihanAktif
            ? MateriPelatihan::where('pelatihan_id', $pelatihanAktif->id)->get()
            : collect();

        return view('notulensi.create', compact('allPelatihan', 'pelatihanAktif', 'materi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelatihan_id'  => 'required|exists:pelatihan,id',
            'materi_id'     => 'required|exists:materi_pelatihan,id',
            'pengampu'      => 'required|string|max:255',
            'moderator'     => 'required|string|max:255',
            'notulis'       => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'jumlah_peserta'=> 'required|integer',
            'kondisi_peserta'=> 'required|string',
            'pokok_materi'  => 'required|string',
            'jalannya_materi'=> 'required|string',
            'pokok_pembahasan'=> 'required|string',
            'pertanyaan'    => 'nullable|array',
            'jawaban'       => 'nullable|array',
        ]);

        // Validate admin access to this pelatihan
        $user      = Auth::user();
        $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) {
            abort(403);
        }

        $notulensi = Notulensi::create($request->only([
            'pelatihan_id', 'materi_id', 'pengampu', 'moderator', 'notulis',
            'tanggal', 'waktu_mulai', 'waktu_selesai', 'jumlah_peserta',
            'kondisi_peserta', 'pokok_materi', 'jalannya_materi', 'pokok_pembahasan',
        ]));

        if ($request->has('pertanyaan')) {
            foreach ($request->pertanyaan as $index => $pertanyaan) {
                NotulensiPertanyaan::create([
                    'notulensi_id' => $notulensi->id,
                    'pertanyaan'   => $pertanyaan,
                    'jawaban'      => $request->jawaban[$index] ?? '',
                ]);
            }
        }

        session(['pelatihan_aktif_id' => $request->pelatihan_id]);

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil disimpan!');
    }

    public function show($id)
    {
        $notulensi = Notulensi::with(['pelatihan', 'materi', 'notulensi_pertanyaan'])->findOrFail($id);
        return view('notulensi.show', compact('notulensi'));
    }

    public function update(Request $request, $id)
    {
        $notulensi = Notulensi::with('pelatihan')->findOrFail($id);
        $this->authorizeNotulensi($notulensi);
        $notulensi->update($request->only([
            'pengampu', 'moderator', 'notulis', 'tanggal', 'waktu_mulai',
            'waktu_selesai', 'jumlah_peserta', 'kondisi_peserta',
            'pokok_materi', 'jalannya_materi', 'pokok_pembahasan'
        ]));

        if ($request->pertanyaan) {
            foreach ($request->pertanyaan as $pid => $pertanyaan) {
                NotulensiPertanyaan::where('id', $pid)->update([
                    'pertanyaan' => $pertanyaan,
                    'jawaban'    => $request->jawaban[$pid] ?? null,
                ]);
            }
        }

        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $notulensi = Notulensi::with('pelatihan')->findOrFail($id);
        $this->authorizeNotulensi($notulensi);
        $notulensi->delete();
        return redirect()->route('notulensi.index')->with('success', 'Notulensi berhasil dihapus.');
    }

    private function authorizeNotulensi(Notulensi $notulensi): void
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->isSuperadmin()) return;
        if ($notulensi->pelatihan && $notulensi->pelatihan->admin_id !== $user->getEffectiveAdminId()) {
            abort(403, 'Anda tidak memiliki akses ke notulensi ini.');
        }
    }

    public function exportPdf($id)
    {
        $notulensi = Notulensi::with(['pelatihan', 'materi', 'notulensi_pertanyaan'])->findOrFail($id);
        $pdf = Pdf::loadView('notulensi.pdf', compact('notulensi'));
        return $pdf->download('notulensi-' . $notulensi->id . '.pdf');
    }
}
