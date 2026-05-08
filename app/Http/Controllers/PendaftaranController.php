<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class PendaftaranController extends Controller
{
    public function create()
    {
        return view('peserta.form');
    }

    public function store(Request $request)
{
    // Menambahkan validasi untuk semua field
    $request->validate([
        'nama' => 'required|string|max:255',
        'ttl' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'jenis_kelamin' => 'required|string|max:10',
        'nomor_hp' => 'required|numeric',
        'asal_pimpinan' => 'required|string|max:255',
        'moto_hidup' => 'required|string|max:255',
    ]);

    Peserta::create([
        'nama' => $request->nama,
        'ttl' => $request->ttl,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'nomor_hp' => $request->nomor_hp,
        'asal_pimpinan' => $request->asal_pimpinan,
        'moto_hidup' => $request->moto_hidup,
    ]);

    return redirect()->route('peserta.create')->with('success', 'Pendaftaran berhasil!');
}

}
