<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Log;

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
     
         // Kiểm tra thông tin tài khoản
         $user = Account::where('email', $credentials['email'])->first();
     
         if (!$user) {
             toastr()->error("Email không tồn tại.");
             return redirect()->back()->withInput();
         }
     
         // Kiểm tra trạng thái xác minh email
         if (!$user->is_verified) {
             toastr()->warning("Tài khoản của bạn chưa được xác minh. Vui lòng kiểm tra email để xác minh tài khoản.");
             return redirect()->back()->withInput();
         }
     
         // Thử đăng nhập với guard 'account'
         if (Auth::guard('account')->attempt($credentials)) {
             // Lấy thông tin người dùng và lưu vào session
             $user = Auth::guard('account')->user();
             session(['login_account' => $user]);
     
             toastr()->success("Đăng nhập thành công");
     
             // Kiểm tra xem có URL được lưu trong session không
             $redirectUrl = session('redirect_after_login', route('CustomerDashBoard.index'));
             session()->forget('redirect_after_login'); // Xóa URL sau khi sử dụng
     
             // Chuyển hướng đến URL được lưu hoặc về trang chủ
             return redirect($redirectUrl);
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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:15|unique:accounts,phone',
                'email' => 'required|email|unique:accounts,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $account = Account::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_verified' => 0,
                'email_verification_token' => Str::random(32),
            ]);

            // Gửi email xác minh
            Mail::send('emails.verify_email', ['token' => $account->email_verification_token], function ($message) use ($request) {
                $message->to($request->email)->subject('Xác thực tài khoản của bạn');
            });

            toastr()->success('Đăng ký thành công. Vui lòng kiểm tra email để xác nhận tài khoản!');
            return redirect()->route('CustomerDashBoard.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            toastr()->error('Đã xảy ra lỗi. Vui lòng thử lại.');
            return back()->withInput();
        }
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
}
// public function resetPassword(Request $request)
// {
//     // Xác thực dữ liệu nhập vào
//     $request->validate([
//         'old_password' => 'required', // Mật khẩu cũ là bắt buộc
//         'password' => 'required|string|min:6|confirmed', // Mật khẩu mới phải trùng khớp với password_confirmation
//         'password_confirmation' => 'required', // Trường xác nhận mật khẩu không được để trống
//     ]);

//     // Lấy thông tin người dùng đang đăng nhập
//     $user = Auth::guard('account')->user();

//     // Kiểm tra mật khẩu cũ
//     if ($request->password !== $request->password_confirmation) {
//         toastr()->error('Mật khẩu cũ mới và mật khẩu xác minh không trùng khớp');
//         return redirect()->back(); // Quay lại trang đổi mật khẩu
//     }
//     if (!Hash::check($request->old_password, $user->password)) {
//         toastr()->error('Mật khẩu cũ không chính xác');
//         return redirect()->back(); // Quay lại trang đổi mật khẩu
//     }


//     // Cập nhật mật khẩu mới
//     $user->password = Hash::make($request->password);
//     $user->save();

//     // Thông báo thành công
//     toastr()->success('Mật khẩu đã được thay đổi thành công');
//     return redirect()->route('view.resetpass'); // Chuyển hướng sau khi đổi mật khẩu
// }
}

