@extends('Backend.dashboard.layout')

@section('content') 
<x-breadcrumbs breadcrumb="carsales" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Quản lý xe bán</h1>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" id="addCarButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Thêm
                </button>
                <ul class="dropdown-menu" aria-labelledby="addCarButton">
                    <li><a class="dropdown-item" href="{{route('car.create')}}">Thêm 1 xe</a></li>
                    <li><a class="dropdown-item" href="{{route('cars.upload')}}">Thêm nhiều xe</a></li>
                </ul>
            </div>
        </div>

        <!-- Bộ lọc và tìm kiếm -->
        <div class="flex items-center space-x-4 mb-4">
            <input type="text" id="carSearchInput" placeholder="Search"
                class="rounded-lg border border-gray-300 px-4 py-2 w-64">

            <!-- Select Engine Type -->
            <select id="engineTypeFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">All Engine Types</option>
                @foreach ($engineTypes as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>

            <!-- Select Seat Capacity -->
            <select id="seatCapacityFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">All Seat Capacities</option>
                @foreach ($seatCapacities as $capacity)
                    <option value="{{ $capacity }}">{{ $capacity }}</option>
                @endforeach
            </select>

            <!-- Select Brand -->
            <select id="brandFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                <option value="">All Brands</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>
        </div>

        <!-- Danh sách xe -->
        <div id="carsContainer" class="d-flex flex-column">
            @foreach ($cars as $index => $car)
                @if ($car->sale) <!-- Kiểm tra nếu car->sale tồn tại -->
                    <div class="car-item align-items-center justify-content-between border bg-white shadow-sm p-4 rounded-lg mb-3"
                        data-index="{{ $index }}" style="width: 100%;">
                        <div class="d-flex align-items-center">
                            <img src="{{ $car->image_url }}" class="rounded-lg" alt="{{ $car->name }}"
                                style="width: 120px; height: auto;">
                            <h2 class="text-xl font-bold ms-3 mb-0">{{ $car->brand }} - {{ $car->model }}</h2>
                            <h2 class="text-xl font-bold ms-3 mb-0">{{ $car->name }}</h2>
                            <h2 class="text-xl font-bold ms-3 mb-0">${{ number_format($car->sale->sale_price, 2) }}</h2>
                            <!-- Chỉ hiển thị giá bán nếu car->sale tồn tại -->
                            <p class="text-lg text-gray-500 hidden">{{ $car->brand }}</p>
                            <p class="text-gray-600 hidden">Seats: {{ $car->seat_capacity }}</p>
                            <p class="text-gray-700 hidden">Engine Type: {{ $car->engine_type }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('show.car.details', ['carId' => $car->car_id]) }}" class="btn"
                                style="background-color: #0194e7; color: white; margin-right: 8px;">Xem chi tiết</a>
                            <a href="{{ route('show.car.edit', ['carId' => $car->car_id]) }}"
                                class="btn btn-warning me-2">Sửa</a>
                            <form action="{{ route('sales.cars.destroy', ['carId' => $car->sale->sale_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background-color: #de3333; color: white;">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endif <!-- Kết thúc kiểm tra nếu car->sale tồn tại -->
            @endforeach

        </div>

        <!-- View All Button -->
        <div class="text-center mt-8">
            <button id="viewAllButton" class="text-blue-500 text-sm font-semibold hover:underline">View more →</button>
        </div>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('carSearchInput');
        const engineTypeFilter = document.getElementById('engineTypeFilter');
        const seatCapacityFilter = document.getElementById('seatCapacityFilter');
        const brandFilter = document.getElementById('brandFilter');
        const carItems = document.querySelectorAll('.car-item'); // Lấy tất cả các xe
        const viewAllButton = document.getElementById('viewAllButton'); // Nút "View more"

        let currentItemCount = 10; // Số lượng xe hiển thị ban đầu
        const totalItems = carItems.length; // Tổng số xe trong danh sách

        // Ẩn các xe không cần thiết khi trang load
        const hideExtraCars = () => {
            for (let i = 0; i < totalItems; i++) {
                carItems[i].style.display = i < currentItemCount ? 'flex' : 'none'; // Hiển thị 10 xe đầu tiên
            }
        };

        // Hiển thị thêm xe khi nhấn "View more"
        viewAllButton.addEventListener('click', function () {
            if (currentItemCount < totalItems) {
                currentItemCount += 10; // Mỗi lần nhấn sẽ thêm 10 xe
                hideExtraCars();
            }
        });
        // Hàm lọc xe
        const filterCars = () => {
            const searchQuery = carSearchInput.value.toLowerCase(); // Lấy giá trị tìm kiếm
            const selectedEngineType = engineTypeFilter.value.toLowerCase(); // Lấy kiểu động cơ đã chọn
            const selectedSeatCapacity = seatCapacityFilter.value.toLowerCase(); // Lấy số ghế đã chọn
            const selectedBrand = brandFilter.value.toLowerCase(); // Lấy thương hiệu đã chọn

            carItems.forEach(car => {
                const brand = car.querySelector('.text-lg.text-gray-500').textContent.toLowerCase(); // Thương hiệu
                const name = car.querySelector('h2.text-xl.font-bold.ms-3.mb-0').textContent.toLowerCase(); // Tên xe
                const model = car.querySelector('h2.text-xl.font-bold.ms-3.mb-0').textContent.toLowerCase(); // Model xe
                const seatCapacity = car.querySelector('.text-gray-600').textContent.toLowerCase(); // Số ghế
                const engineType = car.querySelector('.text-gray-700').textContent.toLowerCase(); // Loại động cơ

                // Kiểm tra nếu xe thỏa mãn tất cả các điều kiện lọc
                const matchesSearchQuery = name.includes(searchQuery) || model.includes(searchQuery) || brand.includes(searchQuery);
                const matchesEngineType = selectedEngineType ? engineType.includes(selectedEngineType) : true;
                const matchesSeatCapacity = selectedSeatCapacity ? seatCapacity.includes(selectedSeatCapacity) : true;
                const matchesBrand = selectedBrand ? brand.includes(selectedBrand) : true;

                // Hiển thị hoặc ẩn xe
                if (matchesSearchQuery && matchesEngineType && matchesSeatCapacity && matchesBrand) {
                    car.style.display = 'flex'; // Hiển thị xe nếu thỏa mãn
                } else {
                    car.style.display = 'none'; // Ẩn xe nếu không thỏa mãn
                }
            });
        };
        // Ẩn các xe không cần thiết khi tải trang
        carSearchInput.addEventListener('input', filterCars);
        engineTypeFilter.addEventListener('change', filterCars);
        seatCapacityFilter.addEventListener('change', filterCars);
        brandFilter.addEventListener('change', filterCars);
        hideExtraCars();
    });

</script>
@endsection