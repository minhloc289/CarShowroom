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
