<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get( '/', function () {
    return view('layouts.layout');
});



Route::get('/dashboard', function () {
    
    return view('layouts.layout');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::prefix('admin')->middleware(['auth', 'verified'])->group(function(){

// });

Route::middleware(['admin', 'auth', 'verified'])->group(function () {
    Route::get('/testuser', [DashboardController::class, 'index'])->name('testuser');
    Route::get('/adduser', [DashboardController::class, 'UserDetail'])->name('adduser');
})->prefix('admin');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
