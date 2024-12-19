@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="rentalCar.details" />

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ $carDetail->brand }} - {{ $carDetail->model }}</h1>
        </div>

        <div class="row">
            <!-- Image Section -->
            <div class="col-md-6 text-center">
                <img src="{{ $carDetail->image_url }}" alt="{{ $carDetail->name }}" class="img-fluid rounded">
            </div>
        
            <!-- Details Section -->
            <div class="col-md-6">
                <h2 class="text-xl font-bold">{{ $carDetail->brand }} - {{ $carDetail->model }}</h2>
                <h4 class="text-muted mt-2">{{ $carDetail->name }}</h4>
                
                <!-- Description -->
                <div class="mt-4">
                    <p style="font-size: 1.1rem; font-weight: 600; line-height: 1.6; color: #333;">
                        {{ $carDetail->description ?? 'Mô tả hiện không có.' }}
                    </p>
                </div>
            </div>
        </div>
        

        <hr class="my-5">

        <!-- Additional Details Section -->
        <div class="row">
            <!-- Rental Information Section -->
            <div class="col-md-6 px-4">
                <h3 class="fw-bold mb-3">Rental Information</h3>
                <ul class="list-unstyled" style="font-size: 1.1rem; line-height: 1.8;">
                    <li><strong>Biển số xe:</strong> {{ $rentalCar->license_plate_number }}</li>
                    <li><strong>Tình trạng:</strong> 
                        <span class="{{ $rentalCar->availability_status == 'Available' ? 'text-success' : 'text-danger' }}">
                            {{ $rentalCar->availability_status }}
                        </span>
                    </li>
                    <li><strong>Giá thuê mỗi ngày:</strong>
                        <span class="text-success">{{ number_format($rentalCar->rental_price_per_day, 2) }} VNĐ/ngày</span></li>
                    <li><strong>Điều kiện thuê:</strong> 
                        {{ $rentalCar->rental_conditions ? $rentalCar->rental_conditions : 'Không có' }}
                    </li>
                </ul>
            </div>
        
            <!-- Car Specifications Section -->
            <div class="col-md-6 px-4">
                <h3 class="fw-bold mb-3">Car Specifications</h3>
                <ul class="list-unstyled" style="font-size: 1.1rem; line-height: 1.8;">
                    <li><strong>Loại động cơ:</strong> {{ $carDetail->engine_type }}</li>
                    <li><strong>Số chỗ ngồi:</strong> {{ $carDetail->seat_capacity }}</li>
                    <li><strong>Tốc độ tối đa:</strong> {{ $carDetail->max_speed }} km/h</li>
                    <li><strong>Sức chứa cốp xe:</strong> {{ $carDetail->trunk_capacity }} cubic feet</li>
                </ul>
            </div>
        </div>                
    </div>
</div>
@endsection