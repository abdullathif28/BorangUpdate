<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Pelatihan;
use App\Traits\PelatihanContext;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    use PelatihanContext;

    /**
     * Menampilkan peserta berdasarkan pelatihan aktif admin
     */
    public function index()
    {
        $user        = Auth::user();
        $pelatihan   = $this->getActivePelatihan();
        $allPelatihan = $this->getAccessiblePelatihan();

        if (!$pelatihan) {
            return view('peserta.index', [
                'peserta'      => collect(),
                'pelatihan'    => null,
                'allPelatihan' => $allPelatihan,
            ]);
        }

        $peserta = Peserta::where('pelatihan_id', $pelatihan->id)->orderBy('nama')->get();

        return view('peserta.index', compact('peserta', 'pelatihan', 'allPelatihan'));
    }

    /**
     * Form tambah peserta (admin input manual)
     */
    public function create()
    {
        $allPelatihan = $this->getAccessiblePelatihan();
        $pelatihanAktif = $this->getActivePelatihan();
        return view('peserta.create', compact('allPelatihan', 'pelatihanAktif'));
    }

    /**
     * Simpan peserta baru (admin manual)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelatihan_id'  => 'required|exists:pelatihan,id',
            'nama'          => 'required|string|max:255',
            'asal_pimpinan' => 'required|string|max:255',
            'alamat'        => 'required|string|max:255',
            'ttl'           => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:20',
            'nomor_hp'      => 'required|string|max:15',
            'moto_hidup'    => 'nullable|string|max:255',
        ]);

        $user      = Auth::user();
        $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);

        // Admin hanya bisa tambah ke pelatihan miliknya
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke pelatihan ini.');
        }

        Peserta::create([
            'pelatihan_id'  => $request->pelatihan_id,
            'nama'          => $request->nama,
            'asal_pimpinan' => $request->asal_pimpinan,
            'alamat'        => $request->alamat,
            'ttl'           => $request->ttl,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_hp'      => $request->nomor_hp,
            'moto_hidup'    => $request->moto_hidup,
        ]);

        // Set pelatihan aktif ke yang baru ditambahkan
        session(['pelatihan_aktif_id' => $request->pelatihan_id]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    /**
     * Form edit peserta
     */
    public function edit($id)
    {
        $peserta      = Peserta::findOrFail($id);
        $allPelatihan = $this->getAccessiblePelatihan();
        $this->authorizeAccess($peserta);
        return view('peserta.edit', compact('peserta', 'allPelatihan'));
    }

    /**
     * Update peserta
     */
    public function update(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $this->authorizeAccess($peserta);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'asal_pimpinan' => 'required|string|max:255',
            'alamat'        => 'required|string|max:255',
            'ttl'           => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:20',
            'nomor_hp'      => 'nullable|string|max:15',
            'moto_hidup'    => 'nullable|string|max:255',
        ]);

        $peserta->update($request->only([
            'nama', 'asal_pimpinan', 'alamat', 'ttl',
            'jenis_kelamin', 'nomor_hp', 'moto_hidup',
        ]));

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil diperbarui.');
    }

    /**
     * Hapus peserta
     */
    public function destroy($id)
    {
        $peserta = Peserta::findOrFail($id);
        $this->authorizeAccess($peserta);
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }

    /**
     * Form publik — peserta daftar mandiri dengan token pelatihan
     */
    public function formPublik(Request $request)
    {
        $token     = $request->query('token');
        $pelatihan = null;
        $error     = null;

        if ($token) {
            $pelatihan = Pelatihan::where('token_pendaftaran', strtoupper($token))
                ->where('status', 'aktif')
                ->first();
            if (!$pelatihan) {
                $error = 'Token tidak valid atau pelatihan tidak aktif.';
            }
        }

        return view('peserta.createguest', compact('token', 'pelatihan', 'error'));
    }

    /**
     * Simpan pendaftaran publik peserta berdasarkan token
     */
    public function storePublik(Request $request)
    {
        $request->validate([
            'token_pendaftaran' => 'required|string',
            'nama'              => 'required|string|max:255',
            'asal_pimpinan'     => 'required|string|max:255',
            'alamat'            => 'required|string|max:255',
            'ttl'               => 'required|string|max:255',
            'jenis_kelamin'     => 'required|string|max:20',
            'nomor_hp'          => 'required|string|max:15',
            'moto_hidup'        => 'nullable|string|max:255',
        ]);

        $pelatihan = Pelatihan::where('token_pendaftaran', strtoupper($request->token_pendaftaran))
            ->where('status', 'aktif')
            ->first();

        if (!$pelatihan) {
            return back()->withErrors(['token_pendaftaran' => 'Token tidak valid atau pelatihan tidak aktif.'])->withInput();
        }

        Peserta::create([
            'pelatihan_id'  => $pelatihan->id,
            'nama'          => $request->nama,
            'asal_pimpinan' => $request->asal_pimpinan,
            'alamat'        => $request->alamat,
            'ttl'           => $request->ttl,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_hp'      => $request->nomor_hp,
            'moto_hidup'    => $request->moto_hidup,
        ]);

        return redirect()->route('login')
            ->with('success', "Pendaftaran berhasil! Anda terdaftar di pelatihan: {$pelatihan->nama_pelatihan}");
    }

    /**
     * Pastikan user hanya bisa akses peserta dari pelatihannya
     */
    private function authorizeAccess(Peserta $peserta): void
    {
        $user = Auth::user();
        if ($user->isSuperadmin()) return;

        // Load pelatihan if not already loaded
        $pelatihan = $peserta->pelatihan ?? $peserta->load('pelatihan')->pelatihan;

        // If peserta has no pelatihan, deny access (data integrity issue)
        if (!$pelatihan) {
            abort(403, 'Peserta ini tidak terikat ke pelatihan manapun.');
        }

        if ($pelatihan->admin_id !== $user->getEffectiveAdminId()) {
            abort(403, 'Anda tidak memiliki akses ke data peserta ini.');
        }
    }
}
