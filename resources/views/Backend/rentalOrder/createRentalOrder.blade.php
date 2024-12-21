@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="rentalOrders.create" />
    <div class="container mt-4">
        <h1 class="text-primary mb-4">Thêm đơn hàng thuê xe</h1>
        <form action="{{route('rentalOrders.store')}}" method="POST">
            @csrf
            <div class="row mb-3">
                <!-- Số điện thoại -->
                <div class="col-md-6">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
                <!-- Tên khách hàng -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Tên khách hàng</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" readonly>
                </div>
            </div>
    
            <!-- Thông tin xe -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="rental_id" class="form-label">Chọn xe thuê</label>
                    <select name="rental_id" id="rental_id" class="form-select" required>
                        <option value="">-- Chọn xe --</option>
                        @foreach ($rentalCars as $car)
                            <option value="{{ $car->rental_id }}">{{ $car->carDetails->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Ngày bắt đầu thuê</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
            </div>
    
            <!-- Thông tin thanh toán -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="rental_days" class="form-label">Số ngày thuê</label>
                    <input type="number" name="rental_days" id="rental_days" class="form-control" value="{{ old('rental_days') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="rental_price_per_day" class="form-label">Giá thuê mỗi ngày (VND)</label>
                    <input type="text" name="rental_price_per_day" id="rental_price_per_day" class="form-control" value="{{ old('rental_price_per_day') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="total_cost" class="form-label">Tổng số tiền thuê (VND)</label>
                    <input type="text" name="total_cost" id="total_cost" class="form-control" value="{{ old('total_cost') }}" readonly>
                </div>
            </div>
    
            <!-- Hình thức thanh toán -->
            <div class="mb-3">
                <label for="payment_type" class="form-label">Hình thức thanh toán</label>
                <select name="payment_type" id="payment_type" class="form-select" required>
                    <option value="deposit">Thanh toán đặt cọc</option>
                    <option value="full">Thanh toán toàn bộ</option>
                </select>
            </div>
    
            <!-- Tiền đặt cọc -->
            <div class="mb-3">
                <label for="deposit_amount" class="form-label">Số tiền đặt cọc (VND)</label>
                <input type="text" name="deposit_amount" id="deposit_amount" class="form-control" value="{{ old('deposit_amount') }}" readonly>
            </div>
    
            <!-- Nút hành động -->
            <div class="text-start">
                <button type="submit" class="btn btn-success">Thêm đơn hàng</button>
                <a href="{{ route('rentalOrders') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </form>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rentalIdSelect = document.getElementById('rental_id');
            const rentalDaysInput = document.getElementById('rental_days');
            const pricePerDayInput = document.getElementById('rental_price_per_day');
            const totalCostInput = document.getElementById('total_cost');
            const depositAmountInput = document.getElementById('deposit_amount');
            const paymentTypeSelect = document.getElementById('payment_type');
            const phoneInput = document.getElementById('phone');
            const nameInput = document.getElementById('name');
            const form = document.querySelector('form');

            // Hàm định dạng tiền tệ
            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            }

            // Hàm cập nhật tổng tiền và tiền đặt cọc
            function updateTotalCost() {
                const rentalDays = parseInt(rentalDaysInput.value) || 0;
                const pricePerDay = parseFloat(pricePerDayInput.value.replace(/[.,₫]/g, '')) || 0;
                const totalCost = rentalDays * pricePerDay;

                totalCostInput.value = formatCurrency(totalCost);

                if (paymentTypeSelect.value === 'deposit') {
                    depositAmountInput.value = formatCurrency(totalCost * 0.3); // 30% của tổng tiền
                } else if (paymentTypeSelect.value === 'full') {
                    depositAmountInput.value = formatCurrency(totalCost); // Thanh toán toàn bộ
                }
            }

            // Lấy thông tin xe khi thay đổi xe thuê
            rentalIdSelect.addEventListener('change', function () {
                const rentalId = rentalIdSelect.value;

                if (rentalId) {
                    fetch(`/admin/rental-car/${rentalId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                const pricePerDay = parseFloat(data.price_per_day.replace(/[.,₫]/g, '')) || 0;
                                pricePerDayInput.value = formatCurrency(pricePerDay);
                                updateTotalCost();
                            }
                        })
                        .catch(error => console.error('Error fetching car details:', error));
                } else {
                    pricePerDayInput.value = '';
                    totalCostInput.value = '';
                    depositAmountInput.value = '';
                }
            });

            // Cập nhật tổng tiền khi thay đổi số ngày thuê
            rentalDaysInput.addEventListener('input', updateTotalCost);

            // Cập nhật tiền đặt cọc khi thay đổi hình thức thanh toán
            paymentTypeSelect.addEventListener('change', updateTotalCost);

            // Xử lý tên khách hàng khi nhập số điện thoại
            phoneInput.addEventListener('input', function () {
                const phone = phoneInput.value;

                if (phone.length >= 10) { // Kiểm tra độ dài số điện thoại
                    fetch(`/admin/customer/get-by-phone?phone=${phone}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                nameInput.value = ''; // Nếu không tìm thấy khách hàng, làm trống ô tên
                                alert(data.error);
                            } else {
                                nameInput.value = data.name; // Điền tên khách hàng vào ô
                            }
                        })
                        .catch(error => console.error('Error fetching customer details:', error));
                } else {
                    nameInput.value = ''; // Làm trống ô tên nếu số điện thoại không đủ ký tự
                }
            });

            // Xử lý dữ liệu trước khi gửi form
            form.addEventListener('submit', function (e) {
                // Loại bỏ định dạng tiền tệ trước khi gửi form
                pricePerDayInput.value = pricePerDayInput.value.replace(/[.,₫]/g, '');
                totalCostInput.value = totalCostInput.value.replace(/[.,₫]/g, '');
                depositAmountInput.value = depositAmountInput.value.replace(/[.,₫]/g, '');
            });
        });

    </script>
    
@endsection