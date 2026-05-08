<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected function adminId()
    {
        return Auth::id();
    }

    // ===== DASHBOARD ADMIN =====
    public function dashboard()
    {
        $admin = Auth::user();
        // Superadmin yang masuk ke /admin/dashboard diredirect ke dashboard-nya sendiri
        if ($admin->isSuperadmin()) {
            return redirect()->route('superadmin.dashboard');
        }
        $totalPelatihan  = Pelatihan::where('admin_id', $this->adminId())->count();
        $aktifPelatihan  = Pelatihan::where('admin_id', $this->adminId())->where('status', 'aktif')->count();
        $pendingPelatihan= Pelatihan::where('admin_id', $this->adminId())->where('status', 'pending')->count();
        $totalPeserta    = Peserta::whereHas('pelatihan', fn($q) => $q->where('admin_id', $this->adminId()))->count();
        $totalSubRole    = User::where('admin_id', $this->adminId())->count();
        $recentPelatihan = Pelatihan::where('admin_id', $this->adminId())->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'admin', 'totalPelatihan', 'aktifPelatihan',
            'pendingPelatihan', 'totalPeserta', 'totalSubRole', 'recentPelatihan'
        ));
    }

    // ===== KELOLA SUB-ROLE =====
    public function subRoleIndex()
    {
        $user = Auth::user();
        if ($user->isSuperadmin()) {
            // Superadmin lihat semua sub-role
            $subRoles = User::whereIn('role', ['iot', 'mog', 'observer'])->with('pelatihanTugas', 'admin')->get();
        } else {
            $subRoles = User::where('admin_id', $this->adminId())->with('pelatihanTugas')->get();
        }
        return view('admin.subrole.index', compact('subRoles'));
    }

    public function subRoleCreate()
    {
        $user = Auth::user();
        if ($user->isSuperadmin()) {
            // Superadmin bisa assign ke semua pelatihan aktif
            $pelatihan = Pelatihan::where('status', 'aktif')->with('admin')->latest()->get();
        } else {
            // Admin hanya bisa assign ke pelatihan miliknya yang aktif
            $pelatihan = Pelatihan::where('admin_id', $this->adminId())
                ->where('status', 'aktif')
                ->latest()->get();
        }
        return view('admin.subrole.create', compact('pelatihan'));
    }

    public function subRoleStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'role'         => 'required|in:iot,mog,observer',
            'email'        => 'required|email|unique:users',
            'pelatihan_id' => 'required|exists:pelatihan,id',
        ]);

        // Verify the pelatihan belongs to this admin (superadmin can use any pelatihan)
        $user = Auth::user();
        if ($user->isSuperadmin()) {
            $pelatihan = Pelatihan::findOrFail($request->pelatihan_id);
        } else {
            $pelatihan = Pelatihan::where('id', $request->pelatihan_id)
                ->where('admin_id', $this->adminId())
                ->firstOrFail();
        }

        // Generate token unik
        do {
            $token = strtoupper(Str::random(8));
        } while (User::where('token_login', $token)->exists());

        $user = Auth::user();
        // If superadmin creates the sub-role, use the pelatihan's own admin_id
        $assignedAdminId = $user->isSuperadmin() ? $pelatihan->admin_id : $this->adminId();

        User::create([
            'name'         => $request->name,
            'username'     => $request->name,
            'email'        => $request->email,
            'password'     => Str::random(16),
            'role'         => $request->role,
            'admin_id'     => $assignedAdminId,
            'pelatihan_id' => $pelatihan->id,
            'token_login'  => $token,
            'status'       => 'approved',
        ]);

        return redirect()->route('admin.subrole.index')
            ->with('success', "Akun berhasil dibuat untuk pelatihan <strong>{$pelatihan->nama_pelatihan}</strong>. Token login: <strong>{$token}</strong>");
    }

    public function subRoleResetToken($id)
    {
        $subRole = User::where('admin_id', $this->adminId())->findOrFail($id);

        do {
            $token = strtoupper(Str::random(8));
        } while (User::where('token_login', $token)->exists());

        $subRole->update(['token_login' => $token]);

        return redirect()->route('admin.subrole.index')->with('success', "Token berhasil direset menjadi: <strong>{$token}</strong>");
    }

    public function subRoleDestroy($id)
    {
        User::where('admin_id', $this->adminId())->findOrFail($id)->delete();
        return redirect()->route('admin.subrole.index')->with('success', 'Akun sub-role berhasil dihapus.');
    }
}
