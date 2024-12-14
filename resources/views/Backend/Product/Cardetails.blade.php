@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="carsales.details"/>

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
                    <h2 class="text-xl font-bold">{{ $carDetail->name }}</h2>
                    <h3 class="text-2xl font-bold text-primary mt-2">
                        ${{ number_format($salesCar->sale_price, 2) ?? 'N/A' }}
                    </h3>
                    <div class="mt-4">
                        <p class="text-muted">{{ $carDetail->description }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <!-- Additional Details Section -->
            <div class="row">
                <div class="col-md-6">
                    <h4>Car Specifications</h4>
                    <ul class="list-unstyled">
                        <li><strong>Engine Type:</strong> {{ $carDetail->engine_type }}</li>
                        <li><strong>Seats:</strong> {{ $carDetail->seat_capacity }}</li>
                        <li><strong>Max Speed:</strong> {{ $carDetail->max_speed }} km/h</li>
                        <li><strong>Trunk Capacity:</strong> {{ $carDetail->trunk_capacity }} cubic feet</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Sales Information</h4>
                    <ul class="list-unstyled">
                        <li><strong>Availability:</strong> {{ $salesCar->availability_status ? 'Available' : 'Out of Stock' }}</li>
                        <li><strong>Warranty Period:</strong> {{ $salesCar->warranty_period }} months</li>
                        <li><strong>Quantity in Stock:</strong> {{ $salesCar->quantity }}</li>
                        <li><strong>Sale Conditions:</strong> {{ $salesCar->sale_conditions }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
