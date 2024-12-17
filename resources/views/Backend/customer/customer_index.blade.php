@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="customer" />

    <div class="container mx-auto px-4 sm:px-8 py-2">
        <!-- Background container -->
        <div class="bg-gray-100 shadow-lg rounded-lg p-6">
            <!-- Tiêu đề -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold text-indigo-600 uppercase tracking-wide">
                        Thông Tin Khách Hàng
                    </h2>
                    <p class="text-sm text-gray-700 mt-1">
                        Số lượng khách hàng | {{ $customers->total() }}
                    </p>
                </div>
                <a href="{{route('customer.create')}}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full transition duration-300 my-2 mr-1">
                    <i class="fas fa-plus mr-1"></i> Thêm Mới
                </a>
            </div>
    
            <!-- Bảng khách hàng -->
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Mã Tài Khoản</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Tên</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Email</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Số Điện Thoại</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Địa Chỉ</th>
                            <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Ngày Tạo</th>
                            <th class="px-5 py-3 text-center text-sm font-semibold uppercase">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-200">
                                <td class="px-5 py-4 text-sm">{{ $customer->id }}</td>
                                <td class="px-5 py-4 text-sm">{{ $customer->name ?: 'Không có tên' }}</td>
                                <td class="px-5 py-4 text-sm">{{ $customer->email }}</td>
                                <td class="px-5 py-4 text-sm">{{ $customer->phone ?: 'Không có số' }}</td>
                                <td class="px-5 py-4 text-sm">{{ $customer->address ?: 'Không có địa chỉ' }}</td>
                                <td class="px-5 py-4 text-sm">{{ $customer->created_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex justify-center space-x-3">
                                        <!-- Nút chỉnh sửa -->
                                        <a href="{{route('customer.edit', $customer->id)}}" 
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-3 rounded-full transition">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Nút xóa -->
                                        <form action="{{route('customer.destroy', $customer->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-full transition"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Khi không có khách hàng -->
                            <tr>
                                <td colspan="7" class="px-5 py-4 text-center text-gray-500">
                                    Không có dữ liệu khách hàng.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            <div class="mt-6 flex justify-center">
                {{ $customers->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>    
@endsection
