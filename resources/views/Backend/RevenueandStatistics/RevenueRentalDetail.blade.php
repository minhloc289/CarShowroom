@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="Revenue.details" />

    <link rel="stylesheet" href="/assets/css/viewRentalOrder.css">
    <div class="container custom-width w-95 ml-4 mt-8 p-6 bg-white shadow-lg rounded-lg">
        <!-- Tiêu đề -->
        <h2 class="text-2xl font-bold text-blue-600 mb-6">
            Chi tiết thanh toán
        </h2>
    
        <!-- Thông tin khách hàng -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin khách hàng</h3>
            <div class="grid grid-cols-2 gap-4">
                <p class="text-gray-600"><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Trạng thái:</strong> 
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if ($order->status === 'Pending') bg-yellow-200 text-yellow-800
                        @elseif ($order->status === 'Deposit Paid') bg-blue-200 text-blue-800
                        @elseif ($order->status === 'Paid') bg-green-200 text-green-800
                        @elseif ($order->status === 'Canceled') bg-red-200 text-red-800
                        @endif">
                        @switch($order->status)
                            @case('Pending')
                                Đang chờ xử lý
                                @break
                            @case('Deposit Paid')
                                Đã đặt cọc
                                @break
                            @case('Paid')
                                Đã thanh toán
                                @break
                            @case('Canceled')
                                Đã hủy
                                @break
                            @default
                                Không xác định
                        @endswitch
                    </span>
                </p>
                <p class="text-gray-600"><strong>Ngày tạo:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    
        <!-- Thông tin hóa đơn thuê xe -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin hóa đơn thuê xe</h3>
            @forelse ($order->rentalReceipts as $receipt)
                <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <p class="text-gray-600"><strong>Mã hóa đơn:</strong> {{ $receipt->receipt_id }}</p>
                        <p class="text-gray-600"><strong>Xe thuê:</strong> {{ $receipt->rentalCar->carDetails->name ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Ngày bắt đầu thuê:</strong> {{ \Carbon\Carbon::parse($receipt->rental_start_date)->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-600"><strong>Ngày kết thúc thuê:</strong> {{ \Carbon\Carbon::parse($receipt->rental_end_date)->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-600"><strong>Giá thuê mỗi ngày:</strong> {{ number_format($receipt->rental_price_per_day, 0, ',', '.') }} VND</p>
                        <p class="text-gray-600"><strong>Tổng chi phí:</strong> {{ number_format($receipt->total_cost, 0, ',', '.') }} VND</p>
                        <p class="text-gray-600"><strong>Trạng thái:</strong> 
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if ($receipt->status === 'Active') bg-yellow-200 text-yellow-800
                                @elseif ($receipt->status === 'Completed') bg-green-200 text-green-800
                                @else bg-red-200 text-red-800
                                @endif">
                                {{ $receipt->status }}
                            </span>
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Không tìm thấy hóa đơn nào liên quan đến đơn hàng này.</p>
            @endforelse
        </div>
 
        <!-- Nút quay lại -->
        <div class="text-center flex justify-center space-x-4">
            <!-- Nút quay lại -->
            <a href="{{ route('payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg">
                Quay lại danh sách
            </a>
        </div>
    </div>
    
    
@endsection