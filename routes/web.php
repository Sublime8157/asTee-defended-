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

// Route for logging out 
Route::get('/logout',  [LoginSignupController::class, 'logout']);
// Default rouse that shows the login form 
Route::get('/', [LoginSignupController::class, 'LoginSignup']);

// Route for logging in proccess
Route::post('/login/process', [LoginSignupController::class, 'process']);
// Route for registering a user 
Route::post('/store', [LoginSignupController::class, 'store']);

// Route for homepage
Route::get('/home', [UserController::class, 'home']);
// Route for about us page
Route::get('/about-us', [UserController::class, 'about_us']);

// Route for product tab
Route::get('/filterProducts', [productsController::class, 'filterProducts']);
Route::get('/Product', [productsController::class, 'displayOnHandsProducts']);

// Route for DIY page
Route::get('/DIY',  [UserController::class, 'DIY']);

// These routes was for updating the user Profile
Route::post('/updateProfile', [UserController::class, 'updateProfile']);
Route::get('/userProfile', [UserController::class, 'userProfile']);

// All these routes are responsible for admin panel
Route::get('/loginAdmin', [adminIndexController::class, 'login']);
Route::get('/dashboard', [adminIndexController::class, 'index']);
Route::get('/feedbacks', [adminIndexController::class, 'feedbacks']);

// Routes for admin products panel tab 
Route::get('/products/onHand', [adminProductsController:: class, 'onHand']);
Route::get('/products/proccessing', [adminProductsController::class, 'proccessing']);
Route::get('/products/finished', [adminProductsController::class, 'finished']);

// Route for accounts admin panel tab 
Route::get('/accounts/active', [adminAccountsController::class, 'active']);
Route::get('/accounts/denied', [adminAccountsController::class, 'denied']);
Route::get('/accounts/pending', [adminAccountsController::class, 'pending']);

