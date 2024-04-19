<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrivacyPolicyController;
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

Route::get('/privacy_policy', function () {
    return view('welcome');
});
Route::group(['middleware' => 'guest'], function () {
    Route::resources([
        'privacy_policy' => PrivacyPolicyController::class,
    ]);
});

require __DIR__ . '/auth.php';
