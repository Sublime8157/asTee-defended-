<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminCustomizeResetPasswordController;
use App\Http\Controllers\Auth\AdminCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\UserCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\UserCustomizeResetPasswordController;
use App\Models\adminLogin;
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
Route::get('/loginAdmin', [adminIndexController::class, 'login'])->name('loginAdmin');
Route::post('/loggingIn', [adminIndexController::class, 'adminLogin']);
Route::post('adminLogout', [adminIndexController::class, 'adminLogout']);
Route::get('/managePassword', [adminIndexController::class, 'managePassword'])->middleware('admin');
Route::post('/changePassword',[adminIndexController::class, 'changePassword'])->name('changeAdmin.password')->middleware('admin');
Route::get('/regsiterAccount', [adminIndexController::class, 'registerAccount'])->name('registration');
Route::post('/submitRegistration', [adminIndexController::class, 'submitRegistration'])->name('registerAdmin.Account');
Route::view('/adminVerified', 'admin.emailverified');
Route::get('/verifyAdmin/{email}', function($email){
    $admin = adminLogin::where('email', $email)->first();
    if($admin) {
        $admin->email_verified_at = now();
        $admin->save();
    }
    return view('admin.emailverified');
})->name('verifyAdminRegistration');

// Route for logging out 
Route::get('/logout',  [LoginSignupController::class, 'logout']);
// Default rouse that shows the login form 
Route::get('/', [LoginSignupController::class, 'LoginSignup'])->name('userLogin');
Auth::routes(['verify' => true]);

// Route for logging in proccess
Route::post('/login/process', [LoginSignupController::class, 'process'])->name('loginProcess')->middleware('throttle:5,1');
// Route for registering a user 
Route::post('/store', [LoginSignupController::class, 'store']);

// Route for homepage
// Route::get('/homepage', [UserController::class, 'home']);
// Route for about us page
Route::get('/about-us', [UserController::class, 'about_us']);
// Route for product tab
Route::get('/filterProducts', [productsController::class, 'filterProducts']);
Route::get('/Product', [productsController::class, 'displayOnHandsProducts']);
// for contact us 
Route::view('/contact-us','user.contact_us');
// Route for DIY page
Route::get('/DIY',  [UserController::class, 'DIY']);
Route::view('/licensing', 'user.licensing')->name('licensing');
// These routes was for updating the user Profile
Route::post('/updateProfile', [userProfileController::class, 'updateUserInfo']);
Route::post('/uploadID',[userProfileController::class,'uploadID'])->name('upload.validID');
Route::get('/userProfile/myAccount', [UserController::class, 'userProfile']);
Route::get('/checkout',[UserController::class, 'checkout'])->name('checkout.process');
Route::post('/userProfileUpdate', [userProfileController::class, 'updateProfile'])->name('update.profile');
Route::get('/userProfile/myPassword', [UserController::class, 'userPassword']);

// All these routes are responsible for admin panel
Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware('admin');
Route::get('/filterSalesDate', [dashboardController::class, 'filterSales']); 
Route::get('/products/feedbacks', [adminIndexController::class, 'feedbacks'])->middleware('admin');
Route::patch('/featureReview/{id}',[adminIndexController::class, 'toFeature'])->name('featureReview');

// route for order history 
Route::get('/orders', [OrderHistoryController::class, 'showOrderList']);
Route::get('/searchOrder', [OrderHistoryController::class, 'filterOrders']);
Route::get('/sortOrders', [OrderHistoryController::class, 'sortOrders']); 
Route::get('/filterDate', [OrderHistoryController::class, 'filterDate']);

//route for payments history 
Route::get('/payments', [PaymentHistoryController::class, 'display']);
Route::post('/paymentForm', [PaymentHistoryController::class, 'store'])->name('paymentForm');
Route::get('/filterPayments', [PaymentHistoryController::class, 'sort']);
Route::get('/filterPaymentsDate', [PaymentHistoryController::class, 'filterDate']); 
Route::get('/filterbyBank', [PaymentHistoryController::class, 'filterBanks']);
Route::get('/filterPrice', [PaymentHistoryController::class, 'filterPrice']);
Route::get('/searchIdPayments', [PaymentHistoryController::class, 'searchById']);
Route::delete('/removePayments', [PaymentHistoryController::class, 'removePaymentsRecords'])->name('removePayments');
Route::delete('/deleteRecordPayments', [PaymentHistoryController::class, 'removeRecord'])->name('deleteRecordPayments');
    
