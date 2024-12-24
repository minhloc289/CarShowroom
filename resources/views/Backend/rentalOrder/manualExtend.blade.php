@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="rental.extend.manual.search" />
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Gia hạn thủ công</h2>

        <!-- Phần tìm kiếm hóa đơn -->
        <form action="{{ route('rental.extend.manual.search.process') }}" method="POST" class="mb-6">
            @csrf
            <div class="space-y-4">
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại khách hàng</label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        class="block w-full px-4 py-3 border border-gray-200 rounded-lg"
                        placeholder="Nhập số điện thoại"
                        required
                    >
                </div>
                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700"
                >
                    Tìm kiếm hóa đơn
                </button>
            </div>
        </form>

        <!-- Phần hiển thị danh sách hóa đơn -->
        @isset($latestReceipts)
            @if($latestReceipts->isNotEmpty())
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Danh sách hóa đơn gần nhất của từng xe</h3>
                    <table class="table-auto w-full border-collapse border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-200 px-4 py-2">Mã hóa đơn</th>
                                <th class="border border-gray-200 px-4 py-2">Tên xe</th>
                                <th class="border border-gray-200 px-4 py-2">Ngày bắt đầu</th>
                                <th class="border border-gray-200 px-4 py-2">Ngày kết thúc</th>
                                <th class="border border-gray-200 px-4 py-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReceipts as $receipt)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $receipt->receipt_id }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $receipt->rentalCar->carDetails->name ?? 'Không có thông tin' }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $receipt->rental_start_date }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $receipt->rental_end_date }}</td>
                                    <td class="border border-gray-200 px-4 py-2 text-center">
                                        <button 
                                            type="button" 
                                            class="text-white bg-green-500 hover:bg-green-700 px-4 py-2 rounded"
                                            onclick="openModal('{{ $receipt->receipt_id }}', '{{ $receipt->rental_price_per_day }}')"
                                        >
                                            Gia hạn
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                    Không tìm thấy hóa đơn nào cho khách hàng này.
                </div>
            @endif
        @endisset
    </div>

    <!-- Modal Gia hạn -->
    <div id="extendModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Nhập số ngày gia hạn</h3>
            <form action="{{ route('rental.extend.manual.process') }}" method="POST">
                @csrf
                <input type="hidden" name="receipt_id" id="modalReceiptId">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label for="extend_days" class="block text-sm font-medium text-gray-700">Số ngày gia hạn</label>
                        <input
                            type="number"
                            name="extend_days"
                            id="modalExtendDays"
                            class="block w-full px-4 py-2 border border-gray-200 rounded-lg"
                            min="1"
                            required
                        >
                    </div>
                    <div class="space-y-2">
                        <label for="renewal_cost" class="block text-sm font-medium text-gray-700">Chi phí gia hạn</label>
                        <input
                            type="text"
                            id="modalRenewalCost"
                            class="block w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-100"
                            readonly
                        >
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button 
                        type="button" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                        onclick="closeModal()"
                    >
                        Hủy
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600"
                    >
                        Xác nhận
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        function openModal(receiptId, pricePerDay) {
            document.getElementById('modalReceiptId').value = receiptId;
            document.getElementById('modalExtendDays').value = '';
            document.getElementById('modalRenewalCost').value = '0 VND';
            document.getElementById('modalExtendDays').oninput = function () {
                const days = parseInt(this.value) || 0;
                const cost = days * pricePerDay;
                document.getElementById('modalRenewalCost').value = new Intl.NumberFormat('vi-VN').format(cost) + ' VND';
            };
            document.getElementById('extendModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('extendModal').classList.add('hidden');
        }
    </script>
@endsection
