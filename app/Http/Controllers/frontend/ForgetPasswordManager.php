<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordManager extends Controller
{
    function forgetPassword()
    {
        return view("frontend.login_sign.forgot_pass");
    }
    public function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Kiểm tra xem email có tồn tại trong bảng accounts hay không
        $accountExists = DB::table('accounts')->where('email', $request->email)->exists();

        if (!$accountExists) {
            // Nếu không tồn tại, hiển thị thông báo lỗi và quay lại trang trước
            toastr()->error("Email chưa được đăng kí");
            return redirect()->back()->withInput();
        }

        // Nếu tồn tại, thực hiện tạo token và gửi email
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now(),
        ]);

        // Gửi email reset mật khẩu
        Mail::send('emails.forget_password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)->subject('Đặt lại mật khẩu của bạn');
        });

        toastr()->success("Gửi xác nhận thành công. Vui lòng kiểm tra email của bạn.");
        return redirect()->route('CustomerDashBoard.index');
    }

    function resetPassword($token)
    {
        return view('frontend.login_sign.new_password', compact('token'));
    }
    function resetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:accounts,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        // Kiểm tra xem token đặt lại mật khẩu có hợp lệ không
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

        if (!$updatePassword) {
            toastr()->error("token hoặc email không hợp lệ");

            return redirect()->route('reset.password');
        }

        // Cập nhật mật khẩu trong bảng accounts
        $updated = Account::where("email", $request->email)->update(["password" => Hash::make($request->password)]);

        // Kiểm tra xem cập nhật có thành công không
        if (!$updated) {
            toastr()->error("không thể cập nhật mật khẩu");

            return redirect()->route('reset.password');
        }

        // Xóa bản ghi đặt lại mật khẩu để ngăn chặn việc sử dụng lại
        DB::table("password_resets")->where("email", $request->email)->delete();

        // Chuyển hướng với thông báo thành công
        toastr()->success("cập nhật mật khẩu thành công");

        return redirect()->route("CustomerDashBoard.index");
    }
}
