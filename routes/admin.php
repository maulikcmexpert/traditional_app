<?php



use Illuminate\Support\Facades\Route;


use App\Http\Controllers\admin\Auth;

use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\admin\DashboardController;

use Illuminate\Support\Facades\Session;





/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/





// Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
//         echo 1;die;
//     // Route::resources([
//     //     'dashboard' => DashboardController::class
//     // ]);
// });


// Route::prefix('admin')->middleware(['admin','auth','verified'])->group(function () {
//         // echo 1;
//         // die;
//     // Route::resources([
//     //     'dashboard' => DashboardController::class
//     // ]);
// });


// Route::middleware(['admin','auth','verified'])->group(function () {

// Route::get('/testuser', [DashboardController::class, 'index'])->name('testuser');

// });

// Route::middleware(['admin', 'auth', 'verified'])->group(function () {
//     Route::get('/testuser', [DashboardController::class, 'index'])->name('testuser');
// });
