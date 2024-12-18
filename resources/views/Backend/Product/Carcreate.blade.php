@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="carsales.create" />
<div class="post d-flex flex-column-fluid" id="kt_post">
	<div id="kt_content_container" class="container-xxl">
		<h1>Thêm xe mới</h1>

		<!-- Hiển thị thông báo thành công -->
		@if(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif

		<!-- Form thêm mới -->
		<form action="{{ route('car.store') }}" method="POST">
			@csrf

			<!-- Thông tin xe -->
			<div class="mb-3">
				<label for="brand" class="form-label">Thương hiệu</label>
				<input type="text" class="form-control" id="brand" name="brand" required>
			</div>

			<div class="mb-3">
				<label for="name" class="form-label">Tên xe</label>
				<input type="text" class="form-control" id="name" name="name" required>
			</div>

			<div class="mb-3">
				<label for="model" class="form-label">Model</label>
				<input type="text" class="form-control" id="model" name="model" required>
			</div>

			<div class="mb-3">
				<label for="year" class="form-label">Năm sản xuất</label>
				<input type="number" class="form-control" id="year" name="year" required min="1900"
					max="{{ date('Y') + 1 }}">
			</div>

			<div class="mb-3">
				<label for="engine_type" class="form-label">Loại động cơ</label>
				<input type="text" class="form-control" id="engine_type" name="engine_type" required>
			</div>

			<div class="mb-3">
				<label for="seat_capacity" class="form-label">Số ghế</label>
				<input type="number" class="form-control" id="seat_capacity" name="seat_capacity" required>
			</div>

			<div class="mb-3">
				<label for="engine_power" class="form-label">Công suất động cơ</label>
				<input type="text" class="form-control" id="engine_power" name="engine_power" required>
			</div>

			<div class="mb-3">
				<label for="max_speed" class="form-label">Tốc độ tối đa (km/h)</label>
				<input type="number" class="form-control" id="max_speed" name="max_speed" required>
			</div>

			<div class="mb-3">
				<label for="trunk_capacity" class="form-label">Dung tích cốp xe (L)</label>
				<input type="text" class="form-control" id="trunk_capacity" name="trunk_capacity" required>
			</div>

			<div class="mb-3">
				<label for="length" class="form-label">Chiều dài (mm)</label>
				<input type="number" class="form-control" id="length" name="length" required>
			</div>

			<div class="mb-3">
				<label for="width" class="form-label">Chiều rộng (mm)</label>
				<input type="number" class="form-control" id="width" name="width" required>
			</div>

			<div class="mb-3">
				<label for="height" class="form-label">Chiều cao (mm)</label>
				<input type="number" class="form-control" id="height" name="height" required>
			</div>

			<div class="mb-3">
				<label for="description" class="form-label">Mô tả</label>
				<textarea class="form-control" id="description" name="description" rows="4"></textarea>
			</div>

			<!-- Thông tin bán xe -->
			<div class="mb-3">
				<label for="sale_price" class="form-label">Giá bán</label>
				<input type="number" class="form-control" id="sale_price" name="sale_price" required>
			</div>

			<div class="mb-3">
				<label for="quantity" class="form-label">Số lượng</label>
				<input type="number" class="form-control" id="quantity" name="quantity" required>
			</div>

			<div class="mb-3">
				<label for="availability_status" class="form-label">Trạng thái</label>
				<select class="form-control" id="availability_status" name="availability_status">
					<option value="1">Có sẵn</option>
					<option value="0">Hết hàng</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="warranty_period" class="form-label">Thời gian bảo hành (tháng)</label>
				<input type="number" class="form-control" id="warranty_period" name="warranty_period">
			</div>

			<div class="mb-3">
				<label for="sale_conditions" class="form-label">Điều kiện bán</label>
				<textarea class="form-control" id="sale_conditions" name="sale_conditions" rows="3"></textarea>
			</div>

			<!-- Thêm trường Image URL -->
			<div class="mb-3">
				<label for="image_url" class="form-label">URL hình ảnh</label>
				<input type="text" class="form-control" id="image_url" name="image_url" required>
			</div>

			<button type="submit" class="btn btn-primary">Thêm Xe</button>
			<a href="{{ route('Carsales') }}" class="btn btn-secondary">Hủy bỏ</a>
		</form>
	</div>
</div>
@endsection