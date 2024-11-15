@extends('frontend.layouts.App')

@section('content')
<!-- resources/views/components/introduce.blade.php -->
    <div class="flex isolate px-6 pt-14 lg:px-8">
        <!-- Background Image -->
        <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="grid place-items-center h-screen">
                <img class="p-4 w-2/4 h-auto object-cover opacity-100" style="box-sizing: content-box;"
                    src="{{ asset('assets/img/porsche4.png') }}" alt="Logo">
            </div>
        </div>

        <!-- Content Section -->
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div
                    class="relative mt-[-30px] rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    Announcing our next round of funding. <a href="#" class="font-semibold text-indigo-600"><span
                            class="absolute inset-0" aria-hidden="true"></span>Read more <span
                            aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="mt-[-30px] text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Discover
                    Luxury Cars</h1><br>
                <p class="text-pretty text-lg font-medium sm:text-xl/8 text-gray-900" style=" margin-top: 300px;">
                    Experience the thrill of driving with our exclusive collection of high-performance vehicles. Quality and
                    elegance in every model, waiting for you to explore.
                </p>
                <br>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get
                        started</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-900" style="color: #4954F4;">Learn more <span
                            aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-center h-[40vh] bg-white mt-[-160px]">
        <!-- Slider container -->
        <div id="default-carousel" class="relative w-[120%] max-w-2xl bg-white rounded-lg overflow-hidden"
            data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative h-80 md:h-80 overflow-hidden" style="width: calc(100% + 20px);">
                <!-- Slide 1 -->
                <div class="duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche1.png') }}" alt="Car Image">
                </div>
                <!-- Slide 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche2.png') }}" alt="Car Image">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche3.png') }}" alt="Car Image">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche4.png') }}" alt="Car Image">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche5.png') }}" alt="Car Image">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche6.png') }}" alt="Car Image">
                </div>
                <!-- Add more slides as needed -->
            </div>

            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-2 cursor-pointer group focus:outline-none"
                data-carousel-prev onclick="updateInfo('prev')">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 group-hover:bg-gray-500 focus:ring-2 focus:ring-gray-500 group-focus:outline-none">
                    <svg class="w-3 h-3 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-2 cursor-pointer group focus:outline-none"
                data-carousel-next onclick="updateInfo('next')">
                <span
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 group-hover:bg-gray-500 focus:ring-2 focus:ring-gray-500 group-focus:outline-none">
                    <svg class="w-3 h-3 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>

<!-- Information display container -->
    <div id="car-info" class="text-center mt-4">
        <p><strong>Model</strong>: Porsche 911 Carrera</p>
        <p><strong>Seats</strong>: 4 seats</p>
        <p><strong>Range</strong>: ~ 350 km (NEDC)</p>
        <p><strong>Starting Price</strong>: 2,500,000,000 VND</p>
        <div class="flex justify-center space-x-4 mt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Reserve</button>
            <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded">View Details</button>
        </div>
    </div>
@endsection