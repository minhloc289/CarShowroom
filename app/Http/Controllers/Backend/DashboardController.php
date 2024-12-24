<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment; // Import model Payment
use App\Models\RentalPayment; // Import model Payment
use App\Models\RentalOrder; // Import model Payment
use App\Models\User;


class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function loadDashboard()
    {
        // Doanh thu từ Payment
        $paymentRevenues = Payment::selectRaw('MONTH(COALESCE(full_payment_date, remaining_payment_date, payment_deposit_date)) as month, SUM(total_amount) as total')
            ->whereRaw('YEAR(COALESCE(full_payment_date, remaining_payment_date, payment_deposit_date)) = ?', [date('Y')])
            ->groupByRaw('MONTH(COALESCE(full_payment_date, remaining_payment_date, payment_deposit_date))')
            ->pluck('total', 'month')
            ->toArray();

        // Doanh thu từ RentalPayment
        $rentalRevenues = RentalPayment::selectRaw('MONTH(payment_date) as month, SUM(total_amount) as total')
            ->whereYear('payment_date', date('Y'))
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month')
            ->toArray();

        // Gộp doanh thu từ cả hai nguồn và đảm bảo đầy đủ 12 tháng
        $monthlyRevenues = [];
        $finalPaymentRevenues = [];
        $finalRentalRevenues = [];

        for ($i = 1; $i <= 12; $i++) {
            $finalPaymentRevenues[$i] = $paymentRevenues[$i] ?? 0;
            $finalRentalRevenues[$i] = $rentalRevenues[$i] ?? 0;
            $monthlyRevenues[$i] = $finalPaymentRevenues[$i] + $finalRentalRevenues[$i];
        }
        $totalPaymentRevenues = array_sum($finalPaymentRevenues);
        $totalRentalRevenues = array_sum($finalRentalRevenues);
        $config = $this->config();
        return view('Backend.dashboard.home.home', [
            'monthlyRevenues' => array_values($monthlyRevenues), // Tổng doanh thu hàng tháng
            'totalPaymentRevenues' => ($totalPaymentRevenues), // Doanh thu từ Payment
            'totalRentalRevenues' => ($totalRentalRevenues), // Doanh thu từ Rental
            'finalRentalRevenues' => array_values($finalRentalRevenues),
            'finalPaymentRevenues' => array_values($finalPaymentRevenues)
        ]);
    }

    public function loadProfile()
    {
        $user = Auth::user();
        return view('Backend.dashboard.profile.employee_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Đảm bảo email không trùng, trừ email của chính user
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id, // Đảm bảo số điện thoại không trùng
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file ảnh
        ]);

        // Xử lý upload ảnh đại diện nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('avatars', 'public');
        } else {
            $imagePath = $user->image; // Giữ nguyên ảnh hiện tại nếu không upload ảnh mới
        }

        // Gán từng giá trị mới cho user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->description = $request->description;
        $user->image = $imagePath;

        // Lưu thông tin mới vào database
        $user->save();

        // Trả về thông báo thành công
        toastr()->success('Cập nhật thông tin cá nhân thành công!');
        return redirect()->back();
    }



    private function config()
    {
        return [
            'js' => [
                'assets/js/custom/widgets.js',
                'assets/js/custom/apps/chat/chat.js',
                'assets/js/custom/modals/create-app.js',
                'assets/js/custom/modals/upgrade-plan.js'
            ]
        ];
    }

}
