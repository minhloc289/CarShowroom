@extends('frontend.profilepage.viewprofile')

@section('main')
@csrf
<main class="flex-1 p-8 mt-[-30px]">
    <div class="flex items-center space-x-2">
        <!-- Icon Back -->
        <a href="{{ route('view.profile') }}" class="text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Đổi Mật Khẩu</h1>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('reset.password.submit') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Mật khẩu cũ -->
            <div>
                <label class="block text-gray-600 font-medium">Mật khẩu cũ</label>
                <input type="password" name="old_password" id="old_password" class="w-full mt-1 px-4 py-2 border rounded-md" required>
            </div>
            
            <!-- Mật khẩu mới -->
            <div>
                <label class="block text-gray-600 font-medium">Mật khẩu mới</label>
                <input type="password" name="password" id="password" class="w-full mt-1 px-4 py-2 border rounded-md" required>
            </div>

            <!-- Xác nhận mật khẩu mới -->
            <div>
                <label class="block text-gray-600 font-medium">Xác nhận mật khẩu mới</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-1 px-4 py-2 border rounded-md" required>
            </div>

            <div class="mt-4">
                <button id="resetPasswordButton"  type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Đổi mật khẩu</button>
            </div>
        </form>
    </div>
</main>
@endsection
