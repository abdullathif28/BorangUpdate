<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pelatihan;

class CheckPelatihanAktif
{
    public function handle(Request $request, Closure $next)
    {
        $pelatihanId = $request->route('pelatihan_id') ?? $request->pelatihan_id ?? session('pelatihan_aktif_id');
        
        if ($pelatihanId) {
            $pelatihan = Pelatihan::find($pelatihanId);
            if (!$pelatihan || !$pelatihan->isAktif()) {
                return redirect()->back()->with('error', 'Borang hanya bisa diisi saat pelatihan berstatus Aktif.');
            }
        }

        return $next($request);
    }
}
