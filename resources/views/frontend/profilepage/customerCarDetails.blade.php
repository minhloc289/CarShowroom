@extends('frontend.profilepage.viewprofile')

@section('main')
<div class="bg-gray-100 py-6">
	<div class="container mx-auto bg-white rounded-lg shadow-md p-6">
		<!-- Tiêu đề -->
		<div class="flex justify-between items-center border-b pb-4 mb-6">
			<h1 class="text-2xl font-semibold">CHI TIẾT ĐƠN HÀNG XE</h1>
		</div>

		@if ($order && $order->salesCar && $order->salesCar->carDetails)
			<!-- Thông tin xe -->
			<div class="bg-gray-100 rounded-lg p-6 mb-6">
				<h2 class="text-lg font-semibold border-b pb-2 mb-4">Thông tin xe</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<!-- Hình ảnh xe -->
					<div>
						<img src="{{ $order->salesCar->carDetails->image_url ?? 'default-image.jpg' }}" alt="Car Image"
							class="w-full h-auto rounded-lg shadow-md">
					</div>

					<!-- Chi tiết xe -->
					<div>
						<p><strong>Tên xe:</strong> {{ $order->salesCar->carDetails->name }}</p>
						<p><strong>Hãng:</strong> {{ $order->salesCar->carDetails->brand }}</p>
						<p><strong>Model:</strong> {{ $order->salesCar->carDetails->model }}</p>
						<p><strong>Năm sản xuất:</strong> {{ $order->salesCar->carDetails->year }}</p>
						<p><strong>Loại động cơ:</strong> {{ $order->salesCar->carDetails->engine_type ?? 'N/A' }}</p>
						<p><strong>Số chỗ ngồi:</strong> {{ $order->salesCar->carDetails->seat_capacity ?? 'N/A' }}</p>
						<p><strong>Công suất động cơ:</strong> {{ $order->salesCar->carDetails->engine_power ?? 'N/A' }} mã
							lực</p>
						<p><strong>Tốc độ tối đa:</strong> {{ $order->salesCar->carDetails->max_speed ?? 'N/A' }} km/h</p>
						<p><strong>Giá:</strong> {{ number_format($order->salesCar->sale_price, 0, ',', '.') }} VNĐ</p>
					</div>
				</div>
			</div>

			<!-- Thông số kỹ thuật -->
			<div class="bg-gray-100 rounded-lg p-6 mb-6">
				<h2 class="text-lg font-semibold border-b pb-2 mb-4">Thông số kỹ thuật</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<p><strong>Thể tích khoang hành lý:</strong>
							{{ $order->salesCar->carDetails->trunk_capacity ?? 'N/A' }} lít</p>
						<p><strong>Thời gian tăng tốc 0-100km/h:</strong>
							{{ $order->salesCar->carDetails->acceleration_time ?? 'N/A' }} giây</p>
						<p><strong>Hiệu suất nhiên liệu:</strong>
							{{ $order->salesCar->carDetails->fuel_efficiency ?? 'N/A' }} lít/100km</p>
					</div>
					<div>
						<p><strong>Mô-men xoắn:</strong> {{ $order->salesCar->carDetails->torque ?? 'N/A' }} Nm</p>
						<p><strong>Kích thước (Dài x Rộng x Cao):</strong>
							{{ $order->salesCar->carDetails->length ?? 'N/A' }} x
							{{ $order->salesCar->carDetails->width ?? 'N/A' }} x
							{{ $order->salesCar->carDetails->height ?? 'N/A' }} mm
						</p>
					</div>
				</div>
			</div>
		@else
			<p class="text-gray-500">Không tìm thấy thông tin đơn hàng hoặc xe.</p>
		@endif
	</div>
</div>
@endsection