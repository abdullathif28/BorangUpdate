<?php

namespace App\Http\Controllers;

use App\Models\AyatPelatihan;
use App\Models\FgdPelatihan;
use App\Models\games;
use App\Models\Imamah_kajian;
use App\Models\Pelatihan;
use App\Models\MateriPelatihan;
use App\Traits\PelatihanContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihanController extends Controller
{
    use PelatihanContext;

    public function index()
    {
        $user = Auth::user();
        if ($user->isSuperadmin()) {
            $pelatihan = Pelatihan::with('admin')->latest()->get();
        } else {
            $pelatihan = Pelatihan::where('admin_id', $user->id)->latest()->get();
        }
        $pelatihanAktifId = $this->getActivePelatihanId();
        return view('pelatihan.index', compact('pelatihan', 'pelatihanAktifId'));
    }

    public function create()
    {
        return view('pelatihan.create');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $pelatihan = Pelatihan::findOrFail($id);

        // Admin hanya bisa hapus pelatihan miliknya
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) {
            abort(403);
        }

        // Clear session if this was the active pelatihan
        if (session('pelatihan_aktif_id') == $id) {
            session()->forget('pelatihan_aktif_id');
        }

        $pelatihan->delete();
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lfp'         => 'required|string|max:255',
            'email_lfp'        => 'required|email|max:255',
            'nama_mot'         => 'required|string|max:255',
            'nba_mot'          => 'required|string|max:255',
            'nama_asisten_mot' => 'required|string|max:255',
            'hp_asisten_mot'   => 'required|string|max:15',
            'nama_pelatihan'   => 'required|string|max:255',
            'penyelenggara'    => 'required|string|max:255',
            'nama_ketum'       => 'required|string|max:255',
            'nba_ketum'        => 'required|string|max:255',
            'tanggal_pelatihan'=> 'required|date',
            'tempat_pelatihan' => 'required|string|max:255',
            'jumlah_materi'    => 'required|integer',
            'jumlah_fgd'       => 'required|integer',
            'jumlah_hafalan'   => 'required|integer',
            'jumlah_kajian'    => 'required|integer',
            'jumlah_games'     => 'required|integer',
            'nama_materi'      => 'required|array|min:1',
            'nama_materi.*'    => 'required|string',
            'nama_kajian'      => 'required|array|min:1',
            'nama_kajian.*'    => 'required|string',
            'nama_games'       => 'required|array|min:1',
            'nama_games.*'     => 'required|string',
            'nama_ayat'        => 'required|array|min:1',
            'nama_ayat.*'      => 'required|string',
        ]);

        $validatedData['admin_id']           = Auth::id();
        $validatedData['status']             = 'pending';
        $validatedData['token_pendaftaran']  = Pelatihan::generateToken();

        $pelatihan = Pelatihan::create($validatedData);

        // FGD
        for ($i = 1; $i <= $request->jumlah_fgd; $i++) {
            FgdPelatihan::create(['pelatihan_id' => $pelatihan->id, 'nama_fgd' => "FGD $i"]);
        }

        // Materi
        foreach ($validatedData['nama_materi'] as $urutan => $materi) {
            MateriPelatihan::create([
                'nama_materi'  => $materi,
                'pelatihan_id' => $pelatihan->id,
                'urutan'       => $urutan + 1,
            ]);
        }

        // Kajian/Imamah
        foreach ($validatedData['nama_kajian'] as $urutan => $kajian) {
            Imamah_kajian::create([
                'nama_kajian'  => $kajian,
                'pelatihan_id' => $pelatihan->id,
                'urutan'       => $urutan + 1,
            ]);
        }

        // Games
        foreach ($validatedData['nama_games'] as $urutan => $g) {
            games::create([
                'nama_games'   => $g,
                'pelatihan_id' => $pelatihan->id,
                'urutan'       => $urutan + 1,
            ]);
        }

        // Ayat Hafalan (dynamic)
        foreach ($validatedData['nama_ayat'] as $urutan => $ayat) {
            AyatPelatihan::create([
                'pelatihan_id' => $pelatihan->id,
                'nama_ayat'    => $ayat,
                'urutan'       => $urutan + 1,
            ]);
        }

        return redirect()->route('pelatihan.index')
            ->with('success', 'Pelatihan berhasil didaftarkan! Menunggu konfirmasi Super Admin. Token pendaftaran peserta: <strong>' . $pelatihan->token_pendaftaran . '</strong>');
    }

    public function show($id)
    {
        $user     = Auth::user();
        $pelatihan = Pelatihan::with(['fgd', 'materi', 'pesertas', 'ayatPelatihan', 'imamahKajian', 'games'])->findOrFail($id);

        // Admin hanya bisa lihat miliknya
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) {
            abort(403);
        }

        return view('pelatihan.show', compact('pelatihan'));
    }
}
