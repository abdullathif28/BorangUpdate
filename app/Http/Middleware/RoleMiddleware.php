<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        // Check account status for admin and sub-roles
        if (in_array($user->role, ['admin', 'iot', 'mog', 'observer']) && $user->status !== 'approved') {
            auth()->logout();
            $msg = $user->role === 'admin'
                ? 'Akun Anda belum disetujui oleh Super Admin.'
                : 'Akun tim Anda tidak aktif. Hubungi admin.';
            return redirect('/login')->with('error', $msg);
        }

        return $next($request);
    }
}
