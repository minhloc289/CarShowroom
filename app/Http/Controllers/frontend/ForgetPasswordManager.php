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
    function forgetPassword(){
        return view("frontend.login_sign.forgot_pass");
    }
    function forgetPasswordPost(Request $request){
        $request->validate([
            'email'=>'required|email|exists:accounts',
        ]);
        $token=Str::random(64);
        DB::table('password_resets')->insert([
            'email'=> $request->email,
            'token'=> $token,
            'created_at'=>\Carbon\Carbon::now(),
        ]);
        Mail::send('emails.forget_password',['token'=>$token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return redirect()->to(route('CustomerDashBoard.index'))->with('success','We have send an email to reset password.');
    }
    function resetPassword($token){
        return view('frontend.login_sign.new_password', compact('token'));
    }
    function resetPasswordPost(Request $request) {
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
            return redirect()->route('reset.password')->with('error', 'Token đặt lại mật khẩu hoặc email không hợp lệ.');
        }
    
        // Cập nhật mật khẩu trong bảng accounts
        $updated = Account::where("email", $request->email)->update(["password" => Hash::make($request->password)]);
        
        // Kiểm tra xem cập nhật có thành công không
        if (!$updated) {
            return redirect()->route('reset.password')->with('error', 'Không thể cập nhật mật khẩu.');
        }
    
        // Xóa bản ghi đặt lại mật khẩu để ngăn chặn việc sử dụng lại
        DB::table("password_resets")->where("email", $request->email)->delete();
        
        // Chuyển hướng với thông báo thành công
        return redirect()->route("CustomerDashBoard.index")->with("success", "Đặt lại mật khẩu thành công.");
    }
}
