@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="order.add.car" />

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <h1>Thêm Đơn Hàng Mới</h1>
        <form action="{{ route('orders.store') }}" method="POST" onsubmit="return confirmPayment()">
            @csrf
            <!-- Filter thông tin khách hàng -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="customer_phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                </div>
                <div class="col-md-6">
                    <label for="customer_name" class="form-label">Tên khách hàng</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email">
                </div>
                <div class="col-md-6">
                    <label for="customer_address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="customer_address" name="customer_address" rows="3"
                        readonly></input>
                </div>
            </div>

            <!-- Ô chọn xe ban đầu -->
            <div id="selectionBox1" onclick="toggleModal(true)"
                class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-white hover:bg-gray-200 cursor-pointer">
                <div id="selectedCarContainer" class="flex items-center justify-center w-full h-full">
                    <span id="selectionPlaceholder" class="text-4xl text-gray-500">+</span>
                    <span class="mt-2 text-gray-700">Chọn xe</span>
                </div>
            </div> <br>
            <!-- Phu kien -->
            <div id="accessorySelectionBox" onclick="toggleAccessoryModal(true)"
                class="border-2 border-blue-500 rounded-lg p-8 flex flex-col items-center justify-center bg-white hover:bg-gray-200 cursor-pointer">
                <div id="selectedAccessoryContainer" class="flex items-center justify-center w-full h-full">
                    <span id="accessorySelectionPlaceholder" class="text-4xl text-gray-500">+</span>
                    <span class="mt-2 text-gray-700">Chọn phụ kiện</span>
                </div>
            </div>

            <!-- Modal hiển thị danh sách xe -->
            <div id="carModal" class="fixed inset-0 bg-opacity-50 flex items-center justify-center hidden z-[1050]">
                <div class="bg-white w-4/5 max-w-4xl max-h-[90vh] p-8 rounded-lg shadow-lg relative overflow-y-auto">
                    <h2 class="text-2xl font-bold mb-4">Danh Sách Xe</h2>
                    <div class="mb-4">
                        <input type="text" id="carSearchInput" onkeyup="filterCars()" class="form-control"
                            placeholder="Tìm kiếm xe...">
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg space-y-8">
                        @foreach($carsByBrand as $brand => $cars)
                            <div>
                                <!-- Hiển thị tên thương hiệu -->
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b">{{ $brand }}</h3>

                                <!-- Xe hiển thị trên cùng 1 hàng -->
                                <div class="grid grid-cols-3 gap-6">
                                    @foreach($cars as $car)
                                        <div
                                            class="flex items-center bg-white p-3 rounded-md shadow hover:shadow-md transition duration-150">
                                            <input type="radio" class="form-radio text-blue-600 w-5 h-5 mr-3" name="selected_car" value="{{ $car->car_id }}" data-image="{{ $car->image_url }}" data-speed="{{ $car->max_speed }}" data-seat="{{ $car->seat_capacity }}" data-power="{{ $car->engine_power }}" data-trunk="{{ $car->trunk_capacity }}" 
                                                data-length="{{ $car->length }}" data-width="{{ $car->width }}" data-height="{{ $car->height }}"  
                                                data-acceleration-time="{{ $car->acceleration_time }}" data-fuel-efficiency="{{ $car->fuel_efficiency }}" data-torque="{{ $car->torque }}" data-price="{{ optional($car->sale)->sale_price ?? '0' }}">
                                            <div class="flex items-center">
                                                <img src="{{ $car->image_url }}" alt="{{ $car->name }}"
                                                    class="w-12 h-auto object-cover rounded-md mr-3">
                                                <span class="car-info" data-name="{{ $car->name }}"
                                                    data-model="{{ $car->model }}">
                                                    {{ $car->name }} {{ $car->model }}
                                                </span>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="confirmCarSelection()"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Chọn Xe</button>

                        <button type="button" onclick="toggleModal(false)"
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Đóng</button>
                    </div>
                </div>
            </div>
            <div id="accessoryModal"
                class="fixed inset-0 bg-opacity-50 flex items-center justify-center hidden z-[1050]">
                <div class="bg-white w-4/5 max-w-4xl max-h-[90vh] p-8 rounded-lg shadow-lg relative overflow-y-auto">
                    <h2 class="text-2xl font-bold mb-4">Danh Sách Phụ Kiện</h2>
                    <div class="mb-4">
                        <input type="text" id="accessorySearchInput" onkeyup="filterAccessories()" class="form-control"
                            placeholder="Tìm kiếm phụ kiện...">
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg space-y-8">
                    @foreach($accessories as $accessory)
