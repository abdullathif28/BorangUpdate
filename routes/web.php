<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PelatihanContextController;
use App\Http\Controllers\Keaktifan\KeaktifanController;
use App\Http\Controllers\Keaktifan\ObservasiPascaController;
use App\Http\Controllers\keaktifan\ObservasiPraController;
use App\Http\Controllers\KultumController;
use App\Http\Controllers\NotulensiController;
use App\Http\Controllers\ObservasigamesController;
use App\Http\Controllers\ObservasiImamahKajianController;
use App\Http\Controllers\ObservasiPendalamanController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SyahadahController;
use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\Admin\AdminController;

// Root redirect
Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

// ============================================================
// GUEST ROUTES
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
    Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');

    // Form publik peserta — dengan token pelatihan
    Route::get('/daftar-peserta', [PesertaController::class, 'formPublik'])->name('daftar-peserta');
    Route::post('/daftar-peserta', [PesertaController::class, 'storePublik'])->name('daftar-peserta.store');
});

// ============================================================
// AUTHENTICATED ROUTES
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Set pelatihan aktif (semua role yang login)
    Route::post('/pelatihan-aktif', [PelatihanContextController::class, 'setAktif'])->name('pelatihan.set-aktif');

    // ============================================================
    // SUPERADMIN ROUTES
    // ============================================================
    Route::prefix('superadmin')->name('superadmin.')->middleware('role:superadmin')->group(function () {
        Route::get('/dashboard', [SuperadminController::class, 'dashboard'])->name('dashboard');

        // Admin management
        Route::get('/admin', [SuperadminController::class, 'adminIndex'])->name('admin.index');
        Route::get('/admin/{id}/edit', [SuperadminController::class, 'adminEdit'])->name('admin.edit');
        Route::put('/admin/{id}', [SuperadminController::class, 'adminUpdate'])->name('admin.update');
        Route::patch('/admin/{id}/approve', [SuperadminController::class, 'adminApprove'])->name('admin.approve');
        Route::patch('/admin/{id}/reject', [SuperadminController::class, 'adminReject'])->name('admin.reject');
        Route::delete('/admin/{id}', [SuperadminController::class, 'adminDestroy'])->name('admin.destroy');

        // Pelatihan management
        Route::get('/pelatihan', [SuperadminController::class, 'pelatihanIndex'])->name('pelatihan.index');
        Route::get('/pelatihan/{id}', [SuperadminController::class, 'pelatihanShow'])->name('pelatihan.show');
        Route::get('/pelatihan/{id}/edit', [SuperadminController::class, 'pelatihanEdit'])->name('pelatihan.edit');
        Route::put('/pelatihan/{id}', [SuperadminController::class, 'pelatihanUpdate'])->name('pelatihan.update');
        Route::patch('/pelatihan/{id}/approve', [SuperadminController::class, 'pelatihanApprove'])->name('pelatihan.approve');
        Route::patch('/pelatihan/{id}/reject', [SuperadminController::class, 'pelatihanReject'])->name('pelatihan.reject');
        Route::patch('/pelatihan/{id}/tutup', [SuperadminController::class, 'pelatihanTutup'])->name('pelatihan.tutup');
        Route::patch('/pelatihan/{id}/buka', [SuperadminController::class, 'pelatihanBuka'])->name('pelatihan.buka');
        Route::delete('/pelatihan/{id}', [SuperadminController::class, 'pelatihanDestroy'])->name('pelatihan.destroy');

        // User management
        Route::get('/users', [SuperadminController::class, 'userIndex'])->name('user.index');
        Route::get('/users/create', [SuperadminController::class, 'userCreate'])->name('user.create');
        Route::post('/users', [SuperadminController::class, 'userStore'])->name('user.store');
        Route::delete('/users/{id}', [SuperadminController::class, 'userDestroy'])->name('user.destroy');
    });

    // ============================================================
    // ADMIN ROUTES
    // ============================================================
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Sub-role management
        Route::get('/admin/tim', [AdminController::class, 'subRoleIndex'])->name('admin.subrole.index');
        Route::get('/admin/tim/create', [AdminController::class, 'subRoleCreate'])->name('admin.subrole.create');
        Route::post('/admin/tim', [AdminController::class, 'subRoleStore'])->name('admin.subrole.store');
        Route::patch('/admin/tim/{id}/reset-token', [AdminController::class, 'subRoleResetToken'])->name('admin.subrole.reset-token');
        Route::delete('/admin/tim/{id}', [AdminController::class, 'subRoleDestroy'])->name('admin.subrole.destroy');

        // Pelatihan
        Route::get('/pelatihan', [PelatihanController::class, 'index'])->name('pelatihan.index');
        Route::get('/pelatihan/create', [PelatihanController::class, 'create'])->name('pelatihan.create');
        Route::post('/pelatihan', [PelatihanController::class, 'store'])->name('pelatihan.store');
        Route::get('/pelatihan/{id}', [PelatihanController::class, 'show'])->name('pelatihan.show');
        Route::delete('/pelatihan/{id}', [PelatihanController::class, 'destroy'])->name('pelatihan.destroy');

        // Peserta (CRUD lengkap)
        Route::resource('peserta', PesertaController::class);

        // Notulensi
        Route::resource('notulensi', NotulensiController::class);
        Route::get('notulensi/{id}/export', [NotulensiController::class, 'exportPdf'])->name('notulensi.exportPdf');

        // Rekapitulasi — export route MUST be before resource to avoid {id} catching 'raport'
        Route::get('/rekapitulasi/raport/{id}/export', [RekapitulasiController::class, 'exportRaport'])->name('raport.export');
        Route::get('/export-ranking', [RekapitulasiController::class, 'exportRanking'])->name('ranking.export');
        Route::resource('rekapitulasi', RekapitulasiController::class);

        // Syahadah
        Route::get('/syahadah/{peserta_id}/export', [SyahadahController::class, 'export'])->name('syahadah.export');
        Route::get('/syahadah/{peserta_id}/preview', [SyahadahController::class, 'preview'])->name('syahadah.preview');

        // Kultum
        Route::resource('kultum', KultumController::class);
    });

    // ============================================================
    // BORANG ROUTES
    // ============================================================

    // Observasi Materi & Pendalaman — Admin + Observer
    Route::middleware('role:admin,superadmin,observer')->group(function () {
        Route::resource('keaktifan/keaktifan', KeaktifanController::class)->only(['index', 'store']);
        Route::resource('observasiPendalaman', ObservasiPendalamanController::class);
        Route::post('/observasipra/store', [ObservasiPraController::class, 'store'])->name('observasipra.store');
        Route::post('/observasipasca/store', [ObservasiPascaController::class, 'store'])->name('observasipasca.store');
        Route::resource('keaktifan/pra', ObservasiPraController::class)->only(['index', 'store']);
    });

    // Imamah + Hafalan — Admin + IOT
    Route::middleware('role:admin,superadmin,iot')->group(function () {
        Route::resource('observasiImamahKajian', ObservasiImamahKajianController::class);
        Route::resource('hafalan', HafalanController::class);
        Route::post('/hafalan/store-bulk', [HafalanController::class, 'storeBulk'])->name('hafalan.store.bulk');
    });

    // Games — Admin + MOG
    Route::middleware('role:admin,superadmin,mog')->group(function () {
        Route::resource('observasigames', ObservasigamesController::class);
    });

    // Shared route aliases for sidebar links
    Route::get('/keaktifan', [KeaktifanController::class, 'index'])->name('keaktifan.index')->middleware('role:admin,superadmin,observer');
    Route::get('/keaktifan/imamah', [ObservasiImamahKajianController::class, 'index'])->name('keaktifan.imamah.index')->middleware('role:admin,superadmin,iot');
    Route::get('/keaktifan/games', [ObservasigamesController::class, 'index'])->name('keaktifan.games.index')->middleware('role:admin,superadmin,mog');

    // API: get materi for a specific pelatihan (for dynamic dropdowns) — MUST be before catch-all
    Route::get('/api/materi-by-pelatihan/{id}', function ($id) {
        $user      = auth()->user();
        $pelatihan = \App\Models\Pelatihan::findOrFail($id);
        // Admin scope check
        if ($user->isAdmin() && $pelatihan->admin_id !== $user->id) abort(403);
        return response()->json(
            \App\Models\MateriPelatihan::where('pelatihan_id', $id)->get(['id', 'nama_materi'])
        );
    });

    // Pages (catch-all) — MUST be last
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
});