<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
class CustomerDashBoardController extends Controller
{
    public function index(){
        return view("frontend.home.home");
    }
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Debug thông tin trước khi xác thực
        if (!Account::where('email', $credentials['email'])->exists()) {
            toastr()->error("Email không tồn tại trong cơ sở dữ liệu");
            return redirect()->route('customer.login');
        }

        // Kiểm tra Auth::attempt
        if (Auth::attempt($credentials)) {
            toastr()->success("Đăng nhập thành công");
            return redirect()->route('CustomerDashBoard.index');
        }

        toastr()->error("Tài khoản hoặc mật khẩu không đúng");
        return redirect()->route('customer.login');
    }


    /**
     * Xử lý đăng ký.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request){
        // Xác thực dữ liệu đầu vào, đảm bảo email là duy nhất trong bảng accounts
        $request->validate([
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:6|confirmed',
        ]);
    
        // Lưu thông tin người dùng vào bảng accounts
        Account::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Chuyển hướng với thông báo thành công
        toastr()->success("Đăng kí tài khoản thành công");
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
}
