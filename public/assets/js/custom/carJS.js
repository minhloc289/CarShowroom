    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('carSearchInput');
        const carItems = document.querySelectorAll('.car-item');

        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();

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
        });
    });

