@extends('frontend.layouts.App')
@section('content')
@php
    $user = session('login_account');
@endphp
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md">
        <div class="py-4 px-6">
            <h2 class="text-lg font-semibold text-gray-800">THÔNG TIN XE</h2>
            <ul class="mt-4 space-y-2">
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-car mr-3"></i> Xe của tôi
                    </a>
                </li>
            </ul>
            <h2 class="text-lg font-semibold text-gray-800 mt-6">ĐẶT HÀNG VÀ DỊCH VỤ</h2>
            <ul class="mt-4 space-y-2">
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-file-invoice-dollar mr-3"></i> Lịch sử giao dịch
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-tools mr-3"></i> Bảo dưỡng - Sửa chữa
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-battery-three-quarters mr-3"></i> Thuê Pin
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-charging-station mr-3"></i> Lịch sử Sạc Pin
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-clipboard-check mr-3"></i> Đăng ký lái thử
                    </a>
                </li>
            </ul>
            <h2 class="text-lg font-semibold text-gray-800 mt-6">TÀI KHOẢN</h2>
            <ul class="mt-4 space-y-2">
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-user mr-3"></i> Thông tin cá nhân
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-file-invoice mr-3"></i> Thông tin xuất hóa đơn
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-headset mr-3"></i> Yêu cầu hỗ trợ
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center text-gray-600 hover:text-blue-600">
                        <i class="fas fa-envelope mr-3"></i> Liên hệ
                    </a>
                </li>
            </ul>
            <ul class="mt-6">
                <li>
                    <form method="POST" action="{{ route('account.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-semibold text-gray-800">Thông tin cá nhân</h1>
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <form action="#" method="POST" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-600 font-medium">Họ và tên</label>
                        <input type="text" name="name" class="w-full mt-1 px-4 py-2 border rounded-md"
                            value="Nguyễn Văn A">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-medium">Email</label>
                        <input type="email" name="email" class="w-full mt-1 px-4 py-2 border rounded-md"
                            value="{{ $user->email }}">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-medium">Số điện thoại</label>
                        <input type="text" name="phone" class="w-full mt-1 px-4 py-2 border rounded-md"
                            value="0123456789">
                    </div>
                    <div>
                        <label class="block text-gray-600 font-medium">Địa chỉ</label>
                        <input type="text" name="address" class="w-full mt-1 px-4 py-2 border rounded-md"
                            value="123 Đường ABC, TP.HCM">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Cập
                        nhật</button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection