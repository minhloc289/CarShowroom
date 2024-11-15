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
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