<div class="flex items-center bg-white p-3 rounded-md shadow hover:shadow-md transition duration-150">
    <input type="checkbox" class="form-checkbox text-blue-600 w-5 h-5 mr-3" 
           name="selected_accessories[]" 
           value="{{ $accessory->accessory_id }}" 
           data-name="{{ $accessory->name }}" 
           data-price="{{ $accessory->price }}" 
           data-image="{{ $accessory->image_url }}" 
           data-quantity-available="{{ $accessory->quantity }}">

    <div class="flex items-center">
        <img src="{{ $accessory->image_url }}" alt="{{ $accessory->name }}" class="w-12 h-auto object-cover rounded-md mr-3">
        <span class="accessory-info text-base font-medium text-gray-800" data-name="{{ $accessory->name }}">
            {{ $accessory->name }} - {{ number_format($accessory->price, 0, ',', '.') }} VNĐ
        </span>
    </div>
</div>
@endforeach

                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="confirmAccessorySelection()"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Chọn Phụ Kiện</button>
                        <button type="button" onclick="toggleAccessoryModal(false)"
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 ml-2">Đóng</button>
                    </div>
                </div>
            </div>
            <div id="selectedAccessoriesList" class="mt-4">
    <!-- Các phụ kiện đã chọn sẽ được hiển thị ở đây -->
</div>

            <!-- Chọn hình thức thanh toán -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Hình thức thanh toán</label>
                <select class="form-control" id="payment_method" name="payment_method" onchange="updatePaymentFields()">
                    <option value="full">Thanh toán toàn bộ</option>
                    <option value="deposit">Thanh toán đặt cọc</option>
                </select>
            </div>

            <!-- Tổng giá trị đơn hàng -->
            <div class="mb-3">
                <label for="total_price" class="form-label">Tổng giá trị đơn hàng (VNĐ)</label>
                <input type="number" class="form-control" id="total_price" name="total_price" min="1" required readonly>

            </div>

            <!-- Số tiền đặt cọc -->
            <div class="mb-3 hidden" id="deposit_container">
                <label for="deposit_amount" class="form-label">Số tiền đặt cọc (VNĐ)</label>
                <input type="number" class="form-control" id="deposit_amount" name="deposit_amount" readonly>
            </div>

            <!-- Số tiền còn lại -->
            <div class="mb-3 hidden" id="remaining_container">
                <label for="remaining_amount" class="form-label">Số tiền còn lại (VNĐ)</label>
                <input type="number" class="form-control" id="remaining_amount" name="remaining_amount" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Đơn Hàng</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>

