document.addEventListener("DOMContentLoaded", async function () {
    const categoryButtons = document.querySelectorAll('[data-category]');
    const productsContainer = document.querySelector('.grid'); // Container chứa sản phẩm

    let allProducts = [];

    // Gọi API để lấy toàn bộ sản phẩm
    try {
        const response = await fetch('/api/accessories');
        if (response.ok) {
            allProducts = await response.json(); // Lưu toàn bộ sản phẩm
        } else {
            console.error('Failed to fetch accessories');
        }
    } catch (error) {
        console.error('Error fetching accessories:', error);
    }

    // Hiển thị tất cả sản phẩm ban đầu
    function renderProducts(products) {
        productsContainer.innerHTML = ""; // Xóa các sản phẩm hiện tại
    
        if (products.length === 0) {
            // Thêm thông báo nếu không tìm thấy sản phẩm
            productsContainer.innerHTML = `<p class="text-gray-500">Không tìm thấy sản phẩm phù hợp.</p>`;
        } else {
            // Render từng sản phẩm
            products.forEach((product) => {
                const productHTML = `
                    <div class="p-4 rounded-lg" style="background-color: #E5E7EB;"> <!-- Đặt nền xám cố định -->
                        <a href="#" class="block">
                            <img src="${product.image_url}" 
                                 alt="${product.name}" 
                                 class="aspect-square w-full rounded-lg object-cover">
                            <h3 class="mt-4 text-sm text-gray-700">${product.name}</h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">${new Intl.NumberFormat().format(product.price)} VND</p>
                        </a>
                    </div>
                `;
                productsContainer.insertAdjacentHTML("beforeend", productHTML);
            });
        }
    }
    

    // Hiển thị toàn bộ sản phẩm ban đầu
    renderProducts(allProducts);

    // Lọc sản phẩm theo danh mục khi nhấn nút
    categoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            const selectedCategory = button.getAttribute('data-category'); // Lấy danh mục được chọn

            // Lọc sản phẩm theo danh mục
            const filteredProducts = allProducts.filter(product => product.category === selectedCategory);

            // Hiển thị sản phẩm đã lọc
            renderProducts(filteredProducts);
        });
    });
});

