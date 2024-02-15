<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    DashboardController,
    UserController,
    InterestAndHobbiesController
};

Route::middleware(['admin', 'web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'user' => UserController::class,
        'interest_and_hobbies' => InterestAndHobbiesController::class,
    ]);
});