<script>
    const accounts = @json($accounts);

    document.addEventListener('keydown', function (e) {
        // Kiểm tra nếu phím Enter được nhấn
        if (e.key === 'Enter') {
            // Lấy phần tử hiện đang được focus
            const activeElement = document.activeElement;

            // Ngăn hành động mặc định (form submit) nếu focus không phải là nút submit
            if (activeElement.tagName !== 'TEXTAREA' && activeElement.type !== 'submit') {
                e.preventDefault();
                // Nếu là ô số điện thoại, thực hiện xử lý dữ liệu
                if (activeElement.id === 'customer_phone') {
                    const input = activeElement.value;
                    const matchedAccount = accounts.find(account => account.phone === input);

                    if (matchedAccount) {
                        document.getElementById('customer_name').value = matchedAccount.name;
                        document.getElementById('customer_email').value = matchedAccount.email;
                        document.getElementById('customer_address').value = matchedAccount.address;
                    } else {
                        alert('Không tìm thấy thông tin khách hàng.');
                        document.getElementById('customer_name').value = '';
                        document.getElementById('customer_email').value = '';
                        document.getElementById('customer_address').value = '';
                    }
                }
            }
        }
    });
    function toggleAccessoryModal(show) {
        const modal = document.getElementById('accessoryModal');
        modal.classList.toggle('hidden', !show); // Hiển thị hoặc ẩn modal phụ kiện dựa trên tham số `show`
    }
    const filterCars = () => {
        const searchQuery = document.getElementById('carSearchInput').value.toLowerCase();

        const carRows = document.querySelectorAll('#carModal .grid .flex');

        carRows.forEach(row => {
            const carInfo = row.querySelector('.car-info');
            const carName = carInfo.dataset.name.toLowerCase();
            const carModel = carInfo.dataset.model.toLowerCase();

            row.style.display = carName.includes(searchQuery) || carModel.includes(searchQuery) ? '' : 'none';
        });
    };

    const filterAccessories = () => {
        const searchQuery = document.getElementById('accessorySearchInput').value.toLowerCase();

        const accessoryRows = document.querySelectorAll('#accessoryModal .flex');

        accessoryRows.forEach(row => {
            const accessoryInfo = row.querySelector('.accessory-info');
            const accessoryName = accessoryInfo.dataset.name.toLowerCase();

            row.style.display = accessoryName.includes(searchQuery) ? '' : 'none';
        });
    };


    function confirmAccessorySelection() {
    const selectedAccessories = document.querySelectorAll('input[name="selected_accessories[]"]:checked');
    const selectedAccessoriesList = document.getElementById('selectedAccessoriesList');
    const accessorySelectionBox = document.getElementById('accessorySelectionBox');

    // Xóa danh sách phụ kiện cũ
    selectedAccessoriesList.innerHTML = '';

    // Duyệt qua các phụ kiện đã chọn
    selectedAccessories.forEach(accessory => {
        const accessoryId = accessory.value;
        const accessoryName = accessory.getAttribute('data-name');
        const accessoryPrice = parseFloat(accessory.getAttribute('data-price'));
        const accessoryImage = accessory.getAttribute('data-image');
        const accessoryQuantityAvailable = accessory.getAttribute('data-quantity-available');

        // Thêm phụ kiện vào danh sách
        const accessoryHtml = `
            <div id="selected-accessory-${accessoryId}" class="flex items-center mb-3">
                <img src="${accessoryImage}" alt="${accessoryName}" class="w-12 h-auto object-cover rounded-md mr-3">
                <div class="flex-1">
                    <span class="block font-medium">${accessoryName}</span>
                    <span class="block text-sm text-gray-500">${accessoryPrice.toLocaleString()} VNĐ</span>
                    <div>
                        <label for="accessory-quantity-${accessoryId}" class="text-sm">Số lượng:</label>
                        <input type="number" id="accessory-quantity-${accessoryId}" 
                               class="form-control w-20" 
                               min="1" 
                               max="${accessoryQuantityAvailable}" 
                               value="1" 
                               onchange="updateAccessoryTotal('${accessoryId}', ${accessoryPrice})">
                    </div>
                </div>
                <button type="button" class="ml-4 text-red-500" onclick="removeAccessory('${accessoryId}')">Xóa</button>
            </div>
        `;
        selectedAccessoriesList.insertAdjacentHTML('beforeend', accessoryHtml);
    });

    // Hiển thị nút "Thêm sản phẩm"
    showAddAccessoryButton();

    // Cập nhật giá tổng và kiểm tra danh sách phụ kiện
    updateTotalPrice();
    toggleAccessorySelectionBox();

    // Đóng modal chọn phụ kiện
    toggleAccessoryModal(false);
}

    function toggleModal(show) {
        const modal = document.getElementById('carModal');
        modal.classList.toggle('hidden', !show); // Hiển thị hoặc ẩn modal dựa trên tham số `show`
    }

    function confirmCarSelection() {
        const selectedCar = document.querySelector('input[name="selected_car"]:checked');
        if (selectedCar) {
            const carImage = selectedCar.getAttribute('data-image');
            const carPrice = selectedCar.getAttribute('data-price');
            const selectedCarContainer = document.getElementById('selectedCarContainer');

            selectedCarContainer.innerHTML = `<img src="${carImage}" class="w-[40%] h-full rounded-full">`;
            document.getElementById('total_price').value = carPrice;
            updatePaymentFields();
            toggleModal(false);
        } else {
            alert('Vui lòng chọn một xe!');
        }
    }