document.addEventListener("DOMContentLoaded", async function () {
    const searchInput = document.querySelector("#search-accessories"); // Input tìm kiếm
    const searchButton = document.querySelector("#search-accessories-button"); // Nút tìm kiếm
    const productsContainer = document.querySelector(".grid"); // Container chứa sản phẩm
    let allProducts = []; // Lưu danh sách sản phẩm từ API

    // Gọi API để lấy toàn bộ danh sách phụ kiện
    try {
        const response = await fetch("/api/accessories"); // Đường dẫn API (Route Laravel)
        if (response.ok) {
            const accessories = await response.json(); // Chuyển JSON thành danh sách sản phẩm
            allProducts = accessories; // Gán danh sách phụ kiện vào biến `allProducts`
        } else {
            console.error("Lỗi khi lấy danh sách phụ kiện từ API");
        }
    } catch (error) {
        console.error("Lỗi kết nối với API:", error);
    }

    // Lắng nghe sự kiện nhập ký tự
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.trim().toLowerCase(); // Lấy giá trị nhập và chuyển thành chữ thường

        // Nếu ô tìm kiếm trống, hiển thị lại tất cả sản phẩm
        if (!searchTerm) {
            renderProducts(allProducts);
            return;
        }

        // Lọc sản phẩm khớp với ký tự tìm kiếm
        const filteredProducts = allProducts.filter((product) => {
            const productName = product.name.toLowerCase(); // Lấy tên sản phẩm từ API
            return productName.includes(searchTerm); // Kiểm tra sản phẩm có chứa từ khóa không
        });

        // Hiển thị danh sách sản phẩm đã lọc
        renderProducts(filteredProducts);
    });

    // Xử lý khi nhấn nút tìm kiếm
    searchButton.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định (submit form nếu có)
        const searchTerm = searchInput.value.trim().toLowerCase(); // Lấy giá trị nhập vào

        // Nếu ô tìm kiếm trống, hiển thị lại toàn bộ sản phẩm
        if (!searchTerm) {
            renderProducts(allProducts);
            return;
        }

        // Lọc sản phẩm khớp với ký tự tìm kiếm
        const filteredProducts = allProducts.filter((product) => {
            const productName = product.name.toLowerCase(); // Lấy tên sản phẩm
            return productName.includes(searchTerm); // Kiểm tra sản phẩm có chứa từ khóa không
        });

        // Hiển thị danh sách sản phẩm đã lọc
        renderProducts(filteredProducts);
    });

    // Hàm hiển thị danh sách sản phẩm
    function renderProducts(products) {
        productsContainer.innerHTML = ""; // Xóa các sản phẩm hiện tại
    
        if (products.length === 0) {
            // Thêm thông báo nếu không tìm thấy sản phẩm
            productsContainer.innerHTML = `<p class="text-gray-500">Không tìm thấy sản phẩm phù hợp.</p>`;
        } else {
            // Render từng sản phẩm
            products.forEach((product) => {
                const productHTML = `
                    <div class="p-4 rounded-lg" style="background-color: #E5E7EB;"> <!-- Đặt nền xám cố định -->
                        <a href="#" class="block">
                            <img src="${product.image_url}" 
                                 alt="${product.name}" 
                                 class="aspect-square w-full rounded-lg object-cover">
                            <h3 class="mt-4 text-sm text-gray-700">${product.name}</h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">${new Intl.NumberFormat().format(product.price)} VND</p>
                        </a>
                    </div>
                `;
                productsContainer.insertAdjacentHTML("beforeend", productHTML);
            });
        }
    }
    
    // Hiển thị tất cả sản phẩm ban đầu
    renderProducts(allProducts);
});

document.addEventListener("DOMContentLoaded", function () {
    const sortButtons = document.querySelectorAll("[data-sort]"); // Các nút sắp xếp
    const productsContainer = document.querySelector(".grid"); // Container sản phẩm
    const defaultUrl = "/api/accessories/sorted"; // URL API

    // Hàm gọi API để lấy sản phẩm đã sắp xếp
    async function fetchSortedProducts(sortType) {
        try {
            const response = await fetch(`${defaultUrl}?sort=${sortType}`);
            if (response.ok) {
                const sortedProducts = await response.json();
                renderProducts(sortedProducts);
            } else {
                console.error("Lỗi khi gọi API sắp xếp sản phẩm.");
            }
        } catch (error) {
            console.error("Lỗi kết nối API:", error);
        }
    }

    // Lắng nghe sự kiện click trên nút sắp xếp
    sortButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const sortType = this.getAttribute("data-sort"); // Lấy loại sắp xếp
            fetchSortedProducts(sortType); // Gọi API để sắp xếp sản phẩm
        });
    });

    // Hàm render lại sản phẩm sau khi sắp xếp
    function renderProducts(products) {
        productsContainer.innerHTML = ""; // Xóa các sản phẩm hiện tại
    
        if (products.length === 0) {
            // Thêm thông báo nếu không tìm thấy sản phẩm
            productsContainer.innerHTML = `<p class="text-gray-500">Không tìm thấy sản phẩm phù hợp.</p>`;
        } else {
            // Render từng sản phẩm
            products.forEach((product) => {
                const productHTML = `
                    <div class="p-4 rounded-lg" style="background-color: #E5E7EB;"> <!-- Đặt nền xám cố định -->
                        <a href="#" class="block">
                            <img src="${product.image_url}" 
                                 alt="${product.name}" 
                                 class="aspect-square w-full rounded-lg object-cover">
                            <h3 class="mt-4 text-sm text-gray-700">${product.name}</h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">${new Intl.NumberFormat().format(product.price)} VND</p>
                        </a>
                    </div>
                `;
                productsContainer.insertAdjacentHTML("beforeend", productHTML);
            });
        }
    }
    
});


