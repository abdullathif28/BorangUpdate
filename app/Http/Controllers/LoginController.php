<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Cek apakah input adalah token (sub-role login)
        if ($request->filled('token_login') && !$request->filled('email')) {
            return $this->loginWithToken($request);
        }

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Cek status admin
            if ($user->role === 'admin' && $user->status !== 'approved') {
                Auth::logout();
                $msg = $user->status === 'pending'
                    ? 'Akun Anda masih menunggu persetujuan Super Admin.'
                    : 'Pendaftaran Anda ditolak. Silakan hubungi Super Admin.';
                return back()->with('error', $msg);
            }

            $request->session()->regenerate();
            return $this->redirectByRole($user);
        }

        return back()->withErrors(['email' => 'Email atau password tidak sesuai.'])->withInput();
    }

    protected function loginWithToken(Request $request)
    {
        $request->validate(['token_login' => 'required|string']);

        $user = User::where('token_login', strtoupper($request->token_login))->first();

        if (!$user) {
            return back()->withErrors(['token_login' => 'Token tidak valid.']);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return $this->redirectByRole($user);
    }

    protected function redirectByRole(User $user): \Illuminate\Http\RedirectResponse
    {
        return match($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin'      => redirect()->route('admin.dashboard'),
            'iot'        => redirect()->route('keaktifan.imamah.index'),
            'mog'        => redirect()->route('keaktifan.games.index'),
            'observer'   => redirect()->route('keaktifan.index'),
            default      => redirect('/dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
