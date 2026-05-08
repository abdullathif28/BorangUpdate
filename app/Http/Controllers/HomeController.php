<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperadmin()) {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Sub-roles: IOT, MOG, Observer - tampilkan dashboard sederhana di layout.app
        return view('dashboard');
    }
}
