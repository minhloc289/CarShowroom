@extends('Backend.dashboard.layout')

@section('content')


<x-breadcrumbs breadcrumb="Order" />

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold text-primary">Danh sách đơn hàng</h1>
                <a href="{{ route('orders.car.add') }}" class="btn btn-success">+ Thêm đơn hàng</a>
            </div>

            <div class="flex items-center space-x-4 mb-4">
                <!-- Tìm kiếm -->
                <input type="text" id="searchInput" class="rounded-lg border border-gray-300 px-4 py-2 w-64"
                    placeholder="Tìm kiếm đơn hàng...">

                <!-- Lọc theo trạng thái đặt cọc -->
                <select id="statusDepositFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả trạng thái đặt cọc</option>
                    <option value="1">Đã đặt cọc</option>
                    <option value="2">Không đặt cọc</option>
                    <option value="0">Đang chờ đặt cọc</option>
                </select>

                <!-- Lọc theo trạng thái thanh toán -->
                <select id="statusPaymentFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả trạng thái thanh toán</option>
                    <option value="1">Đã thanh toán</option>
                    <option value="2">Không thanh toán</option>
                    <option value="0">Đang chờ thanh toán</option>
                </select>
            </div>

            <div id="ordersContainer" class="table-responsive shadow-sm">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Xe</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái đặt cọc</th>
                            <th scope="col">Trạng thái thanh toán</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                                                <tr>
                                                    <td class="fw-bold">{{ $order->order_id }}</td>
                                                    <td>{{ optional($order->account)->name ?? 'Không có thông tin' }}</td>
                                                    <td>
                                                        @php
                                                            $hasCar = !empty(optional($order->salesCar)->carDetails); // Kiểm tra xe
                                                            $hasAccessories = $order->accessories()->exists(); // Kiểm tra phụ kiện

                                                            // Xác định nội dung hiển thị
                                                            if ($hasCar && $hasAccessories) {
                                                                $vehicleText = 'Xe, Phụ kiện';
                                                            } elseif ($hasCar) {
                                                                $vehicleText = 'Xe';
                                                            } elseif ($hasAccessories) {
                                                                $vehicleText = 'Phụ kiện';
                                                            } else {
                                                                $vehicleText = 'Không có thông tin';
                                                            }
                                                        @endphp

                                                        {{ $vehicleText }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                                    <td>
                                                        @php
                                                            $statusDeposit = optional($order->payments->first())->status_deposit;
                                                            $statusColorDeposit = match ($statusDeposit) {
                                                                0 => 'bg-warning text-dark',
                                                                1 => 'bg-success',
                                                                2 => 'bg-danger',
                                                                default => 'bg-secondary'
                                                            };
                                                            $statusTextDeposit = match ($statusDeposit) {
                                                                0 => 'Đang chờ đặt cọc',
                                                                1 => 'Đã đặt cọc',
                                                                2 => 'Không đặt cọc',
                                                                default => 'Chưa rõ'
                                                            };
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $statusColorDeposit }}">
                                                            {{ $statusTextDeposit }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusPayment = optional($order->payments->first())->status_payment_all;
                                                            $statusColorPayment = match ($statusPayment) {
                                                                0 => 'bg-warning text-dark',
                                                                1 => 'bg-success',
                                                                2 => 'bg-danger',
                                                                default => 'bg-secondary'
                                                            };
                                                            $statusTextPayment = match ($statusPayment) {
                                                                0 => 'Đang chờ thanh toán',
                                                                1 => 'Đã thanh toán',
                                                                2 => 'Không thanh toán',
                                                                default => 'Chưa rõ'
                                                            };
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $statusColorPayment }}">
                                                            {{ $statusTextPayment }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('orders.detail', ['order' => $order->order_id]) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-eye"></i> Chi tiết
                                                        </a>
                                                    </td>
                                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const statusDepositFilter = document.getElementById('statusDepositFilter');
        const statusPaymentFilter = document.getElementById('statusPaymentFilter');
        const ordersContainer = document.querySelector('#ordersContainer tbody');

        // Hàm chuyển trạng thái từ số thành chuỗi để so sánh
        function getStatusText(status, type) {
            const statusMapping = {
                deposit: {
                    0: "Đang chờ đặt cọc",
                    1: "Đã đặt cọc",
                    2: "Không đặt cọc",
                },
                payment: {
                    0: "Đang chờ thanh toán",
                    1: "Đã thanh toán",
                    2: "Không thanh toán",
                }
            };
            return statusMapping[type][status] || "Không xác định";
        }

        // Hàm lọc đơn hàng dựa trên giá trị tìm kiếm và bộ lọc
        function filterOrders() {
            const searchValue = searchInput.value.toLowerCase().trim();
            const depositValue = statusDepositFilter.value;
            const paymentValue = statusPaymentFilter.value;

            const rows = Array.from(ordersContainer.querySelectorAll('tr'));

            rows.forEach(row => {
                const orderId = row.cells[0].textContent.toLowerCase().trim();
                const customerName = row.cells[1].textContent.toLowerCase().trim();
                const depositStatusText = row.cells[4].textContent.trim();
                const paymentStatusText = row.cells[5].textContent.trim();

                // Kiểm tra điều kiện tìm kiếm
                const matchesSearch =
                    !searchValue || orderId.includes(searchValue) || customerName.includes(searchValue);

                // Kiểm tra điều kiện lọc trạng thái đặt cọc
                const matchesDeposit =
                    !depositValue || depositStatusText === getStatusText(depositValue, "deposit");

                // Kiểm tra điều kiện lọc trạng thái thanh toán
                const matchesPayment =
                    !paymentValue || paymentStatusText === getStatusText(paymentValue, "payment");

                // Hiển thị/ẩn hàng dựa trên kết quả lọc
                row.style.display = matchesSearch && matchesDeposit && matchesPayment ? '' : 'none';
            });
        }

        // Lắng nghe sự kiện input và change
        searchInput.addEventListener('input', filterOrders);
        statusDepositFilter.addEventListener('change', filterOrders);
        statusPaymentFilter.addEventListener('change', filterOrders);
    });
</script>



@endsection