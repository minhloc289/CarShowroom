<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;



class CustomerAuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('frontend.login_sign.customer_login');
    }

    /**
     * Hiển thị form đăng ký.
     *
     * @return \Illuminate\View\View
     */
    public function showSignUpForm()
    {
        return view('frontend.login_sign.customer_signup');
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
    
        // Thử đăng nhập với guard 'account'
        if (Auth::guard('account')->attempt($credentials)) {
            // Nếu đăng nhập thành công, lấy thông tin người dùng và chuyển hướng
            $user = Auth::guard('account')->user();
            session(['login_account' => $user]);
            toastr()->success("Đăng nhập thành công");
    
            return redirect()->route('CustomerDashBoard.index');
        }
    
        // Nếu đăng nhập thất bại, chuyển hướng về trang đăng nhập với thông báo lỗi
        toastr()->error("Tài khoản hoặc mật khẩu không đúng");
        return redirect()->back()->withInput();
    }
    


    /**
     * Xử lý đăng ký.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request)
    {
        // Xác thực dữ liệu đầu vào, đảm bảo các trường được nhập đúng và email là duy nhất
        $request->validate([
            'name' => 'required|string|max:255', // Họ tên bắt buộc
            'address' => 'required|string|max:255', // Địa chỉ bắt buộc
            'phone' => 'required|string|max:15|unique:accounts,phone', // Số điện thoại phải là duy nhất
            'email' => 'required|email|unique:accounts,email', // Email phải là duy nhất
            'password' => 'required|min:6|confirmed', // Mật khẩu xác nhận
        ]);
    
        // Lưu thông tin người dùng vào bảng accounts
        Account::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);
    
        // Chuyển hướng với thông báo thành công
        toastr()->success("Đăng ký tài khoản thành công");
        return redirect()->route('CustomerDashBoard.index');
    }
    
    
    //From forgot pass
    public function showForgotForm(){
        return view("frontend.login_sign.forgot_pass");
    }
    public function Forgot(Request $request)
{
    // Validate email input
    $request->validate([
        'email' => 'required|email|exists:accounts,email',
    ]);

    // Gửi email reset mật khẩu
    $status = Password::sendResetLink(
        $request->only('email')
    );

    // Kiểm tra và thông báo theo kết quả gửi email
    if ($status === Password::RESET_LINK_SENT) {
        toastr()->success(__($status));
    } else {
        toastr()->error(__($status));
    }

    return redirect()->route('Forgotpass.showForgotfrom');
}
public function logout(Request $request)
{
        
    Auth::guard('account')->logout();
    $request->session()->invalidate(); // Làm mất hiệu lực của phiên làm việc
    $request->session()->regenerateToken(); // Tạo lại token CSRF

    return redirect()->route('CustomerDashBoard.index');
}public function resetPassword(Request $request)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
        'old_password' => 'required', // Mật khẩu cũ là bắt buộc
        'password' => 'required|string|min:6|confirmed', // Mật khẩu mới phải trùng khớp với password_confirmation
        'password_confirmation' => 'required', // Trường xác nhận mật khẩu không được để trống
    ]);

    // Lấy thông tin người dùng đang đăng nhập
    $user = Auth::guard('account')->user();

    // Kiểm tra mật khẩu cũ
    if ($request->password !== $request->password_confirmation) {
        toastr()->error('Mật khẩu cũ mới và mật khẩu xác minh không trùng khớp');
        return redirect()->back(); // Quay lại trang đổi mật khẩu
    }
    if (!Hash::check($request->old_password, $user->password)) {
        toastr()->error('Mật khẩu cũ không chính xác');
        return redirect()->back(); // Quay lại trang đổi mật khẩu
    }


    // Cập nhật mật khẩu mới
    $user->password = Hash::make($request->password);
    $user->save();

    // Thông báo thành công
    toastr()->success('Mật khẩu đã được thay đổi thành công');
    return redirect()->route('view.resetpass'); // Chuyển hướng sau khi đổi mật khẩu
}
}

