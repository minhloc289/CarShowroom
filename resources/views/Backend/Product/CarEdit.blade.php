@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="carsales.edit" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <h1>Chỉnh sửa thông tin xe: {{ $carDetail->name }}</h1>

        <!-- Hiển thị thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form chỉnh sửa -->
        <form action="{{ route('car.update', $carDetail->car_id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Thông tin từ bảng car_details -->
            <div class="mb-3">
                <label for="brand" class="form-label">Thương hiệu</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ $carDetail->brand }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Tên xe</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $carDetail->name }}" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $carDetail->model }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Link_image_url</label>
                <input type="text" class="form-control" id="image_url" name="image_url"
                    value="{{ $carDetail->image_url }}" required>
            </div>
            <div class="mb-3">
                <label for="engine_type" class="form-label">Loại động cơ</label>
                <input type="text" class="form-control" id="engine_type" name="engine_type"
                    value="{{ $carDetail->engine_type }}" required>
            </div>

            <div class="mb-3">
                <label for="seat_capacity" class="form-label">Số ghế</label>
                <input type="number" class="form-control" id="seat_capacity" name="seat_capacity"
                    value="{{ $carDetail->seat_capacity }}" required>
            </div>

            <div class="mb-3">
                <label for="engine_power" class="form-label">Công suất động cơ</label>
                <input type="text" class="form-control" id="engine_power" name="engine_power"
                    value="{{ $carDetail->engine_power }}" required>
            </div>

            <div class="mb-3">
                <label for="max_speed" class="form-label">Tốc độ tối đa (km/h)</label>
                <input type="number" class="form-control" id="max_speed" name="max_speed"
                    value="{{ $carDetail->max_speed }}" required>
            </div>

            <div class="mb-3">
                <label for="trunk_capacity" class="form-label">Dung tích cốp xe (L)</label>
                <input type="text" class="form-control" id="trunk_capacity" name="trunk_capacity"
                    value="{{ $carDetail->trunk_capacity }}" required>
            </div>

            <div class="mb-3">
                <label for="length" class="form-label">Chiều dài (mm)</label>
                <input type="number" class="form-control" id="length" name="length" value="{{ $carDetail->length }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="width" class="form-label">Chiều rộng (mm)</label>
                <input type="number" class="form-control" id="width" name="width" value="{{ $carDetail->width }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Chiều cao (mm)</label>
                <input type="number" class="form-control" id="height" name="height" value="{{ $carDetail->height }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description"
                    rows="4">{{ $carDetail->description }}</textarea>
            </div>

            <!-- Thông tin từ bảng sales_cars -->
            <div class="mb-3">
                <label for="sale_price" class="form-label">Giá bán</label>
                <input type="number" class="form-control" id="sale_price" name="sale_price"
                    value="{{ $salesCar->sale_price ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="{{ $salesCar->quantity ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="availability_status" class="form-label">Trạng thái</label>
                <select class="form-control" id="availability_status" name="availability_status">
                    <option value="1" {{ $salesCar->availability_status == 1 ? 'selected' : '' }}>Có sẵn</option>
                    <option value="0" {{ $salesCar->availability_status == 0 ? 'selected' : '' }}>Hết hàng</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="warranty_period" class="form-label">Thời gian bảo hành (tháng)</label>
                <input type="number" class="form-control" id="warranty_period" name="warranty_period"
                    value="{{ $salesCar->warranty_period ?? '' }}">
            </div>

            <div class="mb-3">
                <label for="sale_conditions" class="form-label">Điều kiện bán</label>
                <textarea class="form-control" id="sale_conditions" name="sale_conditions"
                    rows="3">{{ $salesCar->sale_conditions ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('Carsales') }}" class="btn btn-secondary">Hủy bỏ</a>
        </form>
    </div>
</div>
@endsection