// Routes for admin products panel tab 
// for onhnad products tab 
Route::get('/products/onHand', [adminOnHandsController:: class, 'onHand'])->middleware('admin');
Route::post('/addProducts', [adminOnHandsController::class, 'storeOnhand']);
// remove product
Route::delete('/removeProduct/{id}', [adminOnHandsController::class, 'removeProduct'])->name('product.remove');
// for filter products for admin panel 
Route::get('/filterOnHandProducts', [adminOnHandsController::class, 'filterOnHandProducts']);
// for editing the products in onhand 
Route::patch('/editProduct/{id}', [adminOnHandsController::class, 'editProduct'])->name('edit.Product');
Route::post('/moveProduct/{id}', [adminOnHandsController::class, 'moveProduct'])->name('move.Product');
Route::post('/moveMultipleOnHand', [adminOnHandsController::class, 'moveMultiple'])->name('moveMultipleFrom.onHand');
// sort on hands product table 
Route::get('/sortProduct', [adminOnHandsController::class, 'sortProducts']);
//delte all
Route::delete('/deleteAll',[adminOnHandsController::class, 'removeAllProduct'])->name('deleteFrom.OnHand');
// For processing tab
Route::get('/products/proccessing', [adminOnProcessController::class, 'proccessing'])->middleware('admin');
Route::post('/storeProcessing ', [adminOnProcessController::class, 'storeProcessing']);
Route::delete('/removeProcessing/{id}', [adminOnProcessController::class, 'removeProduct'])->name('productProcess.remove');
Route::patch('/editProcessingProduct/{id}', [adminOnProcessController::class, 'editProcessingProduct'])->name('productProcess.edit');
Route::get('/updateTable', [adminOnProcessController::class, 'updateTable'])->name('updateTable');
Route::post('/updateMultiple',[adminOnProcessController::class, 'multipleUpdate'])->name('updateMultiple.status');
Route::post('/moveMultipleProcessing',[adminOnProcessController::class, 'moveMultiple'])->name('moveMutipleFrom.Processing');
// move a product
Route::post('/processMoveProduct/{id}', [adminOnProcessController::class, 'moveProduct'])->name('move.processProduct');
// sort a product
Route::get('/sortProcessingProduct', [adminOnProcessController::class, 'sortProduct']);
// change a product status 
Route::patch('/updateStatus/{id}', [adminOnProcessController::class, 'updateStatus'])->name('update.status');
// filter products in processign tab 
Route::get('/filterProcessingProducts', [adminOnProcessController::class, 'filterProcessing']);
Route::delete('/removeMultiple', [adminOnProcessController::class, 'removeMultiple'])->name('deleteFrom.Processing');
Route::get('/filterDateProcessing', [adminOnProcessController::class, 'filterDate']);
// for cancel or return tab
Route::get('/products/cancelReturn', [adminCancelReturnController::class, 'cancel_return'])->middleware('admin');
Route::post('/storeCancelReturn', [adminCancelReturnController::class, 'storeCancelReturn']);
Route::patch('/editCancelReturnProduct/{id}', [adminCancelReturnController::class, 'editCancelReturn'])->name('edit.cancelReturn');
Route::post('/moveCancelReturn/{id}', [adminCancelReturnController::class, 'moveProduct'])->name('move.cancelReturnProduct');
// filter products in cancel or return
Route::get('/filterCancelReturn', [adminCancelReturnController::class, 'filterCancelReturn']);
Route::delete('/removeReturnCancel/{id}', [adminCancelReturnController::class, 'removeProduct'])->name('cancelReturn.remove');
// sort products in cancel or return 
Route::get('/sortCancelReturnProduct', [adminCancelReturnController::class, 'sortProduct']);
Route::delete('/removeMultipleCancel', [adminCancelReturnController::class, 'removeMultiple'])->name('deleteFrom.cancel');
Route::post('/moveMultiple.cancel',[adminCancelReturnController::class, 'moveMultiple'])->name('moveMultipleFrom.cancel');
Route::get('/filterReturnedCancelDate', [adminCancelReturnController::class, 'filterDate']); 


// Route for accounts admin panel tab 
Route::get('/accounts/active', [accountsController::class, 'displayUsers'])->middleware('admin');
// search a suer 
Route::get('/searchUser', [accountsController::class, 'searchUsers']);
// sort user by name, email or id and if descend or ascend 
Route::get('/sortUsers', [accountsController::class, 'sortUsers']);
// block a user 
Route::patch('/userBlock/{id}', [accountsController::class, 'block'])->name('users.block');

