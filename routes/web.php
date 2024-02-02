<?php

namespace App\Http\Controllers;
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

// Route::get('/', function(){
//     return view('welcome');
// });


Route::get('/logout',  [LoginSignupController::class, 'logout']);
Route::get('/default', [LoginSignupController::class, 'default']);

Route::get('/', [LoginSignupController::class, 'LoginSignup']);
Route::post('/login/process', [LoginSignupController::class, 'process']);


Route::post('/store', [LoginSignupController::class, 'store']);


Route::get('/home', [UserController::class, 'home']);

Route::get('/about-us', [UserController::class, 'about_us']);

Route::get('/Product', [UserController::class, 'Product']);

Route::get('/DIY',  [UserController::class, 'DIY']);

Route::get('/userProfile', [UserController::class, 'userProfile']);