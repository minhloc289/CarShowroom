<?php

use App\Http\Controllers\frontend\paymentcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\frontend\CustomerDashBoardController;
use App\Http\Controllers\frontend\CarController;
use App\Http\Controllers\frontend\BuyCarController;
use App\Http\Controllers\frontend\ForgetPasswordManager;
use App\Http\Controllers\frontend\CustomerAuthController;
use App\Http\Controllers\frontend\ProfileController;

use App\Http\Controllers\frontend\RentCarController;

use App\Http\Controllers\frontend\CartController;



/* BACKEND ROUTES */
Route::prefix('admin')->middleware(AuthenticateMiddleware::class)->group(function () {

    /* AUTHENTICATION */
    Route::get('/', [AuthController::class, 'index'])->name('auth.admin')->withoutMiddleware([AuthenticateMiddleware::class])->middleware(LoginMiddleware::class);
    Route::post('login', [AuthController::class, 'login'])->name('auth.login')->withoutMiddleware([AuthenticateMiddleware::class])->middleware(LoginMiddleware::class);
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    /* DASHBOARD */
    Route::get('/dashboard', [DashboardController::class, 'loadDashboard'])->name('dashboard');

    /* USERS */
    Route::get('/user', [AdminController::class, 'loadUserPage'])->name('user'); // Load user page

    /* USER CRUD */
    Route::get('/user/create', [AdminController::class, 'loadUserCreatePage'])->name('user.create');
    Route::post('/user/create', [AdminController::class, 'createUser'])->name('user.store'); // Unique name for POST
    Route::get('/user/edit/{id}', [AdminController::class, 'loadUserEditPage'])->name('user.edit');
    Route::post('/user/edit/{id}', [AdminController::class, 'editUser'])->name('user.update'); // Unique name for POST
    Route::delete('/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('user.delete'); // Use DELETE method;
    Route::get('user/details/{id}', [AdminController::class, 'loadUserDetails'])->name('user.details');

});


/* FRONTEND ROUTES */

Route::get('/', [CustomerDashBoardController::class, 'index'])->name('CustomerDashBoard.index');
Route::get('/compare', [CustomerDashBoardController::class, 'compare'])->name('CustomerDashBoard.compare');
// Booking form
Route::get('/booking-form', [CustomerDashBoardController::class, 'Bookingform'])->name('CustomerDashBoard.bookingform');
// Cars
Route::get('/cars', [CarController::class, 'index'])->name('CarController.index');
//details car
Route::get('/cars/{car_id}', [CarController::class, 'show'])->name('cars.details');

Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login');

    // Route đăng ký
    Route::get('/sign_up', [CustomerAuthController::class, 'showSignUpForm'])->name('customer.sign_up');
    Route::post('/sign_up', [CustomerAuthController::class, 'signUp'])->name('sign_up');
});

//Route forgot

Route::prefix('password')->group(function () {
    Route::get('/forget', [ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
    Route::post('/forget', [ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');
    Route::get('/reset/{token}', [ForgetPasswordManager::class, 'resetPassword'])->name('reset.password');
    Route::post('/reset/{token}', [ForgetPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');
});

// Route view profile
Route::get('/view-profile', [ProfileController::class, 'viewprofile'])->name('view.profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
// Rout view reset password
Route::get('/view-profile/resetpass', [ProfileController::class, 'showResetPass'])->name('view.resetpass');
// Xử lý yêu cầu đổi mật khẩu
Route::post('/view-profile/resetpass', [CustomerAuthController::class, 'resetPassword'])->name('reset.password.submit');


// Route logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('CustomerDashBoard.index');
    })->name('logout');
});


Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('account.logout');



// Introduce 
Route::get('/introduce', [CustomerDashBoardController::class, 'introduce'])->name('CustomerDashBoard.introduce');
// Registration 
Route::get('/registration', [CustomerDashBoardController::class, 'registration'])->name('CustomerDashBoard.registration');
//Route accessories
Route::get('/accessories', [CustomerDashBoardController::class, 'accessories'])->name('CustomerDashBoard.accsessories');
Route::get('/api/accessories', [CustomerDashBoardController::class, 'getAccessories'])->name('api.accessories');
Route::get('/api/accessories/sorted', [CustomerDashBoardController::class, 'getSortedAccessories']);
Route::get('/accessory/{id}', [CustomerDashBoardController::class, 'showAccessory'])->name('accessory.show');

Route::middleware(['auth:account'])->group(function () {
    Route::get('/accessories/cart', [CustomerDashBoardController::class, 'showCart'])->name('show.cart');
});
Route::post('/cart/add', [CartController::class, 'addToCart'])
    ->name('cart.add') // Giữ tên route
    ->middleware('auth:account'); // Thêm middleware 'auth:account'


// Kiểm tra trạng thái đăng nhập
Route::get('/api/check-login', function () {
    return response()->json(['logged_in' => Auth::check()]);
});

Route::get('/check-login-status', function () {
    if (Auth::check()) {
        return response()->json(['loggedIn' => true]);
    }
    return response()->json(['loggedIn' => false]);
});
// cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/update/quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
Route::get('/cart/total-price', [CartController::class, 'getTotalPrice'])->name('cart.total.price');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/cart/items', [CartController::class, 'getCartItems'])->name('cart.items');



//Car rent
Route::get('/car-rent', [RentCarController::class, 'carRent'])->name('rent.car');
Route::get('/api/cars/{id}', [RentCarController::class, 'show']);
Route::get('/car-rent/{id}', [RentCarController::class, 'showRentForm'])->name('rent.form');
//Car buy
Route::get('/car/{id}/buy', [BuyCarController::class, 'showBuyForm'])->name('car.buy');
Route::post('/vnpay_payment', [paymentcontroller::class, 'vnpay_payment']);



// Trang chủ
Route::get('/home', function () {    
    return view('home');
})->name('home');


