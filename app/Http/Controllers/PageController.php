<?php

namespace App\Http\Controllers;

use App\Models\games;
use App\Models\Imamah_kajian;
use App\Models\MateriPelatihan;
use App\Models\ObservasiPendalaman;
use App\Models\Pelatihan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(string $page)
    {
        $user = Auth::user();

        // Route ke controller yang sesuai berdasarkan nama page
        switch ($page) {
            case 'pelatihan':
                return app(\App\Http\Controllers\PelatihanController::class)->index();

            case 'peserta':
                return app(\App\Http\Controllers\PesertaController::class)->index();

            case 'rekapitulasi':
                return app(\App\Http\Controllers\RekapitulasiController::class)->index();

            case 'observasiPendalaman':
                return app(\App\Http\Controllers\ObservasiPendalamanController::class)->index();

            case 'observasiImamahKajian':
                return app(\App\Http\Controllers\ObservasiImamahKajianController::class)->index();

            case 'observasigames':
                return app(\App\Http\Controllers\ObservasigamesController::class)->index();

            case 'notulensi':
                return app(\App\Http\Controllers\NotulensiController::class)->index();

            case 'hafalan':
                // hafalan only for admin, superadmin, iot
                if (!in_array($user->role, ['admin', 'superadmin', 'iot'])) {
                    abort(403);
                }
                return app(\App\Http\Controllers\HafalanController::class)->index();

            default:
                if (view()->exists("{$page}")) {
                    return view("{$page}");
                }
                return abort(404);
        }
    }

    public function profile()
    {
        return view('user-profile');
    }
}
