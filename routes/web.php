<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\fontend\CustomerDashBoardController;


/* BACKEND ROUTES */

/* AUTHENTICATION */



Route::prefix('admin')->middleware(AuthenticateMiddleware::class)->group(function () {

    /* AUTHENTICATION */
    Route::get('/', [AuthController::class, 'index'])->name('auth.admin')->withoutMiddleware([AuthenticateMiddleware::class])->middleware(LoginMiddleware::class);
    Route::post('login', [AuthController::class, 'login'])->name('auth.login')->withoutMiddleware([AuthenticateMiddleware::class]);
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    /* DASHBOARD */
    Route::get('/dashboard', [DashboardController::class, 'loadDashboard'])->name('dashboard');

    /* USERS */
    Route::get('/user', [AdminController::class, 'loadUserPage'])->name('user');
    Route::get('/user/account', [AdminController::class, 'loadUserAccountPage'])->name('user.account');

});


/* FRONTEND ROUTES */
Route::get('/', [CustomerDashBoardController::class, 'index'])->name('CustomerDashBoard.index');
