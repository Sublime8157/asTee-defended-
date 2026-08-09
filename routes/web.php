<?php

use App\Http\Controllers\Auth\AdminCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\AdminCustomizeResetPasswordController;
use App\Http\Controllers\Auth\UserCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\UserCustomizeResetPasswordController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginSignupController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PendingAccountsController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPurchaseController;
use App\Http\Controllers\accountsController;
use App\Http\Controllers\adminCancelReturnController;
use App\Http\Controllers\adminIndexController;
use App\Http\Controllers\adminOnHandsController;
use App\Http\Controllers\adminOnProcessController;
use App\Http\Controllers\blockedAccountsController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\userProfileController;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes are grouped by who is allowed to reach them. Before this rewrite the
| file was a flat list in which `middleware('admin')` was attached to eight GET
| display pages only — every admin write (create/edit/delete product, block or
| delete a customer, approve an ID, delete payment records) was reachable by an
| anonymous visitor who knew the URI.
|
| URIs and route names are deliberately unchanged: Blade `route()` helpers and
| the hand-written jQuery in public/js/ hardcode both.
|
*/

// ---------------------------------------------------------------------------
// Public — storefront browsing and the login/registration entry points
// ---------------------------------------------------------------------------

Route::get('/', [LoginSignupController::class, 'LoginSignup'])->name('userLogin');

Route::post('/login/process', [LoginSignupController::class, 'process'])
    ->name('loginProcess')
    ->middleware('throttle:5,1');

Route::post('/store', [LoginSignupController::class, 'store'])
    ->middleware('throttle:5,1');

Route::post('/logout', [LoginSignupController::class, 'logout'])->name('logout');

Route::get('/about-us', [UserController::class, 'about_us']);
Route::get('/Product', [productsController::class, 'displayOnHandsProducts']);
Route::get('/filterProducts', [productsController::class, 'filterProducts']);
Route::get('/productDetails/{id}', [productsController::class, 'details']);
Route::get('/DIY', [UserController::class, 'DIY']);
Route::view('/contact-us', 'user.contact_us');
Route::view('/licensing', 'user.licensing')->name('licensing');

Route::post('/userContact', [ContactUsController::class, 'sendToEmail'])
    ->name('sendFeedback')
    ->middleware('throttle:5,1');

// ---------------------------------------------------------------------------
// Public — email verification and password reset
//
// /emailVerified/{email} previously had no signature, token or throttle: any
// visitor could mark any customer's email verified by typing the address into
// the URL. It is now a signed, expiring link that only the mail recipient holds.
// ---------------------------------------------------------------------------

Route::get('/emailVerified/{email}', function ($email) {
    $user = User::where('email', $email)->first();

    if ($user) {
        $user->email_verified_at = now();
        $user->save();
    }

    return view('user.verified');
})->name('verified')->middleware('signed');

Route::view('/emailSent', 'user.emailSent');

Route::get('verifyEmail2', function () {
    return view('user.verifyEmail2')->with('email', session('email'));
});

Route::post('/emailVerification2', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email', 'exists:customers,email'],
    ]);

    Mail::to($validated['email'])->send(new VerificationEmail($validated['email']));

    return view('user.emailSent');
})->name('verifyAgain')->middleware('throttle:3,1');

Route::view('/findUser', 'user.findUser')->name('findUser');
Route::post('/searchedUser', [LoginSignupController::class, 'searchUser'])
    ->name('submit.search')
    ->middleware('throttle:5,1');
Route::view('/userFound', 'user.foundUser')->name('foundUser');

Route::post('user/password/email', [UserCustomizeForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('user.password.email')
    ->middleware('throttle:5,1');
Route::view('/userEmailSent', 'user.sentEmail')->name('userSent.Email');
Route::get('password/reset/{token}', [UserCustomizeResetPasswordController::class, 'showResetForm'])
    ->name('userPassword.reset');
Route::post('password/reset', [UserCustomizeResetPasswordController::class, 'reset'])
    ->name('userPassword.update')
    ->middleware('throttle:5,1');

// ---------------------------------------------------------------------------
// Authenticated customers
// ---------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/userProfile/myAccount', [UserController::class, 'userProfile']);
    Route::get('/userProfile/myPassword', [UserController::class, 'userPassword']);
    Route::post('/updateProfile', [userProfileController::class, 'updateUserInfo']);
    Route::post('/userProfileUpdate', [userProfileController::class, 'updateProfile'])->name('update.profile');
    Route::post('/uploadID', [userProfileController::class, 'uploadID'])->name('upload.validID');
    Route::post('userChangePassword', [userProfileController::class, 'changePassword'])->name('userChange.Password');

    // Cart and checkout
    Route::post('/storeCart', [UserController::class, 'store'])->name('cart');
    Route::get('/cart/{userId}', [UserController::class, 'cart']);
    Route::delete('/removeCartItem/{productId}', [UserController::class, 'remove'])->name('remove.cart');
    Route::delete('/removeAll', [UserController::class, 'removeAll'])->name('remove.All');
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout.process');
    Route::post('/confirmCheckout', [UserController::class, 'confirmCheckout'])->name('confirmCheckout');

    // Purchases
    Route::get('/userProfile/myPurchase/{userId}', [UserPurchaseController::class, 'toPay'])->name('myPurchase');
    Route::get('userProfile/myPurchase//{status}', [UserPurchaseController::class, 'productStatus'])->name('product.status');
    Route::post('/submitCancel/{id}', [UserPurchaseController::class, 'submitToCancel'])->name('submitOrder.cancel');
    Route::post('/orderRecieved', [UserPurchaseController::class, 'orderRecieved'])->name('order.recieved');
    Route::post('/submitReview', [UserPurchaseController::class, 'submitReview'])->name('submitReview');
});

