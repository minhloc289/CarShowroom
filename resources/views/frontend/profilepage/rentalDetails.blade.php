@extends('frontend.profilepage.viewprofile')

@section('main')
    <div class="p-4">
        <div class="max-w-6xl mx-auto">
            <div class="pl-2 pr-4 py-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">THÔNG TIN ĐẶT HÀNG</h2>
                </div>

                <!-- Main Content -->
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Left Column -->
                    <div class="w-full md:w-1/2">
                        <!-- General Information -->
                        <div class="mb-12">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Thông tin chung</h3>
                            <div class="space-y-3">
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Mã đơn hàng</span>
                                    <span class="text-gray-800">{{ $rentalOrder->order_id }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Ngày đặt hàng</span>
                                    <span class="text-gray-800">{{ $rentalOrder->order_date }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Trạng thái</span>
                                    <span class="px-3 py-1 rounded-md text-sm 
                                        {{ $rentalOrder->status == 'Canceled' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $rentalOrder->status == 'Deposit Paid' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $rentalOrder->status == 'Paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $rentalOrder->status == 'Pending' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ $rentalOrder->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Thông tin chủ xe</h3>
                            <div class="space-y-3">
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Họ và tên</span>
                                    <span class="text-gray-800">{{ $rentalOrder->user->name }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Số điện thoại</span>
                                    <span class="text-gray-800">{{ $rentalOrder->user->phone }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Email</span>
                                    <span class="text-gray-800">{{ $rentalOrder->user->email }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-600 w-36">Showroom nhận xe</span>
                                    <span class="text-gray-800">Trường Đại học Công Nghệ Thông Tin</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="w-full md:w-1/2">
                        <!-- Car Information -->
                        <div class="mb-6">
                            <div class="text-center mb-6">
                                <img src="{{ $rentalOrder->rentalCar->carDetails->image_url ?? '/default-car-image.jpg' }}"
                                    alt="Car Image" class="w-full h-auto rounded-lg shadow-md mb-4">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $rentalOrder->rentalCar->carDetails->name }}
                                </h3>
                            </div>

                            <!-- Payment Information -->
                            <div class="border-t pt-4">
                                <table class="w-full border-collapse">
                                    <tr>
                                        <td class="py-3 font-medium text-gray-600 border-b border-gray-200">Giá trị đơn hàng</td>
                                        <td class="py-3 text-right border-b border-gray-200">
                                            {{ number_format($rentalOrder->rentalPayments->sum('total_amount'), 0, ',', '.') }} VNĐ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 font-medium text-gray-600 border-b border-gray-200">Đã thanh toán</td>
                                        <td class="py-3 text-right border-b border-gray-200">
                                            {{ $rentalOrder->status === 'Paid' ? number_format($rentalOrder->rentalPayments->sum('total_amount'), 0, ',', '.') : number_format($rentalOrder->rentalPayments->sum('deposit_amount'), 0, ',', '.') }} VNĐ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 font-medium text-gray-600">Số tiền còn lại</td>
                                        <td class="py-3 text-right">
                                            {{ $rentalOrder->status === 'Paid' ? '0' : number_format($rentalOrder->rentalPayments->sum('remaining_amount'), 0, ',', '.') }} VNĐ
                                        </td>
                                    </tr>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orderId = {{ $rentalOrder->order_id }}; // Lấy ID đơn hàng từ server
            const statusElement = document.getElementById('payment-status');
            let previousStatus = statusElement.textContent.trim(); // Lưu trạng thái hiện tại để so sánh

            function fetchOrderStatus() {
                fetch(`/rental-order-status/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Nếu trạng thái mới khác trạng thái cũ, cập nhật giao diện
                        if (data.status !== previousStatus) {
                            previousStatus = data.status; // Cập nhật trạng thái hiện tại
                            statusElement.textContent = data.status;

                            // Thay đổi màu sắc trạng thái theo trạng thái đơn hàng
                            if (data.status === 'Paid') {
                                statusElement.className = 'bg-green-100 text-green-800 px-3 py-1 rounded-md';
                            } else if (data.status === 'Deposit Paid') {
                                statusElement.className = 'bg-yellow-100 text-yellow-800 px-3 py-1 rounded-md';
                            } else if (data.status === 'Pending') {
                                statusElement.className = 'bg-blue-100 text-blue-800 px-3 py-1 rounded-md';
                            } else if (data.status === 'Canceled') {
                                statusElement.className = 'bg-red-100 text-red-800 px-3 py-1 rounded-md';
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching order status:', error));
            }
            // Gọi fetchOrderStatus mỗi 5 giây
            setInterval(fetchOrderStatus, 5000);
        });
    </script>
@endsection
