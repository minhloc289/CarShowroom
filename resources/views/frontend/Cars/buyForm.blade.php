@extends('frontend.layouts.app')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('account')->user();
@endphp
@section('content')
<link rel="stylesheet" href="/assets/css/buyForm.css">
<div class="min-h-screen w-full bg-gray-100 grid grid-cols-12">
    <!-- Car Info (7 phần) -->
    <div class="col-span-12 md:col-span-7 bg-white shadow-md rounded-none flex flex-col justify-between">
        <div>
            <div class="flex justify-center">
                <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-auto object-cover rounded-lg">
            </div>
        </div>
    </div>

    <!-- Buy Form (3 phần) -->
    <div class="col-span-12 md:col-span-5 bg-white shadow-md rounded-none flex flex-col justify-between mt-4">
        <div class="flex flex-col justify-between h-[80%]">
            <!-- Tabs -->
            <div class="flex justify-between bg-gray-100">
                <button type="button" id="info-tab"
                    class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200  focus:outline-none"
                    onclick="showTab('info')">Thông tin</button>
                <button type="button" id="payment-tab"
                    class="w-full text-center py-4 px-4 font-medium text-gray-700 hover:bg-gray-200  focus:outline-none"
                    onclick="showTab('payment')" disabled>Thanh toán</button>
            </div>

            <!-- Thông báo lỗi -->
            <div id="error-message"
                class="hidden fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-300 opacity-100">
                Vui lòng nhập đầy đủ thông tin!
            </div>

            <!-- Tab content -->
            <div id="info-content" class="tab-content px-6 pt-2 pb-2">
                <!-- Personal Info Form -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pt-2 pb-2">
                    <!-- Họ và tên -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                        <input type="text" name="name" id="name" required readonly
                            class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 bg-gray-100"
                            value="{{ $user->name }}">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" required readonly
                            class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 bg-gray-100"
                            value="{{ $user->email }}">
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="tel" name="phone" id="phone" required readonly
                            class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 bg-gray-100"
                            value="{{ $user->phone }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày đặt cọc: </label>
                        <input type="date" name="date" id="date" required readonly
                            class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 bg-gray-100">
                    </div>
                </div>


                <!-- Tổng chi phí -->
                <div class="p-6">
                    <div class="p-4 bg-blue-100 rounded-md shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">Tổng chi phí</h3>
                        <p class="text-gray-700 mt-2">Giá xe: <span
                                id="car_price">{{ number_format($car->sale->sale_price ?? $car->price, 0) }}</span> VNĐ
                        </p>
                        <p class="text-gray-700 mt-2">Tiền cọc (15%): <span id="deposit_amount"></span> VNĐ</p>
                        <p class="text-gray-700 mt-2">Còn lại: <span id="remaining_amount"></span> VNĐ</p>
                        <p class="text-lg font-bold text-blue-600 mt-4">Tổng cộng: <span
                                id="total_price">{{ number_format($car->sale->sale_price ?? $car->price, 0) }}</span>
                            VNĐ</p>
                    </div>
                </div>

                <div class="flex justify-start items-center space-x-2 mt-6">
                    <input type="checkbox" id="agree-terms" class="w-5 h-5 border-gray-300 focus:ring-blue-500"
                        required>
                    <label for="agree-terms" class="text-gray-700">
                        Tôi đồng ý với các <a href="{{ route('CustomerDashBoard.terms') }}" target="_blank"
                            class="text-blue-500 hover:underline">Điều khoản & Dịch vụ</a> của Merus.
                    </label>
                </div>
                <div class="p-4">
                    <!-- Nút xác nhận thông tin -->
                    <div class="flex justify-center">
                        <button type="button" id="confirm-info"
                            class="px-10 py-3 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 shadow-md transition-all"
                            onclick="goToDepositTab()">
                            Xác nhận thông tin
                        </button>
                    </div>
                </div>
            </div>

            <div id="payment-content" class="tab-content hidden p-4">
                <!-- Payment Section -->
                <div class="space-y-6 max-w-4xl mx-auto">
                    <!-- Thông tin người mua -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-blue-600">Thông tin người mua</h3>
                        <p class="text-gray-700">Họ và tên: <span id="payment-name">John Doe</span></p>
                        <p class="text-gray-700">Số điện thoại: <span id="payment-phone">+84 123 456 789</span></p>
                        <p class="text-gray-700">Ngày đặt cọc: <span id="payment-date">mm/dd/yyyy</span></p>
                    </div>

                    <div class="border-t border-gray-300 my-2"></div>

                    <!-- Thông tin thanh toán -->
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-blue-600">Giá xe</h3>
                        <p class="text-gray-700">Giá xe: <span
                                id="payment-car-price">{{ number_format($car->sale->sale_price ?? $car->price, 0) }}</span>
                            VNĐ</p>
                        <p class="text-gray-700">Tiền cọc (15%): <span id="payment-deposit-amount"
                                name="payment-deposit-amount"></span> VNĐ</p>
                        <p class="text-gray-700">Còn lại: <span id="payment-remaining-amount"></span> VNĐ</p>
                        <p class="text-lg font-bold text-blue-600 mt-4">Tổng cộng: <span
                                id="payment-total-price">{{ number_format($car->sale->sale_price ?? $car->price, 0) }}</span>
                            VNĐ</p>

                    </div>

                    <div class="border-t border-gray-300 my-2"></div>

                    <!-- Nút xác nhận thanh toán -->
                    <div class="flex justify-center mt-6">
                        <form action={{url('/vnpay_payment')}} method="POST">
                            @if ($car->sale) <!-- Kiểm tra nếu car->sale tồn tại -->
                                @csrf
                                <input type="hidden" name="sale_id" value="{{ $car->sale->sale_id }}">
                                <input type="hidden" name="total-price" value="{{ $car->sale->sale_price }}">
                                <input type="hidden" name="remaining_amount" id="payment-remaining-amount-input">
                                <input type="hidden" name="payment_deposit_amount" id="payment-deposit-amount-input">
                                <button type="submit" name="redirect"
                                    class="px-10 py-3 bg-green-600 text-white font-bold rounded-md hover:bg-green-700 shadow-md transition-all">
                                    Xác nhận thanh toán
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let isInfoConfirmed = false;

    // Hiển thị các tab
    function showTab(tab) {
        // Nếu tab "Thanh toán" được chọn mà thông tin chưa được xác nhận
        if (tab === 'payment' && !isInfoConfirmed) {
            alert("Vui lòng xác nhận thông tin trước khi thanh toán!");
            return;
        }

        // Ẩn tất cả các tab
        document.getElementById('info-content').classList.add('hidden');
        document.getElementById('payment-content').classList.add('hidden');

        // Hiển thị tab hiện tại
        if (tab === 'info') {
            document.getElementById('info-content').classList.remove('hidden');
        } else if (tab === 'payment') {
            document.getElementById('payment-content').classList.remove('hidden');
        }
    }

    // Chuyển sang tab "Thanh toán" nếu thông tin hợp lệ
    function goToDepositTab() {
        const agreeTerms = document.getElementById('agree-terms');

        if (!agreeTerms.checked) {
            alert("Vui lòng đồng ý với Điều khoản & Dịch vụ trước khi tiếp tục!");
            return;
        }

        if (validateInfo()) {
            // Lấy thông tin từ tab "Thông tin" và điền vào tab "Thanh toán"
            updatePaymentTab();

            // Đánh dấu thông tin đã xác nhận
            isInfoConfirmed = true;

            // Kích hoạt lại nút "Thanh toán"
            document.getElementById('payment-tab').disabled = false;

            // Chuyển sang tab "Thanh toán"
            showTab('payment');
        } else {
            // Hiển thị thông báo lỗi nếu thông tin không hợp lệ
            alert("Vui lòng nhập đầy đủ thông tin!");
        }
    }

    // Kiểm tra tính hợp lệ của thông tin
    function validateInfo() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        if (name && email && phone) {
            return true; // Thông tin hợp lệ
        } else {
            return false; // Thông tin không hợp lệ
        }
    }

    // Cập nhật tab "Thanh toán" với thông tin từ tab "Thông tin"
    function updatePaymentTab() {
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const date = document.getElementById('date').value.trim();

        // Cập nhật thông tin người mua
        document.getElementById('payment-name').textContent = name;
        document.getElementById('payment-phone').textContent = phone;
        document.getElementById('payment-date').textContent = date;

        // Cập nhật thông tin giá xe
        const carPriceText = document.getElementById('car_price').textContent.replace(/,/g, '');
        const carPrice = parseFloat(carPriceText);

        // Tính toán tiền cọc (15%) và số còn lại
        const depositAmount = Math.round(carPrice * 0.15);
        const remainingAmount = carPrice - depositAmount;


        // Hiển thị tiền cọc và số còn lại trong tab thanh toán
        document.getElementById('payment-deposit-amount').textContent = depositAmount.toLocaleString();
        document.getElementById('payment-deposit-amount-input').value = depositAmount.toLocaleString();
        document.getElementById('payment-remaining-amount').textContent = remainingAmount.toLocaleString();
        document.getElementById('payment-remaining-amount-input').value = remainingAmount.toLocaleString();

    }


    // Xác nhận thanh toán và gửi form

    // Sự kiện khi DOM đã tải xong
    document.addEventListener('DOMContentLoaded', function () {
        // Đảm bảo chỉ tab "Thông tin" được hiển thị ban đầu
        showTab('info');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('date');
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; // Định dạng ngày (yyyy-MM-dd)
        startDateInput.value = formattedDate; // Gán giá trị ngày hiện tại
        // Tính toán và hiển thị thông tin ban đầu
        updateInitialCosts();
    });
    function updateInitialCosts() {
        // Lấy giá xe
        const carPriceText = document.getElementById('car_price').textContent.replace(/,/g, '');
        const carPrice = parseFloat(carPriceText);

        // Tính toán tiền cọc (15%) và số còn lại
        const depositAmount = Math.round(carPrice * 0.15);
        const remainingAmount = carPrice - depositAmount;

        // Hiển thị thông tin ban đầu
        document.getElementById('deposit_amount').textContent = depositAmount.toLocaleString();
        document.getElementById('remaining_amount').textContent = remainingAmount.toLocaleString();

        // Cập nhật giá trong tab thanh toán
        document.getElementById('payment-deposit-amount').textContent = depositAmount.toLocaleString();
        document.getElementById('payment-remaining-amount').textContent = remainingAmount.toLocaleString();
    }

</script>

@endsection