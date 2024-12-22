@extends('frontend.profilepage.viewprofile')

@section('main')
<div class="bg-gray-100 py-6">
	<div class="container mx-auto bg-white rounded-lg shadow-md p-6">
		<!-- Tabs điều hướng -->
		<div class="d-flex border-bottom mb-4">
			<button class="tablinks active px-4 py-2" onclick="openTab(event, 'carsContainer')"
				style="border: none; font-size: 18px; color: #007bff; font-weight: bold; border-bottom: 3px solid #007bff; background-color: transparent;">
				Xe ô tô
			</button>
			<button class="tablinks px-4 py-2" onclick="openTab(event, 'accessoriesContainer')"
				style="border: none; font-size: 18px; color: #6c757d; background-color: transparent; font-weight: normal; border-bottom: 3px solid transparent;">
				Phụ kiện
			</button>
		</div>

		<!-- Tab Nội dung Xe Ô Tô -->
		<div id="carsContainer" class="tabcontent" style="display: block;">
			<h1 class="text-2xl mb-6">TỔNG QUAN XE Ô TÔ CỦA BẠN</h1>
			@if ($customerCars && $customerCars->isNotEmpty())
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
					@foreach ($customerCars as $payment)
						@if ($payment->order && $payment->order->salesCar && $payment->order->salesCar->carDetails)
							<!-- Card hiển thị thông tin xe -->
							<div class="bg-gray-100 rounded-lg shadow-md p-4">
								<img src="{{ $payment->order->salesCar->carDetails->image_url ?? 'default-image.jpg' }}"
									alt="Car Image" class="w-full h-48 object-cover rounded-t-md">
								<div class="p-4">
									<h2 class="text-lg font-semibold mb-2">{{ $payment->order->salesCar->carDetails->name }}</h2>
									<p><strong>Hãng:</strong> {{ $payment->order->salesCar->carDetails->brand }}</p>
									<p><strong>Model:</strong> {{ $payment->order->salesCar->carDetails->model }}</p>
									<p><strong>Giá:</strong> {{ number_format($payment->order->salesCar->sale_price, 0, ',', '.') }}
										VNĐ
									</p>
									<div class="mt-4">
										<a href="{{route('customer.car.detail', ['id' => $payment->order->order_id])}}"
											class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Xem chi
											tiết</a>
									</div>
								</div>
							</div>
						@endif
					@endforeach
				</div>
			@else
				<p class="text-gray-500">Không tìm thấy xe nào thuộc về bạn.</p>
			@endif
		</div>

		<!-- Tab Nội dung Phụ Kiện -->
		<div id="accessoriesContainer" class="tabcontent" style="display: none;">
			<h1 class="text-2xl mb-6">TỔNG QUAN PHỤ KIỆN CỦA BẠN</h1>
			@if ($customerAccessories && $customerAccessories->isNotEmpty())
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
					@foreach ($customerAccessories as $accessoryData)
						<!-- Card hiển thị thông tin phụ kiện -->
						<div class="bg-gray-100 rounded-lg shadow-md p-4">
							<img src="{{ $accessoryData->accessory->image_url ?? 'default-image.jpg' }}" alt="Accessory Image"
								class="w-20px h-auto object-cover rounded-t-md">
							<div class="p-4">
								<h2 class="text-lg font-semibold mb-2">{{ $accessoryData->accessory->name }}</h2>
								<p><strong>Giá:</strong> {{ number_format($accessoryData->price, 0, ',', '.') }} VNĐ</p>
								<p><strong>Số lượng:</strong> {{ $accessoryData->quantity }}</p>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<p class="text-gray-500">Không tìm thấy phụ kiện nào thuộc về bạn.</p>
			@endif

		</div>
	</div>
</div>

<script>
	function openTab(evt, tabName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
			tablinks[i].style.color = "#6c757d";
			tablinks[i].style.borderBottom = "3px solid transparent";
			tablinks[i].style.fontWeight = "normal";
		}
		document.getElementById(tabName).style.display = "block";
		evt.currentTarget.className += " active";
		evt.currentTarget.style.color = "#007bff";
		evt.currentTarget.style.borderBottom = "3px solid #007bff";
		evt.currentTarget.style.fontWeight = "bold";
	}
</script>
@endsection