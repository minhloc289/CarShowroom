@extends('frontend.profilepage.viewprofile')

@section('main')
<div style="background-color: #f3f4f6; padding: 20px;">
	<div class="container" style="background-color: #fff; border-radius: 12px; padding: 20px;">


		<!-- Tiêu đề -->
		<h3 class="mb-4 font-weight-bold">THÔNG TIN ĐẶT HÀNG</h3>

		<!-- Bố cục 2 cột -->
		<div style="display: flex; justify-content: space-between; gap: 30px;">

			<!-- Cột trái: Thông tin chung và chủ xe -->
			<div style="flex: 1; min-width: 50%;">
				<!-- Thông tin chung -->
				<h5 class="font-weight-bold mb-3">Thông tin chung</h5>
				<p><strong>Mã đơn hàng:</strong> {{ $order->order_id }}</p>
				<p><strong>Ngày đặt hàng:</strong> {{ $order->order_date }}</p>
				@php
					$statusText = '';
					$statusColor = '#e3e3e3'; // Default color
					$colorText = '#1e1e1e';

					// Xử lý trạng thái thanh toán
					switch ($order->payments->first()->status_deposit ?? 0) {
						case 0:
							$statusText = 'Chờ đặt cọc';
							$statusColor = '#e3e3e3';
							$colorText = '#1e1e1e';
							break;
						case 1:
							$statusText = 'Đã đặt cọc';
							$statusColor = '#28a745';
							$colorText = '#fff';
							break;
						case 2:
							$statusText = 'Đã hủy';
							$statusColor = '#dc3545';
							$colorText = '#fff';
							break;
					}
				@endphp
				<p><strong>Trạng thái:</strong>
					<span style="background-color: {{ $statusColor }};
						color: {{ $colorText }}; padding: 5px 10px; border-radius: 8px;">
						{{ $statusText }}
					</span>
				</p>

				<!-- Thông tin chủ xe -->
				<h5 class="font-weight-bold mt-4 mb-3">Thông tin chủ xe</h5>
				<p><strong>Họ và tên:</strong> {{ $order->account->name ?? 'N/A' }}</p>
				<p><strong>Số điện thoại:</strong> {{ $order->account->phone ?? 'N/A' }}</p>
				<p><strong>Email:</strong> {{ $order->account->email ?? 'N/A' }}</p>
			</div>

			<!-- Cột phải: Thông tin xe và thanh toán -->
			<div style="flex: 1; min-width: 40%; background-color: #f9f9f9; border-radius: 12px; padding: 20px;">
				<!-- Thông tin xe -->
				@if ($order->salesCar && $order->salesCar->carDetails)
					<div style="display: flex; align-items: center;">
						<img src="{{ $order->salesCar->carDetails->image_url ?? 'default-image.jpg' }}" alt="Car Image"
							style="width: 150px; height: auto; margin-right: 15px; border-radius: 8px;">
						<div>
							<h4 style="margin: 0; font-weight: bold;">{{ $order->salesCar->carDetails->name }}</h4>
						</div>
					</div>
				@endif

				<!-- Thông tin thanh toán -->

				<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
					<span>Giá trị đơn hàng:</span>
					<span><strong>{{ number_format($order->salesCar->sale_price ?? 0) }} VNĐ</strong></span>
				</div>
				<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
					<span>Đã thanh toán:</span>
					<span><strong>{{ number_format($order->payments->sum('deposit_amount') ?? 0) }} VNĐ</strong></span>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<span>Cần thanh toán:</span>
					<span><strong>{{ number_format(($order->salesCar->sale_price ?? 0) - ($order->payments->sum('deposit_amount') ?? 0)) }}
							VNĐ</strong></span>
				</div>


			</div>
		</div>
	</div>
</div>
@endsection