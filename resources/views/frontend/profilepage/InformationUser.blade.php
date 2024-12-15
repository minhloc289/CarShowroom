@extends('frontend.profilepage.viewprofile')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('account')->user();
@endphp
@section('main')
<main class="flex-1 p-8 mt-[-30px]">
    <h1 class="text-2xl font-semibold text-gray-800">Thông tin cá nhân</h1>
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 font-medium">Họ và tên</label>
                    <input type="text" name="name" class="w-full mt-1 px-4 py-2 border rounded-md"
                        value="{{ $user->name }}">
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Email</label>
                    <input type="email" name="email" class="w-full mt-1 px-4 py-2 border rounded-md"
                        value="{{ $user->email }}">
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Số điện thoại</label>
                    <input type="text" name="phone" class="w-full mt-1 px-4 py-2 border rounded-md"
                        value="{{ $user->phone }}">
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Địa chỉ</label>
                    <input type="text" name="address" class="w-full mt-1 px-4 py-2 border rounded-md"
                        value="{{ $user->address }}">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 mr-4">Cập
                    nhật</button>
                    <a href="{{route('view.resetpass')}}" class="text-blue-600 hover:text-blue-800">Đổi mật khẩu</a>
            </div>
        </form>

        <!-- Thêm thẻ a để đổi mật khẩu -->
    </div>
</main>
@endsection
