@extends('frontend.layouts.App')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<script src="{{asset('/assets/js/custom/accessories.js')}}"></script>
<link rel="stylesheet" href="{{asset('/assets/css/accessories.css')}}"> 
<div class="bg-white"> 
    <div class="w-screen h-[700px] relative flex items-center bg-gradient-to-r from-white via-gray-300 to-black">
        <!-- Text Section -->
        <div class="text-container absolute left-0 w-2/5 h-full flex items-center justify-center p-8 ">
            <div class="text-black max-w-lg">
                <h1 class="text-4xl font-bold mb-4">MERUS ACCESSORIES</h1>
                <p class="text-lg mb-6">
                    Welcome to Merus Accessories, where you can find everything to elevate your driving experience.
                    With the perfect combination of modern design, durable materials, and advanced technology, our accessories are crafted to provide comfort, safety, and style for you and your beloved vehicle.
                </p>
                <a href="#accessories-dropdown-button" class="find-more-btn bg-blue-600 text-white text-sm font-medium px-6 py-3 hover:bg-blue-700 transition">
                    Find more
                </a>
            </div>
        </div>

        <!-- Image Section -->
        <div class="image-container absolute right-0 w-3/5 h-full">
            <img src="assets/img/Khothietke.net-PNG-02652.png" 
                alt="Merus" 
                class="w-full h-full object-contain animate-car">
        </div>
    </div>
    <div class="mx-auto max-w-full px-4 py-16 sm:px-6 sm:py-24 lg:max-w-[90%] lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <!-- Category and Search Bar -->
            <div class="flex items-center w-1/2">
                <!-- Accessories Category Dropdown -->
                <button id="accessories-dropdown-button" data-dropdown-toggle="accessories-dropdown-menu" 
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-gray-800 border border-black rounded-l-lg rounded-r-none hover:bg-gray-500 focus:ring-1 focus:outline-none focus:ring-gray-600">
                    Accessories Category
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
            
                <!-- Dropdown Menu -->
                <div id="accessories-dropdown-menu" class="z-10 hidden bg-gray-800 divide-y divide-gray-700 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-white" aria-labelledby="accessories-dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Interior">Interior</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Exterior">Exterior</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Car Care">Car Care</button>
                        </li>
                    </ul>
                </div>
        
                <!-- Search Input -->
                <div class="relative w-full ml-2">
                    <input type="search" id="search-accessories" 
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-100 border border-black rounded-l-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" 
                        placeholder="Search for a product?" required />
                    <button type="submit" id="search-accessories-button" 
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-black rounded-r-lg hover:bg-gray-800 focus:outline-none focus:ring-gray-500">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        
            <!-- Sorting and Cart -->
            <div class="flex items-center space-x-8">
                <!-- Sorting -->
                <div class="flex items-center">
                    <label for="sort-dropdown-button" class="text-sm font-medium text-gray-700 mr-2">Sort</label>
                    <button id="sort-dropdown-button" data-dropdown-toggle="sort-dropdown-menu"
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-gray-800 border border-black rounded-l-lg hover:bg-gray-500 focus:ring-1 focus:outline-none focus:ring-gray-600">
                        Newest
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                </div>

                <!-- Dropdown Menu -->
                <div id="sort-dropdown-menu" class="z-10 hidden bg-gray-800 divide-y divide-gray-700 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-white" aria-labelledby="sort-dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500" data-sort="newest">Newest</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500" data-sort="low-high">Price: Low - High</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500" data-sort="high-low">Price: High - Low</button>
                        </li>
                    </ul>
                </div>
        
                <!-- Product Count -->
                    <div>
                        <p class="text-sm text-gray-700">
                            Displaying <span id="product-count" class="font-bold"></span><span id="total-products" class="font-bold"></span>
                        </p>
                    </div>
        
                <!-- Cart Button -->
                <div>
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
        </div>
        
    
        <!-- Product List -->
        <h2 class="sr-only">Products</h2>
  
        <div id="product-list" class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8 mt-12">
            @foreach ($accessories as $accessory)
                <div class="p-4 rounded-lg bg-whitesmoke hover:text-blue-700 transition"> <!-- Fixed gray background -->
                    <a href="{{ route('accessory.show', ['id' => $accessory->accessory_id]) }}" class="block">
                        <img src="{{ $accessory->image_url }}" 
                            alt="{{ $accessory->name }}" 
                            class="aspect-square w-full rounded-lg object-cover">
                        <h3 class="mt-4 text-sm text-gray-700">{{ $accessory->name }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ number_format($accessory->price, 0, ',', '.') }} VND</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Load More Button -->
    <div class="flex justify-center mt-8">
        <button id="load-more" class="text-blue-600 text-lg underline hover:text-blue-800 focus:outline-none">
            Load more products
        </button>
    </div>

</div>
<script src="{{asset('/assets/js/custom/accessories.js')}}"></script>
<link rel="stylesheet" href="{{asset('/assets/css/accessories.css')}}">
@endsection
