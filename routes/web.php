<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\DashboardController::class, 'welcome']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/transcriptions', [\App\Http\Controllers\DashboardController::class, 'transcriptions'])->name('transcriptions');

    Route::get('/files', [\App\Http\Controllers\FileController::class, 'index'])->name('files.index');
    Route::post('/files', [\App\Http\Controllers\FileController::class, 'store'])->name('files.store');
});
