<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use App\Models\Account;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function viewprofile(Request $request){
        return view("frontend.profilepage.informationuser");
    }
    function showResetPass(Request $request){
        return view("frontend.profilepage.resetpass");
    }
    public function update(Request $request)
    {
        // Lấy thông tin người dùng từ session
        $user = session('login_account');

        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email,' . $user->id,
            'phone' => 'required|string|max:15|unique:accounts,phone,' . $user->id,
            'address' => 'nullable|string|max:255',
        ]);

        // Kiểm tra thông tin có thay đổi không
        if (
            $user->name === $request->name &&
            $user->email === $request->email &&
            $user->phone === $request->phone &&
            $user->address === $request->address
        ) {
            toastr()->warning("Không có thông tin thay đổi");
            return back();
        }

        // Cập nhật thông tin trong cơ sở dữ liệu
        $account = Account::find($user->id);
        $account->name = $request->name;
        $account->email = $request->email;
        $account->phone = $request->phone;
        $account->address = $request->address;
        $account->save();

        // Cập nhật session sau khi thay đổi
        session(['login_account' => $account]);

        // Trả về thông báo thành công
        toastr()->success("Cập nhật thông tin thành công");

        return back();
    }
}
