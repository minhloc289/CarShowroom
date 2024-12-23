@extends('Backend.dashboard.layout')

@section('content')

    <x-breadcrumbs breadcrumb="rentalReceipt" />

    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Quản lý hóa đơn thuê xe</h2>

        <!-- Danh sách hóa đơn -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Danh sách hóa đơn</h3>
            <table class="table-auto w-full border-collapse border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border border-gray-200 px-4 py-2">Mã hóa đơn</th>
                        <th class="border border-gray-200 px-4 py-2">Tên xe</th>
                        <th class="border border-gray-200 px-4 py-2">Trạng thái</th>
                        <th class="border border-gray-200 px-4 py-2">Ngày bắt đầu</th>
                        <th class="border border-gray-200 px-4 py-2">Ngày kết thúc</th>
                        <th class="border border-gray-200 px-4 py-2">Tổng chi phí</th>
                        <th class="border border-gray-200 px-4 py-2">Yêu cầu gia hạn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentalReceipts as $receipt)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-200 px-4 py-2">{{ $receipt->receipt_id }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $receipt->rentalCar->carDetails->name ?? 'Không có thông tin' }}</td>
                            <td class="border border-gray-200 px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($receipt->status === 'Active')
                                        bg-green-100 text-green-800
                                    @elseif($receipt->status === 'Completed')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ $receipt->status }}
                                </span>
                            </td>
                            <td class="border border-gray-200 px-4 py-2">{{ $receipt->rental_start_date }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $receipt->rental_end_date }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ number_format($receipt->total_cost, 0, ',', '.') }} VND</td>
                            <td class="border border-gray-200 px-4 py-2">
                                @if($receipt->renewals->isNotEmpty())
                                    <a href="{{ route('rental.renewals.show', $receipt->renewals->first()->renewal_id) }}"
                                       class="text-blue-500 hover:text-blue-700">
                                        Có {{ $receipt->renewals->count() }} yêu cầu
                                    </a>
                                @else
                                    <span class="text-gray-500">Không có</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
