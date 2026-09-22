<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMagangController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('data-magang')->name('data-magang.')->group(function () {
    Route::get('/', [DataMagangController::class, 'index'])->name('index');
    Route::post('/', [DataMagangController::class, 'store'])->name('store');
    Route::delete('/{dataMagang}', [DataMagangController::class, 'destroy'])->name('destroy');
});

Route::prefix('absensi')->name('absensi.')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('index');
    Route::post('/', [AbsensiController::class, 'store'])->name('store');
    Route::delete('/{absensi}', [AbsensiController::class, 'destroy'])->name('destroy');
});

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('index');
    Route::get('/pdf', [LaporanController::class, 'pdf'])->name('pdf');
});
