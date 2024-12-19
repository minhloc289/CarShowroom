@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="rentalCar.edit" />

    <div class="container mt-5">
        <h2 class="mb-4">Chỉnh sửa thông tin thuê xe</h2>

        <form action="{{ route('rentalCar.update', $rentalCar->rental_id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Chọn Xe -->
            <div class="mb-3">
                <label for="car_id" class="form-label">Chọn Xe</label>
                <select class="form-select" id="car_id" name="car_id" required>
                    @foreach($carDetails as $car)
                        <option value="{{ $car->car_id }}" 
                            {{ $rentalCar->car_id == $car->car_id ? 'selected' : '' }}>
                            {{ $car->brand }} - {{ $car->model }} ({{ $car->name }})
                        </option>
                    @endforeach
                </select>
                @error('car_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Biển Số Xe -->
            <div class="mb-3">
                <label for="license_plate_number" class="form-label">Biển số xe</label>
                <input type="text" class="form-control" id="license_plate_number" 
                    name="license_plate_number" value="{{ $rentalCar->license_plate_number }}" required>
                @error('license_plate_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Giá Thuê Mỗi Ngày -->
            <div class="mb-3">
                <label for="rental_price_per_day" class="form-label">Giá thuê mỗi ngày</label>
                <input type="number" step="0.01" class="form-control" id="rental_price_per_day" 
                    name="rental_price_per_day" value="{{ $rentalCar->rental_price_per_day }}" required>
                @error('rental_price_per_day')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tình Trạng -->
            <div class="mb-3">
                <label for="availability_status" class="form-label">Tình trạng</label>
                <select class="form-select" id="availability_status" name="availability_status" required>
                    <option value="Available" {{ $rentalCar->availability_status == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Rented" {{ $rentalCar->availability_status == 'Rented' ? 'selected' : '' }}>Rented</option>
                </select>
            </div>

            <!-- Điều Kiện Thuê -->
            <div class="mb-3">
                <label for="rental_conditions" class="form-label">Điều kiện thuê</label>
                <textarea class="form-control" id="rental_conditions" name="rental_conditions" rows="3">{{ $rentalCar->rental_conditions }}</textarea>
                @error('rental_conditions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nút Lưu -->
            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
            <a href="{{ route('rentalCar') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
