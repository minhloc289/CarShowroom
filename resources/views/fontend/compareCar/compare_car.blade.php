@extends('fontend.layouts.App')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Title and Subtitle -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-semibold">Compare Car</h1>
        <p class="text-gray-600">To best evaluate the car, please select 2 or more cars.</p>
    </div>

    <!-- Filter and Selection Boxes -->
    <div class="flex items-center justify-between mb-6">
        <!-- Filter Dropdown -->
        <div class="flex items-center space-x-2 border border-gray-300 rounded-lg p-3 bg-white shadow-sm">
            <span class="text-gray-700">Filter specs:</span>
            <select class="border-gray-300 rounded-md text-blue-600 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="all">All</option>
                <option value="similar">Similar</option>
                <option value="different">Different</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Selection Boxes -->
        <div onclick="toggleModal(true)" class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 cursor-pointer">
            <span class="text-4xl text-gray-500">+</span>
            <span class="mt-2 text-gray-700">Choose a car</span>
        </div>

        <div onclick="toggleModal(true)" class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-gray-100 hover:bg-gray-200 cursor-pointer">
            <span class="text-4xl text-gray-500">+</span>
            <span class="mt-2 text-gray-700">Choose a car</span>
        </div>
    </div>
</div>

<!-- Modal Background (Popup) -->
<div id="carModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-11/12 max-w-lg p-6 rounded-lg shadow-lg relative">
        <button onclick="toggleModal(false)" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-2xl font-semibold mb-4">Chọn tối đa 3 phiên bản xe</h2>
        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
            <!-- Electric and Gasoline Cars Options -->
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Động cơ điện</h3>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>VF 3</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>VF 5 Plus</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>VF e34</span>
                    </label>
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Động cơ xăng</h3>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>FADIL - TIÊU CHUẨN</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>FADIL - NÂNG CAO</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox text-blue-600" onchange="getSelectedCars()">
                        <span>FADIL - CAO CẤP</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-6 text-center">
            <button onclick="toggleModal(false); choose_car()" class="px-6 py-2 bg-gray-600 text-white rounded-lg">CHỌN XE</button>
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
                @include('fontend.compareCar.chart_compare')
        <!-- Right Column: Tab Content -->
        <div>
            <div id="contentCar1" class="p-4 hidden">
                <h2 class="text-2xl font-bold">AMD Ryzen Threadripper Pro 7995WX</h2>
                <ul class="list-disc pl-5 text-gray-700 mt-2">
                    <li>3.75x faster CPU speed (96 x 2.5 GHz vs 8 x 3.2 GHz & 16 x 2.4 GHz)</li>
                    <li>160 more CPU threads (192 threads vs 32 threads)</li>
                    <li>5 nm smaller semiconductor size (5 nm vs 10 nm)</li>
                </ul>
            </div>

            <div id="contentCar2" class="p-4">
                <h2 class="text-2xl font-bold">Intel Core i9-13900KS</h2>
                <ul class="list-disc pl-5 text-gray-700 mt-2">
                    <li>400 MHz higher RAM speed (5600 MHz vs 5200 MHz)</li>
                    <li>Has integrated graphics</li>
                    <li>5°C higher maximum operating temperature (100°C vs 95°C)</li>
                </ul>
            </div>
        </div>
    </div>
</div>


{{--------------------------------------- Card ----------------------------------------------------------}}
<div class="Card bg-gray-100 p-10 mt-10">

    <div class="text-center">
        <h1 class="text-3xl font-bold flex items-center ml-10">
            <i class="fa-solid fa-house text-blue-900 border-b-2 border-green-400 w-10 "></i> Design
        </h1>

    </div>
    
    <!-- Specification Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10 mr-10 mt-5">
        <!-- Weight Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200 ">
            <h2 class="text-lg font-semibold mb-2">WEIGHT</h2>
            <div class="mb-2">
                <p class="text-sm font-bold text-blue-600">300 g</p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full" style="width: 10%"></div>
                </div>
                <p class="text-sm font-bold text-red-600">199 g</p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div class="h-2 bg-gradient-to-r from-red-500 to-purple-500 rounded-full" style="width: 35%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">We consider a lower weight better because lighter devices are more comfortable to carry.</p>
        </div>
        
        <!-- Thickness Card -->
        <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-gray-200">
            <h2 class="text-lg font-semibold mb-2">THICKNESS</h2>
            <div class="mb-2">
                <p class="text-sm font-bold text-blue-600">18.4 mm</p>
                <div class="w-full h-2 bg-gray-300 rounded-full mb-2">
                    <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full" style="width: 85%"></div>
                </div>
                <p class="text-sm font-bold text-red-600">8 mm</p>
                <div class="w-full h-2 bg-gray-300 rounded-full">
                    <div class="h-2 bg-gradient-to-r from-red-500 to-purple-500 rounded-full" style="width: 40%"></div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">The thickness (or depth) of the product.</p>
        </div>
    </div>
</div>
    
@endsection
