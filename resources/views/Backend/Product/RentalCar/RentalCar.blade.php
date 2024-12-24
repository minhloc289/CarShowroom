@extends('Backend.dashboard.layout')

@section('content')
    <x-breadcrumbs breadcrumb="rentalCar" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Quản lý xe đang được thuê</h1>
                <div class="d-flex align-items-center">
                    <!-- Nút Xóa -->
                    <div id="deleteSelectedContainer" class="d-none text-end me-3">
                        <form id="deleteSelectedForm" action="{{ route('rentalCar.deleteMultiple') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="rental_ids" id="rentalIdsInput">
                            <button id="deleteSelectedButton" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Xóa các xe đã chọn
                            </button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" id="addCarButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Thêm
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="addCarButton">
                            <li><a class="dropdown-item" href="{{route('rentalCar.create')}}">Thêm 1 xe</a></li>
                            <li><a class="dropdown-item" href="{{route('rentalCar.record.create')}}">Thêm nhiều xe</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bộ lọc và tìm kiếm -->
            <div class="flex items-center space-x-4 mb-4">
                <!-- Ô tìm kiếm -->
                <input type="text" id="carSearchInput" placeholder="Tìm kiếm"
                    class="rounded-lg border border-gray-300 px-4 py-2 w-64">
            
                <!-- Bộ lọc tình trạng -->
                <select id="statusFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả tình trạng</option>
                    <option value="Available">Sẵn sàng</option>
                    <option value="Rented">Đang thuê</option>
                </select>

                <!-- Bộ lọc số chỗ ngồi -->
                <select id="seatCapacityFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả số chỗ ngồi</option>
                    @foreach ($seatCapacities as $seat)
                        <option value="{{ $seat }}">{{ $seat }} chỗ</option>
                    @endforeach
                </select>

                <!-- Bộ lọc thương hiệu -->
                <select id="brandFilter" class="rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Tất cả thương hiệu</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand }}">{{ $brand }}</option>
                    @endforeach
                </select>
            
                <!-- Bộ lọc giá thuê -->
                <input type="number" id="minPriceFilter" placeholder="Giá thuê tối thiểu"
                    class="rounded-lg border border-gray-300 px-4 py-2 w-40">
                <input type="number" id="maxPriceFilter" placeholder="Giá thuê tối đa"
                    class="rounded-lg border border-gray-300 px-4 py-2 w-40">
            </div>

            

            <div class="d-flex align-items-center mb-4">
                <!-- Select All Checkbox -->
                <input type="checkbox" id="checkAll" class="me-3">
                <label for="checkAll" class="mb-0">Select All</label>
            </div>

            <!-- Danh sách xe -->
            <div id="carsContainer" class="d-flex flex-column">
                @foreach ($rentalCars as $car)
                    <div class="car-item d-flex justify-content-between align-items-center border bg-white shadow-sm p-4 rounded-lg mb-3">
                        <!-- Phần hình ảnh, tiêu đề và tình trạng xe -->
                        <div class="d-flex align-items-center">
                            <!-- Checkbox -->
                            <input type="checkbox" class="car-checkbox me-3" data-car-id="{{ $car->rental_id }}">
            
                            <!-- Hình ảnh xe -->
                            <img src="{{ $car->carDetails->image_url }}" class="rounded-lg me-3" alt="{{ $car->carDetails->name }}"
                                style="width: 100px; height: auto;">
            
                            <!-- Tên xe và tình trạng -->
                            <div>
                                <h2 class="text-xl font-bold mb-0">
                                    {{ $car->carDetails->brand }} - {{ $car->carDetails->model }}
                                </h2>
                                <!-- Badge tình trạng xe -->
                                <span class="badge 
                                    {{ $car->availability_status == 'Available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $car->availability_status }}
                                </span>
                            </div>
                        </div>
            
                        <!-- Các nút thao tác bên phải -->
                        <div class="d-flex align-items-center ms-auto">
                            <a href="{{ route('rentalCar.details', ['id' => $car->car_id]) }}" class="btn btn-primary me-2">
                                Xem chi tiết
                            </a>
                            <a href="{{ route('rentalCar.edit', ['id' => $car->car_id]) }}" 
                                class="btn btn-warning me-2">
                                Sửa
                            </a>
                            <form action="{{route('rentalCar.delete', ['id' => $car->rental_id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa xe thuê này?')">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            

            <!-- View All Button -->
            <div class="text-center mt-8">
                <button id="viewAllButton" class="text-blue-500 text-sm font-semibold hover:underline">Xem thêm →</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filters = {
                search: document.getElementById('carSearchInput'),
                status: document.getElementById('statusFilter'),
                seatCapacity: document.getElementById('seatCapacityFilter'),
                brand: document.getElementById('brandFilter'),
                minPrice: document.getElementById('minPriceFilter'),
                maxPrice: document.getElementById('maxPriceFilter')
            };
    
            // Hàm lấy dữ liệu từ filter
            function fetchFilteredCars() {
                const search = filters.search.value;
                const status = filters.status.value;
                const seatCapacity = filters.seatCapacity.value;
                const brand = filters.brand.value;
                const minPrice = filters.minPrice.value;
                const maxPrice = filters.maxPrice.value;
    
                // Gửi AJAX request
                fetch("{{ route('rental.car.filter') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF cho Laravel
                    },
                    body: JSON.stringify({
                        search,
                        status,
                        seatCapacity,
                        brand,
                        minPrice,
                        maxPrice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    updateCarList(data.cars);
                })
                .catch(error => console.error('Error:', error));
            }
    
            // Hàm cập nhật danh sách xe
            function updateCarList(cars) {
                const container = document.getElementById('carsContainer');
                container.innerHTML = ''; // Xóa danh sách cũ

                if (cars.length === 0) {
                    container.innerHTML = '<p>Không tìm thấy xe nào phù hợp.</p>';
                    return;
                }

                cars.forEach(car => {
                    const carHTML = `
                        <div class="car-item d-flex justify-content-between align-items-center border bg-white shadow-sm p-4 rounded-lg mb-3">
                            <!-- Phần hình ảnh, tiêu đề và tình trạng xe -->
                            <div class="d-flex align-items-center">
                                <!-- Checkbox -->
                                <input type="checkbox" class="car-checkbox me-3" data-car-id="${car.rental_id}">
                
                                <!-- Hình ảnh xe -->
                                <img src="${car.image_url}" class="rounded-lg me-3" alt="${car.name}"
                                    style="width: 100px; height: auto;">
                
                                <!-- Tên xe và tình trạng -->
                                <div>
                                    <h2 class="text-xl font-bold mb-0">
                                        ${car.brand} - ${car.model}
                                    </h2>
                                    <!-- Badge tình trạng xe -->
                                    <span class="badge ${car.availability_status === 'Available' ? 'bg-success' : 'bg-danger'}">
                                        ${car.availability_status}
                                    </span>
                                </div>
                            </div>
                
                            <!-- Các nút thao tác bên phải -->
                            <div class="d-flex align-items-center ms-auto">
                                <a href="/admin/rental-car/details/${car.car_id}" class="btn btn-primary me-2">
                                    Xem chi tiết
                                </a>
                                <a href="/admin/rental-car/edit/${car.car_id}" class="btn btn-warning me-2">
                                    Sửa
                                </a>
                                <form action="/admin/rental-car/delete/${car.rental_id}" method="POST" class="mb-0">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', carHTML);
                });
            }
    
            // Thêm event listener cho filter
            Object.values(filters).forEach(filter => {
                filter.addEventListener('change', fetchFilteredCars);
                filter.addEventListener('keyup', fetchFilteredCars);
            });

            //Xóa hàng loạt
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.car-checkbox');
            const deleteSelectedContainer = document.getElementById('deleteSelectedContainer');
            const rentalIdsInput = document.getElementById('rentalIdsInput');

            // Hàm cập nhật nút "Xóa các xe đã chọn"
            function updateDeleteButtonVisibility() {
                const selectedIds = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.getAttribute('data-car-id'));

                console.log("Selected IDs:", selectedIds); // Debug giá trị ID được chọn

                if (selectedIds.length > 0) {
                    deleteSelectedContainer.classList.remove('d-none');
                    rentalIdsInput.value = JSON.stringify(selectedIds); // Chuỗi JSON
                } else {
                    deleteSelectedContainer.classList.add('d-none');
                    rentalIdsInput.value = ''; // Reset nếu không có xe nào được chọn
                }
            }


            // Sự kiện khi chọn/deselect tất cả checkbox
            checkAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = checkAll.checked;
                });
                updateDeleteButtonVisibility();
            });

            // Sự kiện khi chọn/deselect từng checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateDeleteButtonVisibility();
                });
            });
        });
    </script>
    
@endsection
