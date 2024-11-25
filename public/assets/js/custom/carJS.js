document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('carSearchInput');
    const engineTypeFilter = document.getElementById('engineTypeFilter');
    const seatCapacityFilter = document.getElementById('seatCapacityFilter');
    const brandFilter = document.getElementById('brandFilter');
    const carItems = document.querySelectorAll('.car-item');
    const viewAllButton = document.getElementById('viewAllButton');

    let currentItemCount = 10; // Số lượng xe hiển thị ban đầu
    const totalItems = carItems.length; // Tổng số xe trong danh sách

    // Ẩn các xe vượt quá số lượng hiển thị ban đầu
    const hideExtraCars = () => {
        for (let i = 0; i < totalItems; i++) {
            carItems[i].style.display = i < currentItemCount ? 'block' : 'none';
        }
    };

    // Hiển thị thêm xe khi nhấn "View All"
    viewAllButton.addEventListener('click', function () {
        currentItemCount += 10;
        hideExtraCars();
    });

    // Hàm lọc xe
    const filterCars = () => {
        const searchText = searchInput.value.toLowerCase();
        const selectedEngineType = engineTypeFilter.value.toLowerCase();
        const selectedSeatCapacity = seatCapacityFilter.value;
        const selectedBrand = brandFilter.value.toLowerCase();

        let filteredCount = 0; // Số lượng xe phù hợp với bộ lọc

        carItems.forEach(car => {
            const name = car.querySelector('h2').textContent.toLowerCase();
            const brand = car.querySelector('p:nth-child(2)').textContent.toLowerCase();
            const seatCapacity = car.querySelector('p:nth-child(5)').textContent.split(': ')[1];
            const engineType = car.querySelector('p:nth-child(6)').textContent.split(': ')[1].toLowerCase(); // Lấy giá trị từ cột engine_type

            const matchesSearch = !searchText || name.includes(searchText) || brand.includes(searchText);
            const matchesEngineType = !selectedEngineType || engineType === selectedEngineType;
            const matchesSeatCapacity = !selectedSeatCapacity || seatCapacity === selectedSeatCapacity;
            const matchesBrand = !selectedBrand || brand.includes(selectedBrand);

            if (matchesSearch && matchesEngineType && matchesSeatCapacity && matchesBrand) {
                car.style.display = 'block';
                filteredCount++;
            } else {
                car.style.display = 'none';
            }
        });

        // Nếu không có bộ lọc nào được áp dụng, hiển thị số xe theo trạng thái ban đầu
        if (!searchText && !selectedEngineType && !selectedSeatCapacity && !selectedBrand) {

            hideExtraCars();
        }
    };

    // Gắn sự kiện cho các bộ lọc và ô tìm kiếm
    searchInput.addEventListener('input', filterCars);
    engineTypeFilter.addEventListener('change', filterCars);
    seatCapacityFilter.addEventListener('change', filterCars);
    brandFilter.addEventListener('change', filterCars);

    // Ẩn các xe vượt quá số lượng hiển thị ban đầu khi tải trang
    hideExtraCars();
});
