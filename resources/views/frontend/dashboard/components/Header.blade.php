<header class="fixed inset-x-0 top-0 z-50 bg-white shadow">
    <div class="container mx-auto">
        <nav class="flex items-center justify-between p-0 lg:px-2" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="{{route('CustomerDashBoard.index')}}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-20 w-auto" src="{{ asset('assets/img/logo (2).png') }}" alt="Logo">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#"
                    class=" md:hover:text-blue-700 font-semibold text-gray-900 hover:underline text">Introduction</a>
                <a href="{{ route('CarController.index') }}" class=" md:hover:text-blue-700 font-semibold text-gray-900 hover:underline">Car</a>
                <a href="# class=" md:hover:text-blue-700 font-semibold text-gray-900 hover:underline">Accessories</a>
                <a href="{{ route('CustomerDashBoard.compare') }}"
                    class=" md:hover:text-blue-700 font-semibold text-gray-900 hover:underline">Compare Cars</a>

                <!-- Service with Centered Dropdown -->
                <div class="relative group">
                    <a href="#" class="inline-flex md:hover:text-blue-700 font-semibold text-gray-900 hover:underline ">
                        Service
                        <svg class="w-2.5 ms-2 translate-y-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </a>
                    <div id="dropdown"
                        class="absolute z-10 left-1/2 transform -translate-x-1/2 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-white-700 group-hover:block">
                        <ul class="py-2 text-sm/6 font-semibold text-gray-900 ">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Car
                                    Rent</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Test
                                    Drive Registration</a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{---------------- Dropdown for service ---------------}}
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
    @if (Auth::check())
        {{-- Nếu người dùng đã đăng nhập, hiển thị file signed.blade.php --}}
        @include('frontend.signed.signed')
    @else
        {{-- Nếu người dùng chưa đăng nhập, hiển thị nút đăng nhập --}}
        <a id="loginLink" href="{{ route('customer.login') }}"
            class="font-semibold text-gray-900 md:hover:text-green-700">Log in <span aria-hidden="true">&rarr;</span></a>
    @endif
</div>
        </nav>
    </div>
    </div>
    <!-- Mobile menu -->
    {{-- <div class="lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-50"></div>
        <div
            class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                        alt="">
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Product</a>
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Features</a>
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Marketplace</a>
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Company</a>
                    </div>
                    <div class="py-6">
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log
                            in</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</header>