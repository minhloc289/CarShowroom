@extends('frontend.layouts.app')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('account')->user();
@endphp
@section('content')
<script src="{{ asset('/assets/js/custom/accessories_detail.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/assets/css/accessories_detail.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased mt-6 md:mt-8">
    <div class="flex items-center justify-between py-4 px-10 pb-8 text-base">
        <!-- Breadcrumb -->
        <div>
            <a href="/accessories" class="text-white hover:text-gray-400">Accessories</a>
            <span class="mx-2 text-white">/</span>
            <span class="text-gray-300">Accessories Detail</span>
        </div>
    
        <!-- Cart Button -->
        <div>
            <a href="{{ route('show.cart') }}">
                <button type="button" id="cart-button" 
                    class="relative bg-white border border-gray-300 text-gray-800 p-2 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-200 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h14M9 17a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center" id="cart-count">
                        0
                    </span>
                </button>
            </a>
        </div>      
    </div>
    
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <!-- Image -->
            <div class="shrink-0 max-w-md lg:max-w-lg mx-auto relative overflow-hidden">
                <div class="relative w-full h-full group">
                    <img class="w-full object-cover" 
                        src="{{ $accessory->image_url }}" 
                        alt="{{ $accessory->name }}" />
                </div>
            </div>

            <!-- Details -->
            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ $accessory->name }}
                </h1>
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p id="accessory-price" class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white" data-price="{{ $accessory->price }}">
                        {{ number_format($accessory->price, 0, ',', '.') }} VND
                    </p>
                </div>

                <!-- Quantity -->
                <div class="mt-6">
                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Chọn số lượng
                    </label>
                    <div class="flex items-center space-x-2">
                        <!-- Nút giảm số lượng -->
                        <button id="decrease" type="button" 
                            class="w-10 h-10 bg-blue-600 border border-blue-700 text-white flex items-center justify-center hover:bg-blue-700 rounded-l-[5px]">
                            -
                        </button>
                        <!-- Hiển thị số lượng -->
                        <input id="quantity" type="text" value="1" readonly class="w-16 h-10 text-center border border-gray-300 bg-gray-100 text-gray-900 focus:outline-none">
                        <!-- Nút tăng số lượng -->
                        <button id="increase" type="button" 
                            class="w-10 h-10 bg-blue-600 border border-blue-700 text-white flex items-center justify-center hover:bg-blue-700 rounded-r-[5px]">
                            +
                        </button>
                    </div>
                    
                </div>

                <!-- Total Price -->
                <div class="mt-4">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tổng tiền: 
                        <span id="total-price" class="text-blue-600 ml-2">
                            {{ number_format($accessory->price, 0, ',', '.') }} VND
                        </span>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <a href="#" class="text-white mt-4 sm:mt-0 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-400 flex items-center justify-center space-x-2">
                        Buy now
                    </a>

                    <!-- Update this link to a button that triggers add to cart -->
                        <button 
                            id="add-to-cart-button"
                            data-accessory-id="{{ $accessory->accessory_id }}"
                            class="text-white mt-4 sm:mt-0 bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 flex items-center justify-center space-x-2">
                            <!-- Cart Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h14M9 17a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                            <span>Add to cart</span>
                        </button>
                </div>

                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <!-- Description -->
                <p class="mb-6 text-gray-500 dark:text-gray-400">
                    {{ $accessory->description }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
