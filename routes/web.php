<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

//---- Authentication Routes
Route::post('/register', [AuthController::class, 'create'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//---- Tokens_need routes
Route::group(['middleware' => 'user'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/changePassword', [UserController::class, 'changePassword'])->name('changePassword'); //->middleware('user');
    Route::get('/showUser', [UserController::class, 'show']);
    Route::post('/addCart', [UserController::class, 'addCart']);
});
