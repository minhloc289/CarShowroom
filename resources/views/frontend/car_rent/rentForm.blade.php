@extends('frontend.layouts.app')
@php
    $user = Auth::guard('account')->user();
@endphp
@section('content')
    <link rel="stylesheet" href="/assets/css/rentForm.css">
    <script src="{{ asset('/assets/js/custom/rentForm.js') }}"></script>
    <div class="min-h-screen w-full bg-gray-100 grid grid-cols-12">
        <!-- Car Info (7 phần) -->
        <div class="col-span-12 md:col-span-7 bg-white shadow-md rounded-none flex flex-col justify-between">
            <div>
                <div class="flex justify-center">
                    <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-auto object-cover rounded-lg">
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center mt-10">
                    <!-- Technical Information -->
                    <div>
                        <img src="/assets/svg/license-plate-number-svgrepo-com.svg" alt="" class="h-10 w-10 mx-auto">
                        <p class="text-sm text-gray-600 mt-2">Biển số xe</p>
                        <p class="text-lg font-bold text-gray-900">{{ $rentalCar->license_plate_number }}</p>
                    </div>
                    <div>
                        <img src="/assets/svg/dollars-money-sale-svgrepo-com.svg" alt="" class="h-10 w-10 mx-auto">
                        <p class="text-sm text-gray-600 mt-2">Giá thuê</p>
                        <p class="text-lg font-bold text-gray-900">{{ number_format($rentalCar->rental_price_per_day, 0) }} VNĐ</p>
                    </div>
                    <div>
                        <img src="/assets/svg/car-seat-svgrepo-com.svg" alt="" class="h-10 w-10 mx-auto">
                        <p class="text-sm text-gray-600 mt-2">Số chỗ</p>
                        <p class="text-lg font-bold text-gray-900">{{ $car->seat_capacity }} chỗ</p>
                    </div>
                    <div>
                        <img src="/assets/svg/speed-one-svgrepo-com.svg" alt="" class="h-10 w-10 mx-auto">
                        <p class="text-sm text-gray-600 mt-2">Tốc độ</p>
                        <p class="text-lg font-bold text-gray-900">{{ $car->max_speed }} km/h</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Form (3 phần) -->
        <div class="col-span-12 md:col-span-5 bg-white shadow-md rounded-none flex flex-col justify-between mt-4">
            <form action="{{route('rent.submit', ['id' => $rentalCar->rental_id])}}" method="POST" id="rental-form" class="flex flex-col justify-between h-[80%]">
                <!-- Tabs -->
                <input type="hidden" name="rental_id" value="{{ $rentalCar->rental_id }}">
                @csrf
                <div class="flex justify-between bg-gray-100">
                    <button type="button" id="info-tab" class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none" onclick="showTab('info')">Thông tin</button>
                    <button type="button" id="terms-tab" class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200 focus:outline-none" onclick="showTab('terms')" disabled>Đặt cọc</button>
                </div>

                <!-- Thông báo lỗi -->
                <div id="error-message" class="hidden fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-300 opacity-100">
                    Vui lòng nhập đầy đủ thông tin!
                </div>



                <!-- Tab content -->
                <div id="info-content" class="tab-content px-6 pt-2 pb-2">
                    <!-- Personal Info Form -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pt-2 pb-2">
                        <!-- Họ và tên -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                            <input type="text" name="name" id="name" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="Nguyễn Văn A" value="{{ $user->name }}">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="nguyenvana@example.com" value="{{ $user->email }}">
                        </div>

                        <!-- Ngày bắt đầu thuê -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu thuê</label>
                            <input type="date" name="start_date" id="start_date" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" min="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Số điện thoại -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="+84 123 456 789" value="{{ $user->phone }}">
                        </div>

                        <!-- Số ngày thuê -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số ngày thuê</label>
                            <input type="number" name="rental_days" id="rental_days" required min="1" value="1" class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" onchange="calculateTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Địa điểm nhận xe</label>
                            <select name="pickup_location" id="pickup_location" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                                <option value="Trường Đại học Công Nghệ Thông Tin" selected>Trường Đại học Công Nghệ Thông Tin</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tổng chi phí -->
                    <div class="p-6">
                        <div class="p-4 bg-blue-100 rounded-md shadow-md">
                            <h3 class="text-lg font-semibold text-gray-900">Tổng chi phí</h3>
                            <p class="text-gray-700 mt-2">Tổng số ngày: <span id="total_days">0</span></p>
                            <p class="text-gray-700">Giá thuê mỗi ngày: <span id="price_per_day">{{ number_format($rentalCar->rental_price_per_day, 0) }}</span> VNĐ</p>
                            <p class="text-lg font-bold text-blue-600 mt-4">Tổng cộng: <span id="total_price">0</span> VNĐ</p>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Nút xác nhận thông tin -->
                        <div class="flex justify-center">
                            <button type="button" id="confirm-info" class="px-10 py-3 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 shadow-md transition-all" onclick="goToTermsTab()">
                                Xác nhận thông tin
                            </button>
                        </div>
                    </div>
                </div>

                <div id="terms-content" class="tab-content hidden px-6 py-4">
                    <!-- Điều khoản và dịch vụ -->
                    <div class="space-y-6 max-w-4xl mx-auto p-4">
                        <!-- Thông tin người thuê -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-blue-600">Thông tin người thuê</h3>
                            <p class="text-gray-700">Họ và tên: <span id="terms-name" class="font-medium">Nguyễn Văn A</span></p>
                            <p class="text-gray-700">Số điện thoại: <span id="terms-phone" class="font-medium">+84 123 456 789</span></p>
                            <p class="text-gray-700">Ngày bắt đầu thuê: <span id="terms-start-date" class="font-medium">2024-12-10</span></p>
                            <p class="text-gray-700">Địa điểm nhận xe: <span id="terms-pickup-location" class="font-medium">Trường Đại học Công Nghệ Thông Tin</span></p>
                        </div>
                
                        <!-- Thông tin giá xe -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-blue-600">Giá xe</h3>
                            <p class="text-gray-700">Số ngày thuê: <span id="terms-total-days" class="font-medium">1</span></p>
                            <p class="text-lg font-bold text-blue-600">Tổng cộng: <span id="terms-total-pay">1,000,000</span> VNĐ</p>
                            <p class="text-lg font-semibold text-gray-900">Tiền đặt cọc: <span id="terms-deposit-amount">300,000</span> VNĐ</p>
                        </div>

                        <div class="border-t border-gray-300 my-4"></div>
                
                        <!-- Điều khoản và dịch vụ -->
                        <div class="flex justify-start items-center space-x-2 mt-6">
                            <input type="checkbox" id="agree-terms" class="w-5 h-5 border-gray-300 focus:ring-blue-500" required>
                            <label for="agree-terms" class="text-gray-700">
                                Tôi đồng ý với các <a href="{{ route('CustomerDashBoard.terms') }}" target="_blank" class="text-blue-500 hover:underline">Điều khoản & Dịch vụ</a> của Merus.
                            </label>
                        </div>

                        <input type="hidden" name="total_cost" id="hidden-total-cost">
                        <input type="hidden" name="deposit_amount" id="hidden-deposit-amount">
                        <input type="hidden" name="rental_price_per_day" id="hidden-rental-price-per-day" value="{{ $rentalCar->rental_price_per_day }}">


                        <!-- Nút xác nhận thanh toán -->
                        <div class="flex justify-center mt-6">
                            <button type="button" id="confirm-payment" class="px-10 py-3 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 shadow-md transition-all" onclick="confirmPayment()">
                                Xác nhận thanh toán
                            </button>
                        </div>
                    </div>
                </div>                                       
            </form>
        </div>
    </div>

    <script>
        // Tính tổng chi phí khi thay đổi số ngày thuê
        function calculateTotal() {
            const days = document.getElementById('rental_days').value || 0;
            const pricePerDay = {{ $rentalCar->rental_price_per_day }};
            const totalPrice = days * pricePerDay;
            const depositAmount = totalPrice * 0.3;

            // Cập nhật thông tin hiển thị
            document.getElementById('total_days').textContent = days;
            document.getElementById('total_price').textContent = new Intl.NumberFormat('vi-VN').format(totalPrice);
            document.getElementById('terms-total-days').textContent = days;
            document.getElementById('terms-total-pay').textContent = new Intl.NumberFormat('vi-VN').format(totalPrice);
            document.getElementById('terms-deposit-amount').textContent = new Intl.NumberFormat('vi-VN').format(depositAmount);

            // Cập nhật các trường input ẩn
            document.getElementById('hidden-total-cost').value = totalPrice;
            document.getElementById('hidden-deposit-amount').value = depositAmount;
            document.getElementById('hidden-rental-price-per-day').value = pricePerDay;
        }

        // Cập nhật tab "Điều khoản và dịch vụ" với thông tin từ tab "Thông tin"
        function updateTermsTab() {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const startDate = document.getElementById('start_date').value;
            const location = document.getElementById('pickup_location').value;

            // Cập nhật thông tin người thuê
            document.getElementById('terms-name').textContent = name;
            document.getElementById('terms-phone').textContent = phone;
            document.getElementById('terms-start-date').textContent = startDate;
            document.getElementById('terms-pickup-location').textContent = location;
        }

        document.addEventListener('DOMContentLoaded', function () {
            calculateTotal();
        });
    </script>
@endsection