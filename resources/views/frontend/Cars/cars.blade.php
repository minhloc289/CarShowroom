@extends('frontend.layouts.App')

@section('content')

<form class="flex items-center max-w-sm mx-auto">   
    <label for="simple-search" class="sr-only">Search</label>
    <div class="relative w-full">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
            </svg>
        </div>
        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search branch name..." required />
    </div>
    <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
        <span class="sr-only">Search</span>
    </button>
</form>

<div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Discover Our Cars</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($cars as $car)
            <div class="border p-4 rounded-lg text-center">
                <h2 class="text-2xl font-bold">{{ $car->name }}</h2>
                <p class="text-lg text-gray-500">{{ $car->brand }} - {{ $car->model }}</p>
                <p class="text-sm text-gray-400">Year: {{ $car->year }}</p>
                <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-auto my-4">
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
    </div>
    @endsection