// remove a user 
Route::delete('/users/{id}', [accountsController::class, 'destroy'])->name('users.destroy');
Route::patch('/userVerifyID/{id}',[accountsController::class,'verifyID'])->name('users.verifyID');

Route::get('/accounts/blocked', [blockedAccountsController::class, 'display'])->middleware('admin');
Route::get('/sortBlockUsers', [blockedAccountsController::class, 'sortBlockUsers']);
Route::patch('/unblock/{id}', [blockedAccountsController::class, 'unblock'])->name('users.unblock');
Route::get('/searchBlockedUsers', [blockedAccountsController::class, 'searchBlockedUsers']);

Route::get('/accounts/pending', [PendingAccountsController::class, 'displayUsers'])->middleware('admin');
Route::get('/sortPendingUsers',[PendingAccountsController::Class, 'sortPendingUsers']);
Route::get('/searchPendingUsers',[PendingAccountsController::Class, 'searchPendingUsers']);

// product details 
Route::get('/productDetails/{id}', [productsController::class, 'details']);
// user cart 
Route::post('/storeCart', [UserController::class, 'store'])
                                                    ->middleware('cart')
                                                    ->name('cart');
Route::get('/cart/{userId}', [UserController::class, 'cart']);
Route::delete('/removeCartItem/{productId}', [UserController::class, 'remove'])->name('remove.cart');
Route::delete('/removeAll',[UserController::class, 'removeAll'])->name('remove.All');
Route::post('/confirmCheckout',[UserController::class, 'confirmCheckout'])->name('confirmCheckout');
Auth::routes();

// for mypurchase controller 
Route::post('/submitCancel/{id}', [UserPurchaseController::class, 'submitToCancel'])->name('submitOrder.cancel');
Route::get('/userProfile/myPurchase/{userId}', [UserPurchaseController::class, 'toPay'])->name('myPurchase');
Route::get('userProfile/myPurchase//{status}',[UserPurchaseController::class, 'productStatus'])->name('product.status');
Route::post('/orderRecieved', [UserPurchaseController::class, 'orderRecieved'])->name('order.recieved');
Route::post('/submitReview', [UserPurchaseController::class, 'submitReview'])->name('submitReview');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/emailVerification', function(){
    return view('emails.verification');
});

// always checks the middleware :) 
Route::view('/adminforgotPassword', 'adminForgotPassword');
Route::post('admin/password/email', [AdminCustomizeForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [AdminCustomizeResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/admin/password/reset', [AdminCustomizeResetPasswordController::class, 'reset'])->name('password.update');

// verify Email 
Route::get('/emailVerified/{email}', function($email){
    $user = User::where('email', $email)->first();

    if($user) {
        $user->email_verified_at = now();
        $user->save();
    }

    return view('user.verified');
})->name('verified');

// view for email 
Route::view('/emailSent', 'user.emailSent');

// view for sending email when user did not verify on their first registration  
Route::get('verifyEmail2', function(){
    $userEmail = session('email');
    return view('user.verifyEmail2')->with('email', session('email'));
});
// email verification for users that doesnt verify their email on ther registration 
Route::post('/emailVerification2', function(Request $request){
    $userEmail = $request->email;
    
    Mail::to($userEmail)->send(new VerificationEmail($userEmail));

    return view('user.emailSent');
})->name('verifyAgain');
// route for user changing password 
Route::post('userChangePassword', [userProfileController::class, 'changePassword'])->name('userChange.Password');
// view for finding user 
Route::view('/findUser', 'user.findUser')->name('findUser');
Route::post('/searchedUser', [LoginSignupController::class, 'searchUser'])->name('submit.search');
// reset password 
Route::view('/userFound', 'user.foundUser')->name('foundUser');
Route::post('user/password/email', [UserCustomizeForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
Route::view('/userEmailSent', 'user.sentEmail')->name('userSent.Email');
Route::get('password/reset/{token}', [UserCustomizeResetPasswordController::class, 'showResetForm'])->name('userPassword.reset');
Route::post('password/reset', [UserCustomizeResetPasswordController::class, 'reset'])->name('userPassword.update');
Route::view('passwordResetEmail', 'emails.customPasswordReset');
// invoice mail 
Route::view('/invoice','mail.mailTemplate');
Route::view('/newOrder', 'mail.newOrderMade');

// user feedback 
Route::post('/userContact', [ContactUsController::class, 'sendToEmail'])->name('sendFeedback');
Route::view('/feedback', 'mail.newUserFeedback');

