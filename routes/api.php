<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ListController;
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
    // Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('user_signup', [UsersController::class, 'user_signup'])->name('user_signup');
    Route::get('country_list', [ListController::class, 'CountryList'])->name('country_list');
    Route::get('state_list', [ListController::class, 'StateList'])->name('state_list');
    Route::get('city_list', [ListController::class, 'CityList'])->name('city_list');
    Route::get('organization_list', [ListController::class, 'OrganizationLIST'])->name('organization_list');
    Route::get('zodiacsign_list', [ListController::class, 'ZodiacSignLIST'])->name('zodiacsign_list');
    Route::get('interest_hobby_list', [ListController::class, 'InterestAndHobbyLIST'])->name('interest_hobby_list');
    Route::get('life_style_list', [ListController::class, 'LifieStyleLIST'])->name('life_style_list');
    Route::post('otp_verify', [UsersController::class, 'otp_verify'])->name('otp_verify');
});
