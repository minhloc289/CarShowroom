<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\RentalReceipt;
use App\Models\RentalRenewal;
use App\Models\RentalOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\RentalPayment;

class RentalRenewalController extends Controller
{
    public function approve($renewal_id)
    {
        $renewal = RentalRenewal::with('rentalReceipt.rentalOrder.user')->findOrFail($renewal_id);

        // Cập nhật trạng thái yêu cầu gia hạn
        $renewal->status = 'Approved';
        $renewal->save();
        $renewalType = '';

        // Lấy thông tin hóa đơn gốc
        $receipt = $renewal->rentalReceipt;

        if ($receipt->status === 'Completed') {
            // Trường hợp hợp đồng đã hết hạn
            $newOrder = RentalOrder::create([
                'user_id' => $receipt->rentalOrder->user_id,
                'rental_id' => $receipt->rental_id,
                'status' => 'Pending', // Trạng thái ban đầu của Order
                'order_date' => now(),
            ]);

            $renewalType = 'completed'; // Dạng gia hạn: Hết hạn
        } elseif ($receipt->status === 'Active') {
            // Trường hợp hợp đồng còn hạn

            $newEndDate = $renewal->new_end_date instanceof Carbon
                ? $renewal->new_end_date
                : Carbon::parse($renewal->new_end_date);

            // Kiểm tra ngày gia hạn hợp lệ
            if ($newEndDate <= $receipt->rental_end_date) {
                toastr()->error('Ngày gia hạn phải lớn hơn ngày hiện tại.');
                return redirect()->back();
            }

            // Tạo Order mới
            $newOrder = RentalOrder::create([
                'user_id' => $receipt->rentalOrder->user_id,
                'rental_id' => $receipt->rental_id,
                'status' => 'Pending', // Trạng thái ban đầu của Order
                'order_date' => now(),
            ]);

            $renewalType = 'active'; // Dạng gia hạn: Còn hạn
        }

        // Tạo link thanh toán
        $paymentLink = route('rental.payment.vnpay_renewal', [
            'order_id' => $newOrder->order_id,
            'amount' => $renewal->renewal_cost,
            'renewal_type' => $renewalType,
            'renewal_id' => $renewal->renewal_id,
        ]);

        // Gửi email thông báo
        try {
            Mail::to($receipt->rentalOrder->user->email)->send(new \App\Mail\RenewalApprovedNotification([
                'name' => $receipt->rentalOrder->user->name,
                'renewal_cost' => $renewal->renewal_cost,
                'new_end_date' => $renewal->new_end_date,
                'payment_link' => $paymentLink,
            ]));

            toastr()->success('Yêu cầu gia hạn đã được chấp nhận. Email với link thanh toán đã được gửi.');
            return redirect()->route('rentalReceipt');
        } catch (\Exception $e) {
            toastr()->warning('Yêu cầu gia hạn đã được chấp nhận, nhưng không gửi được email thông báo.');
            return redirect()->route('rentalReceipt');
        }
    }



    public function reject($renewal_id)
    {
        $renewal = RentalRenewal::with('rentalReceipt.rentalOrder.user')->findOrFail($renewal_id);

        // Cập nhật trạng thái yêu cầu gia hạn
        $renewal->status = 'Rejected';
        $renewal->save();

        // Gửi email thông báo
        try {
            $user = $renewal->rentalReceipt->rentalOrder->user;
            Mail::to($user->email)->send(new \App\Mail\RenewalRejectedNotification([
                'name' => $user->name, // Tên khách hàng
                'renewal_id' => $renewal->renewal_id, // Mã yêu cầu gia hạn
                'rental_end_date' => Carbon::parse($renewal->rentalReceipt->rental_end_date)->format('d-m-Y'), // Định dạng ngày
            ]));

            toastr()->success('Yêu cầu gia hạn đã bị từ chối. Email thông báo đã được gửi.');
        } catch (\Exception $e) {
            toastr()->warning('Yêu cầu gia hạn đã bị từ chối, nhưng không thể gửi email thông báo.');
        }

        return redirect()->route('rentalReceipt');
    }




    public function show($renewal_id)
    {
        $renewal = RentalRenewal::with([
            'rentalReceipt.rentalOrder.user',
            'rentalReceipt.rentalCar.carDetails'
            ])->findOrFail($renewal_id);


        $extendDays = $renewal->new_end_date->diffInDays($renewal->rentalReceipt->rental_end_date, false);

        // Đảm bảo số ngày gia hạn không âm
        if ($extendDays < 0) {
            $extendDays = abs($extendDays);
        }

        return view('Backend.rentalOrder.renewalDetails', compact('renewal', 'extendDays'));
    }

    public function showSearchPage()
    {
        return view('Backend.rentalOrder.manualExtend');
    }

