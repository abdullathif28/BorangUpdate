<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihanContextController extends Controller
{
    /**
     * Set pelatihan aktif ke session
     */
    public function setAktif(Request $request)
    {
        $request->validate(['pelatihan_id' => 'required|exists:pelatihan,id']);

        $user = Auth::user();
        $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);

        // Sub-role tidak bisa ganti pelatihan — sudah ditetapkan saat pembuatan akun
        if ($user->isSubRole()) {
            return redirect()->back()->with('error', 'Tim sub-role tidak dapat mengganti pelatihan. Pelatihan sudah ditetapkan oleh admin.');
        }

        // Admin hanya bisa pilih pelatihan miliknya
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke pelatihan ini.');
        }

        session(['pelatihan_aktif_id' => $pelatihan->id]);

        return redirect()->back()->with('success', "Pelatihan aktif diubah ke: {$pelatihan->nama_pelatihan}");
    }
}
