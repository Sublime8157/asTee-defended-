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
// for onhnad products tab 
Route::get('/products/onHand', [adminOnHandsController:: class, 'onHand']);
Route::post('/addProducts', [adminOnHandsController::class, 'storeOnhand']);
// remove product
Route::delete('/removeProduct/{id}', [adminOnHandsController::class, 'removeProduct'])->name('product.remove');
// for filter products for admin panel 
Route::get('/filterOnHandProducts', [adminOnHandsController::class, 'filterOnHandProducts']);
// for editing the products in onhand 
Route::patch('/editProduct/{id}', [adminOnHandsController::class, 'editProduct'])->name('edit.Product');

// For processing tab
Route::get('/products/proccessing', [adminOnProcessController::class, 'proccessing']);
Route::post('/storeProcessing ', [adminOnProcessController::class, 'storeProcessing']);
Route::delete('/removeProcessing/{id}', [adminOnProcessController::class, 'removeProduct'])->name('productProcess.remove');
Route::patch('/editProcessingProduct/{id}', [adminOnProcessController::class, 'editProcessingProduct'])->name('productProcess.edit');

// filter products in processign tab 
Route::get('/filterProcessingProducts', [adminOnProcessController::class, 'filterProcessing']);

// for cancel or return tab 
Route::get('/products/cancelReturn', [adminCancelReturnController::class, 'cancel_return']);
Route::post('/storeCancelReturn', [adminCancelReturnController::class, 'storeCancelReturn']);
Route::patch('/editCancelReturnProduct/{id}', [adminCancelReturnController::class, 'editCancelReturn'])->name('edit.cancelReturn');
// filter products in cancel or return
Route::get('/filterCancelReturn', [adminCancelReturnController::class, 'filterCancelReturn']);
Route::delete('/removeReturnCancel/{id}', [adminCancelReturnController::class, 'removeProduct'])->name('cancelReturn.remove');



// Route for accounts admin panel tab 
Route::get('/accounts/active', [accountsController::class, 'displayUsers']);
// search a suer 
Route::get('/searchUser', [accountsController::class, 'searchUsers']);
// sort user by name, email or id and if descend or ascend 
Route::get('/sortUsers', [accountsController::class, 'sortUsers']);
// block a user 
Route::patch('/userBlock/{id}', [accountsController::class, 'block'])->name('users.block');

// remove a user 
Route::delete('/users/{id}', [accountsController::class, 'destroy'])->name('users.destroy');



Route::get('/accounts/blocked', [blockedAccountsController::class, 'display']);
Route::get('/sortBlockUsers', [blockedAccountsController::class, 'sortBlockUsers']);
Route::patch('/unblock/{id}', [blockedAccountsController::class, 'unblock'])->name('users.unblock');
Route::get('/searchBlockedUsers', [blockedAccountsController::class, 'searchBlockedUsers']);

Route::get('/accounts/pending', [adminAccountsController::class, 'pending']);
