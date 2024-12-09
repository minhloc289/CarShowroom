@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="/assets/css/rentForm.css">
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
                        <p class="text-lg font-bold text-gray-900">{{ number_format($rentalCar->rental_price_per_day, 0) }}
                            VNĐ</p>
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
            <form action="#" method="POST" id="rental-form" class="flex flex-col justify-between h-[80%]">
                <!-- Tabs -->
                <div class="flex justify-between bg-gray-100">
                    <button type="button" id="info-tab" class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200  focus:outline-none" onclick="showTab('info')">Thông tin</button>
                    <button type="button" id="deposit-tab" class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200  focus:outline-none" onclick="showTab('deposit')" disabled>Đặt cọc</button>
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
                            <input type="text" name="name" id="name" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="John Doe">
                        </div>
        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="john@example.com">
                        </div>
        
                        <!-- Ngày bắt đầu thuê -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu thuê</label>
                            <input type="date" name="start_date" id="start_date" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" min="{{ date('Y-m-d') }}">
                        </div>
        
                        <!-- Số điện thoại -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" required class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" placeholder="+84 123 456 789">
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
                            <button type="button" id="confirm-info" class="px-10 py-3 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 shadow-md transition-all" onclick="goToDepositTab()">
                                Xác nhận thông tin
                            </button>
                        </div>
                    </div>
                </div>
        
                <div id="deposit-content" class="tab-content hidden p-4">
                    <!-- Đặt cọc -->
                    <div class="space-y-6 max-w-4xl mx-auto">
                        <!-- Thông tin người thuê -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-blue-600">Thông tin người thuê</h3>
                            <p class="text-gray-700">Họ và tên: <span id="deposit-name">John Doe</span></p>
                            <p class="text-gray-700">Số điện thoại: <span id="deposit-phone">+84 123 456 789</span></p>
                            <p class="text-gray-700">Ngày bắt đầu thuê: <span id="deposit-start-date">2024-12-10</span></p>
                        </div>
                
                        <!-- Đường ngăn cách -->
                        <div class="border-t border-gray-300 my-2"></div>
                
                        <!-- Thông tin giá xe -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-blue-600">Giá xe</h3>
                            <p class="text-gray-700">Số ngày thuê: <span id="total_days">1</span></p>
                            <p class="text-lg font-bold text-blue-600 mt-4">Tổng cộng: <span id="total_pay">0</span> VNĐ</p>
                            <p class="text-lg font-semibold text-gray-900 mt-4">Tiền đặt cọc: <span id="deposit-amount">1,000,000</span> VNĐ</p>
                        </div>

                        <div class="border-t border-gray-300 my-2"></div>
                
                        <!-- Điều kiện thuê -->
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-blue-600">Điều kiện thuê</h3>
                            <p class="text-gray-700" id="rental_conditions">{{ $rentalCar->rental_conditions }}</p>
                        </div>
                
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
            const pricePerDay = {{ $rentalCar->rental_price_per_day }}; // Giá thuê mỗi ngày
            const totalPrice = days * pricePerDay;

            // Cập nhật UI thông tin tổng tiền ở phần thông tin
            document.getElementById('total_days').textContent = days;
            document.getElementById('total_price').textContent = new Intl.NumberFormat('vi-VN').format(totalPrice);

        }

        let isConfirmed = false;
        // Hiển thị các tab
        function showTab(tab) {
            // Kiểm tra nếu chuyển sang tab Đặt cọc mà thông tin chưa được xác nhận
            if (tab === 'deposit' && !isInfoConfirmed) {
                // Nếu chưa xác nhận thông tin, không cho phép chuyển tab và hiển thị thông báo lỗi
                return; // Không chuyển tab
            }

            // Ẩn tất cả các tab
            document.getElementById('info-content').classList.add('hidden');
            document.getElementById('deposit-content').classList.add('hidden');

            // Hiển thị tab hiện tại
            if (tab === 'info') {
                document.getElementById('info-content').classList.remove('hidden');
            } else if (tab === 'deposit') {
                document.getElementById('deposit-content').classList.remove('hidden');
            }
        }

        // Chuyển sang tab "Đặt cọc" nếu thông tin hợp lệ
        function goToDepositTab() {
            // Kiểm tra thông tin người dùng đã nhập
            if (validateInfo()) {
                // Lấy thông tin từ tab "Thông tin" và điền vào tab "Đặt cọc"
                updateDepositTab();

                // Đánh dấu thông tin đã xác nhận
                isInfoConfirmed = true;

                // Kích hoạt lại nút Đặt cọc
                document.getElementById('deposit-tab').disabled = false;

                // Chuyển sang tab Đặt cọc
                showTab('deposit');
                document.getElementById('error-message').classList.add('hidden'); // Ẩn thông báo lỗi
            } else {
                // Hiển thị thông báo lỗi nếu thông tin không hợp lệ
                alert("Thông tin không hợp lệ!");
            }
        }

    
        // Kiểm tra tính hợp lệ của thông tin
        function validateInfo() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const startDate = document.getElementById('start_date').value;
            const phone = document.getElementById('phone').value;
            const rentalDays = document.getElementById('rental_days').value;

            if (name && email && startDate && phone && rentalDays > 0) {
                return true; // Nếu tất cả thông tin hợp lệ
            } else {
                return false; // Nếu có thông tin không hợp lệ
            }
        }
    
        // Cập nhật tab "Đặt cọc" với thông tin từ tab "Thông tin"
        function updateDepositTab() {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const startDate = document.getElementById('start_date').value;
            const rentalDays = document.getElementById('rental_days').value;
            const rentalPrice = {{ $rentalCar->rental_price_per_day }}; // Giá thuê mỗi ngày

            // Cập nhật thông tin người thuê
            document.getElementById('deposit-name').textContent = name;
            document.getElementById('deposit-phone').textContent = phone;
            document.getElementById('deposit-start-date').textContent = startDate;

            // Tính tổng tiền thuê
            const totalPrice = rentalDays * rentalPrice;

            // Cập nhật thông tin tổng tiền
            document.getElementById('total_pay').textContent = new Intl.NumberFormat('vi-VN').format(totalPrice);

            // Tính tiền đặt cọc (30% của tổng tiền)
            const depositAmount = totalPrice * 0.30; // Tính 30% tiền đặt cọc

            // Cập nhật tổng tiền đặt cọc
            document.getElementById('deposit-amount').textContent = new Intl.NumberFormat('vi-VN').format(depositAmount);
        }

    
        // Xác nhận thanh toán và gửi form
        function confirmPayment() {
            // Hiển thị thông báo thanh toán thành công
            alert("Thanh toán đặt cọc thành công!");
    
            // Gửi form
            document.getElementById('rental-form').submit();
        }

        document.addEventListener('DOMContentLoaded', function () {
            calculateTotal();
        });
        

    </script>      
@endsection
