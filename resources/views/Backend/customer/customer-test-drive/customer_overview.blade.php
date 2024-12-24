@extends('Backend.dashboard.layout')

@section('content') 
<x-breadcrumbs breadcrumb="TestDrive" />

<div class="container mx-auto px-4 sm:px-8 py-2">
    <!-- Background container -->
    <div class="bg-gray-100 shadow-lg rounded-lg p-6">
        <!-- Tiêu đề -->
        <div class="flex justify-between items-center mb-4">
            <!-- Tiêu đề -->
            <h2 class="text-xl font-bold text-indigo-600 uppercase tracking-wide">
                Thông Tin Khách Hàng
            </h2>
        
            <!-- Thanh tìm kiếm và nút thêm mới -->
            <div class="flex space-x-4">
                <!-- Thanh tìm kiếm -->
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchQuery" 
                        placeholder="Tìm kiếm khách hàng..." 
                        class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                </div>
        
                <!-- Nút thêm mới -->
                <a href="{{ route('customer.creates') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full transition duration-300">
                    <i class="fas fa-plus mr-1"></i> Thêm Mới
                </a>
            </div>
        </div>
        
        <!-- Bảng khách hàng -->
        <div class="overflow-x-auto">
            <table id="customerTable" class="min-w-full leading-normal bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">ID</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Tên</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Email</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Số Điện Thoại</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Xe lái thử</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Ngày Lái Thử</th>
                        <th class="px-5 py-3 text-left text-sm font-semibold uppercase">Yêu cầu khác</th>
                        <th class="px-5 py-3 text-center text-sm font-semibold uppercase">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rental as $item)
                        <tr>
                            <td class="px-5 py-4 text-sm">{{ $item->rental_id }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->customer_name }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->email }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->phone_number }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->carDetails->brand }} {{ $item->carDetails->name }} - {{ $item->carDetails->model }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->test_drive_date }}</td>
                            <td class="px-5 py-4 text-sm">{{ $item->other_request }}</td>
                            <td class="px-5 py-4 text-center">
                                <form action="{{route('test_drive.destroy', $item->rental_id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-full transition"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchQuery');
        const customerRows = document.querySelectorAll('#customerTable tbody tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();

            customerRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(query) ? '' : 'none';
            });
        });
    });
</script>

@endsection
