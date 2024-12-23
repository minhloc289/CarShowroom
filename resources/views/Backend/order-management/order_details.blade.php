@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="order.details" />
    <div class="container custom-width w-95 ml-4 mt-8 p-6 bg-white shadow-lg rounded-lg">
        <!-- Tiêu đề -->
        <h2 class="text-2xl font-bold text-blue-600 mb-6">
            Chi tiết đơn hàng: <span class="text-gray-800">{{ $order->order_id }}</span>
        </h2>

        <!-- Thông tin khách hàng -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin khách hàng</h3>
            <div class="grid grid-cols-2 gap-4">
                <p class="text-gray-600"><strong>Khách hàng:</strong> {{ $order->account->name ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Email:</strong> {{ $order->account->email ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Số điện thoại:</strong> {{ $order->account->phone ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Ngày tạo:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Thông tin xe và phụ kiện -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin sản phẩm</h3>
            @if ($order->salesCar)
                <div class="mb-4">
                    <h4 class="text-md font-bold text-gray-700">Thông tin xe</h4>
                    <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <p class="text-gray-600"><strong>Thương hiệu:</strong> {{ $order->salesCar->carDetails->brand ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Tên xe:</strong> {{ $order->salesCar->carDetails->name ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Model:</strong> {{ $order->salesCar->carDetails->model ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Năm sản xuất:</strong> {{ $order->salesCar->carDetails->year ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Giá:</strong> {{ number_format($order->salesCar->sale_price, 0, ',', '.') }} VNĐ</p>
                    </div>
                </div>
            @endif

            @if ($order->accessories->isNotEmpty())
                <div class="mb-4">
                    <h4 class="text-md font-bold text-gray-700">Thông tin phụ kiện</h4>
                    @foreach ($order->accessories as $accessory)
                        <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                            <p class="text-gray-600"><strong>Tên phụ kiện:</strong> {{ $accessory->name }}</p>
                            <p class="text-gray-600"><strong>Số lượng:</strong> {{ $accessory->pivot->quantity }}</p>
                            <p class="text-gray-600"><strong>Giá mỗi sản phẩm:</strong> {{ number_format($accessory->pivot->price, 0, ',', '.') }} VNĐ</p>
                            <p class="text-gray-600"><strong>Tổng:</strong> {{ number_format($accessory->pivot->quantity * $accessory->pivot->price, 0, ',', '.') }} VNĐ</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!$order->salesCar && $order->accessories->isEmpty())
                <p class="text-gray-600">Không có thông tin sản phẩm liên quan đến đơn hàng này.</p>
            @endif
        </div>

        <!-- Thông tin thanh toán -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin thanh toán</h3>
            @php
                $payment = $order->payments->first();
            @endphp
            @if ($payment)
                <p class="text-gray-600"><strong>Tổng tiền:</strong> {{ number_format($payment->total_amount, 0, ',', '.') }} VNĐ</p>
                <p class="text-gray-600"><strong>Đặt cọc:</strong> {{ number_format($payment->deposit_amount, 0, ',', '.') }} VNĐ</p>
                <p class="text-gray-600"><strong>Số tiền còn lại:</strong> {{ number_format($payment->remaining_amount, 0, ',', '.') }} VNĐ</p>
                <p class="text-gray-600"><strong>Trạng thái thanh toán:</strong>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if ($payment->status_payment_all == 1) bg-green-200 text-green-800
                        @elseif ($payment->status_payment_all == 0) bg-yellow-200 text-yellow-800
                        @elseif ($payment->status_payment_all == 2) bg-red-200 text-red-800
                        @endif">
                        @switch($payment->status_payment_all)
                            @case(1)
                                Đã thanh toán
                                @break
                            @case(0)
                                Đang chờ thanh toán
                                @break
                            @case(2)
                                Không thanh toán
                                @break
                            @default
                                Không xác định
                        @endswitch
                    </span>
                </p>
            @else
                <p class="text-gray-600">Không tìm thấy thông tin thanh toán cho đơn hàng này.</p>
            @endif
        </div>

        <!-- Nút quay lại -->
        <div class="text-center flex justify-center space-x-4">
            <!-- Nút thanh toán nếu chưa thanh toán -->
            @if ($payment && $payment->status_payment_all == 0)
                <form action="{{ route('orders.confirmPayment', ['order' => $order->order_id]) }}" method="POST" class="inline-block">
                    @csrf 
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-lg">
                        Xác nhận thanh toán
                    </button>
                </form>
            @endif
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg">
                Quay lại danh sách
            </a>
        </div>
    </div>
@endsection
