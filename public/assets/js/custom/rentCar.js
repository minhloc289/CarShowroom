document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.getElementById('sortSelect');
    const carContainer = document.getElementById('carsContainer');
    const carSearchInput = document.getElementById('carSearchInput');
    let originalCars = []; // Lưu danh sách ban đầu

    // Lưu trữ danh sách ban đầu khi trang tải
    originalCars = Array.from(carContainer.querySelectorAll('.car-item'));
    console.log('Danh sách ban đầu đã được lưu trữ.');

    // Hàm tìm kiếm
    function searchCars() {
        const query = carSearchInput.value.toLowerCase().trim();
        const filteredCars = originalCars.filter((item) => {
            const name = item.querySelector('.text-lg.font-bold.text-gray-800').textContent.toLowerCase();
            const brand = item.querySelector('.text-sm.text-gray-600').textContent.toLowerCase();
            const year = item.querySelector('.text-xs.text-gray-500').textContent.toLowerCase();
            return name.includes(query) || brand.includes(query) || year.includes(query);
        });

        displayCars(filteredCars);
    }

    // Hàm sắp xếp
    function sortCars() {
        const sortValue = sortSelect.value; // Giá trị sort được chọn

        console.log('Bắt đầu sắp xếp xe, giá trị sort:', sortValue);

        // Nếu chọn All, reset về danh sách ban đầu
        if (sortValue === 'all') {
            resetCars();
            return;
        }

        const carItems = Array.from(carContainer.querySelectorAll('.car-item'));

        carItems.sort((a, b) => {
            const rentalInfoA = a.querySelector('.text-lg.font-bold.text-gray-900');
            const rentalInfoB = b.querySelector('.text-lg.font-bold.text-gray-900');

            // Đưa xe không có giá thuê xuống cuối
            if (!rentalInfoA && rentalInfoB) return 1;
            if (rentalInfoA && !rentalInfoB) return -1;
            if (!rentalInfoA && !rentalInfoB) return 0;

            // Sắp xếp xe có giá thuê
            if (sortValue === 'price-asc') {
                const priceA = parseInt(rentalInfoA.textContent.replace(/\D/g, ''));
                const priceB = parseInt(rentalInfoB.textContent.replace(/\D/g, ''));
                return priceA - priceB;
            } else if (sortValue === 'price-desc') {
                const priceA = parseInt(rentalInfoA.textContent.replace(/\D/g, ''));
                const priceB = parseInt(rentalInfoB.textContent.replace(/\D/g, ''));
                return priceB - priceA;
            } else if (sortValue === 'brand-asc') {
                const brandA = a.querySelector('.text-sm.text-gray-600').textContent.toLowerCase();
                const brandB = b.querySelector('.text-sm.text-gray-600').textContent.toLowerCase();
                return brandA.localeCompare(brandB);
            } else {
                return 0;
            }
        });

        console.log('Hoàn tất sắp xếp xe');

        // Làm trống container và thêm lại các xe đã sắp xếp
        carContainer.innerHTML = '';
        carItems.forEach((item) => carContainer.appendChild(item));
    }

    // Hàm reset danh sách về trạng thái ban đầu
    function resetCars() {
        console.log('Reset danh sách về trạng thái ban đầu.');

        // Làm trống container và thêm lại các xe từ originalCars
        carContainer.innerHTML = '';
        originalCars.forEach((item) => carContainer.appendChild(item));
    }

    function displayCars(cars) {
        carContainer.innerHTML = '';
        cars.forEach((item) => carContainer.appendChild(item));
    }

    // Lắng nghe sự kiện thay đổi trên dropdown
    carSearchInput.addEventListener('input', searchCars);
    sortSelect.addEventListener('change', sortCars);

    // Lắng nghe sự kiện khi nhấn "Rent Now"
    const rentNowButtons = document.querySelectorAll('.rent-now-button');
    const confirmationModal = document.getElementById('confirmationModal');
    const cancelButton = document.getElementById('cancelButton');
    const confirmButton = document.getElementById('confirmButton');

    let selectedCarId = null; // Lưu trữ ID của xe được chọn

    // Hiển thị modal khi nhấn "Rent Now"
    rentNowButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Ngăn chặn hành động mặc định
            selectedCarId = button.dataset.carId; // Lưu ID xe được chọn
            confirmationModal.classList.remove('hidden'); // Hiển thị modal
        });
    });

    // Đóng modal khi nhấn "Cancel"
    cancelButton.addEventListener('click', () => {
        confirmationModal.classList.add('hidden'); // Ẩn modal
        selectedCarId = null; // Xóa ID xe đã chọn
    });

    // Chuyển hướng khi nhấn "Confirm"
    confirmButton.addEventListener('click', () => {
        if (selectedCarId) {
            // Chuyển hướng đến trang hiển thị form thuê
            window.location.href = `/car-rent/${selectedCarId}`;
        }
    });
});




