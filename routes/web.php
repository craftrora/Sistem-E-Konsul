<?php

use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IrbanController as AdminIrbanController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\OpdController as AdminOpdController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Irban\DashboardController as IrbanDashboardController;
use App\Http\Controllers\Irban\TicketController as IrbanTicketController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Opd\ConsultationController;
use App\Http\Controllers\Opd\DashboardController as OpdDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
| Beranda selalu ditampilkan, baik pengguna sudah masuk maupun belum.
*/
Route::view('/', 'publik.beranda')->name('beranda');

Route::view('/kegunaan',    'publik.kegunaan')->name('kegunaan');
Route::view('/alur',        'publik.alur')->name('alur');
Route::view('/tanya-jawab', 'publik.tanya-jawab')->name('tanya-jawab');
Route::view('/kontak',      'publik.kontak')->name('kontak');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/daftar', [RegisterController::class, 'create'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->post('/logout', [LoginController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Notifikasi (lintas peran)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])
    ->prefix('notifikasi')
    ->name('notifikasi.')
    ->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/{notifikasi}/buka', [NotifikasiController::class, 'buka'])->name('buka');
        Route::post('/baca-semua', [NotifikasiController::class, 'bacaSemua'])->name('baca-semua');
    });

/*
|--------------------------------------------------------------------------
| Lampiran
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])
    ->get('/lampiran/{attachment}/unduh', [AttachmentController::class, 'download'])
    ->name('lampiran.unduh');

/*
|--------------------------------------------------------------------------
| OPD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:opd'])
    ->prefix('opd')
    ->name('opd.')
    ->group(function () {
        Route::get('/dashboard', [OpdDashboardController::class, 'index'])->name('dashboard');

        Route::get('/konsultasi/buat', [ConsultationController::class, 'create'])->name('konsultasi.create');
        Route::post('/konsultasi', [ConsultationController::class, 'store'])->name('konsultasi.store');
        Route::get('/konsultasi', [ConsultationController::class, 'index'])->name('konsultasi.index');
        Route::get('/konsultasi/{tiket}', [ConsultationController::class, 'show'])->name('konsultasi.show');
        Route::post('/konsultasi/{tiket}/balas', [ConsultationController::class, 'balas'])->name('konsultasi.balas');

        Route::get('/riwayat', [ConsultationController::class, 'riwayat'])->name('riwayat');

        Route::get('/panduan', [OpdDashboardController::class, 'panduan'])->name('panduan');

        Route::get('/profil', [ProfileController::class, 'edit'])->name('profil');
        Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    });

/*
|--------------------------------------------------------------------------
| Irban
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:irban'])
    ->prefix('irban')
    ->name('irban.')
    ->group(function () {
        Route::get('/dashboard', [IrbanDashboardController::class, 'index'])->name('dashboard');

        Route::get('/tiket/baru', [IrbanTicketController::class, 'baru'])->name('tiket.baru');
        Route::get('/tiket/diproses', [IrbanTicketController::class, 'diproses'])->name('tiket.diproses');
        Route::get('/tiket/selesai', [IrbanTicketController::class, 'selesai'])->name('tiket.selesai');
        Route::get('/tiket/{tiket}', [IrbanTicketController::class, 'show'])->name('tiket.show');
        Route::post('/tiket/{tiket}/balas', [IrbanTicketController::class, 'balas'])->name('tiket.balas');
        Route::post('/tiket/{tiket}/tutup', [IrbanTicketController::class, 'tutup'])->name('tiket.tutup');
    });

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/tiket', [AdminTicketController::class, 'index'])->name('tiket.index');
        Route::get('/tiket/{tiket}', [AdminTicketController::class, 'show'])->name('tiket.show');
        Route::post('/tiket/{tiket}/disposisi', [AdminTicketController::class, 'disposisi'])->name('tiket.disposisi');
        Route::post('/tiket/{tiket}/buka-kembali', [AdminTicketController::class, 'bukaKembali'])->name('tiket.buka-kembali');
        Route::delete('/tiket/{tiket}', [AdminTicketController::class, 'destroy'])->name('tiket.destroy');

        // Akun OPD
        Route::get('/opd', [AdminOpdController::class, 'index'])->name('opd.index');
        Route::get('/opd/tambah', [AdminOpdController::class, 'create'])->name('opd.create');
        Route::post('/opd', [AdminOpdController::class, 'store'])->name('opd.store');
        Route::get('/opd/{opd}', [AdminOpdController::class, 'show'])->name('opd.show');
        Route::get('/opd/{opd}/edit', [AdminOpdController::class, 'edit'])->name('opd.edit');
        Route::put('/opd/{opd}', [AdminOpdController::class, 'update'])->name('opd.update');
        Route::post('/opd/{opd}/toggle', [AdminOpdController::class, 'toggle'])->name('opd.toggle');
        Route::post('/opd/{opd}/reset-kode', [AdminOpdController::class, 'resetKode'])->name('opd.reset-kode');

        // Akun Irban
        Route::get('/irban', [AdminIrbanController::class, 'index'])->name('irban.index');
        Route::get('/irban/tambah', [AdminIrbanController::class, 'create'])->name('irban.create');
        Route::post('/irban', [AdminIrbanController::class, 'store'])->name('irban.store');
        Route::get('/irban/{irban}', [AdminIrbanController::class, 'show'])->name('irban.show');
        Route::get('/irban/{irban}/edit', [AdminIrbanController::class, 'edit'])->name('irban.edit');
        Route::put('/irban/{irban}', [AdminIrbanController::class, 'update'])->name('irban.update');
        Route::post('/irban/{irban}/toggle', [AdminIrbanController::class, 'toggle'])->name('irban.toggle');

        // Kategori
        Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/tambah', [AdminKategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [AdminKategoriController::class, 'update'])->name('kategori.update');
        Route::post('/kategori/{kategori}/toggle', [AdminKategoriController::class, 'toggle'])->name('kategori.toggle');

        // Audit Log
        Route::get('/audit-log', [AdminAuditLogController::class, 'index'])->name('audit-log.index');

        // Laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [AdminLaporanController::class, 'export'])->name('laporan.export');
    });
