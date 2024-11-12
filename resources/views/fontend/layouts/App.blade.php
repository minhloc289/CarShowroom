<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="bg-white">
        <!-- Include Header Component -->
        @include('fontend.dashboard.components.Header')
        <!-- Include Introduce Component -->
        @include('fontend.dashboard.components.Introduce')
        @include('fontend.dashboard.components.Swiper')
        <!-- Include Introduce Footer -->
        @include('fontend.dashboard.components.Footer')
    </div>
</body>

</html>
