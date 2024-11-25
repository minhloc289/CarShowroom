@extends('frontend.layouts.App')
@section('content')

<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        @include('frontend.profilepage.components.nav')
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
    <body>
        <div class="bg-white">
            <!-- main -->
            <div class="content flex-grow w-full pt-[80px] mb-10">
                @yield('main')
            </div>
        </div>
    </body>
    </main>
</div>
@endsection