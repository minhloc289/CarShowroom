@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="carsales.create" />

<div class="container">
	<h2>Thêm Dữ Liệu Xe Từ File Excel</h2>

	<!-- Liên kết tải về file mẫu -->
	<div class="mb-3">
		<a href="{{ asset('public\assets\excel\caradd.xlsx') }}" class="btn btn-secondary" download>
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
</div>
@endsection