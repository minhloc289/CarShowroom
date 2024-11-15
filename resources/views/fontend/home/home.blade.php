<!-- resources/views/components/introduce.blade.php -->
@extends('fontend.layouts.App')

@section('content')
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
                <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    Announcing our next round of funding. <a href="#" class="font-semibold text-indigo-600"><span
                            class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Discover Luxury Cars</h1><br><br>
                <p class="mt-8 text-pretty text-lg font-medium sm:text-xl/8" style="color: #DFE5E2;">
                    Experience the thrill of driving with our exclusive collection of high-performance vehicles. Quality and elegance in every model, waiting for you to explore.
                </p><br>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get started</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-900" style="color: #4954F4;">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </div>

    {{-- /* Swipper */ --}}
    <div class="flex items-center justify-center h-[40vh] bg-white">
        <!-- Slider container -->
        <div id="default-carousel" class="relative w-[120%] max-w-2xl bg-white rounded-lg overflow-hidden" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-80 md:h-80 overflow-hidden" style="width: calc(100% + 20px);">
                <!-- Item 1 -->
                <div class="duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche4.png') }}" alt="Logo">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche1.png') }}" alt="Logo">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche2.png') }}" alt="Logo">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche3.png') }}" alt="Logo">
                </div>
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img class="p-0 w-full h-auto object-cover opacity-90 -translate-y-2.5" style="box-sizing: content-box;"
                        src="{{ asset('assets/img/porsche5.png') }}" alt="Logo">
                </div>
            </div>

            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 bottom-0 left-1/2 space-x-3 rtl:space-x-reverse">
                <button type="button" style="margin:10px 5px" class="w-3 h-3 bg-gray-500 rounded-full" aria-current="true" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
                <button type="button" style="margin:10px 8px" class="w-3 h-3 bg-gray-500 rounded-full opacity-60 hover:opacity-100"
                    aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                <button type="button" style="margin:10px 8px" class="w-3 h-3 bg-gray-500 rounded-full opacity-60 hover:opacity-100"
                    aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                    <button type="button"style="margin:10px 8px" class="w-3 h-3 bg-gray-500 rounded-full opacity-60 hover:opacity-100"
                    aria-current="false" aria-label="Slide 4" data-carousel-slide-to="2"></button>
                    <button type="button" style="margin:10px 8px" class="w-3 h-3 bg-gray-500 rounded-full opacity-60 hover:opacity-100"
                    aria-current="false" aria-label="Slide 5" data-carousel-slide-to="2"></button>
            </div>

            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-2 cursor-pointer group focus:outline-none"
                data-carousel-prev>
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
                data-carousel-next>
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
@endsection