<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {

    Route::post('user_signup', [UsersController::class, 'userSignup'])->name('user_signup');
    Route::post('organization_signup', [UsersController::class, 'organizationSignup'])->name('organization_signup');
    Route::post('login', [UsersController::class, 'signIn'])->name('login');
    Route::get('sizeoforganization_list', [ListController::class, 'sizeOfOrganizationList'])->name('sizeoforganization_list');

    Route::post('state_list', [ListController::class, 'stateList'])->name('state_list');
    Route::post('city_list', [ListController::class, 'cityList'])->name('city_list');
    Route::get('organization_list', [ListController::class, 'organizationList'])->name('organization_list');
    Route::get('zodiacsign_list', [ListController::class, 'zodiacSignList'])->name('zodiacsign_list');
    Route::get('interest_hobby_list', [ListController::class, 'interestAndHobbyList'])->name('interest_hobby_list');
    Route::get('life_style_list', [ListController::class, 'lifieStyleList'])->name('life_style_list');
    Route::post('otp_verify', [UsersController::class, 'otpVerify'])->name('otp_verify');



    Route::post('store_profile', [UsersController::class, 'storeProfile'])->middleware('check_user');
    Route::post('user_personality', [UsersController::class, 'userPersonality'])->middleware('check_user');

    Route::get('check', [UsersController::class, 'check'])->name('check');
    Route::post('showsstopperque_add', [UsersController::class, 'ShowsStoperQuesAdd'])->name('showsstopperque_add');
    // Route::middleware(['check_user'])->group( function () {
    //     Route::get('country_list_login', [ListController::class, 'CountryList']);
    // });
});
