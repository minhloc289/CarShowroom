<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\CustomerRequest;

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
        Account::create([
            'id' => 'ACC' . (Account::count() + 1), // Mã tài khoản tự động
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_verified' => false, // Luôn là chưa xác thực
            'email_verification_token' => null, // Token trống
            'password' => bcrypt('defaultpassword'), // Mật khẩu mặc định
        ]);

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

    

}
