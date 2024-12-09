<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.dashboard.components.head')
</head>
    <body>
        <div class="bg-white">
            <!-- Include Header Component -->
            @include('frontend.dashboard.components.Header')

            <!-- Content -->
            <div class="content flex-grow w-full mb-10 mt-16 ">
                @yield('content')
            </div>
            <!-- End Content -->

            <!-- Login Overlay -->
            @include('frontend.home.login_sign')
            <!-- Include Introduce Footer -->
            @include('frontend.dashboard.components.Footer')
        </div>
    </body>
</html>



