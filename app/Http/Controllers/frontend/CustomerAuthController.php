<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('customer_login');
    }

    /**
     * Hiển thị form đăng ký.
     *
     * @return \Illuminate\View\View
     */
    public function showSignUpForm()
    {
        return view('customer_signup');
    }

    /**
     * Xử lý đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Thử đăng nhập
        if (Auth::attempt($credentials)) {
            // Nếu đăng nhập thành công, chuyển hướng về trang chủ với thông báo thành công
            return redirect()->route('CustomerDashBoardController.index')->with('success', 'Đăng nhập thành công!');
        }

        // Nếu đăng nhập thất bại, chuyển hướng về trang đăng nhập với thông báo lỗi
        return redirect()->route('CustomerDashBoardController.index')->with('error', 'Đăng nhập không thành công!');
    }

    /**
     * Xử lý đăng ký.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email|unique:accounts,email', // Đảm bảo tên bảng là "accounts"
            'password' => 'required|min:6|confirmed',
        ]);

        // Lưu thông tin vào bảng account
        Account::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Chuyển hướng hoặc trả về thông báo thành công
        return redirect()->route('CustomerDashBoardController.index')->with('success', 'Tài khoản tạo thành công');
    }
}
