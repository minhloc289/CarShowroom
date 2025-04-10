@extends('frontend.layouts.App')

@section('content')
    <script src="{{asset('assets/js/custom/rentCar.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/rentCar.css')}}">
    <!-- Main Container - Subtle luxury gradient background -->
    <div class="relative min-h-screen py-10" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%, #f8fafc 100%);">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-gray-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>

        <!-- Banner Section -->
        <div class="container mx-auto px-4 relative">
            <div class="relative overflow-hidden bg-gradient-to-r from-gray-900 via-gray-800 to-blue-900 shadow-2xl rounded-2xl p-12 mb-10">
                <!-- Luxury Pattern Overlay -->
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <div class="flex items-center justify-between relative">
                    <!-- Left Text Section -->
                    <div class="max-w-lg">
                        <h1 class="text-5xl font-bold text-white mb-6 leading-tight">
                            The Ultimate Luxury <br> <span class="text-blue-400">Car Rental Experience</span>
                        </h1>
                        <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                            Elevate your journey with our premium car rental services, featuring a curated fleet of luxury vehicles tailored to fulfill every need – from business engagements to grand occasions and unforgettable experiences.
                        </p>
                        <div class="mt-8 flex space-x-6">
                            <a href="#carsContainer"
                                class="bg-white text-gray-900 px-8 py-4 rounded-lg hover:bg-gray-100 transition-all duration-300 font-semibold text-lg shadow-lg hover:shadow-xl">
                                Explore the collection
                            </a>
                        </div>
                    </div>
                    <!-- Right Image Section -->
                    <div class="w-1/2 relative">
                        <div class="absolute -top-20 -right-20 w-96 h-96 bg-blue-500/20 rounded-full mix-blend-overlay filter blur-3xl"></div>
                        <img src="https://porsche-vietnam.vn/wp-content/uploads/2023/02/982-718-bo-se-modelimage-sideshot-840x473.png"
                            alt="Luxury Car" 
                            class="relative z-10 rounded-lg object-contain transform hover:scale-105 transition duration-500 drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>

        
        <div class="container mx-auto px-4">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold text-gray-800">Premium Car Collection</h1>
                <!-- Search and Dropdown Container -->
                <div class="flex items-center gap-4">
                    <!-- Search Bar -->
                    <div class="relative w-72">
                        <input type="text" id="carSearchInput" placeholder="Search by name, brand, or year..."
                            class="w-full py-3 pl-12 pr-4 rounded-lg bg-white border border-gray-200 shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-3 left-3 h-6 w-6 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
            
                    <!-- Dropdown Sort -->
                    <div class="relative">
                        <select id="sortSelect" class="w-48 py-3 pl-4 pr-10 rounded-lg bg-white border border-gray-200 shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="all">All</option>
                            <option value="brand-asc">Brand: A to Z</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
            
            

            <!-- Cars Grid -->
            <div id="carsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($rental_car as $car)
                    @if ($car->rentalCars->isNotEmpty())
                        @foreach ($car->rentalCars as $rentalCar)
                            @if ($rentalCar->availability_status === 'Available') <!-- Chỉ hiển thị xe có trạng thái 'Available' -->
                                <div class="car-item bg-white/80 backdrop-blur-sm border border-gray-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                                    <!-- Header Information -->
                                    <div class="h-16 text-center">
                                        <h2 class="text-lg font-bold text-gray-800 mb-1">{{ $car->name }}</h2>
                                        <p class="text-sm text-gray-600 mb-1">{{ $car->brand }} - {{ $car->model }}</p>
                                        <p class="text-xs text-gray-500">Year: {{ $car->year }}</p>
                                    </div>
                                    
                                    <!-- Car Image -->
                                    <div class="h-32 flex items-center justify-center my-4">
                                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" 
                                            class="max-h-full w-auto rounded-lg transform hover:scale-105 transition duration-300">
                                    </div>
                                    
                                    <!-- Specifications -->
                                    <div class="h-20 space-y-1">
                                        <p class="text-gray-700 flex items-center justify-center gap-2 text-sm">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            Seats: {{ $car->seat_capacity }}
                                        </p>
                                        <p class="text-gray-700 flex items-center justify-center gap-2 text-sm">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                            </svg>
                                            Max Speed: {{ $car->max_speed }} km/h
                                        </p>
                                    </div>
            
                                    <!-- Rental Information -->
                                    <div class="h-24 mt-2 space-y-1 text-center">
                                        <div class="text-sm space-y-2">
                                            <p class="text-gray-600">License plates: {{ $rentalCar->license_plate_number }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ number_format($rentalCar->rental_price_per_day, 0) }} VNĐ/day</p>
                                            <p>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Ready
                                                </span>
                                            </p>
                                        </div>
                                    </div>
            
                                    <!-- Action Button -->
                                    <div class="flex justify-center gap-4 mt-4" id="app" data-authenticated="{{ auth('account')->check() ? 'true' : 'false' }}">
                                        <!-- Rent Now Button -->
                                        <a href="#"
                                            class="w-1/2 py-3 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300 text-center font-medium rent-now-button"
                                            data-car-id="{{ $rentalCar->car_id }}">
                                            Rent Now
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>            
        </div>

        <!-- Modal Xác Nhận -->
        <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Rental</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to rent this car?</p>
                <div class="flex justify-end gap-4">
                    <button id="cancelButton"
                        class="py-2 px-4 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors duration-300">
                        Cancel
                    </button>
                    <button id="confirmButton"
                        class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection