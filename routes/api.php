<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\UsersController_v2;
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
    Route::post('show_organization_profile', [UsersController::class, 'organizationProfileId']);
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
    Route::post('member_of_organization', [UsersController::class, 'memberOfOrganization']);
    Route::post('approach_request', [UsersController::class, 'approachRequest'])->middleware('check_user');
    Route::post('manage_request_by_male', [UsersController::class, 'manageRequestByMale'])->middleware('check_user');
    Route::post('cancel_request', [UsersController::class, 'cancelRequest'])->middleware('check_user');
    Route::post('manage_request_by_female', [UsersController::class, 'manageRequestByFemale'])->middleware('check_user');
    Route::post('accept_reject_by_female', [UsersController::class, 'acceptRejectByFemale'])->middleware('check_user');
    Route::post('search_user', [UsersController::class, 'searchUser'])->middleware('check_user');
    Route::post('block_user_list', [UsersController::class, 'blockUserList'])->middleware('check_user');
    Route::post('update_show_stopper_ques', [UsersController::class, 'updateShowStopperQues'])->middleware('check_user');
    Route::post('logout', [UsersController::class, 'logout'])->middleware('check_user');

    // Route::middleware(['check_user'])->group( function () {
    //     Route::get('country_list_login', [ListController::class, 'CountryList']);
    // });
});


Route::group(['namespace' => 'Api', 'prefix' => 'v2'], function () {
    Route::get('install_app', [UsersController_v2::class, 'installApp']);
    Route::post('notification_test', [UsersController_v2::class, 'notificationTest']);
    Route::post('country_list', [UsersController_v2::class, 'country_list'])->name('country_list');
    Route::post('user_signup', [UsersController_v2::class, 'userSignup'])->name('user_signup');
    Route::post('organization_signup', [UsersController_v2::class, 'organizationSignup'])->name('organization_signup');
    Route::post('login', [UsersController_v2::class, 'signIn'])->name('login');
    Route::get('sizeoforganization_list', [ListController::class, 'sizeOfOrganizationList'])->name('sizeoforganization_list');

    Route::post('state_list', [ListController::class, 'stateList'])->name('state_list');
    Route::post('city_list', [ListController::class, 'cityList'])->name('city_list');
    Route::get('organization_list', [ListController::class, 'organizationList'])->name('organization_list');
    Route::get('zodiacsign_list', [ListController::class, 'zodiacSignList'])->name('zodiacsign_list');
    Route::get('interest_hobby_list', [ListController::class, 'interestAndHobbyList'])->name('interest_hobby_list');
    Route::get('life_style_list', [ListController::class, 'lifieStyleList'])->name('life_style_list');
    Route::get('religion_list', [ListController::class, 'religionList']);
    Route::post('otp_verify', [UsersController_v2::class, 'otpVerify'])->name('otp_verify');



    Route::post('store_profile', [UsersController_v2::class, 'storeProfile'])->middleware('check_user');
    Route::post('user_personalities', [UsersController_v2::class, 'userPersonalities'])->middleware('check_user');
    Route::post('user_love_lang_rate', [UsersController_v2::class, 'userLoveLangRate'])->middleware('check_user');
    Route::post('add_shows_stoper_ques', [UsersController_v2::class, 'addShowsStoperQues'])->middleware('check_user');
    Route::post('organization_profile', [UsersController_v2::class, 'organizationProfile'])->middleware('check_user');
    Route::post('show_organization_profile', [UsersController_v2::class, 'organizationProfileId']);
    Route::post('user_profile', [UsersController_v2::class, 'userProfile'])->middleware('check_user');
    Route::post('update_user_profile', [UsersController_v2::class, 'updateUserprofile'])->middleware('check_user');
    Route::post('update_organization_profile', [UsersController_v2::class, 'updateOrganizationprofile'])->middleware('check_user');
    Route::post('update_profile_photo', [UsersController_v2::class, 'updateProfilePhoto'])->middleware('check_user');
    Route::post('home', [UsersController_v2::class, 'home'])->middleware('check_user');
    Route::post('check_user_approach_status', [UsersController_v2::class, 'checkUserApproachStatus'])->middleware('check_user');


    Route::post('get_show_stopper_ques', [UsersController_v2::class, 'getShowStopperQues'])->middleware('check_user');
    Route::post('check_ques_answer', [UsersController_v2::class, 'checkQuesAnswer'])->middleware('check_user');
    Route::post('approch_request', [UsersController_v2::class, 'approchRequest'])->middleware('check_user');
    Route::post('show_user_profile', [UsersController_v2::class, 'showUserProfile'])->middleware('check_user');
    Route::post('member_of_organization', [UsersController_v2::class, 'memberOfOrganization']);
    Route::post('approach_request', [UsersController_v2::class, 'approachRequest'])->middleware('check_user');
    Route::post('manage_request_by_male', [UsersController_v2::class, 'manageRequestByMale'])->middleware('check_user');
    Route::post('cancel_request', [UsersController_v2::class, 'cancelRequest'])->middleware('check_user');
    Route::post('manage_request_by_user', [UsersController_v2::class, 'manageRequestByUser'])->middleware('check_user');
    Route::post('manage_request_by_female', [UsersController_v2::class, 'manageRequestByFemale'])->middleware('check_user');
    Route::post('accept_reject_by_user', [UsersController_v2::class, 'acceptRejectByUser'])->middleware('check_user');
    Route::post('search_user', [UsersController_v2::class, 'searchUser'])->middleware('check_user');
    Route::post('block_user_list', [UsersController_v2::class, 'blockUserList'])->middleware('check_user');
    Route::post('block_unblock_to_user', [UsersController_v2::class, 'blockUnblockToUser'])->middleware('check_user');
    Route::get('age_limiter', [UsersController_v2::class, 'ageLimiter']);
    Route::get('block_reason', [UsersController_v2::class, 'blockReason']);
    Route::post('update_show_stopper_ques', [UsersController_v2::class, 'updateShowStopperQues'])->middleware('check_user');
    Route::post('logout', [UsersController_v2::class, 'logout'])->middleware('check_user');
    Route::post('notification_list', [UsersController_v2::class, 'notificationList'])->middleware('check_user');
    Route::post('delete_notification', [UsersController_v2::class, 'deleteNotification'])->middleware('check_user');
    Route::get('clear_notification', [UsersController_v2::class, 'clearNotification'])->middleware('check_user');
    Route::post('friend_request', [UsersController_v2::class, 'friendRequest'])->middleware('check_user');
    Route::post('report_user', [UsersController_v2::class, 'ReportUser'])->middleware('check_user');
    Route::get('feedback_review_list', [UsersController_v2::class, 'feedbackReviewList']);
    Route::post('user_feedback', [UsersController_v2::class, 'UserFeedback'])->middleware('check_user');
    Route::get('certain_word_list', [UsersController_v2::class, 'CertainWordList']);
    Route::post('disconnect_to_user', [UsersController_v2::class, 'DisconnectToUser'])->middleware('check_user');
    Route::post('update_approach_preference', [UsersController_v2::class, 'updateApproachPreference'])->middleware('check_user');
    Route::get('get_approach_preference', [UsersController_v2::class, 'getApproachPreference'])->middleware('check_user');
    Route::get('get_verify_object', [UsersController_v2::class, 'getVerifyObject'])->middleware('check_user');
    Route::get('verified_user_profile', [UsersController_v2::class, 'verifiedUserProfile'])->middleware('check_user');


    // Route::middleware(['check_user'])->group( function () {
    //     Route::get('country_list_login', [ListController::class, 'CountryList']);
    // });
});
