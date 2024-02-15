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
        'interest_and_hobby' => InterestAndHobbiesController::class,
    ]);
    Route::post('interest_and_hobby/interest_and_hobby_exist', [InterestAndHobbiesController::class, 'interestAndHobbyExist'])->name('interest_and_hobby.exist');
});
