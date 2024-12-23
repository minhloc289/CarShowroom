@extends('Backend.dashboard.layout')

@section('content')


<div class="container mt-4">
	<div class="row">
		<div class="col-12">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<h1 class="fw-bold text-primary">Danh sách thanh toán</h1>
				<a href="" class="btn btn-success">+ Thêm thanh toán</a>
			</div>

			<div class="flex items-center space-x-4 mb-4">
				<!-- Tìm kiếm -->
				<input type="text" id="searchInput" class="rounded-lg border border-gray-300 px-4 py-2 w-64"
					placeholder="Tìm kiếm mã đơn hàng hoặc khách hàng...">

				<!-- Lọc theo loại thanh toán -->
				<select id="paymentTypeFilter" class="rounded-lg border border-gray-300 px-4 py-2">
					<option value="">Tất cả loại thanh toán</option>
					<option value="đặt cọc">Đặt cọc</option>
					<option value="thanh toán toàn bộ">Thanh toán toàn bộ</option>
					<option value="thanh toán còn lại">Thanh toán còn lại</option>
				</select>

			</div>

			<div id="paymentsContainer" class="table-responsive shadow-sm">
				<table class="table table-striped table-hover text-center align-middle">
					<thead class="bg-primary text-white">
						<tr>
							<th scope="col">Mã đơn hàng</th>
							<th scope="col">Khách hàng</th>
							<th scope="col">Loại sản phẩm</th>
							<th scope="col">Loại thanh toán</th>
							<th scope="col">Ngày thanh toán</th>
							<th scope="col">Số tiền</th>
							<th scope="col">Hành động</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($payments as $payment)
												@php
													$hasDeposit = $payment->deposit_amount > 0 && $payment->remaining_amount > 0;
													$hasRemaining = $payment->remaining_payment_date && $payment->remaining_amount > 0;
													$hasFullPayment = $payment->full_payment_date && $payment->total_amount > 0;
												@endphp

												<!-- Hiển thị dòng thanh toán đặt cọc -->
												@if ($hasDeposit)
																	<tr>
																		<td class="fw-bold">{{ optional($payment->order)->order_id ?? 'Không rõ' }}</td>
																		<td>{{ optional($payment->order->account)->name ?? 'Không rõ' }}</td>
																		<td>
																			@php
																				$hasCar = !empty(optional($payment->order->salesCar)->carDetails);
																				$hasAccessories = $payment->order->accessories()->exists();
																				$productType = $hasCar && $hasAccessories ? 'Xe, Phụ kiện' :
																					($hasCar ? 'Xe' : ($hasAccessories ? 'Phụ kiện' : 'Không rõ'));
																			@endphp
																			{{ $productType }}
																		</td>
																		<td>Đặt cọc</td>
																		<td>{{ $payment->payment_deposit_date ? \Carbon\Carbon::parse($payment->payment_deposit_date)->format('d/m/Y') : 'Chưa rõ' }}
																		</td>
																		<td>{{ number_format($payment->deposit_amount, 0, ',', '.') }} VND</td>
																		<td>
																			<a href="{{ route('payments.detail', ['payment' => $payment->payment_id]) }}"
																				class="btn btn-outline-primary btn-sm">
																				<i class="bi bi-eye"></i> Chi tiết
																			</a>
																		</td>
																	</tr>
												@endif
												<!-- Hiển thị dòng thanh toán phần còn lại -->
												@if ($hasRemaining)
																	<tr>
																		<td class="fw-bold">{{ optional($payment->order)->order_id ?? 'Không rõ' }}</td>
																		<td>{{ optional($payment->order->account)->name ?? 'Không rõ' }}</td>
																		<td>
																			@php
																				$hasCar = !empty(optional($payment->order->salesCar)->carDetails);
																				$hasAccessories = $payment->order->accessories()->exists();
																				$productType = $hasCar && $hasAccessories ? 'Xe, Phụ kiện' :
																					($hasCar ? 'Xe' : ($hasAccessories ? 'Phụ kiện' : 'Không rõ'));
																			@endphp
																			{{ $productType }}
																		</td>
																		<td>Thanh toán còn lại</td>
																		<td>{{ $payment->remaining_payment_date ? \Carbon\Carbon::parse($payment->remaining_payment_date)->format('d/m/Y') : 'Chưa rõ' }}
																		</td>
																		<td>{{ number_format($payment->remaining_amount, 0, ',', '.') }} VND</td>
																		<td>
																			<a href="{{ route('payments.detail', ['payment' => $payment->payment_id]) }}"
																				class="btn btn-outline-primary btn-sm">
																				<i class="bi bi-eye"></i> Chi tiết
																			</a>
																		</td>
																	</tr>
												@endif

												<!-- Hiển thị dòng thanh toán toàn bộ -->
												@if ($hasFullPayment)
																	<tr>
																		<td class="fw-bold">{{ optional($payment->order)->order_id ?? 'Không rõ' }}</td>
																		<td>{{ optional($payment->order->account)->name ?? 'Không rõ' }}</td>
																		<td>
																			@php
																				$hasCar = !empty(optional($payment->order->salesCar)->carDetails);
																				$hasAccessories = $payment->order->accessories()->exists();
																				$productType = $hasCar && $hasAccessories ? 'Xe, Phụ kiện' :
																					($hasCar ? 'Xe' : ($hasAccessories ? 'Phụ kiện' : 'Không rõ'));
																			@endphp
																			{{ $productType }}
																		</td>
																		<td>Thanh toán toàn bộ</td>
																		<td>{{ $payment->full_payment_date ? \Carbon\Carbon::parse($payment->full_payment_date)->format('d/m/Y') : 'Chưa rõ' }}
																		</td>
																		<td>{{ number_format($payment->total_amount, 0, ',', '.') }} VND</td>
																		<td>
																			<a href="{{ route('payments.detail', ['payment' => $payment->payment_id]) }}"
																				class="btn btn-outline-primary btn-sm">
																				<i class="bi bi-eye"></i> Chi tiết
																			</a>
																		</td>
																	</tr>
												@endif
						@endforeach
					</tbody>


				</table>
			</div>
		</div>
	</div>

