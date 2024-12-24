@extends('Backend.dashboard.layout')

@section('content')

    <div class="container mx-auto px-4 sm:px-8 py-8">
        <!-- Background form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Tiêu đề -->
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Thêm Mới Lái Thử</h2>
    
            <!-- Form thêm mới -->
            <form action="{{ route('email.RegisterTestDrive') }}" method="POST">
                @csrf
                <!-- Tên khách hàng -->
                <div class="mb-4">
                    <label for="customer_name" class="block text-gray-600 font-medium mb-1">Tên Khách Hàng</label>
                    <input type="text" id="customer_name" name="customer_name" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                    @error('customer_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Số điện thoại -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-600 font-medium mb-1">Số Điện Thoại</label>
                    <input type="text" id="phone_number" name="phone_number" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" value="{{ old('phone') }}">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                {{--  --}}
                <input type="text" class="hidden" name="car_id" id="car_id" value="">
                <input type="text" class="hidden" name="car_url" id="car_url" value="">
                {{--  --}}
                <div class="flex space-x-4 mb-4">
                    <!-- Left Side (Form Fields) -->
                    <div class="w-1/3 space-y-4">
                        <!-- Chọn Brand -->
                        <div>
                            <label for="car_type" class="block text-gray-600 font-medium mb-1">Car Brand *</label>
                            <select id="car_type" name="car_type" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select Car Brand</option>
                                @foreach ($carsByBrand as $brand => $cars)
                                    <option value="{{ $brand }}">{{ $brand }}</option>
                                @endforeach
                            </select>
                            @error('car_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <!-- Chọn Car Name -->
                        <div>
                            <label for="car_model" class="block text-gray-600 font-medium mb-1">Car Name *</label>
                            <select id="car_model" name="car_model" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select Car Name</option>
                            </select>
                            @error('car_model')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <!-- Ngày lái thử -->
                        <div>
                            <label for="test_drive_date" class="block text-gray-600 font-medium mb-1">Ngày lái thử *</label>
                            <input type="date" id="test_drive_date" name="test_drive_date" 
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                                min="{{ date('Y-m-d') }}" value="{{ old('test_drive_date') }}" required>
                            @error('test_drive_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                
                    <!-- Right Side (Car Image) -->
                    <div class="w-2/3 flex justify-center items-center">
                        <img id="car_image" src="assets/img/logo (2).png" alt="Car Image" class="w-full max-w-[50%] rounded-lg">
                    </div>
                </div>
                

                {{-- Other Request --}}
                <div class="mb-4">
                    <label for="other_request" class="block text-gray-600 font-medium mb-1">Other Requests</label>
                    <textarea id="other_request" name="other_request" rows="3" 
                              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                              placeholder="Enter any additional requests or comments here"></textarea>
                    @error('other_request')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Nút Submit -->
                <div class="mt-6">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition">
                        Tạo Lái Thử
                    </button>
                </div>
            </form>
            
        </div>
    </div>    



    <script>
        // Js chọn ngày
        document.addEventListener('DOMContentLoaded', function () {
            const testDriveDateInput = document.getElementById('test_drive_date');
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
            const dd = String(today.getDate()).padStart(2, '0');
            const minDate = `${yyyy}-${mm}-${dd}`;
        
            if (testDriveDateInput) {
                // Gán giá trị min cho input
                testDriveDateInput.setAttribute('min', minDate);
        
                // Thêm sự kiện kiểm tra ngày
                testDriveDateInput.addEventListener('change', function () {
                    const selectedDate = new Date(this.value);
                    if (selectedDate < today) {
                        alert('Ngày lái thử phải lớn hơn hoặc bằng ngày hôm nay.');
                        this.value = ''; // Xóa giá trị nếu không hợp lệ
                    }
                });
            }
        });

        // JS chọn xe
       
        document.addEventListener('DOMContentLoaded', function () {
    const carBrandDropdown = document.getElementById('car_type');
    const carNameDropdown = document.getElementById('car_model');
    const carImage = document.getElementById('car_image');
    const carIdInput = document.getElementById('car_id');
    const carUrlInput = document.getElementById('car_url');

    const carsByBrand = @json($carsByBrand);

    if (carBrandDropdown && carNameDropdown && carImage && carIdInput && carUrlInput) {
        // Handle Brand Selection
        carBrandDropdown.addEventListener('change', function () {
            const selectedBrand = this.value;

            // Reset Car Name Dropdown
            carNameDropdown.innerHTML = '<option value="">Select Car Name</option>';

            // Populate Car Name Dropdown
            if (carsByBrand[selectedBrand]) {
                carsByBrand[selectedBrand].forEach(car => {
                    const option = document.createElement('option');
                    option.value = `${car.name} - ${car.model}`; // Set value as "name - model"
                    option.textContent = `${car.name} - ${car.model}`;
                    option.setAttribute('data-image', car.image_url);
                    option.setAttribute('data-id', car.car_id);
                    carNameDropdown.appendChild(option);
                });
            }
        });

        // Handle Car Name Selection
        carNameDropdown.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const imageUrl = selectedOption.getAttribute('data-image') || 'assets/img/logo (2).png';
            const carID = selectedOption.getAttribute('data-id');

            // Update Image and Hidden Inputs   
            carImage.setAttribute('src', imageUrl);
            carUrlInput.value = imageUrl;
            carIdInput.value = carID; // Set car_id in the hidden input
        });
    } else {
        console.error("Required elements not found!");
    }
});



        </script>
        
@endsection