@extends('Backend.dashboard.layout')

@section('content')
    <div class="container custom-width w-95 ml-4 mt-8 p-6 bg-white shadow-lg rounded-lg">
        <!-- Tiêu đề -->
        <h2 class="text-2xl font-bold text-blue-600 mb-6">
            Chi tiết đơn hàng: <span class="text-gray-800">{{ $payment->order->order_id ?? 'Không rõ' }}</span>
        </h2>

        <!-- Thông tin khách hàng -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin khách hàng</h3>
            <div class="grid grid-cols-2 gap-4">
                <p class="text-gray-600"><strong>Khách hàng:</strong> {{ $payment->order->account->name ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Email:</strong> {{ $payment->order->account->email ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Số điện thoại:</strong> {{ $payment->order->account->phone ?? 'Không có thông tin' }}</p>
                <p class="text-gray-600"><strong>Ngày tạo:</strong> {{ \Carbon\Carbon::parse($payment->order->order_date)->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Thông tin xe và phụ kiện -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin sản phẩm</h3>
            @if ($payment->order->salesCar)
                <div class="mb-4">
                    <h4 class="text-md font-bold text-gray-700">Thông tin xe</h4>
                    <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <p class="text-gray-600"><strong>Thương hiệu:</strong> {{ $payment->order->salesCar->carDetails->brand ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Tên xe:</strong> {{ $payment->order->salesCar->carDetails->name ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Model:</strong> {{ $payment->order->salesCar->carDetails->model ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Năm sản xuất:</strong> {{ $payment->order->salesCar->carDetails->year ?? 'Không có thông tin' }}</p>
                        <p class="text-gray-600"><strong>Giá:</strong> {{ number_format($payment->order->salesCar->sale_price, 0, ',', '.') }} VNĐ</p>
                    </div>
                </div>
            @endif

            @if ($payment->order->accessories->isNotEmpty())
                <div class="mb-4">
                    <h4 class="text-md font-bold text-gray-700">Thông tin phụ kiện</h4>
                    @foreach ($payment->order->accessories as $accessory)
                        <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                            <p class="text-gray-600"><strong>Tên phụ kiện:</strong> {{ $accessory->name }}</p>
                            <p class="text-gray-600"><strong>Số lượng:</strong> {{ $accessory->pivot->quantity }}</p>
                            <p class="text-gray-600"><strong>Giá mỗi sản phẩm:</strong> {{ number_format($accessory->pivot->price, 0, ',', '.') }} VNĐ</p>
                            <p class="text-gray-600"><strong>Tổng:</strong> {{ number_format($accessory->pivot->quantity * $accessory->pivot->price, 0, ',', '.') }} VNĐ</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!$payment->order->salesCar && $payment->order->accessories->isEmpty())
                <p class="text-gray-600">Không có thông tin sản phẩm liên quan đến đơn hàng này.</p>
            @endif
        </div>

        <!-- Thông tin thanh toán -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Thông tin thanh toán</h3>
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
        </div>

        <!-- Nút quay lại -->
        <div class="text-center flex justify-center space-x-4">
            <a href="{{ route('payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-lg">
                Quay lại danh sách
            </a>
        </div>
    </div>
@endsection
