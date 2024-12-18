@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="accessories.details" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <!-- Image Section (40%) -->
            <div class="col-md-4 text-center">
                <img src="{{ $accessory->image_url }}" alt="{{ $accessory->name }}" 
                     class="img-fluid rounded" style="max-width: 100%; height: auto;">
            </div>

            <!-- Details Section (60%) -->
            <div class="col-md-6">
                <h2 class="font-baloo" style="font-family: 'Baloo 2', cursive; font-size: 2rem; font-weight: bold;">
                    {{ $accessory->name }}</h2>
                <h3 class="text-3xl font-bold text-primary mt-2">
                    {{ number_format($accessory->price) }} VNĐ
                </h3>
                <div class="mt-4">
                    <p class="text-muted">{{ $accessory->description }}</p>
                </div>

                <!-- Additional Details Section (ngay dưới description) -->
                <div class="mt-4" style= "font-size: 1.25 rem">
                    <h4 style="margin-bottom: 6px;">Các thông tin khác của phụ kiện</h4>
                    <ul class="list-unstyled">
                        <li><strong>Phân loại:</strong> {{ $accessory->category }}</li>
                        <li><strong>Số lượng:</strong> {{ $accessory->quantity }}</li>
                        <li><strong>Trạng thái:</strong> 
                            {{ $accessory->status === 'Available' ? 'Available' : 'Out of Stock' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
