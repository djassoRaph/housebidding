<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PropertyController::class, 'show'])->name('property.show');
Route::get('/bids', [PropertyController::class, 'bids'])->name('property.bids');
Route::post('/bid', [BidController::class, 'store'])->middleware('auth')->name('bid.store');
Route::view('/mentions-legales', 'mentions-legales');
Route::view('/conditions', 'conditions');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/close', [AdminController::class, 'close'])->name('admin.close');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
     ->middleware('guest')
     ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
     ->middleware('guest');



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/__backpanel_secret', [AdminController::class, 'index'])->name('admin.panel');
});

require __DIR__.'/auth.php';
