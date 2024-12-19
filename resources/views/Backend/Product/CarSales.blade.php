@extends('Backend.dashboard.layout')

@section('content') 
<x-breadcrumbs breadcrumb="carsales" />
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Quản lý xe bán</h1>
            <div class="d-flex align-items-center">
                <!-- Nút Xóa -->
                <div id="deleteSelectedContainer" class="d-none text-end me-3">
                    <form id="deleteSelectedForm" action="{{route('cars.deleteSelected')}}" method="POST">
                        @csrf
                        <input type="hidden" name="car_ids[]" id="carIdsInput">
                        <button id="deleteSelectedButton" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Xóa các xe đã chọn
                        </button>
                    </form>
                </div>

                <!-- Dropdown Thêm -->
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
        <div class="d-flex align-items-center mb-4">
            <!-- Select All Checkbox -->
            <input type="checkbox" id="checkAll" class="me-3">
            <label for="checkAll" class="mb-0">Select All</label>
        </div>
        <!-- Danh sách xe -->


        <div id="carsContainer" class="d-flex flex-column">
            @foreach ($cars as $index => $car)
                @if ($car->sale)
                    <div class="car-item align-items-center justify-content-between border bg-white shadow-sm p-4 rounded-lg mb-3"
                        data-index="{{ $index }}" style="width: 100%;">
                        <div class="d-flex align-items-center">
                            <!-- Checkbox -->
                            <input type="checkbox" class="car-checkbox me-3" data-car-id="{{ $car->car_id }}">

                            <img src="{{ $car->image_url }}" class="rounded-lg" alt="{{ $car->name }}"
                                style="width: 120px; height: auto;">
                            <h2 class="text-xl font-bold ms-3 mb-0">{{ $car->brand }} - {{ $car->model }}</h2>
                            <h2 class="text-xl font-bold ms-3 mb-0">{{ $car->name }}</h2>
                            <h2 class="text-xl font-bold ms-3 mb-0">${{ number_format($car->sale->sale_price, 2) }}</h2>
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
                @endif
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
        const carItems = document.querySelectorAll('.car-item');
        const viewAllButton = document.getElementById('viewAllButton');
        const deleteSelectedButton = document.getElementById('deleteSelectedButton');
        const carCheckboxes = document.querySelectorAll('.car-checkbox');
        const carIdsInput = document.getElementById('carIdsInput');
        const deleteSelectedContainer = document.getElementById('deleteSelectedContainer');
        const checkAll = document.getElementById('checkAll');

        let currentItemCount = 10;
        const totalItems = carItems.length;

        const hideExtraCars = () => {
            for (let i = 0; i < totalItems; i++) {
                carItems[i].style.display = i < currentItemCount ? 'flex' : 'none';
            }
        };

        viewAllButton.addEventListener('click', function () {
            if (currentItemCount < totalItems) {
                currentItemCount += 10;
                hideExtraCars();
            }
        });

        const filterCars = () => {
            const searchQuery = searchInput.value.toLowerCase();
            const selectedEngineType = engineTypeFilter.value.toLowerCase();
            const selectedSeatCapacity = seatCapacityFilter.value.toLowerCase();
            const selectedBrand = brandFilter.value.toLowerCase();

            carItems.forEach(car => {
                const brand = car.querySelector('.text-lg.text-gray-500').textContent.toLowerCase();
                const name = car.querySelector('h2.text-xl.font-bold.ms-3.mb-0').textContent.toLowerCase();
                const model = car.querySelector('h2.text-xl.font-bold.ms-3.mb-0').textContent.toLowerCase();
                const seatCapacity = car.querySelector('.text-gray-600').textContent.toLowerCase();
                const engineType = car.querySelector('.text-gray-700').textContent.toLowerCase();

                const matchesSearchQuery = name.includes(searchQuery) || model.includes(searchQuery) || brand.includes(searchQuery);
                const matchesEngineType = selectedEngineType ? engineType.includes(selectedEngineType) : true;
                const matchesSeatCapacity = selectedSeatCapacity ? seatCapacity.includes(selectedSeatCapacity) : true;
                const matchesBrand = selectedBrand ? brand.includes(selectedBrand) : true;

                if (matchesSearchQuery && matchesEngineType && matchesSeatCapacity && matchesBrand) {
                    car.style.display = 'flex';
                } else {
                    car.style.display = 'none';
                }
            });
        };

        searchInput.addEventListener('input', filterCars);
        engineTypeFilter.addEventListener('change', filterCars);
        seatCapacityFilter.addEventListener('change', filterCars);
        brandFilter.addEventListener('change', filterCars);
        hideExtraCars();

        // Hàm kiểm tra trạng thái checkbox và cập nhật form
        const updateDeleteForm = () => {
            const selectedCarIds = Array.from(carCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.dataset.carId); // Lấy carId từ dữ liệu của checkbox

            // Cập nhật giá trị cho input ẩn 'car_ids'
            carIdsInput.value = selectedCarIds.join(',');

            // Nếu có ít nhất một xe được chọn, hiển thị nút xóa, ngược lại ẩn nó
            if (selectedCarIds.length > 0) {
                deleteSelectedContainer.classList.remove('d-none');
            } else {
                deleteSelectedContainer.classList.add('d-none');
            }
        };

        // Lắng nghe sự kiện thay đổi trên các checkbox
        carCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateDeleteForm);
        });
        checkAll.addEventListener('change', updateDeleteForm);
        // Khởi động lại khi trang được tải
        updateDeleteForm();
    });
    document.getElementById('checkAll').addEventListener('change', function (e) {
        var checkboxes = document.querySelectorAll('.car-checkbox');  // Chọn tất cả các checkbox con
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = e.target.checked;
            // Đánh dấu hoặc bỏ đánh dấu tất cả các checkbox con
        });
    });
</script>

@endsection