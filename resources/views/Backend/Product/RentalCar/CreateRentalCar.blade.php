@extends('Backend.dashboard.layout')

@section('content')

    <x-breadcrumbs breadcrumb="rentalCar.create" />

    <div class="container mt-5">
        <h2 class="mb-4">Thêm Xe Thuê Mới</h2>

        <!-- Form Tạo Mới Xe Thuê -->
        <form action="{{route('rentalCar.store')}}" method="POST">
            @csrf
            
            <!-- Chọn Xe từ CarDetails -->
            <div class="mb-3">
                <label for="car_id" class="form-label">Chọn Xe</label>
                <select class="form-select" id="car_id" name="car_id" required>
                    <option value="">-- Chọn xe --</option>
                    @foreach($carDetails as $car)
                        <option value="{{ $car->car_id }}">
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
                <input type="text" class="form-control" id="license_plate_number" name="license_plate_number" required>
                @error('license_plate_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Giá Thuê Mỗi Ngày -->
            <div class="mb-3">
                <label for="rental_price_per_day" class="form-label">Giá thuê mỗi ngày</label>
                <input type="number" step="0.01" class="form-control" id="rental_price_per_day" name="rental_price_per_day" required>
                @error('rental_price_per_day')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <!-- Điều Kiện Thuê -->
            <div class="mb-3">
                <label for="rental_conditions" class="form-label">Điều kiện thuê</label>
                <textarea class="form-control" id="rental_conditions" name="rental_conditions" rows="3"></textarea>
                @error('rental_conditions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nút Lưu -->
            <button type="submit" class="btn btn-primary mr-2">Thêm Xe Thuê</button>
            <a href="{{route('rentalCar')}}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

@endsection
