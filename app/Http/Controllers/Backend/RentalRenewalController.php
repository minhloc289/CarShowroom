<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalReceipt;
use App\Models\RentalRenewal;
use App\Models\RentalOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RentalRenewalController extends Controller
{
    public function approve($renewal_id)
    {
        $renewal = RentalRenewal::with('rentalReceipt.rentalOrder.user')->findOrFail($renewal_id);

        // Cập nhật trạng thái yêu cầu gia hạn
        $renewal->status = 'Approved';
        $renewal->save();

        // Lấy thông tin hóa đơn
        $receipt = $renewal->rentalReceipt;

        if ($receipt->status === 'Completed') {
            // Trường hợp đã hết hạn thuê
            $newOrder = RentalOrder::create([
                'user_id' => $receipt->rentalOrder->user_id,
                'rental_id' => $receipt->rental_id,
                'status' => 'Pending', // Trạng thái ban đầu của Order
                'order_date' => now(),
            ]);

            // Tạo một hóa đơn mới
            $newReceipt = RentalReceipt::create([
                'rental_id' => $receipt->rental_id,
                'order_id' => $newOrder->order_id,
                'rental_start_date' => Carbon::parse($receipt->rental_end_date)->copy()->addDay(), // Chuyển thành Carbon trước khi xử lý
                'rental_end_date' => $renewal->new_end_date, // Giữ nguyên nếu $renewal->new_end_date đã là Carbon
                'rental_price_per_day' => $receipt->rental_price_per_day,
                'total_cost' => $renewal->renewal_cost,
                'status' => 'Active', // Trạng thái ban đầu
            ]);

            // Gửi email với link thanh toán
            $paymentLink = route('rental.payment.vnpay_renewal', [
                'order_id' => $newOrder->order_id,
                'amount' => $renewal->renewal_cost,
            ]);
        } elseif ($receipt->status === 'Active') {
            // Trường hợp còn hạn thuê -> cập nhật ngày kết thúc hóa đơn hiện tại
            $receipt->rental_end_date = $renewal->new_end_date;
            $receipt->total_cost += $renewal->renewal_cost; // Cộng thêm chi phí gia hạn
            $receipt->save();

            // Gửi email với thông tin gia hạn
            $paymentLink = route('rental.payment.vnpay_renewal', [
                'order_id' => $receipt->order_id,
                'amount' => $renewal->renewal_cost,
            ]);
        }

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
            return response()->json(['message' => 'Lỗi khi gửi email: ' . $e->getMessage()], 500);
        }
    }





    public function reject($renewal_id)
    {
        $renewal = RentalRenewal::findOrFail($renewal_id);

        // Cập nhật trạng thái yêu cầu gia hạn
        $renewal->status = 'Rejected';
        $renewal->save();

        return response()->json(['message' => 'Yêu cầu gia hạn đã bị từ chối.']);
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

}
