<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TranscriptionController;

use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'welcome']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/transcriptions', [TranscriptionController::class, 'index'])->name('transcriptions.index');

    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/files/{file}', [FileController::class, 'show'])->name('files.show');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
});
