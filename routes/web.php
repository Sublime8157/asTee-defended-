<?php

use App\Http\Controllers\accountsController;
use App\Http\Controllers\AdminFileController;
use App\Http\Controllers\adminIndexController;
use App\Http\Controllers\AdminOrderItemController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\Auth\AdminCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\AdminCustomizeResetPasswordController;
use App\Http\Controllers\Auth\UserCustomizeForgotPasswordController;
use App\Http\Controllers\Auth\UserCustomizeResetPasswordController;
use App\Http\Controllers\blockedAccountsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginSignupController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PendingAccountsController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\userProfileController;
use App\Http\Controllers\UserPurchaseController;
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
| Routes are grouped by who is allowed to reach them. Before the Phase 2a
| rewrite the file was a flat list in which `middleware('admin')` was attached
| to eight GET display pages only — every admin write was reachable by an
| anonymous visitor who knew the URI.
|
| Phase 3 removes the customer id from customer-facing URIs. /cart/{userId} and
| /userProfile/myPurchase/{userId} took whatever id was typed, so one customer
| could read another's cart and purchase history by editing the address bar.
| The owner is the signed-in user or there is no owner.
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
    Route::get('/cart', [UserController::class, 'cart'])->name('cart.show');
    Route::delete('/removeCartItem/{cartItem}', [UserController::class, 'remove'])->name('remove.cart');
    Route::delete('/removeAll', [UserController::class, 'removeAll'])->name('remove.All');
    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout.process');
    Route::post('/confirmCheckout', [UserController::class, 'confirmCheckout'])->name('confirmCheckout');

    // Purchases
    Route::get('/userProfile/myPurchase', [UserPurchaseController::class, 'index'])->name('myPurchase');
    Route::post('/submitCancel/{id}', [UserPurchaseController::class, 'submitToCancel'])->name('submitOrder.cancel');
    Route::post('/orderRecieved', [UserPurchaseController::class, 'orderReceived'])->name('order.recieved');
    Route::post('/submitReview', [UserPurchaseController::class, 'submitReview'])->name('submitReview');
});

// ---------------------------------------------------------------------------
// Admin — authentication
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

    // Reviews
    Route::get('/products/feedbacks', [adminIndexController::class, 'feedbacks']);
    Route::patch('/featureReview/{id}', [adminIndexController::class, 'toFeature'])->name('featureReview');

    // Private files — government IDs and bank transfer proofs. The id is a
    // record id, not a path, so there is nothing to traverse.
    Route::get('/admin/files/valid-id/{user}', [AdminFileController::class, 'validId'])->name('admin.file.validId');
    Route::get('/admin/files/payment-proof/{payment}', [AdminFileController::class, 'paymentProof'])->name('admin.file.paymentProof');

    // Order history
    Route::get('/orders', [OrderHistoryController::class, 'showOrderList']);
    Route::get('/searchOrder', [OrderHistoryController::class, 'filterOrders']);
    Route::get('/sortOrders', [OrderHistoryController::class, 'sortOrders']);
    Route::get('/filterDate', [OrderHistoryController::class, 'filterDate']);

    // Payments
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

    // Catalog
    Route::get('/products/onHand', [AdminProductController::class, 'index']);
    Route::post('/addProducts', [AdminProductController::class, 'store']);
    Route::patch('/editProduct/{id}', [AdminProductController::class, 'update'])->name('edit.Product');
    Route::delete('/removeProduct/{id}', [AdminProductController::class, 'destroy'])->name('product.remove');
    Route::delete('/deleteAll', [AdminProductController::class, 'destroyMany'])->name('deleteFrom.OnHand');
    Route::post('/moveProduct/{id}', [AdminProductController::class, 'sell'])->name('move.Product');
    Route::get('/filterOnHandProducts', [AdminProductController::class, 'filter']);
    Route::get('/sortProduct', [AdminProductController::class, 'sort']);

    // Order lines — the Processing and Cancel/Return tabs are one query with a
    // different status filter, not two tables.
    Route::get('/products/proccessing', [AdminOrderItemController::class, 'processing']);
    Route::get('/products/cancelReturn', [AdminOrderItemController::class, 'cancelReturn']);
    Route::patch('/updateStatus/{id}', [AdminOrderItemController::class, 'updateStatus'])->name('update.status');
    Route::post('/updateMultiple', [AdminOrderItemController::class, 'updateStatusMany'])->name('updateMultiple.status');
    Route::delete('/removeProcessing/{id}', [AdminOrderItemController::class, 'destroy'])->name('productProcess.remove');
    Route::delete('/removeMultiple', [AdminOrderItemController::class, 'destroyMany'])->name('deleteFrom.Processing');
    Route::get('/filterProcessingProducts', [AdminOrderItemController::class, 'filter']);
    Route::get('/sortProcessingProduct', [AdminOrderItemController::class, 'sort']);
    Route::get('/filterDateProcessing', [AdminOrderItemController::class, 'filterDate']);

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
// ---------------------------------------------------------------------------

if (app()->environment(['local', 'development'])) {
    Route::view('/emailVerification', 'emails.verification');
    Route::view('/passwordResetEmail', 'emails.customPasswordReset');
    Route::view('/invoice', 'mail.mailTemplate');
    Route::view('/newOrder', 'mail.newOrderMade');
    Route::view('/feedback', 'mail.newUserFeedback');
}
