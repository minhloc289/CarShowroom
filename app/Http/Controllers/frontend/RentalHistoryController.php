<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RentalReceipt;

class RentalHistoryController extends Controller
{
    public function index()
    {
        // Lấy user hiện tại
        $userId = Auth::guard('account')->user()->id;

        // Lấy tất cả các biên lai thuê xe của khách hàng
        $rentalReceipts = RentalReceipt::whereHas('rentalOrder', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['rentalCar.carDetails', 'rentalOrder'])->get();

        return view('frontend.profilepage.rentalHistory', compact('rentalReceipts'));
    }

    public function showReceipt($receiptId)
    {
        $userId = Auth::guard('account')->user()->id;

        // Tìm biên lai thuê xe theo receipt_id và kiểm tra xem nó thuộc về user hiện tại
        $rentalReceipt = RentalReceipt::where('receipt_id', $receiptId)
            ->whereHas('rentalOrder', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['rentalCar.carDetails', 'rentalOrder'])
            ->firstOrFail();

        return view('frontend.profilepage.rentalHistoryDetails', compact('rentalReceipt'));
    }
}
