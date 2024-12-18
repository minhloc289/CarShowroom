@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="carsales.create" />

<div class="container">
	<h2>Thêm Dữ Liệu Xe Từ File Excel</h2>

	<!-- Liên kết tải về file mẫu -->
	<div class="mb-3">
		<a href="{{ route('caradd.download.template')}}" class="btn btn-secondary" download>
			Tải về file mẫu Excel
		</a>
	</div>

	<!-- Form tải lên file Excel -->
	<form action="{{ route('cars.import') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label for="file">Chọn file Excel</label>
			<input type="file" class="form-control" id="file" name="file" required>
		</div>

		<button type="submit" class="btn btn-primary mt-3">Tải lên và Thêm Xe</button>
	</form>

	<div class="alert alert-info mt-3">
		<p><strong>Hướng dẫn:</strong></p>
		<ul>
			<li>1. Tải về file mẫu Excel bằng cách nhấn vào nút <strong>"Tải về file mẫu Excel"</strong>.</li>
			<li>2. Điền thông tin xe vào file Excel theo đúng định dạng.</li>
			<li>3. Chọn file Excel đã hoàn thành và nhấn <strong>"Tải lên và Thêm Xe"</strong>.</li>
		</ul>
	</div>
</div>
@endsection