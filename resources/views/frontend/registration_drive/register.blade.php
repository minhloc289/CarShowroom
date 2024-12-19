@extends('frontend.layouts.App')

@section('content')
<div class="flex justify-center items-center h-screen ">
    <!-- Left Side: Form -->
    <div class="w-1/2 p-4 bg-green-100 ml-10 mt-10">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold uppercase ">Test Drive Registration</h1>
            <p>To register for a test drive, you need to provide your driver's license to Merus.</p>
        </div>
        <form action="" method="POST" class="space-y-6 max-w-[80%] mx-auto">
            @csrf
            <!-- Các trường nhập liệu chính -->
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Your Full Name *</label>
                <input type="text" id="customer_name" name="customer_name" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" maxlength="80" required>
            </div>
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="text" id="phone_number" name="phone_number" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                </div>
                <div class="w-1/2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" id="email" name="email" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                </div>
            </div>
            {{-- Chọn xe --}}
            <div class="flex space-x-4">
                <!-- Dòng xe -->
                <div class="w-1/2">
                    <label for="car_type" class="block text-sm font-medium text-gray-700">Car Brand *</label>
                    <select id="car_type" name="car_type" class="mt-1 w-full px-3 py-2 rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Select Car Brand</option>
                        @foreach ($carsByBrand as $brand => $cars)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Tên xe -->
                <div class="w-1/2">
                    <label for="car_model" class="block text-sm font-medium text-gray-700">Car Name *</label>
                    <select id="car_model" name="car_model" class="mt-1 w-full px-3 py-2 rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Select Car Name</option>
                    </select>
                </div>
            </div>
            
            
            {{-- ---------------------------------------- --}}
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="city" class="block text-sm font-medium text-gray-700">Province *</label>
                    <select id="city" name="city" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Select Province</option>
                        <option value="Hanoi">Hà Nội</option>
                        <option value="HoChiMinh">Hồ Chí Minh</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <label for="showroom" class="block text-sm font-medium text-gray-700">Showroom *</label>
                    <select id="showroom" name="showroom" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
                        <option value="">Select showroom</option>
                        <option value="Showroom 1">Showroom 1</option>
                        <option value="Showroom 2">Showroom 2</option>
                    </select>
                </div>
            </div>
            
            {{-- ngày lái thử  --}}

            <div>
                <label for="test_drive_date" class="block text-sm font-medium text-gray-700">Select Test Drive Date *</label>
                <input type="date" id="test_drive_date" name="test_drive_date" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" required>
            </div>
            

            <!-- Thêm phần yêu cầu khác -->
            <div>
                <label for="other_request" class="block text-sm font-medium text-gray-700 uppercase">Other Requirements</label>
                <textarea id="other_request" name="other_request" rows="3" maxlength="100" placeholder="Please enter your request here" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50"></textarea>
                <div  id="charCount" class="text-sm text-gray-500 text-right">0/50</div>
            </div>
    
            <!-- Nút đăng ký -->
            <div class="flex justify-center">
                <button type="submit" class="w-full py-2 px-4 bg-blue-800 text-white rounded-md hover:bg-gray-500 focus:outline-none focus:bg-gray-500 uppercase">Test Drive Registration</button>
            </div>
    
            <!-- Checkbox và thông tin hotline -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="subscribe" name="subscribe" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-600">
                <label for="subscribe" class="text-sm text-gray-700">Sign up to receive promotional offers and services from Merus</label>
            </div>
            <p class="text-sm text-gray-600 text-center mt-4">For any inquiries, please contact us - <strong class="text-blue-600">HOTLINE - 0377892859</strong></p>
        </form>
    </div>
    
    <!-- Right Side: Car Image -->
    <div class="w-1/2 flex justify-center items-center">
        <img id="car_image" src="assets/img/logo (2).png" alt="Car Image" class=" h-auto max-w-[90%] rounded-lg">
    </div>
    
</div>
<script>
    const carsByBrand = @json($carsByBrand);
</script>
<script src="{{ asset('/assets/js/custom/register.js') }}"></script>
@endsection