</div>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const searchInput = document.getElementById('searchInput');
		const paymentTypeFilter = document.getElementById('paymentTypeFilter');
		const paymentsContainer = document.querySelector('#paymentsContainer tbody');

		function filterPayments() {
			// Lấy giá trị từ ô tìm kiếm và combobox
			const searchValue = searchInput.value.toLowerCase().trim();
			const paymentTypeValue = paymentTypeFilter.value.toLowerCase().trim();

			// Lấy tất cả các hàng trong bảng
			const rows = Array.from(paymentsContainer.querySelectorAll('tr'));

			rows.forEach(row => {
				// Lấy dữ liệu từng cột cần so sánh
				const orderId = row.cells[0].textContent.toLowerCase().trim();
				const customerName = row.cells[1].textContent.toLowerCase().trim();
				const paymentType = row.cells[3].textContent.toLowerCase().trim();

				// Kiểm tra điều kiện tìm kiếm
				const matchesSearch = !searchValue || orderId.includes(searchValue) || customerName.includes(searchValue);

				// Kiểm tra điều kiện lọc combobox loại thanh toán
				const matchesType = !paymentTypeValue || paymentType === paymentTypeValue;

				// Hiển thị hoặc ẩn hàng dựa trên kết quả lọc
				row.style.display = matchesSearch && matchesType ? '' : 'none';
			});
		}

		// Lắng nghe sự kiện input và change cho ô tìm kiếm và combobox
		searchInput.addEventListener('input', filterPayments);
		paymentTypeFilter.addEventListener('change', filterPayments);
	});
</script>

@endsection