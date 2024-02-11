<?php

use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Middleware\noLogin;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [homeController::class, 'index']);


Route::middleware([noLogin::class])->group(function(){

    Route::get('/register', [loginController::class, 'register']);
    Route::post('/register', [loginController::class, 'store_register']);
    
    Route::get('/login', [loginController::class, 'login'])->name('login');
    Route::post('/login', [loginController::class, 'store_login']);
});

Route::middleware(['auth']) -> group(function(){
    Route::get('/dashboard', [homeController::class, 'dashboard']);

    Route::get('/logout', [loginController::class, 'logout']);
});