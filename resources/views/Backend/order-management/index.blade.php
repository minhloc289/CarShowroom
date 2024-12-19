@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="Order" />

<div class="container">
    <h1 class="mb-4">Danh sách đơn hàng</h1>

    <!-- Bộ lọc -->
    <div class="flex items-center space-x-4 mb-4">
            <input type="text" id="searchInput"class="rounded-lg border border-gray-300 px-4 py-2 w-64" placeholder="Tìm kiếm">
            <select id="statusDepositFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">Tất cả trạng thái đặt cọc</option>
                <option value="1">Đã đặt cọc</option>
                <option value="2">Không đặt cọc</option>
                <option value="0">Đang chờ đặt cọc</option>
            </select>
            <select id="statusPaymentFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">Tất cả trạng thái thanh toán</option>
                <option value="1">Đã thanh toán</option>
                <option value="2">Không thanh toán</option>
                <option value="0">Đang chờ thanh toán</option>
            </select>
    </div>

    <div class="row" id="orderList">
        <div class="col-12">
            @foreach ($orders as $order)
            <a href="{{route('orders.detail',['order'=>$order->order_id])}}">
                <div class="card mb-4 order-card" 
                     data-name="{{ optional(optional($order->salesCar)->carDetails)->name ?? '' }}"
                     data-brand="{{ optional(optional($order->salesCar)->carDetails)->brand ?? '' }}"
                     data-model="{{ optional(optional($order->salesCar)->carDetails)->model ?? '' }}"
                     data-year="{{ optional(optional($order->salesCar)->carDetails)->year ?? '' }}"
                     data-account-name="{{ optional($order->account)->name ?? '' }}"
                     data-email="{{ optional($order->account)->email ?? '' }}"
                     data-order-id="{{ $order->order_id }}"
                     data-deposit-status="{{ optional($order->payments->first())->status_deposit }}"
                     data-payment-status="{{ optional($order->payments->first())->status_payment_all }}">
                    <div class="row g-0">
                        <!-- Ảnh -->
                        <div class="col-md-3">
                            <img src="{{ optional(optional($order->salesCar)->carDetails)->image_url ?? asset('images/default-car.jpg') }}"
                                class="img-fluid rounded-start"
                                style="height: auto; max-width: calc(100% - 130px); margin: 5px;"
                                alt="{{ optional(optional($order->salesCar)->carDetails)->car_name ?? 'Tên xe' }}">
                        </div>

                        <!-- Nội dung thông tin -->
                        <div class="col-md-6">
                            <div class="card-body">
                                <div style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                                    <h5 class="card-title">
                                        {{ optional(optional($order->salesCar)->carDetails)->brand ?? 'Thương hiệu chưa cập nhật' }}
                                        {{ optional(optional($order->salesCar)->carDetails)->name ?? 'Tên xe chưa cập nhật' }}
                                        {{ optional(optional($order->salesCar)->carDetails)->model ?? 'Mẫu xe chưa cập nhật' }}
                                        {{ optional(optional($order->salesCar)->carDetails)->year ?? 'Năm chưa cập nhật' }}
                                    </h5>
                                    <div>
                                        <p>
                                            <strong>Tên tài khoản:</strong> {{ optional($order->account)->name ?? 'Không có tên' }}<br>
                                            <strong>Email:</strong> {{ optional($order->account)->email ?? 'Không có email' }}<br>
                                            <strong>Mã đơn hàng:</strong> {{ $order->order_id }}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                                    // Trạng thái đặt cọc
                                    $statusTextDeposit = '';
                                    $statusColorDeposit = '#e3e3e3'; // Default background color
                                    $colorTextDeposit = '#1e1e1e'; // Default text color

                                    switch (optional($order->payments->first())->status_deposit) {
                                        case 0:
                                            $statusTextDeposit = 'Đang chờ đặt cọc';
                                            $statusColorDeposit = '#ffc107'; // Yellow
                                            $colorTextDeposit = '#000';
                                            break;
                                        case 1:
                                            $statusTextDeposit = 'Đã đặt cọc';
                                            $statusColorDeposit = '#28a745'; // Green
                                            $colorTextDeposit = '#fff';
                                            break;
                                        case 2:
                                            $statusTextDeposit = 'Không đặt cọc';
                                            $statusColorDeposit = '#dc3545'; // Red
                                            $colorTextDeposit = '#fff';
                                            break;
                                    }

                                    // Trạng thái thanh toán tất cả
                                    $statusTextPaymentAll = '';
                                    $statusColorPaymentAll = '#e3e3e3'; // Default background color
                                    $colorTextPaymentAll = '#1e1e1e'; // Default text color

                                    switch (optional($order->payments->first())->status_payment_all) {
                                        case 0:
                                            $statusTextPaymentAll = 'Đang chờ thanh toán';
                                            $statusColorPaymentAll = '#ffc107'; // Yellow
                                            $colorTextPaymentAll = '#000';
                                            break;
                                        case 1:
                                            $statusTextPaymentAll = 'Đã thanh toán';
                                            $statusColorPaymentAll = '#28a745'; // Green
                                            $colorTextPaymentAll = '#fff';
                                            break;
                                        case 2:
                                            $statusTextPaymentAll = 'Không thanh toán';
                                            $statusColorPaymentAll = '#dc3545'; // Red
                                            $colorTextPaymentAll = '#fff';
                                            break;
                                    }
                                @endphp
                        <!-- Trạng thái -->
                        <div class="col-md-3 d-flex align-items-center justify-content-end" style="padding-right: 10px;">
                            <div style="display: flex; flex-direction: row; gap: 10px;">
                                <!-- Trạng thái đặt cọc -->
                                <span style="font-size: 14px; background-color: {{ $statusColorDeposit }}; color: {{ $colorTextDeposit }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                                    {{ $statusTextDeposit }}
                                </span>

                                <!-- Trạng thái thanh toán -->
                                <span style="font-size: 14px; background-color: {{ $statusColorPaymentAll }}; color: {{ $colorTextPaymentAll }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                                    {{ $statusTextPaymentAll }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const statusDepositFilter = document.getElementById('statusDepositFilter');
        const statusPaymentFilter = document.getElementById('statusPaymentFilter');
        const orderCards = document.querySelectorAll('.order-card');

        function filterOrders() {
            const searchText = searchInput.value.toLowerCase();
            const depositStatus = statusDepositFilter.value;
            const paymentStatus = statusPaymentFilter.value;

            orderCards.forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                const brand = card.getAttribute('data-brand').toLowerCase();
                const model = card.getAttribute('data-model').toLowerCase();
                const year = card.getAttribute('data-year').toLowerCase();
                const accountName = card.getAttribute('data-account-name').toLowerCase();
                const email = card.getAttribute('data-email').toLowerCase();
                const orderId = card.getAttribute('data-order-id').toLowerCase();
                const deposit = card.getAttribute('data-deposit-status');
                const payment = card.getAttribute('data-payment-status');

                const matchesSearch =
                    name.includes(searchText) ||
                    brand.includes(searchText) ||
                    model.includes(searchText) ||
                    year.includes(searchText) ||
                    accountName.includes(searchText) ||
                    email.includes(searchText) ||
                    orderId.includes(searchText);

                const matchesDeposit = depositStatus === '' || deposit === depositStatus;
                const matchesPayment = paymentStatus === '' || payment === paymentStatus;

                if (matchesSearch && matchesDeposit && matchesPayment) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterOrders);
        statusDepositFilter.addEventListener('change', filterOrders);
        statusPaymentFilter.addEventListener('change', filterOrders);
    });
</script>
@endsection
