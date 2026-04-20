<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return view('auth.login'); });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ===================== ADMIN =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('anggota', \App\Http\Controllers\Admin\AnggotaController::class)->except(['create','edit','show']);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('petugas', \App\Http\Controllers\Admin\PetugasController::class);
    Route::resource('buku', \App\Http\Controllers\Admin\BukuController::class);
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
    Route::resource('penerbit', \App\Http\Controllers\Admin\PenerbitController::class);
    Route::resource('pengarang', \App\Http\Controllers\Admin\PengarangController::class);
    Route::resource('rak', \App\Http\Controllers\Admin\RakController::class)->except(['create','edit','show']);
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class)->except(['create','edit','show']);
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
});

// ===================== PETUGAS =====================
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Petugas\PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi', [\App\Http\Controllers\Petugas\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [\App\Http\Controllers\Petugas\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{id}/terima', [\App\Http\Controllers\Petugas\TransaksiController::class, 'terima'])->name('transaksi.terima');
    Route::patch('/transaksi/{id}/tolak', [\App\Http\Controllers\Petugas\TransaksiController::class, 'tolak'])->name('transaksi.tolak');
    Route::patch('/transaksi/{id}/kembalikan', [\App\Http\Controllers\Petugas\TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
    Route::patch('/transaksi/{id}/lunasi', [\App\Http\Controllers\Petugas\TransaksiController::class, 'lunasi'])->name('transaksi.lunasi');
    Route::get('/laporan', [\App\Http\Controllers\Petugas\LaporanController::class, 'index'])->name('laporan.index');
});

// ===================== ANGGOTA =====================
Route::middleware(['auth', 'anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Anggota\AnggotaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/buku', [\App\Http\Controllers\Anggota\BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{id}', [\App\Http\Controllers\Anggota\BukuController::class, 'show'])->name('buku.show');
    Route::post('/pinjam', [\App\Http\Controllers\Anggota\PeminjamanController::class, 'store'])->name('pinjam.store');
    Route::get('/history', [\App\Http\Controllers\Anggota\PeminjamanController::class, 'history'])->name('history');
    Route::patch('/kembalikan/{id}', [\App\Http\Controllers\Anggota\PeminjamanController::class, 'kembalikan'])->name('kembalikan');
});
