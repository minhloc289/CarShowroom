@extends('frontend.layouts.App')

@section('content')

<div class="bg-white">

        <!-- Mục Giới thiệu -->
        <div class="w-screen relative mb-12">
            <!-- Hình ảnh -->
            <img src="assets/img/Porsche-Wallpaper.jpg" 
                alt="Merus" 
                class="w-screen h-[400px] object-cover">

            <!-- Phần chữ -->
            <div class="absolute bottom-0 left-0 w-full p-8 bg-gradient-to-t from-black to-transparent">
                <div class="text-white max-w-lg">
                    <h1 class="text-4xl font-bold mb-4">MERUS</h1>
                    <p class="text-lg">
                        Cuộc sống là hành trình không ngừng bứt phá để chinh phục tầm cao. Merus không ngừng đột phá với đường nét thiết kế thể thao cá tính, công nghệ tiên tiến để cùng chủ nhân vươn xa trên hành trình kiến tạo thành công mới.
                    </p>
                </div>
            </div>
        </div>
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">  
        <div class="flex items-center justify-between mb-8">
            <!-- Phần danh mục xe và ô tìm kiếm -->
            <div class="flex items-center w-1/2">
                <!-- Dropdown Danh mục xe -->
                <button id="accessories-dropdown-button" data-dropdown-toggle="accessories-dropdown-menu" 
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-gray-800 border border-black rounded-l-lg rounded-r-none hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-600">
                    Danh mục xe
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
            
                <!-- Dropdown Menu -->
                <div id="accessories-dropdown-menu" class="z-10 hidden bg-gray-800 divide-y divide-gray-700 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-white" aria-labelledby="accessories-dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Nội thất">Nội thất</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Ngoại thất">Ngoại thất</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-category="Chăm sóc xe">Chăm sóc xe</button>
                        </li>
                    </ul>
                </div>
    
                <!-- Search Input -->
                <div class="relative w-full ml-2">
                    <input type="search" id="search-accessories" 
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-200 border border-black rounded-l-none focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" 
                        placeholder="Tìm kiếm sản phẩm" required />
                    <button type="submit" id="search-accessories-button" 
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-black rounded-r-lg border border-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-500">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        
            <!-- Phần sắp xếp -->
            <div class="flex items-center w-1/3 justify-end">
                <!-- Label "Sắp xếp" -->
                <label for="sort-dropdown-button" class="text-sm font-medium text-gray-700 mr-2">Sắp xếp</label>

                <!-- Dropdown Sắp xếp -->
                <button id="sort-dropdown-button" data-dropdown-toggle="sort-dropdown-menu"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-gray-800 border border-black rounded-l-lg hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-600">
                    Mới nhất
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="sort-dropdown-menu" class="z-10 hidden bg-gray-800 divide-y divide-gray-700 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-white" aria-labelledby="sort-dropdown-button">
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-sort="newest">Mới nhất</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-sort="low-high">Giá: Thấp - Cao</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 bg-gray-800 text-white hover:bg-gray-500 hover:text-white focus:bg-gray-500" data-sort="high-low">Giá: Cao - Thấp</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    
        <!-- Danh sách sản phẩm -->
        <h2 class="sr-only">Products</h2>
  
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8 mt-12">
            @foreach ($accessories as $accessory)
                <div class="p-4 rounded-lg" style="background-color: #E5E7EB;"> <!-- Nền xám cố định -->
                    <a href="#" class="block">
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

</div>
<script src="{{asset('/assets/js/custom/accessories.js')}}"></script>
<link rel="stylesheet" href="{{asset('/assets/css/accessories.css')}}">
@endsection
