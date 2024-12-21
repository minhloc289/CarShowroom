@extends('frontend.layouts.App')

@section('content')
<div class="max-w-6xl mx-auto pt-10">
    <!-- Title and Subtitle -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-semibold">Compare Car</h1>
        <p class="text-gray-600 text-xl">Please select 2 cars to compare.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Selection Box 1 -->
        <div id="selectionBox1" 
             onclick="toggleModal(true)" 
             class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 cursor-pointer">
            <span class="text-4xl text-gray-500">+</span>
            <span class="mt-2 text-gray-700">Choose a car</span>
        </div>
    
        <!-- Selection Box 2 -->
        <div id="selectionBox2" 
             onclick="toggleModal(true)" 
             class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 cursor-pointer">
            <span class="text-4xl text-gray-500">+</span>
            <span class="mt-2 text-gray-700">Choose a car</span>
        </div>
    </div>
    
</div>
    {{-- Popup --}}
<div id="carModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-[1050]">
    <!-- Tăng kích thước modal -->
    <div class="bg-white w-4/5 max-w-4xl max-h-[90vh] p-8 rounded-lg shadow-lg relative overflow-y-auto">
        <!-- Dấu "X" lớn hơn -->
        <button onclick="toggleModal(false)" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl font-bold">&times;</button>

        <!-- Tiêu đề -->
        <h2 class="text-3xl font-semibold mb-6 text-center">Chọn tối đa 2 xe để so sánh</h2>

        <!-- Nội dung -->
        <div class="bg-gray-50 p-6 rounded-lg space-y-8">
            @foreach($carsByBrand as $brand => $cars)
                <div>
                    <!-- Hiển thị tên thương hiệu -->
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b">{{ $brand }}</h3>
                    
                    <!-- Xe hiển thị trên cùng 1 hàng -->
                    <div class="grid grid-cols-3 gap-6">
                        @foreach($cars as $car)
                            <label class="flex items-center bg-white p-3 rounded-md shadow hover:shadow-md transition duration-150">
                                <input type="checkbox" class="form-checkbox text-blue-600 w-5 h-5 mr-3" value="{{ $car->id }}" data-image="{{ $car->image_url }} "speed="{{ $car->max_speed }} "seat="{{ $car->seat_capacity }} "power="{{ $car->engine_power }} "trunk="{{ $car->trunk_capacity }} 
                                   "length="{{ $car->length }} "width="{{ $car->width }} "height="{{ $car->height   }}  
                                           "acceleration_time="{{ $car->acceleration_time }} "fuel_efficiency="{{ $car->fuel_efficiency }} "torque="{{ $car->torque }} "price="{{ optional($car->sale)->sale_price ?? 'Price not available' }} "onchange="getSelectedCars()">
                                <span class="text-base font-medium text-gray-800">
                                    {{ $car->name }} {{ $car->model }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Nút chọn xe -->
        <div class="mt-8 text-center">
            <button onclick="toggleModal(false); choose_car()" class="px-10 py-4 bg-green-700 text-white text-lg rounded-lg hover:bg-green-800 transition duration-200">Chọn xe</button>
        </div>
    </div>
</div>


<div class="max-w-4xl mx-auto bg-white p-4 rounded-lg shadow">
    <div class="flex items-center justify-between border-b border-gray-300">
        <div class="flex w-full">
            <button onclick="showTab('car1')" id="tabCar1" class="flex-1 text-center text-gray-600 font-semibold pb-2 border-b-2 border-transparent focus:outline-none">
                <span class="Car1"></span>
            </button>
            <button onclick="showTab('car2')" id="tabCar2" class="flex-1 text-center text-gray-600 font-semibold pb-2 border-b-2 border-transparent focus:outline-none">
                <span class="Car2"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Left Column: Chart -->
                @include('frontend.compareCar.chart_compare')
        <!-- Right Column: Tab Content -->
        <div>
            <div id="contentCar1" class="p-4 hidden">
                <h2 id="tit" class="text-2xl font-bold">Select cars to compare</h2>
                <ul class="list-disc pl-5 text-gray-700 mt-2">
                </ul>
            </div>

            <div id="contentCar2" class="p-4">
                <h2 class="text-2xl font-bold">Select cars to compare</h2>
                <ul class="list-disc pl-5 text-gray-700 mt-2">
                </ul>
            </div>
        </div>
    </div>
</div>


{{--------------------------------------- Design Card ----------------------------------------------------------}}
<div class="Card bg-gray-100 p-10 m-10 ">

    <div class="text-center">
        <h1 class="text-3xl font-bold flex items-center ml-10">
            <i class="fa-solid fa-wrench text-blue-900 border-b-2 border-green-400 w-10 "></i> Design
        </h1>

    </div>
    
    <!-- Specification Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10 mr-10 mt-5 p-5 ">
        <!-- Length Card -->
        <div id="lengthCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">LENGTH</h2>
            <div class="mb-2">
                <p id="car1-length-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-length-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-length-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-length-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider a longer length better because longer cars often offer more interior space and improved stability.</p>
        </div>
        
        
        <!-- Width Card -->
        <div id="widthCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">WIDTH</h2>
            <div class="mb-2">
                <p id="car1-width-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-width-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-width-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-width-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider a longer length better because longer cars often offer more interior space and improved stability.</p>
        </div>


       <!-- Height Card -->
        <div id="heightCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">HEIGHT</h2>
            <div class="mb-2">
                <p id="car1-height-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-height-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-height-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-height-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider a taller height better because taller cars often offer more headroom and an elevated driving position.</p>
        </div>
    </div>
</div>
    {{-------------------------------------------------- Performance Card  --------------------------------------------------}}
<div class="Card bg-gray-100 p-10 m-10">

    <div class="text-center">
        <h1 class="text-3xl font-bold flex items-center ml-10">
            <i class="fa-solid fa-chart-line text-blue-900 border-b-2 border-green-400 w-10 "></i> Performance
        </h1>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10 mr-10 mt-5 p-5">
            <!-- Acceleration Card -->
        <div id="accelerationCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2 ">ACCELERATION</h2>
            <div class="mb-2">
                <p id="car1-acceleration-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-acceleration-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-acceleration-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-acceleration-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider faster acceleration better because it improves performance and driving dynamics.</p>
        </div>

                <!-- Efficiency Card -->
        <div id="efficiencyCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">EFFICIENCY</h2>
            <div class="mb-2">
                <p id="car1-efficiency-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-efficiency-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-efficiency-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-efficiency-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider better fuel efficiency to be more economical and environmentally friendly.</p>
        </div>

        <!-- Torque Card -->
        <div id="torqueCard" class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">TORQUE</h2>
            <div class="mb-2">
                <p id="car1-torque-value" class="text-sm font-bold text-blue-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div id="car1-torque-bar" class="h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full" style="width: 0%"></div>
                </div>
                <p id="car2-torque-value" class="text-sm font-bold text-red-600"></p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div id="car2-torque-bar" class="h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">Higher torque is better for towing and overall performance in low-speed acceleration.</p>
        </div>
    </div>
</div>

<script src="{{ asset('/assets/js/custom/compare.js') }}"></script>


@endsection
