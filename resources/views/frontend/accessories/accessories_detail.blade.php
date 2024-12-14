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

<section class="py-0 bg-white md:py-0 antialiased mt-0 md:mt-0">
    <div class="flex items-center justify-between py-4 px-10 pb-8 text-base bg-gray-100">
        <!-- Breadcrumb -->
        <div class="mr-4 mt-4"> <!-- Thêm margin-top để thụt xuống -->
            <a href="/accessories" class="text-black hover:text-gray-400 font-bold">Accessories </a>
            <span class="mx-2 text-black">/</span>
            <span class="text-blue-600 font-bold">Accessories Detail</span>
        </div>
    
        <!-- Cart Button -->
        <div class="ml-4 mt-4"> <!-- Thêm margin-top để thụt xuống -->
            <a href="{{ route('show.cart') }}">
                <button type="button" id="cart-button" 
                    class="relative bg-white border border-gray-300 text-gray-800 p-2 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-200 shadow-md">
                    <!-- Icon trái tim với màu đen -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="#000000" viewBox="0 0 24 24" stroke="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1 21.7c-.3.2-.8.2-1.1 0-4.5-2.8-9.2-6.2-9.2-10.8 0-2.6 2.1-4.7 4.7-4.7 1.7 0 3.3.9 4.2 2.3.9-1.4 2.5-2.3 4.2-2.3 2.6 0 4.7 2.1 4.7 4.7 0 4.5-4.7 8-9.2 10.8z"></path>
                    </svg>
                    <!-- Bộ đếm -->
                    <span class="absolute top-0 right-0 bg-blue-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center" id="cart-count">
                        0
                    </span>
                </button>
            </a>
        </div>
    </div>
    
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16 py-8">
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
                <h1 class="text-xl font-semibold text-black sm:text-2xl dark:text-black">
                    {{ $accessory->name }}
                </h1>
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p id="accessory-price" class="text-2xl font-extrabold text-black sm:text-3xl dark:text-black" data-price="{{ $accessory->price }}">
                        {{ number_format($accessory->price, 0, ',', '.') }} VND
                    </p>
                </div>

                <!-- Quantity -->
                <div class="mt-6">
                    <label for="quantity" class="block mb-2 text-sm font-medium text-black dark:text-black">
                        Choose quantity
                    </label>
                    <div class="flex items-center space-x-2">
                        <!-- Nút giảm số lượng -->
                        <button id="decrease" type="button" 
                            class="w-10 h-10 bg-black border border-blue-700 text-white flex items-center justify-center hover:bg-blue-700 rounded-l-[5px]">
                            -
                        </button>
                        <!-- Hiển thị số lượng -->
                        <input id="quantity" type="text" value="1" readonly class="w-16 h-10 text-center border border-gray-300 bg-gray-100 text-black focus:outline-none">
                        <!-- Nút tăng số lượng -->
                        <button id="increase" type="button" 
                            class="w-10 h-10 bg-black border border-blue-700 text-white flex items-center justify-center hover:bg-blue-700 rounded-r-[5px]">
                            +
                        </button>
                    </div>
                    
                </div>

                <!-- Total Price -->
                <div class="mt-4">
                    <p class="text-lg font-semibold text-black dark:text-black">
                        Total price: 
                        <span id="total-price" class="text-blue-600 ml-2">
                            {{ number_format($accessory->price, 0, ',', '.') }} VND
                        </span>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                
                    <!-- Update this link to a button that triggers add to cart -->
                    <button 
                        id="add-to-cart-button"
                        data-accessory-id="{{ $accessory->accessory_id }}"
                        class="text-black mt-4 sm:mt-0 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-400 flex items-center justify-center space-x-2">
                        <!-- Heart Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1 21.7c-.3.2-.8.2-1.1 0-4.5-2.8-9.2-6.2-9.2-10.8 0-2.6 2.1-4.7 4.7-4.7 1.7 0 3.3.9 4.2 2.3.9-1.4 2.5-2.3 4.2-2.3 2.6 0 4.7 2.1 4.7 4.7 0 4.5-4.7 8-9.2 10.8z"></path>
                        </svg>
                        <span>Add to wishlist</span>
                    </button>
                </div>

                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <!-- Description -->
                <p class="mb-6 text-black dark:text-black">
                    {{ $accessory->description }}
                </p>
            </div>
        </div>
    </div>

    <!-- Overlay thông báo -->
    <div id="notification-overlay" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg p-6 shadow-lg text-center">
            <!-- Icon dấu tích xanh lá mới -->
            <div class="mb-4 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" viewBox="0 0 448 512">
                    <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                </svg>
            </div>
            <!-- Thông báo -->
            <p id="notification-message" class="text-lg font-bold text-green-600"></p>
        </div>
    </div>    
</section>
@endsection
