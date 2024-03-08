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

    Route::post('country_list', [UsersController::class, 'country_list'])->name('country_list');
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
    Route::get('religion_list', [ListController::class, 'religionList']);
    Route::post('otp_verify', [UsersController::class, 'otpVerify'])->name('otp_verify');



    Route::post('store_profile', [UsersController::class, 'storeProfile'])->middleware('check_user');
    Route::post('user_personalities', [UsersController::class, 'userPersonalities'])->middleware('check_user');
    Route::post('user_love_lang_rate', [UsersController::class, 'userLoveLangRate'])->middleware('check_user');
    Route::post('add_shows_stoper_ques', [UsersController::class, 'addShowsStoperQues'])->middleware('check_user');
    Route::post('organization_profile', [UsersController::class, 'organizationProfile'])->middleware('check_user');
    Route::post('user_profile', [UsersController::class, 'userProfile'])->middleware('check_user');
    Route::post('update_user_profile', [UsersController::class, 'updateUserprofile'])->middleware('check_user');
    Route::post('update_organization_profile', [UsersController::class, 'updateOrganizationprofile'])->middleware('check_user');
    Route::post('update_profile_photo', [UsersController::class, 'updateProfilePhoto'])->middleware('check_user');
    Route::post('home', [UsersController::class, 'home'])->middleware('check_user');
    Route::post('check_user_approach_status', [UsersController::class, 'checkUserApproachStatus'])->middleware('check_user');


    Route::post('get_show_stopper_ques', [UsersController::class, 'getShowStopperQues'])->middleware('check_user');
    Route::post('check_ques_answer', [UsersController::class, 'checkQuesAnswer'])->middleware('check_user');
    Route::post('approch_request', [UsersController::class, 'approchRequest'])->middleware('check_user');
    Route::post('show_user_profile', [UsersController::class, 'showUserProfile'])->middleware('check_user');
    Route::post('member_of_organization', [UsersController::class, 'memberOfOrganization'])->middleware('check_user');
    Route::post('approach_request', [UsersController::class, 'approachRequest'])->middleware('check_user');
    Route::post('manage_request_by_male', [UsersController::class, 'manageRequestByMale'])->middleware('check_user');
    Route::post('cancel_request', [UsersController::class, 'cancelRequest'])->middleware('check_user');
    Route::post('manage_request_by_female', [UsersController::class, 'manageRequestByFemale'])->middleware('check_user');
    Route::post('accept_reject_by_female', [UsersController::class, 'acceptRejectByFemale'])->middleware('check_user');
    Route::post('search_user', [UsersController::class, 'searchUser'])->middleware('check_user');

    // Route::middleware(['check_user'])->group( function () {
    //     Route::get('country_list_login', [ListController::class, 'CountryList']);
    // });
});
