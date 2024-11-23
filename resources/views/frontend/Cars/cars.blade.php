@extends('frontend.layouts.App')

@section('content')
<div class="relative bg-gradient-to-b from-[#E9D5FF] via-[#DBEAFE] to-[#FFFFFF] min-h-screen py-10">
  <div class="container mx-auto px-4">
    <!-- Hero Section -->
    <div class="bg-white bg-opacity-40 shadow-lg rounded-xl p-10 mb-10">
      <div class="flex items-center justify-between">
        <!-- Left Text Section -->
        <div>
          <h1 class="text-3xl font-bold text-gray-800">
            Australia's leading platform for <span class="text-blue-600">vehicle</span> trading.
          </h1>
          <div class="mt-6 flex space-x-4">
            <button class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Trade now</button>
            <button class="border border-black text-black px-6 py-3 rounded-lg hover:bg-gray-200">Follow a trade</button>
          </div>
        </div>
        <!-- Right Image Section -->
        <div class="w-1/2">
          <img src="https://porsche-vietnam.vn/wp-content/uploads/2023/02/982-718-bo-se-modelimage-sideshot-840x473.png" alt="Car" class="object-contain rounded-lg">
        </div>
      </div>
    </div>

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
      <nav class="text-gray-600 text-sm">
        <span>Home / Trade vehicle / </span><span class="font-bold text-blue-600">Sport</span>
      </nav>
      <div class="flex items-center space-x-4">
        <input type="text" id="carSearchInput"  placeholder="Search" class="rounded-lg border border-gray-300 px-4 py-2 w-64">
        <select class="rounded-lg border border-gray-300 px-4 py-2">
          <option>Sport</option>
        </select>
        <select class="rounded-lg border border-gray-300 px-4 py-2">
          <option>Sort</option>
        </select>
      </div>
    </div>

    <div id="carsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    @foreach ($cars as $index => $car)
        <div class="car-item border bg-white shadow-lg p-4 rounded-lg text-center" data-index="{{ $index }}">
            <h2 class="text-2xl font-bold">{{ $car->name }}</h2>
            <p class="text-lg text-gray-500">{{ $car->brand }} - {{ $car->model }}</p>
            <p class="text-sm text-gray-400">Year: {{ $car->year }}</p>
            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-auto my-4 rounded-lg">
            <p class="text-gray-600">Seats: {{ $car->seat_capacity }}</p>
            <p class="text-gray-600">Max Speed: {{ $car->max_speed }} km/h</p>
            @if ($car->sale)
                <p class="text-gray-600">Price: ${{ number_format($car->sale->sale_price, 2) }}</p>
                <p class="text-gray-600">Status: {{ $car->sale->availability_status }}</p>
            @endif
            <div class="mt-4 flex justify-center space-x-4">
                <a href="#" class="text-blue-500 hover:underline">Vehicle Details</a>
                <a href="#" class="text-blue-500 hover:underline">Build & Buy</a>
            </div>
        </div>
    @endforeach
</div>

<!-- View All Button -->
<div class="text-center mt-8">
    <button id="viewAllButton" class="text-blue-500 text-sm font-semibold hover:underline">View all →</button>
</div>


</div>

<script src="{{ asset('assets/js/custom/carJS.js') }}">
</script>

@endsection