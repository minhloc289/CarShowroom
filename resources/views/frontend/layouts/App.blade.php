
<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.dashboard.components.head')
</head>
<body>
    <div class="bg-white">
        <!-- Include Header Component -->
        @include('frontend.dashboard.components.Header')
        <!-- Include Introduce Component -->
        
        <!-- Content -->
        <div class="content flex-grow w-full pt-[90px] mb-10">
            @yield('content')
        </div>
        <!-- Login Overlay -->
        @include('frontend.home.login_sign')
        <!-- Include Introduce Footer -->
        @include('frontend.dashboard.components.Footer')
    </div>
</body>

</html>
