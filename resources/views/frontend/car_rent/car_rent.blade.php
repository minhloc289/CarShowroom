@extends('frontend.layouts.App')

@section('content')
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
                            <a href="#"
                                class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white/10 transition-all duration-300 text-lg">
                                Detailed consultation
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

        <!-- Header Section -->
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800">Premium Car Collection</h1>
                <div class="relative w-1/3">
                    <input type="text" id="carSearchInput" placeholder="Tìm kiếm xe..."
                        class="w-full py-4 pl-12 pr-4 rounded-lg bg-white/80 backdrop-blur-sm border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-lg transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-4 left-4 h-6 w-6 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Cars Grid -->
            <div id="carsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($rental_car as $car)
                    <div class="car-item bg-white/80 backdrop-blur-sm border border-gray-100 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300">
                        <!-- Header Information - Fixed Height -->
                        <div class="h-24 text-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $car->name }}</h2>
                            <p class="text-lg text-gray-600 mb-1">{{ $car->brand }} - {{ $car->model }}</p>
                            <p class="text-sm text-gray-500">Year: {{ $car->year }}</p>
                        </div>

                        <!-- Car Image - Fixed Height Container -->
                        <div class="h-48 flex items-center justify-center my-6">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" 
                                class="max-h-full w-auto rounded-lg transform hover:scale-105 transition duration-300">
                        </div>

                        <!-- Specifications - Fixed Height -->
                        <div class="h-24 space-y-3">
                            <p class="text-gray-700 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <span class="min-w-[100px] text-center">Seats: {{ $car->seat_capacity }}</span>
                            </p>
                            <p class="text-gray-700 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                <span class="min-w-[100px] text-center">{{ $car->max_speed }} km/h</span>
                            </p>
                        </div>

                        <!-- Rental Information - Fixed Height -->
                        <div class="h-32 mt-4">
                            @if ($car->rentalCars->isNotEmpty())
                                @foreach ($car->rentalCars as $rentalCar)
                                    <div class="space-y-2">
                                        <p class="text-gray-600 text-center">License plates: {{ $rentalCar->license_plate_number }}</p>
                                        <p class="text-2xl font-bold text-gray-900 text-center">
                                            {{ number_format($rentalCar->rental_price_per_day, 0) }} VNĐ/day
                                        </p>
                                        <p class="text-center">
                                            @if ($rentalCar->availability_status === 'Available')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    Ready
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                    Rented
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-red-500 font-medium text-center">There is no rental information at this time.</p>
                            @endif
                        </div>

                        <!-- Action Button - Fixed Position -->
                        <div class="mt-6">
                            <a href="#" 
                            class="block w-full py-3 px-4 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors duration-300 text-center font-medium">
                                View details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center px-8 py-4 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-all duration-300 text-lg font-medium group">
                View more
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
@endsection
