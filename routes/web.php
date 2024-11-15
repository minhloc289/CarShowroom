<?php

use App\Http\Controllers\frontend\ForgotPassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\frontend\CustomerDashBoardController;
use App\Http\Controllers\frontend\ForgetPasswordManager;
use App\Http\Controllers\frontend\CustomerAuthController;




/* BACKEND ROUTES */

/* AUTHENTICATION */


Route::get('/', [CustomerDashBoardController::class, 'index'])->name('CustomerDashBoard.index');


Route::prefix('admin')->middleware(AuthenticateMiddleware::class)->group(function () {

    /* AUTHENTICATION */
    Route::get('/', [AuthController::class, 'index'])->name('auth.admin')->withoutMiddleware([AuthenticateMiddleware::class])->middleware(LoginMiddleware::class);
    Route::post('login', [AuthController::class, 'login'])->name('auth.login')->withoutMiddleware([AuthenticateMiddleware::class]);
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    /* DASHBOARD */
    Route::get('/dashboard', [DashboardController::class, 'loadDashboard'])->name('dashboard');

    /* USERS */
    Route::get('/user', [AdminController::class, 'loadUserPage'])->name('user'); // Load user page
    Route::get('/user/account', [AdminController::class, 'loadUserAccountPage'])->name('user.account');

    /* USER CRUD */
    Route::get('/user/create', [AdminController::class, 'loadUserCreatePage'])->name('user.create');
    Route::post('/user/create', [AdminController::class, 'createUser'])->name('user.store'); // Unique name for POST
    Route::get('/user/edit/{id}', [AdminController::class, 'loadUserEditPage'])->name('user.edit');
    Route::post('/user/edit/{id}', [AdminController::class, 'editUser'])->name('user.update'); // Unique name for POST
    Route::delete('/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('user.delete'); // Use DELETE method;
    Route::get('user/details/{id}', [AdminController::class, 'loadUserDetails'])->name('user.details');

});

// Route đăng nhập
Route::get('/customer/login', [CustomerDashBoardController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerDashBoardController::class, 'login'])->name('login');

// Route đăng ký
Route::get('/customer/sign_up', [CustomerDashBoardController::class, 'showSignUpForm'])->name('customer.sign_up');
Route::post('/customer/sign_up', [CustomerDashBoardController::class, 'signUp'])->name('sign_up');
//Route forgot

Route::get('/forget-password', [ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password', [ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgetPasswordManager::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password/{token}', [ForgetPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');


// Trang chủ
Route::get('/home', function () {    
    return view('home');
})->name('home');



