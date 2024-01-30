<?php
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\EducatorsController;
use App\Http\Controllers\Api\InstituteController;
use App\Http\Controllers\Api\HostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\ApiValidationTrait;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store']);

    Route::post('signup', [UsersController::class, 'signup'])->name('signup');
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => ['json.response', 'auth:api']], function () {
    Route::post('logout', [AuthenticationController::class, 'destroy']);
    Route::post('profileupdate', [UsersController::class, 'profileupdate']);
    Route::post('hostprofileupdate', [HostController::class, 'hostprofileupdate']);
    Route::post('instituteprofileupdate', [InstituteController::class, 'instituteprofileupdate']);
    Route::post('createcourse', [EducatorsController::class, 'createcourse']);
    Route::post('getCategoryOfsubcategory', [EducatorsController::class, 'getCategoryOfsubcategory']);
    Route::post('getLearners', [EducatorsController::class, 'getLearners']);
    Route::post('user_connection', [EducatorsController::class, 'user_connection']);
    Route::post('getUserRequest', [EducatorsController::class, 'getUserRequest']);


});