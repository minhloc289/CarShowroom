<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\CustomerRequest;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function loadCustomerPage()
    {
        $customers = Account::paginate(10);
        return view('backend.customer.customer_index', compact('customers'));
    }

    public function loadCustomerCreatePage()
    {
        return view('backend.customer.customer_create');
    }

    public function createCustomer(CustomerRequest $request)
    {
        // Lưu khách hàng vào database
        $account = Account::create([
            'id' => 'ACC' . (Account::count() + 1), // Mã tài khoản tự động
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_verified' => false, // Luôn là chưa xác thực
            'email_verification_token' => Str::random(32), // Token trống
            'password' => bcrypt('merus'), // Mật khẩu mặc định
        ]);

        Mail::send('emails.verify_email', ['token' => $account->email_verification_token], function ($message) use ($request) {
            $message->to($request->email)->subject('Xác thực tài khoản của bạn');
        });

        toastr()->success('Thêm khách hàng thành công.');
        return redirect()->route('customer');
    }

    public function loadEditPage($id)
    {
        $customer = Account::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $customerId)
    {
        // Tìm khách hàng cần cập nhật
        $customer = Account::findOrFail($customerId);

        // Cập nhật thông tin khách hàng
        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        toastr()->success('Cập nhật thông tin khách hàng thành công.');
        return redirect()->route('customer');
    }

    public function delete($id)
    {
        // Tìm khách hàng cần xóa
        $customer = Account::findOrFail($id);

        // Xóa khách hàng
        $customer->delete();

        toastr()->success('Xóa khách hàng thành công.');
        return redirect()->route('customer');
    }

    public function getCustomerByPhone(Request $request)
    {
        $phone = $request->query('phone');

        if (!$phone) {
            return response()->json(['error' => 'Số điện thoại không được để trống'], 400);
        }

        $customer = Account::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json(['error' => 'Không tìm thấy khách hàng'], 404);
        }

        return response()->json(['name' => $customer->name]);
    }


}
