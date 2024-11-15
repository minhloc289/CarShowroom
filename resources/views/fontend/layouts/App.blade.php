<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('fontend.dashboard.components.head')
</head>

<body>
    <div class="bg-white">
        <!-- Include Header Component -->
        @include('fontend.dashboard.components.Header')
        <!-- Include Introduce Component -->

        <div class="content flex-grow w-full pt-[90px] mb-10">
            @yield('content')
        </div>

        <!-- Include Introduce Footer -->
        @include('fontend.dashboard.components.Footer')
    </div>
</body>

</html>
