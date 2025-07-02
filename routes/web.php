<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyController::class, 'show'])->name('property.show');
Route::get('/bids', [PropertyController::class, 'bids'])->name('property.bids');
Route::post('/bid', [BidController::class, 'store'])->middleware('auth')->name('bid.store');
Route::middleware('auth')->group(function () {
    Route::get('/justificatif', [DocumentController::class, 'show'])->name('document.form');
    Route::post('/justificatif', [DocumentController::class, 'store'])->name('document.store');
});
Route::view('/mentions-legales', 'mentions-legales');
Route::view('/conditions', 'conditions');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/close', [AdminController::class, 'close'])->name('admin.close');
Route::post('/admin/users/{user}/validate', [AdminController::class, 'validateDocument'])->name('admin.validate');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
