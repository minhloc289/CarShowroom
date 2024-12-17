@extends('Backend.dashboard.layout')

@section('content')
    <!-- Breadcrumbs -->
    <x-breadcrumbs breadcrumb="customer.edit"/>

    <div class="container mx-auto mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa thông tin khách hàng</h2>
            
            <!-- Form chỉnh sửa -->
            <form action="{{ route('customer.update', $customer->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
            
                <!-- Tên khách hàng -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên khách hàng</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $customer->name) }}"
                           class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Nhập tên khách hàng">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Email (read-only) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" 
                           value="{{ $customer->email }}"
                           class="mt-1 p-2 w-full border rounded-lg bg-gray-200 text-gray-700" readonly>
                    <!-- Input ẩn để gửi email -->
                    <input type="hidden" name="email" value="{{ $customer->email }}">
                </div>
            
                <!-- Số điện thoại -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" 
                           value="{{ old('phone', $customer->phone) }}"
                           class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Nhập số điện thoại">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Địa chỉ -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <textarea name="address" id="address" rows="3" 
                              class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Nhập địa chỉ">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Nút submit -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('customer') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Quay lại
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Cập nhật
                    </button>
                </div>
            </form>            
        </div>
    </div>
@endsection
