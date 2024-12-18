@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="customer.create"/>

    <div class="container mx-auto px-4 sm:px-8 py-8">
        <!-- Background form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Tiêu đề -->
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Thêm Mới Khách Hàng</h2>
    
            <!-- Form thêm mới -->
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <!-- Tên khách hàng -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 font-medium mb-1">Tên Khách Hàng</label>
                    <input type="text" id="name" name="name" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Số điện thoại -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-600 font-medium mb-1">Số Điện Thoại</label>
                    <input type="text" id="phone" name="phone" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Địa chỉ -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-600 font-medium mb-1">Địa Chỉ</label>
                    <input type="text" id="address" name="address" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('address') }}">
                    @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Nút Submit -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition">
                        Tạo Tài Khoản
                    </button>
                </div>
            </form>
            
        </div>
    </div>    

@endsection