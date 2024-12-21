@extends('Backend.dashboard.layout')

@section('content')
<x-breadcrumbs breadcrumb="order.add.car" />

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <h1>Thêm Đơn Hàng Mới</h1>
        <form action="{{ route('orders.store') }}" method="POST">
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
                                            <input type="radio" class="form-radio text-blue-600 w-5 h-5 mr-3"
                                                name="selected_car" data-car-id="{{ $car->car_id }}"
                                                value="{{ optional($car->sale)->sale_id }}" data-image="{{ $car->image_url }}"
                                                data-speed="{{ $car->max_speed }}" data-seat="{{ $car->seat_capacity }}"
                                                data-power="{{ $car->engine_power }}" data-trunk="{{ $car->trunk_capacity }}"
                                                data-length="{{ $car->length }}" data-width="{{ $car->width }}"
                                                data-height="{{ $car->height }}"
                                                data-acceleration-time="{{ $car->acceleration_time }}"
                                                data-fuel-efficiency="{{ $car->fuel_efficiency }}"
                                                data-torque="{{ $car->torque }}"
                                                data-price="{{ optional($car->sale)->sale_price ?? '0' }}">
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
                            <div
                                class="flex items-center bg-white p-3 rounded-md shadow hover:shadow-md transition duration-150">
                                <input type="checkbox" class="form-checkbox text-blue-600 w-5 h-5 mr-3"
                                    name="selected_accessories[]" value="{{ $accessory->accessory_id }}"
                                    data-accessory-id="{{ $accessory->accessory_id }}" data-name="{{ $accessory->name }}"
                                    data-price="{{ number_format($accessory->price, 2, '.', '') }}"
                                    data-image="{{ $accessory->image_url }}"
                                    data-quantity-available="{{ $accessory->quantity }}">

                                <div class="flex items-center">
                                    <img src="{{ $accessory->image_url }}" alt="{{ $accessory->name }}"
                                        class="w-12 h-auto object-cover rounded-md mr-3">
                                    <span class="accessory-info text-base font-medium text-gray-800"
                                        data-name="{{ $accessory->name }}">
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
                <label for="payment_method" id="method" class="form-label hidden">Hình thức thanh toán</label>
                <select class="form-control hidden" id="payment_method" name="payment_method"
                    onchange="updatePaymentFields()">
                    <option value="full">Thanh toán toàn bộ</option>
                    <option value="deposit">Thanh toán đặt cọc</option>
                </select>
            </div>

            <!-- Tổng giá trị đơn hàng -->
            <div class="mb-3">
                <label for="total_price" class="form-label">Tổng giá trị đơn hàng (VNĐ)</label>
                <input type="number" class="form-control" id="total_price" name="total_price" min="1" value="0" required
                    readonly>

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

            <button type="submit" onclick="confirmSubmission()" class="btn btn-primary">Thêm Đơn Hàng</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
