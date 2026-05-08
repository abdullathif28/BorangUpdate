<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // Form pendaftaran admin
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pimpinan'    => 'required|string|max:255',
            'tingkat_pimpinan' => 'required|in:Wilayah,Daerah',
            'nama_ketum'       => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'nomor_hp'         => 'required|string|max:20',
            'jumlah_cabang'    => 'required|integer|min:1',
            'password'         => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'             => $request->nama_pimpinan,
            'username'         => $request->nama_pimpinan,
            'email'            => $request->email,
            'password'         => $request->password,
            'role'             => 'admin',
            'status'           => 'pending',
            'nama_pimpinan'    => $request->nama_pimpinan,
            'tingkat_pimpinan' => $request->tingkat_pimpinan,
            'nama_ketum'       => $request->nama_ketum,
            'nomor_hp'         => $request->nomor_hp,
            'jumlah_cabang'    => $request->jumlah_cabang,
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan Super Admin.');
    }
}
