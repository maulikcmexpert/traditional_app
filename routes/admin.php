<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    DashboardController
};

Route::middleware(['admin', 'web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