<script>
    const accounts = @json($accounts);

    document.getElementById('customer_phone').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            const phone = this.value.trim();
            const accounts = @json($accounts); // Danh sách tài khoản từ backend

            // Tìm account dựa trên số điện thoại
            const account = accounts.find(acc => acc.phone === phone);

            if (account) {
                // Gán thông tin tài khoản vào các trường input
                document.getElementById('customer_name').value = account.name;
                document.getElementById('customer_email').value = account.email;
                document.getElementById('customer_address').value = account.address;

                // Lưu account_id vào hidden input để gửi lên server
                let accountIdInput = document.getElementById('account_id');
                if (!accountIdInput) {
                    accountIdInput = document.createElement('input');
                    accountIdInput.type = 'hidden';
                    accountIdInput.id = 'account_id';
                    accountIdInput.name = 'account_id';
                    document.querySelector('form').appendChild(accountIdInput);
                }
                accountIdInput.value = account.id;
            } else {
                alert('Không tìm thấy thông tin tài khoản.');
                // Xóa các thông tin cũ nếu không tìm thấy tài khoản
                document.getElementById('customer_name').value = '';
                document.getElementById('customer_email').value = '';
                document.getElementById('customer_address').value = '';
            }
        }
    });


    function toggleAccessoryModal(show) {
        const modal = document.getElementById('accessoryModal');
        modal.classList.toggle('hidden', !show);
    }

    function filterCars() {
        const searchQuery = document.getElementById('carSearchInput').value.toLowerCase();
        const carRows = document.querySelectorAll('#carModal .grid .flex');

        carRows.forEach(row => {
            const carInfo = row.querySelector('.car-info');
            const carName = carInfo.dataset.name.toLowerCase();
            const carModel = carInfo.dataset.model.toLowerCase();

            row.style.display = carName.includes(searchQuery) || carModel.includes(searchQuery) ? '' : 'none';
        });
    }

    function filterAccessories() {
        const searchQuery = document.getElementById('accessorySearchInput').value.toLowerCase();
        const accessoryRows = document.querySelectorAll('#accessoryModal .flex');

        accessoryRows.forEach(row => {
            const accessoryInfo = row.querySelector('.accessory-info');
            const accessoryName = accessoryInfo.dataset.name.toLowerCase();

            row.style.display = accessoryName.includes(searchQuery) ? '' : 'none';
        });
    }

    function confirmAccessorySelection() {
        const selectedAccessories = document.querySelectorAll('input[name="selected_accessories[]"]:checked');
        const selectedAccessoriesList = document.getElementById('selectedAccessoriesList');
        selectedAccessoriesList.innerHTML = '';


        selectedAccessories.forEach(accessory => {
            const accessoryId = accessory.dataset.accessoryId;
            const accessoryName = accessory.getAttribute('data-name');
            const accessoryPrice = parseFloat(accessory.getAttribute('data-price'));
            const accessoryImage = accessory.getAttribute('data-image');
            const accessoryQuantityAvailable = accessory.getAttribute('data-quantity-available');

            const accessoryHtml = `
                <div id="selected-accessory-${accessoryId}" class="flex items-center mb-3">
                    <img src="${accessoryImage}" alt="${accessoryName}" class="w-12 h-auto object-cover rounded-md mr-3">
                    <div class="flex-1">
                        <span class="block font-medium">${accessoryName}</span>
                        <span class="block text-sm text-gray-500">${accessoryPrice.toLocaleString()} VNĐ</span>
                        <div>
                            <label for="accessory-quantity-${accessoryId}" class="text-sm">Số lượng:</label>
                            <input type="number" id="accessory-quantity-${accessoryId}" 
                                    name="selected_accessories[${accessoryId}][quantity]"
                                   class="form-control w-20" 
                                   min="1" 
                                   max="${accessoryQuantityAvailable}" 
                                   value="1" 
                                   onchange="updateAccessoryTotal('${accessoryId}', ${accessoryPrice})">
                        </div>
                    </div>
                                        <input type="hidden" name="selected_accessories[${accessoryId}][price]" value="${accessoryPrice}">

                    <input type="hidden" name="selected_accessories[${accessoryId}][accessory_id]" value="${accessoryId}">
                    <button type="button" class="btn" style="background-color: #de3333; color: white;" onclick="removeAccessory('${accessoryId}')">Xóa</button>
                </div>
            `;
            selectedAccessoriesList.insertAdjacentHTML('beforeend', accessoryHtml);
        });

        if (!document.getElementById('addAccessoryButton') && selectedAccessories.length > 0) {
            const addAccessoryButtonHtml = `
                <button id="addAccessoryButton" 
                        type="button" 
                        class="btn btn-secondary mt-3"
                        onclick="toggleAccessoryModal(true)">
                    Thêm sản phẩm
                </button>
            `;
            selectedAccessoriesList.insertAdjacentHTML('afterend', addAccessoryButtonHtml);
        }

        updateTotalPrice();
        toggleAccessorySelectionBox();
        toggleAccessoryModal(false);
    }

    function toggleModal(show) {
        const modal = document.getElementById('carModal');
        modal.classList.toggle('hidden', !show);
    }

    function updatePaymentMethodVisibility() {
        const paymentMethod = document.getElementById('payment_method');
        const Method = document.getElementById('method');
        const selectedCar = document.querySelector('input[name="selected_car"]:checked');

        if (!selectedCar) {
            // Nếu chưa có xe nào được chọn, ẩn combobox phương thức thanh toán và đặt mặc định là "Thanh toán toàn bộ"
            paymentMethod.value = 'full';
            paymentMethod.classList.add('hidden');
            Method.classList.add('hidden');
            updatePaymentFields(); // Cập nhật lại các trường liên quan đến thanh toán
        } else {
            // Hiển thị combobox phương thức thanh toán nếu có xe được chọn
            Method.classList.remove('hidden');
            paymentMethod.classList.remove('hidden');
        }
    }

    // Gọi hàm này mỗi khi cần kiểm tra trạng thái chọn xe, ví dụ sau khi chọn xe:
    function confirmCarSelection() {
        const selectedCar = document.querySelector('input[name="selected_car"]:checked');
        if (selectedCar) {
            const carImage = selectedCar.getAttribute('data-image');
            const selectedCarContainer = document.getElementById('selectedCarContainer');
            const carPrice = selectedCar.getAttribute('data-price');
            selectedCarContainer.innerHTML = `<img src="${carImage}" class="w-[40%] h-full rounded-full">`;
            document.getElementById('total_price').value = carPrice;
            updatePaymentFields();
            toggleModal(false);
        } else {
            alert('Vui lòng chọn một xe!');
        }

        updatePaymentMethodVisibility()

    }

    // Thêm sự kiện onchange để kiểm tra mỗi khi thay đổi trạng thái chọn xe


    function updateAccessoryTotal(accessoryId, accessoryPrice) {
        const quantityInput = document.getElementById(`accessory-quantity-${accessoryId}`);
        const quantity = parseInt(quantityInput.value);
        if (quantity < 1) {
            quantityInput.value = 1;
        }
        updateTotalPrice();
    }

    function updateTotalPrice() {
        const totalPriceInput = document.getElementById('total_price');
        const depositAmountInput = document.getElementById('deposit_amount');
        const remainingAmountInput = document.getElementById('remaining_amount');
        const paymentMethod = document.getElementById('payment_method').value;

        const selectedCar = document.querySelector('input[name="selected_car"]:checked');
        const carPrice = selectedCar ? parseFloat(selectedCar.getAttribute('data-price').replace(/,/g, '').trim()) : 0;

        let accessoriesTotal = 0;
        document.querySelectorAll('#selectedAccessoriesList > div').forEach(accessory => {
            const accessoryId = accessory.id.replace('selected-accessory-', '');
            const quantity = parseInt(document.getElementById(`accessory-quantity-${accessoryId}`).value) || 1;
            const price = parseFloat(document.querySelector(`input[data-accessory-id="${accessoryId}"]`).getAttribute('data-price'));
            accessoriesTotal += quantity * price;
        });

        const totalPrice = carPrice + accessoriesTotal;
        totalPriceInput.value = totalPrice.toFixed(0);

        if (selectedCar) {
            if (paymentMethod === 'full') {
                depositAmountInput.value = '0';
                remainingAmountInput.value = '0';
            } else if (paymentMethod === 'deposit') {
                const depositAmount = (carPrice * 0.15) + accessoriesTotal;
                const remainingAmount = totalPrice - depositAmount;

                depositAmountInput.value = depositAmount.toFixed(0);
                remainingAmountInput.value = remainingAmount.toFixed(0);
            }
        } else {
            depositAmountInput.value = '0';
            remainingAmountInput.value = '0';
        }

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
    function removeAccessory(accessoryId) {
        const checkbox = document.querySelector(`input[name="selected_accessories[]"][data-accessory-id="${accessoryId}"]`);
        checkbox.checked = false;
        document.getElementById(`selected-accessory-${accessoryId}`).remove();
        updateTotalPrice();
        toggleAccessorySelectionBox();

        const selectedAccessoriesList = document.getElementById('selectedAccessoriesList');
        const addAccessoryButton = document.getElementById('addAccessoryButton');
        if (selectedAccessoriesList.children.length === 0 && addAccessoryButton) {
            addAccessoryButton.remove();
        }
    }
    function updatePaymentFields() {
        const paymentMethod = document.getElementById('payment_method').value;
        const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
        const depositContainer = document.getElementById('deposit_container');
        const remainingContainer = document.getElementById('remaining_container');
        if (paymentMethod === 'deposit') {
            updateTotalPrice();
            depositContainer.classList.remove('hidden');
            remainingContainer.classList.remove('hidden');
        } else {
            depositContainer.classList.add('hidden');
            remainingContainer.classList.add('hidden');

            document.getElementById('deposit_amount').value = '0';
            document.getElementById('remaining_amount').value = '0';
        }
    }
    function confirmSubmission() {
        const selectedCar = document.querySelector('input[name="selected_car"]:checked');
        const selectedAccessories = document.querySelectorAll('input[name="selected_accessories[]"]:checked');

        if (!selectedCar && selectedAccessories.length === 0) {
            alert('Vui lòng chọn ít nhất một xe hoặc một phụ kiện!');
            return false;
        }
        return true;
    }

</script>
@endsection