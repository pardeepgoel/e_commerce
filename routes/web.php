<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php

Route::get('login-page', [AuthController::class, 'loginPage']);
Route::get('register-page', [AuthController::class, 'registerPage']);

Route::get('login-process', [AuthController::class, 'loginProcess']);



Route::middleware(['checkTokenFrontent'])->group(function () {
    Route::get('/frontend-products', [FrontendController::class, 'productPage']);
   
    
        
    });

