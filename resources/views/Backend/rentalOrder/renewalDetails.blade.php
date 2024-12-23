@extends('Backend.dashboard.layout')

@section('content')

    <x-breadcrumbs breadcrumb="rentalRenewals" />

    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Chi tiết yêu cầu gia hạn</h2>

        <!-- Thông tin yêu cầu -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-medium text-gray-700 mb-6">Thông tin yêu cầu</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên khách hàng -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Tên khách hàng:</p>
                    <p class="text-xl text-gray-800 font-bold">{{ $renewal->rentalReceipt->rentalOrder->user->name ?? 'Không có thông tin' }}</p>
                </div>
                <!-- Mã hóa đơn -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Mã hóa đơn:</p>
                    <p class="text-xl text-gray-800 font-bold">{{ $renewal->rentalReceipt->receipt_id }}</p>
                </div>
                <!-- Ngày yêu cầu -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Ngày yêu cầu:</p>
                    <p class="text-xl text-gray-800">{{ $renewal->request_date }}</p>
                </div>
                <!-- Ngày kết thúc hiện tại -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Ngày kết thúc hiện tại:</p>
                    <p class="text-xl text-gray-800">{{ $renewal->rentalReceipt->rental_end_date }}</p>
                </div>
                <!-- Ngày kết thúc mới -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Ngày kết thúc mới:</p>
                    <p class="text-xl text-gray-800">{{ $renewal->new_end_date }}</p>
                </div>
                <!-- Số ngày gia hạn -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Số ngày gia hạn:</p>
                    <p class="text-xl text-gray-800">{{ $extendDays }} ngày</p>
                </div>
                <!-- Chi phí gia hạn -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Chi phí gia hạn:</p>
                    <p class="text-xl text-gray-800 font-semibold text-blue-600">{{ number_format($renewal->renewal_cost, 0, ',', '.') }} VND</p>
                </div>
                <!-- Trạng thái -->
                <div>
                    <p class="text-base font-semibold text-gray-500">Trạng thái:</p>
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        @if($renewal->status === 'Pending')
                            bg-yellow-100 text-yellow-800
                        @elseif($renewal->status === 'Approved')
                            bg-green-100 text-green-800
                        @else
                            bg-red-100 text-red-800
                        @endif">
                        {{ $renewal->status }}
                    </span>
                </div>
            </div>

            <!-- Nút thao tác -->
            @if($renewal->status === 'Pending')
                <div class="mt-8 flex justify-end space-x-4">
                    <form action="{{ route('rental.renewals.approve', $renewal->renewal_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-6 py-3 bg-green-600 text-white text-lg rounded-lg shadow hover:bg-green-700 transition">
                            Chấp nhận
                        </button>
                    </form>
                    <form action="{{ route('rental.renewals.reject', $renewal->renewal_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-6 py-3 bg-red-600 text-white text-lg rounded-lg shadow hover:bg-red-700 transition">
                            Từ chối
                        </button>
                    </form>
                </div>
            @else
                <p class="mt-8 text-gray-500 text-lg">Yêu cầu đã được xử lý.</p>
            @endif
        </div>
    </div>

@endsection
