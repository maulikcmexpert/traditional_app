<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    BlockReasonController,
    CurseWordController,
    DashboardController,
    UserController,
    InterestAndHobbiesController,
    LifeStyleController,
    VerificationObjectController,
    ZodiacSignController
};


Route::middleware(['admin', 'web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'user' => UserController::class,
        'interest_and_hobby' => InterestAndHobbiesController::class,
        'lifestyle' => LifeStyleController::class,
        'zodiacsign' => ZodiacSignController::class,
        'curseword' => CurseWordController::class,
        'blockreason' => BlockReasonController::class,
        'verificationobject' => VerificationObjectController::class
    ]);
    Route::post('interest_and_hobby/interest_and_hobby_exist', [InterestAndHobbiesController::class, 'interestAndHobbyExist'])->name('interest_and_hobby.exist');
    Route::post('lifestyle/lifestyle_exist', [LifeStyleController::class, 'lifestyleExist'])->name('lifestyle.exist');
    Route::post('zodiacsign/zodiacsign_exist', [ZodiacSignController::class, 'zodiacsignExist'])->name('zodiacsign.exist');
    Route::post('curseword/curseword_exist', [CurseWordController::class, 'CursewordExist'])->name('curseword.exist');
    Route::post('blockreason/blockreason_exist', [BlockReasonController::class, 'BlockReasonExist'])->name('blockreason.exist');
    Route::post('verificationobject/verificationobject_exist', [VerificationObjectController::class, 'VerificationObjectExist'])->name('verificationobject.exist');
});
