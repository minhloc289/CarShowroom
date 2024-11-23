document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('carSearchInput');
    const carItems = document.querySelectorAll('.car-item');
    const carsContainer = document.getElementById('carsContainer');
    const viewAllButton = document.getElementById('viewAllButton');

    let currentItemCount = 10; // Số lượng xe hiển thị ban đầu
    const totalItems = carItems.length; // Tổng số xe

    // Ẩn các phần tử vượt quá số lượng hiện tại
    for (let i = currentItemCount; i < totalItems; i++) {
        carItems[i].style.display = 'none';
    }

    // Thêm sự kiện click cho nút "View All"
    viewAllButton.addEventListener('click', function () {
        // Tăng số lượng xe hiển thị thêm 10
        currentItemCount += 10;

        // Hiển thị các xe mới
        for (let i = 0; i < currentItemCount && i < totalItems; i++) {
            carItems[i].style.display = 'block';
        }

        // Nếu đã hiển thị tất cả xe, không làm gì cả, chỉ dừng việc tăng số lượng xe hiển thị
    });

    // Thêm sự kiện tìm kiếm cho ô input
    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();

        if (filter === "") {
            // Nếu ô tìm kiếm trống, hiển thị số lượng xe ban đầu
            for (let i = 0; i < totalItems; i++) {
                if (i < currentItemCount) {
                    carItems[i].style.display = 'block';
                } else {
                    carItems[i].style.display = 'none';
                }
            }
        } else {
            // Tìm kiếm xe phù hợp
            carItems.forEach(car => {
                // Lấy tên, thương hiệu và model của ô tô
                const name = car.querySelector('h2').textContent.toLowerCase();
                const brand = car.querySelector('p:nth-child(2)').textContent.toLowerCase();
                const model = brand.split(' - ')[1]; // model nằm sau dấu "-"

                // Kiểm tra xem từ khóa tìm kiếm có khớp với tên, thương hiệu hoặc model
                if (name.includes(filter) || brand.includes(filter) || (model && model.includes(filter))) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        }
    });
});