    public function searchReceipts(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
        ]);

        // Tìm khách hàng dựa trên số điện thoại
        $customer = Account::where('phone', $validated['phone'])->first();

        if (!$customer) {
            return redirect()->back()->withErrors(['error' => 'Không tìm thấy khách hàng với số điện thoại này.']);
        }

        // Lấy hóa đơn gần nhất của từng xe mà khách hàng đã thuê
        $latestReceipts = RentalReceipt::with('rentalCar.carDetails')
            ->whereHas('rentalOrder', function ($query) use ($customer) {
                $query->where('user_id', $customer->id);
            })
            ->orderBy('rental_end_date', 'desc') // Sắp xếp theo ngày kết thúc giảm dần
            ->get()
            ->groupBy('rental_id') // Nhóm theo từng xe
            ->map(function ($group) {
                return $group->first(); // Lấy hóa đơn gần nhất trong mỗi nhóm
            });
        

        if ($latestReceipts->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Không tìm thấy hóa đơn nào cho khách hàng này.']);
        }

        // Hiển thị danh sách các hóa đơn gần nhất
        return view('Backend.rentalOrder.manualExtend', compact('latestReceipts'));
    }

    public function processManualExtend(Request $request)
    {
        $validated = $request->validate([
            'receipt_id' => 'required|exists:rental_receipt,receipt_id',
            'extend_days' => 'required|integer|min:1',
        ]);

        $receipt = RentalReceipt::findOrFail($validated['receipt_id']);
        $extendDays = (int) $validated['extend_days'];

        // Tính chi phí gia hạn
        $renewalCost = $receipt->rental_price_per_day * $extendDays;

        if ($receipt->status === 'Active') {
            // Trường hợp hóa đơn còn hạn
            // Tạo order mới
            $newOrder = RentalOrder::create([
                'user_id' => $receipt->rentalOrder->user_id,
                'rental_id' => $receipt->rental_id,
                'status' => 'Paid', // Trạng thái đã thanh toán
                'order_date' => now(),
            ]);

            // Cập nhật order_id trên hóa đơn cũ
            $receipt->update([
                'order_id' => $newOrder->order_id,
                'rental_end_date' => Carbon::parse($receipt->rental_end_date)->addDays($extendDays),
                'total_cost' => $receipt->total_cost + $renewalCost,
                'is_renewal' => true,
            ]);

            // Tạo thanh toán cho order mới
            RentalPayment::create([
                'order_id' => $newOrder->order_id,
                'status_deposit' => 'Successful', // Đã thanh toán cọc
                'full_payment_status' => 'Successful', // Đã thanh toán đầy đủ
                'deposit_amount' => 0,
                'total_amount' => $renewalCost,
                'remaining_amount' => 0,
                'due_date' => now(),
                'payment_date' => now(), // Thanh toán ngay tại showroom
                'transaction_code' => uniqid(), // Mã giao dịch
            ]);
        } elseif ($receipt->status === 'Completed') {
            // Trường hợp hóa đơn đã hết hạn
            // Tạo order mới
            $newOrder = RentalOrder::create([
                'user_id' => $receipt->rentalOrder->user_id,
                'rental_id' => $receipt->rental_id,
                'status' => 'Paid', // Trạng thái đã thanh toán
                'order_date' => now(),
            ]);

            // Tạo hóa đơn mới
            $newReceipt = RentalReceipt::create([
                'rental_id' => $receipt->rental_id,
                'order_id' => $newOrder->order_id,
                'rental_start_date' => Carbon::now()->hour >= 22 
                    ? Carbon::now()->addDay()->startOfDay() // Nếu gia hạn sau 22:00, bắt đầu ngày kế tiếp
                    : Carbon::now(), // Nếu gia hạn trước 20:00, bắt đầu ngay lập tức
                'rental_end_date' => Carbon::now()->addDays($extendDays)->endOfDay(), // Thời điểm hiện tại + số ngày gia hạn
                'rental_price_per_day' => $receipt->rental_price_per_day,
                'total_cost' => $renewalCost,
                'status' => 'Active',
                'is_renewal' => true,
            ]);

            // Tạo thanh toán cho hóa đơn mới
            RentalPayment::create([
                'order_id' => $newOrder->order_id,
                'status_deposit' => 'Successful', // Đã thanh toán cọc
                'full_payment_status' => 'Successful', // Đã thanh toán đầy đủ
                'deposit_amount' => 0,
                'total_amount' => $renewalCost,
                'remaining_amount' => 0,
                'due_date' => now(),
                'payment_date' => now(), // Thanh toán ngay tại showroom
                'transaction_code' => uniqid(), // Mã giao dịch
            ]);
        }
        toastr()->success('Gia hạn hợp đồng thành công.');
        return redirect()->route('rentalReceipt');
    }


}