function updateAccessoryTotal(accessoryId, accessoryPrice) {
    const quantityInput = document.getElementById(`accessory-quantity-${accessoryId}`);
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(accessoryPrice);
    if (quantity < 1) {
        quantityInput.value = 1; // Không cho phép giá trị nhỏ hơn 1
    }
    updateTotalPrice();
}

function updateAccessoryTotal(accessoryId, accessoryPrice) {
    const quantityInput = document.getElementById(`accessory-quantity-${accessoryId}`);
    const quantity = parseInt(quantityInput.value);
    const price = parseFloat(accessoryPrice);
    if (quantity < 1) {
        quantityInput.value = 1; // Không cho phép giá trị nhỏ hơn 1
    }
    updateTotalPrice();
}

function updateTotalPrice() {
    const totalPriceInput = document.getElementById('total_price');
    const selectedAccessories = document.querySelectorAll('#selectedAccessoriesList > div');
    let totalPrice = 0;

    selectedAccessories.forEach(accessory => {
        const accessoryId = accessory.id.replace('selected-accessory-', '');
        const quantity = parseInt(document.getElementById(`accessory-quantity-${accessoryId}`).value);
        const price = parseFloat(document.querySelector(`input[value="${accessoryId}"]`).getAttribute('data-price'));
        totalPrice += quantity * price;
    });

    totalPriceInput.value = totalPrice.toFixed(0);
}
function removeAccessory(accessoryId) {
    // Xóa phụ kiện khỏi danh sách
    const checkbox = document.querySelector(`input[name="selected_accessories[]"][value="${accessoryId}"]`);
    checkbox.checked = false;
    document.getElementById(`selected-accessory-${accessoryId}`).remove();

    updateTotalPrice();
    toggleAccessorySelectionBox();
}
function toggleAccessorySelectionBox() {
    const accessorySelectionBox = document.getElementById('accessorySelectionBox');
    const selectedAccessoriesList = document.getElementById('selectedAccessoriesList');

    if (selectedAccessoriesList.children.length > 0) {
        accessorySelectionBox.classList.add('hidden'); // Ẩn hộp chọn phụ kiện
    } else {
        accessorySelectionBox.classList.remove('hidden'); // Hiển thị lại hộp chọn phụ kiện
    }
}   


    function updatePaymentFields() {
        const paymentMethod = document.getElementById('payment_method').value;
        const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
        const depositContainer = document.getElementById('deposit_container');
        const remainingContainer = document.getElementById('remaining_container');
        if (paymentMethod === 'deposit') {
            const depositAmount = totalPrice * 0.15;
            const remainingAmount = totalPrice - depositAmount;

            document.getElementById('deposit_amount').value = depositAmount.toFixed(0);
            document.getElementById('remaining_amount').value = remainingAmount.toFixed(0);

            depositContainer.classList.remove('hidden');
            remainingContainer.classList.remove('hidden');
        } else {
            depositContainer.classList.add('hidden');
            remainingContainer.classList.add('hidden');

            document.getElementById('deposit_amount').value = '0';
            document.getElementById('remaining_amount').value = '0';
        }
    }

    function confirmPayment() {
        const customerPhone = document.getElementById('customer_phone').value.trim();
        const customerName = document.getElementById('customer_name').value.trim();
        const customerEmail = document.getElementById('customer_email').value.trim();
        const customerAddress = document.getElementById('customer_address').value.trim();
        const selectedCar = document.querySelector('input[name="selected_car"]:checked');

        if (!customerPhone || !customerName || !customerEmail || !customerAddress) {
            alert('Vui lòng nhập đầy đủ thông tin khách hàng.');
            return false;
        }

        if (!selectedCar) {
            alert('Vui lòng chọn một xe!');
            return false;
        }

        return true;
    }
</script>
@endsection