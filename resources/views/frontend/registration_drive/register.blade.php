@extends('frontend.layouts.App')

@section('content')
<div class="flex justify-center items-center h-screen ">
    <!-- Left Side: Form -->
    <div class="w-1/2 p-4 bg-green-100 ml-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold">ĐĂNG KÝ LÁI THỬ</h1>
            <p>Để đăng ký lái thử, Quý khách cần cung cấp giấy phép lái xe cho Merus</p>
        </div>
        <form action="" method="POST" class="space-y-6 max-w-[80%] mx-auto">
            @csrf
            <!-- Các trường nhập liệu chính -->
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Họ và tên Quý khách *</label>
                <input type="text" id="customer_name" name="customer_name" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" maxlength="80" required>
            </div>
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Số điện thoại *</label>
                    <input type="text" id="phone_number" name="phone_number" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                </div>
                <div class="w-1/2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" id="email" name="email" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                </div>
            </div>
            <div>
                <label for="car_model" class="block text-sm font-medium text-gray-700">Lựa chọn mẫu xe *</label>
                <select id="car_model" name="car_model" class="mt-1 w-full px-3 py-2 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                    <option value="">Chọn mẫu xe</option>
                    <option value="Model A" data-image="assets/img/bugati1.png">Model A</option>
                    <option value="Model B" data-image="assets/img/mercedes2.jpg">Model B</option>
                </select>
            </div>
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="city" class="block text-sm font-medium text-gray-700">Tỉnh thành *</label>
                    <select id="city" name="city" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Chọn tỉnh thành</option>
                        <option value="Hanoi">Hà Nội</option>
                        <option value="HoChiMinh">Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <label for="showroom" class="block text-sm font-medium text-gray-700">Showroom *</label>
                    <select id="showroom" name="showroom" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Chọn showroom</option>
                        <option value="Showroom 1">Showroom 1</option>
                        <option value="Showroom 2">Showroom 2</option>
                    </select>
                </div>
            </div>
    
            <!-- Thêm phần yêu cầu khác -->
            <div>
                <label for="other_request" class="block text-sm font-medium text-gray-700">YÊU CẦU KHÁC</label>
                <textarea id="other_request" name="other_request" rows="3" maxlength="50" placeholder="Ghi yêu cầu của Quý khách tại đây" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50"></textarea>
                <div class="text-sm text-gray-500 text-right">0/50</div>
            </div>
    
            <!-- Nút đăng ký -->
            <div class="flex justify-center">
                <button type="submit" class="w-full py-2 px-4 bg-gray-400 text-white rounded-md hover:bg-gray-500 focus:outline-none focus:bg-gray-500">ĐĂNG KÝ LÁI THỬ</button>
            </div>
    
            <!-- Checkbox và thông tin hotline -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="subscribe" name="subscribe" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-600">
                <label for="subscribe" class="text-sm text-gray-700">Đăng ký nhận thông tin chương trình khuyến mãi, dịch vụ từ Merus</label>
            </div>
            <p class="text-sm text-gray-600 text-center mt-4">Mọi thắc mắc xin liên hệ - <strong class="text-blue-600">HOTLINE - 0377892859</strong></p>
        </form>
    </div>
    
    <!-- Right Side: Car Image -->
    <div class="w-1/2 flex justify-center items-center">
        <img id="car_image" src="assets/img/mercedes.png" alt="Car Image" class="w-3/4 h-auto max-w-lg rounded-lg">
    </div>
    
</div>



<script>
    // JavaScript to dynamically update car image based on selection
    document.getElementById('car_model').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const imageUrl = selectedOption.getAttribute('data-image') || 'assets/img/porsche_panamera.jpg';
        document.getElementById('car_image').setAttribute('src', imageUrl);
    });
</script>
@endsection