// ---------------------------------------------------------------------------
// Admin — authentication
//
// Self-service admin registration (/regsiterAccount, /submitRegistration) and
// the unsigned /verifyAdmin/{email} route are removed. Together they allowed
// anyone to create an admin account and mark it verified in two unauthenticated
// requests. Admin accounts are now created with `php artisan astee:make-admin`.
// ---------------------------------------------------------------------------

Route::get('/loginAdmin', [adminIndexController::class, 'login'])->name('loginAdmin');
Route::post('/loggingIn', [adminIndexController::class, 'adminLogin'])
    ->middleware('throttle:5,1');

Route::view('/adminforgotPassword', 'adminForgotPassword');
Route::post('admin/password/email', [AdminCustomizeForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('admin.password.email')
    ->middleware('throttle:5,1');
Route::get('/admin/password/reset/{token}', [AdminCustomizeResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/admin/password/reset', [AdminCustomizeResetPasswordController::class, 'reset'])
    ->name('password.update')
    ->middleware('throttle:5,1');

// ---------------------------------------------------------------------------
// Admin — everything below requires an authenticated admin
// ---------------------------------------------------------------------------

Route::middleware('admin')->group(function () {
    Route::post('adminLogout', [adminIndexController::class, 'adminLogout']);
    Route::get('/managePassword', [adminIndexController::class, 'managePassword']);
    Route::post('/changePassword', [adminIndexController::class, 'changePassword'])->name('changeAdmin.password');

    // Dashboard
    Route::get('/dashboard', [dashboardController::class, 'dashboard']);
    Route::get('/filterSalesDate', [dashboardController::class, 'filterSales']);

    // Feedback
    Route::get('/products/feedbacks', [adminIndexController::class, 'feedbacks']);
    Route::patch('/featureReview/{id}', [adminIndexController::class, 'toFeature'])->name('featureReview');

    // Order history
    Route::get('/orders', [OrderHistoryController::class, 'showOrderList']);
    Route::get('/searchOrder', [OrderHistoryController::class, 'filterOrders']);
    Route::get('/sortOrders', [OrderHistoryController::class, 'sortOrders']);
    Route::get('/filterDate', [OrderHistoryController::class, 'filterDate']);

    // Payment history
    Route::get('/payments', [PaymentHistoryController::class, 'display']);
    Route::get('/refresh', [PaymentHistoryController::class, 'refresh']);
    Route::post('/paymentForm', [PaymentHistoryController::class, 'store'])->name('paymentForm');
    Route::get('/filterPayments', [PaymentHistoryController::class, 'sort']);
    Route::get('/filterPaymentsDate', [PaymentHistoryController::class, 'filterDate']);
    Route::get('/filterbyBank', [PaymentHistoryController::class, 'filterBanks']);
    Route::get('/filterPrice', [PaymentHistoryController::class, 'filterPrice']);
    Route::get('/searchIdPayments', [PaymentHistoryController::class, 'searchById']);
    Route::delete('/removePayments', [PaymentHistoryController::class, 'removePaymentsRecords'])->name('removePayments');
    Route::delete('/deleteRecordPayments', [PaymentHistoryController::class, 'removeRecord'])->name('deleteRecordPayments');
    Route::get('/ordersIdAmount', [PaymentHistoryController::class, 'ordersIdAmount']);

    // Sales
    Route::get('/sales', [SalesHistoryController::class, 'display'])->name('salesDisplay');

    // Products — on hand
    Route::get('/products/onHand', [adminOnHandsController::class, 'onHand']);
    Route::post('/addProducts', [adminOnHandsController::class, 'storeOnhand']);
    Route::delete('/removeProduct/{id}', [adminOnHandsController::class, 'removeProduct'])->name('product.remove');
    Route::get('/filterOnHandProducts', [adminOnHandsController::class, 'filterOnHandProducts']);
    Route::patch('/editProduct/{id}', [adminOnHandsController::class, 'editProduct'])->name('edit.Product');
    Route::post('/moveProduct/{id}', [adminOnHandsController::class, 'moveProduct'])->name('move.Product');
    Route::post('/moveMultipleOnHand', [adminOnHandsController::class, 'moveMultiple'])->name('moveMultipleFrom.onHand');
    Route::get('/sortProduct', [adminOnHandsController::class, 'sortProducts']);
    Route::delete('/deleteAll', [adminOnHandsController::class, 'removeAllProduct'])->name('deleteFrom.OnHand');

    // Products — processing
    Route::get('/products/proccessing', [adminOnProcessController::class, 'proccessing']);
    Route::post('/storeProcessing', [adminOnProcessController::class, 'storeProcessing']);
    Route::delete('/removeProcessing/{id}', [adminOnProcessController::class, 'removeProduct'])->name('productProcess.remove');
    Route::patch('/editProcessingProduct/{id}', [adminOnProcessController::class, 'editProcessingProduct'])->name('productProcess.edit');
    Route::post('/updateMultiple', [adminOnProcessController::class, 'multipleUpdate'])->name('updateMultiple.status');
    Route::post('/moveMultipleProcessing', [adminOnProcessController::class, 'moveMultiple'])->name('moveMutipleFrom.Processing');
    Route::post('/processMoveProduct/{id}', [adminOnProcessController::class, 'moveProduct'])->name('move.processProduct');
    Route::get('/sortProcessingProduct', [adminOnProcessController::class, 'sortProduct']);
    Route::patch('/updateStatus/{id}', [adminOnProcessController::class, 'updateStatus'])->name('update.status');
    Route::get('/filterProcessingProducts', [adminOnProcessController::class, 'filterProcessing']);
    Route::delete('/removeMultiple', [adminOnProcessController::class, 'removeMultiple'])->name('deleteFrom.Processing');
    Route::get('/filterDateProcessing', [adminOnProcessController::class, 'filterDate']);

    // Products — cancel / return
    Route::get('/products/cancelReturn', [adminCancelReturnController::class, 'cancel_return']);
    Route::post('/storeCancelReturn', [adminCancelReturnController::class, 'storeCancelReturn']);
    Route::patch('/editCancelReturnProduct/{id}', [adminCancelReturnController::class, 'editCancelReturn'])->name('edit.cancelReturn');
    Route::post('/moveCancelReturn/{id}', [adminCancelReturnController::class, 'moveProduct'])->name('move.cancelReturnProduct');
    Route::get('/filterCancelReturn', [adminCancelReturnController::class, 'filterCancelReturn']);
    Route::delete('/removeReturnCancel/{id}', [adminCancelReturnController::class, 'removeProduct'])->name('cancelReturn.remove');
    Route::get('/sortCancelReturnProduct', [adminCancelReturnController::class, 'sortProduct']);
    Route::delete('/removeMultipleCancel', [adminCancelReturnController::class, 'removeMultiple'])->name('deleteFrom.cancel');
    Route::post('/moveMultiple.cancel', [adminCancelReturnController::class, 'moveMultiple'])->name('moveMultipleFrom.cancel');
    Route::get('/filterReturnedCancelDate', [adminCancelReturnController::class, 'filterDate']);

    // Accounts — active
    Route::get('/accounts/active', [accountsController::class, 'displayUsers']);
    Route::get('/searchUser', [accountsController::class, 'searchUsers']);
    Route::get('/sortUsers', [accountsController::class, 'sortUsers']);
    Route::patch('/userBlock/{id}', [accountsController::class, 'block'])->name('users.block');
    Route::delete('/users/{id}', [accountsController::class, 'destroy'])->name('users.destroy');
    Route::patch('/userVerifyID/{id}', [accountsController::class, 'verifyID'])->name('users.verifyID');

    // Accounts — blocked
    Route::get('/accounts/blocked', [blockedAccountsController::class, 'display']);
    Route::get('/sortBlockUsers', [blockedAccountsController::class, 'sortBlockUsers']);
    Route::patch('/unblock/{id}', [blockedAccountsController::class, 'unblock'])->name('users.unblock');
    Route::get('/searchBlockedUsers', [blockedAccountsController::class, 'searchBlockedUsers']);

    // Accounts — pending
    Route::get('/accounts/pending', [PendingAccountsController::class, 'displayUsers']);
    Route::get('/sortPendingUsers', [PendingAccountsController::class, 'sortPendingUsers']);
    Route::get('/searchPendingUsers', [PendingAccountsController::class, 'searchPendingUsers']);
});

// ---------------------------------------------------------------------------
// Local-only mail template previews
//
// These render raw mail templates and were publicly reachable in production
// with no middleware.
// ---------------------------------------------------------------------------

if (app()->environment(['local', 'development'])) {
    Route::view('/emailVerification', 'emails.verification');
    Route::view('/passwordResetEmail', 'emails.customPasswordReset');
    Route::view('/invoice', 'mail.mailTemplate');
    Route::view('/newOrder', 'mail.newOrderMade');
    Route::view('/feedback', 'mail.newUserFeedback');
}
