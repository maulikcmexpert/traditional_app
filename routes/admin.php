<?php

use App\Http\Controllers\admin\{
    DashboardController
};
use Illuminate\Support\Facades\Route;

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

  

// Route::resources([
//     'dashboard' => DashboardController::class
// ]);

Route::middleware(['auth','web'])->group(function () {
    
    echo "admin";exit;
 

})->prefix('admin');

// require __DIR__.'/auth.php';
