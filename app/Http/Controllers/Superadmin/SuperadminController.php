<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    // ===== DASHBOARD =====
    public function dashboard()
    {
        $totalAdmin       = User::where('role', 'admin')->where('status', 'approved')->count();
        $pendingAdmin     = User::where('role', 'admin')->where('status', 'pending')->count();
        $totalPelatihan   = Pelatihan::count();
        $pendingPelatihan = Pelatihan::where('status', 'pending')->count();
        $aktifPelatihan   = Pelatihan::where('status', 'aktif')->count();
        $totalPeserta     = Peserta::count();

        $recentPelatihan = Pelatihan::with('admin')->latest()->take(5)->get();
        $recentAdmins    = User::where('role', 'admin')->where('status', 'pending')->latest()->take(5)->get();

        return view('superadmin.dashboard', compact(
            'totalAdmin', 'pendingAdmin', 'totalPelatihan',
            'pendingPelatihan', 'aktifPelatihan', 'totalPeserta',
            'recentPelatihan', 'recentAdmins'
        ));
    }

    // ===== KELOLA ADMIN =====
    public function adminIndex()
    {
        $admins = User::where('role', 'admin')->with('pelatihan')->latest()->paginate(15);
        return view('superadmin.admin.index', compact('admins'));
    }

    public function adminEdit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('superadmin.admin.edit', compact('admin'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        $request->validate([
            'nama_pimpinan'    => 'required|string|max:255',
            'tingkat_pimpinan' => 'nullable|string|max:100',
            'nama_ketum'       => 'nullable|string|max:255',
            'nomor_hp'         => 'nullable|string|max:20',
            'jumlah_cabang'    => 'nullable|integer',
            'email'            => 'required|email|unique:users,email,' . $id,
        ]);

        $admin->update($request->only([
            'nama_pimpinan', 'tingkat_pimpinan', 'nama_ketum',
            'nomor_hp', 'jumlah_cabang', 'email',
        ]));

        return redirect()->route('superadmin.admin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function adminApprove($id)
    {
        $admin = User::findOrFail($id);
        $admin->update(['status' => 'approved']);
        return redirect()->back()->with('success', "Admin {$admin->nama_pimpinan} berhasil disetujui.");
    }

    public function adminReject(Request $request, $id)
    {
        $request->validate(['catatan' => 'nullable|string']);
        $admin = User::findOrFail($id);
        $admin->update(['status' => 'rejected', 'catatan_penolakan' => $request->catatan]);
        return redirect()->back()->with('success', "Pendaftaran admin {$admin->nama_pimpinan} ditolak.");
    }

    public function adminDestroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('superadmin.admin.index')->with('success', 'Admin berhasil dihapus.');
    }

    // ===== KELOLA PELATIHAN =====
    public function pelatihanIndex()
    {
        $pelatihan = Pelatihan::with('admin')->latest()->paginate(15);
        return view('superadmin.pelatihan.index', compact('pelatihan'));
    }

    public function pelatihanShow($id)
    {
        $pelatihan = Pelatihan::with(['admin', 'materi', 'pesertas', 'ayatPelatihan', 'imamahKajian', 'games'])->findOrFail($id);
        return view('superadmin.pelatihan.show', compact('pelatihan'));
    }

    public function pelatihanEdit($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return view('superadmin.pelatihan.edit', compact('pelatihan'));
    }

    public function pelatihanUpdate(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $request->validate([
            'nama_pelatihan'    => 'required|string|max:255',
            'penyelenggara'     => 'required|string|max:255',
            'nama_mot'          => 'nullable|string|max:255',
            'tanggal_pelatihan' => 'required|date',
            'tempat_pelatihan'  => 'required|string|max:255',
            'nama_ketum'        => 'nullable|string|max:255',
        ]);

        $pelatihan->update($request->only([
            'nama_pelatihan', 'penyelenggara', 'nama_mot', 'nba_mot',
            'nama_asisten_mot', 'hp_asisten_mot', 'tanggal_pelatihan',
            'tempat_pelatihan', 'nama_ketum', 'nba_ketum',
            'nama_lfp', 'email_lfp',
        ]));

        return redirect()->route('superadmin.pelatihan.show', $id)->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    public function pelatihanApprove($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->update(['status' => 'aktif', 'catatan_superadmin' => null]);
        return redirect()->back()->with('success', "Pelatihan '{$pelatihan->nama_pelatihan}' berhasil diaktifkan.");
    }

    public function pelatihanReject(Request $request, $id)
    {
        $request->validate(['catatan' => 'nullable|string']);
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->update(['status' => 'ditolak', 'catatan_superadmin' => $request->catatan]);
        return redirect()->back()->with('success', "Pelatihan '{$pelatihan->nama_pelatihan}' ditolak.");
    }

    public function pelatihanTutup($id)
    {
        Pelatihan::findOrFail($id)->update(['status' => 'selesai']);
        return redirect()->back()->with('success', 'Pelatihan ditutup.');
    }

    public function pelatihanBuka($id)
    {
        Pelatihan::findOrFail($id)->update(['status' => 'aktif']);
        return redirect()->back()->with('success', 'Pelatihan dibuka kembali.');
    }

    public function pelatihanDestroy($id)
    {
        Pelatihan::findOrFail($id)->delete();
        return redirect()->route('superadmin.pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

    // ===== KELOLA USER MANAGEMENT =====
    public function userIndex()
    {
        $users = User::whereNotIn('role', ['superadmin'])->with('admin')->latest()->paginate(20);
        return view('superadmin.user.index', compact('users'));
    }

    public function userCreate()
    {
        return view('superadmin.user.create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,iot,mog,observer',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role,
            'status'   => 'approved',
        ]);

        return redirect()->route('superadmin.user.index')->with('success', 'User berhasil dibuat.');
    }

    public function userDestroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('superadmin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
