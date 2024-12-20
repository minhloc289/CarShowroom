@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="order.details" />

<div class="container">
    <h1 class="mb-4">Chi tiết đơn hàng</h1>

    <!-- Thông tin đơn hàng -->
    <div class="card mb-4">
        <div class="card-body">
            <h3>Thông tin đơn hàng</h3>
            @php
                $statusOrderText = '';
                $statusOrderColor = '#e3e3e3'; // Default background color
                $statusOrderTextColor = '#1e1e1e'; // Default text color

                switch ($order->status_order) {
                    case 0:
                        $statusOrderText = 'Đang xử lý';
                        $statusOrderColor = '#ffc107'; // Yellow
                        $statusOrderTextColor = '#000';
                        break;
                    case 1:
                        $statusOrderText = 'Hoàn tất';
                        $statusOrderColor = '#28a745'; // Green
                        $statusOrderTextColor = '#fff';
                        break;
                    case 2:
                        $statusOrderText = 'Đã hủy';
                        $statusOrderColor = '#dc3545'; // Red
                        $statusOrderTextColor = '#fff';
                        break;
                }
            @endphp
            <p style="padding: 8px 0px;"><strong>Trạng thái:</strong>
                <span style="font-size: 14px; background-color: {{ $statusOrderColor }}; color: {{ $statusOrderTextColor }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                    {{ $statusOrderText }}
                </span>
            </p>
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_id }}</p>
            <p><strong>Ngày tạo:</strong> {{ $order->order_date }}</p>
            <p><strong>Khách hàng:</strong> {{ optional($order->account)->name ?? 'Không có tên' }}</p>
            <p><strong>Email:</strong> {{ optional($order->account)->email ?? 'Không có email' }}</p>
            <p><strong>Số điện thoại:</strong> {{ optional($order->account)->phone ?? 'Không có số điện thoại' }}</p>
        </div>
    </div>

    <!-- Thông tin xe -->
    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ optional(optional($order->salesCar)->carDetails)->image_url ?? asset('images/default-car.jpg') }}" 
                     class="img-fluid rounded-start" 
                     alt="{{ optional(optional($order->salesCar)->carDetails)->name ?? 'Tên xe' }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3>Thông tin xe</h3>
                    <p><strong>Thương hiệu:</strong> {{ optional(optional($order->salesCar)->carDetails)->brand ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Tên xe:</strong> {{ optional(optional($order->salesCar)->carDetails)->name ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Model:</strong> {{ optional(optional($order->salesCar)->carDetails)->model ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Năm sản xuất:</strong> {{ optional(optional($order->salesCar)->carDetails)->year ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Loại động cơ:</strong> {{ optional(optional($order->salesCar)->carDetails)->engine_type ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Công suất:</strong> {{ optional(optional($order->salesCar)->carDetails)->engine_power ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Dung tích cốp:</strong> {{ optional(optional($order->salesCar)->carDetails)->trunk_capacity ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Kích thước:</strong> {{ optional(optional($order->salesCar)->carDetails)->length ?? '-' }} x 
                        {{ optional(optional($order->salesCar)->carDetails)->width ?? '-' }} x 
                        {{ optional(optional($order->salesCar)->carDetails)->height ?? '-' }} mm</p>
                    <p><strong>Mô tả:</strong> {{ optional(optional($order->salesCar)->carDetails)->description ?? 'Chưa cập nhật' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin thanh toán -->
    <div class="card mb-4">
        <div class="card-body">
            <h3>Thông tin thanh toán</h3>
            @php
                $statusDeposit = optional($order->payments->first())->status_deposit;
                $statusTextDeposit = '';
                $statusColorDeposit = '#e3e3e3'; // Default background color
                $colorTextDeposit = '#1e1e1e'; // Default text color

                switch ($statusDeposit) {
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

                $statusPayment = optional($order->payments->first())->status_payment_all;
                $statusTextPayment = '';
                $statusColorPayment = '#e3e3e3'; // Default background color
                $colorTextPayment = '#1e1e1e'; // Default text color

                switch ($statusPayment) {
                    case 0:
                        $statusTextPayment = 'Đang chờ thanh toán';
                        $statusColorPayment = '#ffc107'; // Yellow
                        $colorTextPayment = '#000';
                        break;
                    case 1:
                        $statusTextPayment = 'Đã thanh toán';
                        $statusColorPayment = '#28a745'; // Green
                        $colorTextPayment = '#fff';
                        break;
                    case 2:
                        $statusTextPayment = 'Không thanh toán';
                        $statusColorPayment = '#dc3545'; // Red
                        $colorTextPayment = '#fff';
                        break;
                }

                $depositAmount = $statusDeposit == 1 ? (optional($order->payments->first())->deposit_amount ?? 0) : 0;
                $totalAmount = optional($order->payments->first())->total_amount ?? 0;
                $remainingAmount = $statusDeposit == 1 ? (optional($order->payments->first())->remaining_amount ?? 0) : $totalAmount;
                $depositDeadline = optional($order->payments->first())->deposit_deadline;
            @endphp
            <p><strong>Số tiền đặt cọc:</strong> {{ $depositAmount == 0 ? '0đ' : number_format($depositAmount, 0, ',', '.') . ' VNĐ' }}</p>
            <p style="padding: 8px 0px;"><strong>Trạng thái đặt cọc:</strong>
                <span style="font-size: 14px; background-color: {{ $statusColorDeposit }}; color: {{ $colorTextDeposit }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                    {{ $statusTextDeposit }}
                </span>
            </p>
            @if ($statusDeposit == 0)
                <p><strong>Hạn đặt cọc:</strong> {{ $depositDeadline ?? 'Chưa cập nhật' }}</p>
            @endif
            <p><strong>Tổng tiền:</strong> {{ number_format($totalAmount, 0, ',', '.') }} VNĐ</p>
            <p><strong>Số tiền còn lại:</strong> {{ number_format($remainingAmount, 0, ',', '.') }} VNĐ</p>
            <p><strong>Hạn thanh toán:</strong> {{ optional($order->payments->first())->payment_deadline ?? 'Chưa cập nhật' }}</p>
            @if (optional($order->payments->first())->status_deposit != 2) 
                <p style="padding: 8px 0px;"><strong>Trạng thái thanh toán:</strong>
                    <span style="font-size: 14px; background-color: {{ $statusColorPayment }}; color: {{ $colorTextPayment }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                        {{ $statusTextPayment }}
                    </span>
                </p>
            @endif
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="text-end d-flex justify-content-end align-items-center gap-2">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        @if (optional($order->payments->first())->status_payment_all != 1&&optional($order->payments->first())->status_deposit != 2) 
            <form action="{{route('orders.confirmPayment',['order'=>$order->order_id])}}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
            </form>
        @endif
    </div>
</div>
@endsection
