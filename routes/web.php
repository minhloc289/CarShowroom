<?php

use App\Http\Controllers\frontend\paymentcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\carSalesController;
use App\Http\Controllers\Backend\AccessoryController;

use App\Http\Controllers\frontend\CustomerDashBoardController;
use App\Http\Controllers\frontend\CarController;
use App\Http\Controllers\frontend\BuyCarController;
use App\Http\Controllers\frontend\ForgetPasswordManager;
use App\Http\Controllers\frontend\CustomerAuthController;
use App\Http\Controllers\frontend\ProfileController;
use App\Http\Controllers\frontend\RentCarController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\TransactionController;
use App\Models\Account;
use App\Http\Controllers\frontend\RentalPaymentController;
use App\Http\Controllers\Backend\CustomerController;



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
    // //////////////////////////////////////////////////////////////// Back end
    //Carsales
    Route::get('/carsales', [carSalesController::class, 'loadCarsales'])->name('Carsales');
    //cardetails back end
    Route::get('car/{carId}/details', [carSalesController::class, 'show_details_Car'])->name('show.car.details');
    //edit car
    Route::get('car/{carId}/edit', [carSalesController::class, 'show_edit_car'])->name('show.car.edit');
    Route::put('car/{carId}/update', [carSalesController::class, 'update_car_edit'])->name('car.update');
    Route::post('car/{carId}/destroy', [carSalesController::class, 'destroy'])->name('sales.cars.destroy');
    Route::get('/cars/create', [carSalesController::class, 'create'])->name('car.create');
    Route::post('/cars/store', [carSalesController::class, 'store'])->name('car.store');
    Route::get('/cars/upload', [carSalesController::class, 'showUploadForm'])->name('cars.upload');
    Route::post('/cars/import', [carSalesController::class, 'import'])->name('cars.import');
    Route::get('/download/car-add-template', [carSalesController::class, 'downloadTemplate'])->name('caradd.download.template');



    /* USER CRUD */
    Route::get('/user/create', [AdminController::class, 'loadUserCreatePage'])->name('user.create');
    Route::post('/user/create', [AdminController::class, 'createUser'])->name('user.store'); // Unique name for POST
    Route::get('/user/edit/{id}', [AdminController::class, 'loadUserEditPage'])->name('user.edit');
    Route::post('/user/edit/{id}', [AdminController::class, 'editUser'])->name('user.update'); // Unique name for POST
    Route::delete('/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('user.delete'); // Use DELETE method;
    Route::get('user/details/{id}', [AdminController::class, 'loadUserDetails'])->name('user.details');
    Route::get('user/record/create', [AdminController::class, 'loadExcel'])->name('user.record.create');
    Route::post('/users/import', [AdminController::class, 'importExcel'])->name('users.import');
    Route::get('/download/user-template', [AdminController::class, 'downloadTemplate'])->name('user.download.template');


    /*CUSTOMER CRUD*/
    Route::get('/customer', [CustomerController::class, 'loadCustomerPage'])->name('customer');
    Route::get('/customer/create', [CustomerController::class, 'loadCustomerCreatePage'])->name('customer.create');
    Route::post('/customer/create', [CustomerController::class, 'createCustomer'])->name('customer.store');
    Route::get('/customer/edit/{customerId}', [CustomerController::class, 'loadEditPage'])->name('customer.edit');
    Route::put('/customer/update/{customerId}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{customerId}', [CustomerController::class, 'delete'])->name('customer.destroy');


});

// Accessories Backend
Route::prefix('admin/accessories')->group(function () {
    Route::get('/', [AccessoryController::class, 'index'])->name('accessories.index');
    Route::get('/create', [AccessoryController::class, 'create'])->name('accessories.create');
    Route::post('/store', [AccessoryController::class, 'store'])->name('accessories.store');
    Route::get('/edit/{id}', [AccessoryController::class, 'edit'])->name('accessories.edit');
    Route::post('/update/{id}', [AccessoryController::class, 'update'])->name('accessories.update');
    Route::post('/{id}/destroy', [AccessoryController::class, 'destroy'])->name('accessories.destroy');
    Route::get('details/{id}', [AccessoryController::class, 'showDetails'])->name('accessories.details');
    Route::get('/upload', [AccessoryController::class, 'showUploadForm'])->name('accessories.upload');
    Route::post('/import', [AccessoryController::class, 'import'])->name('accessories.import');
    Route::get('/template', [AccessoryController::class, 'downloadTemplate'])->name('accessories.template');
    Route::post('/bulk-delete', [AccessoryController::class, 'bulkDelete'])->name('accessories.bulkDelete');
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
//transactionHistory
Route::get('/transaction-history', [TransactionController::class, 'index'])->name('transaction.history');
Route::get('/transactionHistory/{orderId}', [TransactionController::class, 'orderDetails'])->name('transactionHistory.details');


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

Route::get('/accessories/cart', [CustomerDashBoardController::class, 'showCart'])->name('show.cart');

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
Route::post('/car-rent/{id}', [RentCarController::class, 'rentCar'])->name('rent.submit');
Route::get('/rental/payment/vnpay', [RentalPaymentController::class, 'vnpay_payment'])->name('rental.payment.vnpay');
Route::get('/rental/payment/vnpay-return', [RentalPaymentController::class, 'vnpay_return'])->name('rental.payment.vnpay_return');

//Car buy
Route::get('/car/{id}/buy', [BuyCarController::class, 'showBuyForm'])->name('car.buy');
Route::post('/vnpay_payment', [paymentcontroller::class, 'vnpay_payment']);
//payment route
Route::get('/payment/vnpay-return', [PaymentController::class, 'vnpay_return']);

//Terms
Route::get('/terms', [CustomerDashBoardController::class, 'terms'])->name('CustomerDashBoard.terms');

// Trang chủ
Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/verify-email/{token}', function ($token) {
    $account = Account::where('email_verification_token', $token)->first();

    if (!$account) {
        toastr()->error('Liên kết xác thực không hợp lệ hoặc đã hết hạn.');
        return redirect()->route('sign_up');
    }

    $account->update([
        'is_verified' => 1,
        'email_verification_token' => null,
    ]);

    toastr()->success('Xác thực tài khoản thành công! Bạn có thể đăng nhập.');
    return redirect()->route('CustomerDashBoard.index');
})->name('verify.email');
