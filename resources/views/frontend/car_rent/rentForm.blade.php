@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-8">
            {{-- Car Information Section --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                    {{-- Car Image Section --}}
                    <div class="lg:col-span-2 h-[400px] lg:h-[500px] relative group">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-all duration-300"></div>
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                            <h1 class="text-4xl font-bold text-white">{{ $car->name }}</h1>
                            <p class="text-gray-200 mt-2">{{ $car->brand }} - {{ $car->model }}</p>
                        </div>
                    </div>

                    {{-- Quick Info Panel --}}
                    <div class="p-8 bg-white flex flex-col justify-between">
                        <div class="space-y-6">
                            <div class="flex flex-col">
                                <span class="text-gray-500 text-sm uppercase tracking-wider">Daily Rate</span>
                                <span class="text-3xl font-bold text-blue-600">
                                    {{ number_format($rentalCar->rental_price_per_day, 0) }} VNĐ
                                </span>
                            </div>
                    
                            <div class="space-y-4">
                                <div class="flex items-center space-x-2">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-600">24/7 Support</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-600">Free Cancellation</span>
                                </div>
                            </div>
                    
                            <div class="flex items-center space-x-3">
                                <div class="flex text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6-4.8-6 4.8 2.4-7.2-6-4.8h7.6z"/>
                                    </svg>
                                    <span class="ml-2 text-gray-700">4.5/5 (123 reviews)</span>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Thay đổi nút thành nút hấp dẫn hơn -->
                        <a href="#rentForm">
                            <button class="mt-6 w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl font-semibold shadow-lg hover:from-blue-700 hover:to-blue-900 focus:ring-4 focus:ring-blue-200 transition duration-300 ease-in-out transform hover:scale-105">
                                Finalize Your Info & Get Started
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Rental Form Section --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden" id="rentForm">
                <div class="p-8">
                    <div class="flex items-center justify-center space-x-4 mb-8">
                        <div class="h-0.5 w-12 bg-blue-600"></div>
                        <h2 class="text-3xl font-bold text-gray-900">Rental Information</h2>
                        <div class="h-0.5 w-12 bg-blue-600"></div>
                    </div>

                    <form action="#" method="POST" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {{-- Personal Information --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 pb-2 border-b border-gray-200">
                                    Personal Details
                                </h3>
                                
                                <div class="space-y-6">
                                    <div class="relative">
                                        <label for="name" class="text-sm font-medium text-gray-700 block mb-2">Full Name</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </span>
                                            <input type="text" name="name" id="name" required
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                                value="{{ old('name') }}" placeholder="John Doe">
                                        </div>
                                        @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <label for="email" class="text-sm font-medium text-gray-700 block mb-2">Email Address</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                            <input type="email" name="email" id="email" required
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                                value="{{ old('email') }}" placeholder="john@example.com">
                                        </div>
                                        @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <label for="phone" class="text-sm font-medium text-gray-700 block mb-2">Phone Number</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </span>
                                            <input type="tel" name="phone" id="phone" required
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                                value="{{ old('phone') }}" placeholder="+84 123 456 789">
                                        </div>
                                        @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Rental Details --}}
                            <div class="space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 pb-2 border-b border-gray-200">
                                    Rental Details
                                </h3>

                                <div class="space-y-6">
                                    <div class="relative">
                                        <label for="start_date" class="text-sm font-medium text-gray-700 block mb-2">Start Date</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                            <input type="date" name="start_date" id="start_date" required
                                                min="{{ date('Y-m-d') }}"
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                                value="{{ old('start_date', date('Y-m-d')) }}">
                                        </div>
                                        @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <label for="rental_days" class="text-sm font-medium text-gray-700 block mb-2">Number of Days</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                            <input type="number" name="rental_days" id="rental_days" required min="1"
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                                value="{{ old('rental_days', 1) }}" onchange="calculateTotal()">
                                        </div>
                                        @error('rental_days')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <label for="pickup_location" class="text-sm font-medium text-gray-700 block mb-2">Pickup Location</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                            <select name="pickup_location" id="pickup_location" required
                                                class="pl-10 block w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm appearance-none bg-white">
                                                <option value="Trường Đại học Công Nghệ Thông Tin">Trường Đại học Công Nghệ Thông Tin</option>
                                            </select>
                                        </div>
                                        @error('pickup_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Rental Conditions and Total Price --}}
                        <div class="space-y-8 mt-8">
                            {{-- Rental Conditions --}}
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Rental Conditions
                                </h3>
                                <div class="prose prose-sm text-gray-600">
                                    <p id="rental_conditions">{{ $rentalCar->rental_conditions }}</p>
                                </div>
                            </div>

                            {{-- Total Price Card --}}
                            <div class="bg-gradient-to-r from-[#3279CB] to-[#2A5ABA] rounded-xl p-6 shadow-xl">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-blue-100 text-sm uppercase tracking-wide">Total Price</p>
                                        <div class="flex items-baseline mt-1">
                                            <span id="total_price" class="text-white text-3xl font-bold">
                                                {{ number_format($rentalCar->rental_price_per_day, 0) }}
                                            </span>
                                            <span class="text-blue-100 ml-1">VNĐ</span>
                                        </div>
                                        <input type="hidden" id="price_per_day" value="{{ $rentalCar->rental_price_per_day }}">
                                    </div>
                                    <div class="hidden md:block">
                                        <img src="/assets/img/secure-payment.png" alt="Secure Payment" class="h-16 w-auto">
                                    </div>
                                </div>
                            </div>

                            {{-- Terms and Conditions --}}
                            <div class="flex items-start space-x-3 bg-white p-4 rounded-xl border border-gray-200">
                                <div class="flex items-center h-6">
                                    <input id="terms" name="terms" type="checkbox" required
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                </div>
                                <div class="text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I agree to the Terms and Conditions
                                    </label>
                                    <p class="text-gray-500">
                                        By checking this box, you agree to our
                                        <a href="#" class="text-blue-600 hover:text-blue-500 font-semibold">Terms of Service</a>
                                        and
                                        <a href="#" class="text-blue-600 hover:text-blue-500 font-semibold">Privacy Policy</a>
                                    </p>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit"
                                class="w-full flex justify-center items-center px-8 py-4 text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-[#3279CB] to-[#2A5ABA] shadow-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Confirm Rental Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add JavaScript for calculating total price --}}
<script>
    function calculateTotal() {
        const days = document.getElementById('rental_days').value;
        const pricePerDay = {{ $rentalCar->rental_price_per_day }};
        const total = days * pricePerDay;
        document.getElementById('total_price').textContent = new Intl.NumberFormat('vi-VN').format(total);
    }
</script>
@endsection