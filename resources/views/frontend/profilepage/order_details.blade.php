@extends('frontend.profilepage.viewprofile')

@section('main')
<div class="bg-gray-100 py-6">
    <div class="container mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Tiêu đề -->
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h1 class="text-2xl ">THÔNG TIN ĐẶT HÀNG</h1>
        </div>

        <!-- Bố cục 2 cột -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Cột trái: Thông tin chung và khách hàng -->
            <div>
                <!-- Thông tin chung -->
                <div class="mb-6">
                    <h2 class="text-lg ">Thông tin chung</h2>
                    <p class="py-1"><strong>Mã đơn hàng:</strong> {{ $order->order_id }}</p>
                    <p class="py-1"><strong>Ngày đặt hàng:</strong> {{ $order->order_date }}</p>
                    @php
                            $statusText = '';
                            $statusColor = '#e3e3e3';
                            $colorText = '#1e1e1e';

                            // Trạng thái thanh toán
                            $paymentStatusText = '';
                            $paymentStatusColor = '#e3e3e3';
                            $paymentColorText = '#1e1e1e';

                        // Xử lý trạng thái thanh toán
						switch ($order->payments->first()->status_deposit) {
                                case 0:
                                    $statusText = 'Chờ đặt cọc';
                                    $statusColor = '#e3e3e3';
                                    break;
                                case 1:
                                    $statusText = 'Đã đặt cọc';
                                    $statusColor = '#28a745';
                                    $colorText = '#fff';
                                    break;
                                case 2:
                                    $statusText = 'Không đặt cọc';
                                    $statusColor = '#dc3545';
                                    $colorText = '#fff';
                                    break;
                            }

                            switch ($order->payments->first()->status_payment_all) {
                                case 0:
                                    $paymentStatusText = 'Chưa toán hết';
                                    $paymentStatusColor = '#ffc107';
                                    break;
                                case 1:
                                    $paymentStatusText = 'Đã thanh toán hết';
                                    $paymentStatusColor = '#28a745';
                                    $paymentColorText = '#fff';
                                case 2:
                                    $paymentStatusText = 'Không thanh toán hết';
                                    $paymentStatusColor = '#dc3545';
                                    $paymentColorText = '#fff';
                                    break;
                            }
                    @endphp
                    <p><strong>Trạng thái:</strong>
					<span class="px-3 py-1 rounded-full text-sm font-medium"
						style="background-color: {{ $statusColor }}; color: {{ $colorText }}; margin-right: 10px;">
						{{ $statusText }}
					</span>
                    </p>
                </div>

                <!-- Thông tin khách hàng -->
                <div>
                    <h2 class=" text-gray-600 w-36 mb-4">Thông tin chủ xe</h2>
                    <p class="text-gray-600 py-2"><strong>Họ và tên:</strong> {{ $order->account->name ?? 'N/A' }}</p>
                    <p class="text-gray-600 py-2"><strong>Số điện thoại:</strong> {{ $order->account->phone ?? 'N/A' }}</p>
                    <p class="text-gray-600 py-2"><strong>Email:</strong> {{ $order->account->email ?? 'N/A' }}</p>
                    <p class="text-gray-600 py-2"> <strong>CMND/CCCD:</strong> {{ $order->account->identity_card ?? 'N/A' }}</p>
                    <p class="text-gray-600 py-2"><strong>Showroom nhận xe:</strong> {{ $order->showroom_name ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Cột phải: Thông tin xe và phụ kiện -->
            <div>
                <!-- Thông tin xe -->
                @if ($order->salesCar && $order->salesCar->carDetails)
                    <div class="bg-gray-100 rounded-lg p-4 mb-6">
                        <h2 class="text-lg font-semibold mb-4">Thông tin xe</h2>
                        <div class="flex items-center">
                            <img src="{{ $order->salesCar->carDetails->image_url ?? 'default-image.jpg' }}" 
                                 alt="Car Image" class="w-40 h-auto rounded-md shadow-md mr-4">
                            <div>
                                <p><strong>Tên xe:</strong> {{ $order->salesCar->carDetails->name }}</p>
                                <p><strong>Hãng:</strong> {{ $order->salesCar->carDetails->brand }}</p>
                                <p><strong>Model:</strong> {{ $order->salesCar->carDetails->model }}</p>
                                <p><strong>Năm sản xuất:</strong> {{ $order->salesCar->carDetails->year }}</p>
                                <p><strong>Giá:</strong> {{ number_format($order->salesCar->sale_price, 0, ',', '.') }} VNĐ</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Thông tin phụ kiện -->
                @if ($order->accessories->isNotEmpty())
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h2 class="text-lg text-gray-600 w-36 mb-4">Phụ kiện</h2>
                        @foreach ($order->accessories as $accessory)
                            <div class="flex items-center mb-4">
                                <img src="{{ $accessory->image_url ?? 'default-image.jpg' }}" 
                                     alt="Accessory Image" class="w-16 h-auto rounded-md shadow-md mr-4">
                                <div>
                                    <p><strong>{{ $accessory->name }}</strong></p>
                                    <p class="text-sm text-gray-500">Số lượng: {{ $accessory->pivot->quantity }}</p>
                                    <p class="text-sm text-gray-500">Giá mỗi sản phẩm: 
                                        {{ number_format($accessory->pivot->price, 0, ',', '.') }} VNĐ</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @if (!$order->salesCar)
                        <p class="text-gray-500">Không có sản phẩm nào liên quan đến đơn hàng này.</p>
                    @endif
                @endif

                <!-- Thông tin thanh toán -->
                <div class="bg-gray-100 rounded-lg p-4 mt-6">
                    <h2 class="text-lg text-gray-600 mb-4">Thông tin thanh toán</h2>
                    @php
                        $totalAmount = $order->payments->first()->total_amount ?? 0;
                        $depositAmount = $order->payments->sum('deposit_amount') ?? 0;
                        $remainingAmount = $totalAmount - $depositAmount;
                    @endphp
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 w-36">Giá trị đơn hàng</p>
                            <p>{{ number_format($totalAmount, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>

                        </div>
                        <div>
							<p class="text-gray-600 w-36">Đặt cọc</p>
							<p>{{ number_format($depositAmount, 0, ',', '.') }} VNĐ</p>
							@if($order->payments->first()->status_deposit===1)
                            <p class="text-gray-600 w-36">Cần thanh toán</p>
                            <p>{{ number_format($remainingAmount, 0, ',', '.') }} VNĐ</p>
							@endif
                        </div>
                        <div>
						<span class="px-3 py-1 rounded-full text-sm font-medium"
                                    style="background-color: {{ $paymentStatusColor }}; color: {{ $paymentColorText }}; margin-right: 10px;">
                                    {{ $paymentStatusText }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
