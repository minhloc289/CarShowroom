@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="rentalOrders" />

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold text-primary">Quản lý đơn hàng thuê xe</h1>
                <a href="{{route('rentalOrders.create')}}" class="btn btn-success">+ Thêm đơn hàng</a>
            </div>

            <div class="flex items-center space-x-4 mb-4">
                <!-- Tìm kiếm -->
                <input type="text" id="searchInput" class="rounded-lg border border-gray-300 px-4 py-2 w-64"
                    placeholder="Tìm kiếm đơn hàng...">

                <!-- Lọc theo trạng thái đơn hàng -->
                <select id="statusFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Pending">Đang chờ xử lý</option>
                    <option value="Deposit Paid">Đã đặt cọc</option>
                    <option value="Paid">Đã thanh toán</option>
                    <option value="Canceled">Đã hủy</option>
                </select>
            </div>

            <div id="ordersContainer" class="table-responsive shadow-sm">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Xe thuê</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fw-bold">{{ $order->order_id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->rentalCar->carDetails->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge rounded-pill 
                                                    @if ($order->status === 'Pending') bg-warning text-dark
                                                    @elseif ($order->status === 'Deposit Paid') bg-primary
                                                    @elseif ($order->status === 'Paid') bg-success
                                                    @elseif ($order->status === 'Canceled') bg-danger
                                                    @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{route('rentalOrders.details', $order->order_id)}}"
                                        class="btn btn-outline-primary btn-sm me-2">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy các phần tử của bộ lọc
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const ordersContainer = document.getElementById('ordersContainer');

        // Hàm fetch dữ liệu qua AJAX
        function fetchFilteredOrders() {
            const searchValue = searchInput.value.trim();
            const statusValue = statusFilter.value;

            // Gửi request AJAX tới server
            fetch("{{ route('rentalOrders.filter') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    search: searchValue,
                    status: statusValue,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    updateOrderList(data.orders); // Cập nhật danh sách đơn hàng
                })
                .catch(error => console.error('Error:', error));
        }

        // Hàm cập nhật danh sách đơn hàng
        function updateOrderList(orders) {
            ordersContainer.innerHTML = ''; // Xóa danh sách cũ

            if (orders.length === 0) {
                ordersContainer.innerHTML = '<p>Không tìm thấy đơn hàng nào.</p>';
                return;
            }

            let html = `
                    <table class="table table-striped table-hover text-center align-middle">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Xe thuê</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

            orders.forEach(order => {
                html += `
                        <tr>
                            <td class="fw-bold">${order.order_id}</td>
                            <td>${order.user ? order.user.name : 'Không có thông tin'}</td>
                            <td>${order.rental_car && order.rental_car.car_details ? order.rental_car.car_details.name : 'Không có thông tin'}</td>
                            <td>${order.order_date}</td>
                            <td>
                                <span class="badge rounded-pill ${order.status === 'Pending' ? 'bg-warning text-dark' :
                        order.status === 'Deposit Paid' ? 'bg-primary' :
                            order.status === 'Paid' ? 'bg-success' :
                                'bg-danger'
                    }">${order.status}</span>
                            </td>
                            <td>
                                <a href="/admin/rental-order/${order.order_id}" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="bi bi-eye"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                    `;
            });

            html += `
                        </tbody>
                    </table>
                `;

            ordersContainer.innerHTML = html;
        }

        // Lắng nghe sự kiện thay đổi hoặc nhập liệu trên các filter
        [searchInput, statusFilter].forEach(filter => {
            filter.addEventListener('change', fetchFilteredOrders); // Khi thay đổi dropdown
            filter.addEventListener('keyup', fetchFilteredOrders); // Khi nhập liệu
        });
    </script>
        // Gọi fetch lần đầu để hiển thị dữ liệu mặc định
        fetchFilteredOrders();
    });

    setInterval(() => {
        fetch('/admin/check-order-status', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data.message); // Log thông báo từ server
                // Bạn có thể thêm logic để cập nhật UI ở đây nếu cần
            })
            .catch(error => {
                console.error('Error checking order status:', error);
            });
    }, 5000); // Thời gian 5 giây
</script>
@endsection