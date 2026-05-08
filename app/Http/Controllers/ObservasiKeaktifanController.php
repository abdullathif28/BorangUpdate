<?php

use App\Models\Materi;
use App\Models\MateriPelatihan;
use Illuminate\Routing\Controller;

class ObservasiKeaktifanController extends Controller
{
    public function index()
    {
        // Mengambil semua materi pelatihan beserta data pelatihan yang terkait
        $materi = MateriPelatihan::with('pelatihan')->get();
        dd($materi); // Debug: melihat apakah data berhasil diambil
        return view('keaktifan.keaktifan', compact('materi'));
    }
}
