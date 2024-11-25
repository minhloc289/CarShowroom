
document.addEventListener("DOMContentLoaded", async function () {
    const categoryButtons = document.querySelectorAll('[data-category]');
    const productsContainer = document.querySelector('.grid'); // Container chứa sản phẩm
    const searchInput = document.querySelector("#search-accessories"); // Input tìm kiếm
    const searchButton = document.querySelector("#search-accessories-button"); // Nút tìm kiếm
    const sortButtons = document.querySelectorAll("[data-sort]"); // Các nút sắp xếp
    const productCountElement = document.getElementById("product-count"); // Phần tử hiển thị số lượng sản phẩm
    const loadMoreButton = document.getElementById("load-more"); // Nút "Xem thêm"
    const defaultUrl = "/api/accessories/sorted"; // URL API sắp xếp

    let allProducts = []; // Lưu danh sách tất cả sản phẩm
    let filteredProducts = []; // Lưu danh sách sản phẩm đã lọc
    let productsToShow = 8; // Số sản phẩm hiển thị ban đầu

    // Gọi API để lấy toàn bộ sản phẩm
    try {
        const response = await fetch('/api/accessories');
        if (response.ok) {
            allProducts = await response.json(); // Lưu toàn bộ sản phẩm
            filteredProducts = [...allProducts]; // Khởi tạo danh sách sản phẩm hiển thị là toàn bộ sản phẩm
            renderProducts(filteredProducts); // Hiển thị toàn bộ sản phẩm ban đầu
        } else {
            console.error('Failed to fetch accessories');
        }
    } catch (error) {
        console.error('Error fetching accessories:', error);
    }

    // Hàm cập nhật số lượng sản phẩm hiển thị
    function updateProductCount(displayed, total) {
        if (productCountElement) {
            productCountElement.textContent = `${displayed}/${total}`; // Hiển thị số lượng
        }
    }

    // Hàm hiển thị danh sách sản phẩm
    function renderProducts(products) {
        productsContainer.innerHTML = ""; // Xóa các sản phẩm hiện tại
        const totalProducts = products.length; // Tổng số sản phẩm trong danh sách đã lọc
        const displayedProducts = products.slice(0, productsToShow); // Lấy sản phẩm cần hiển thị

        // Cập nhật số lượng sản phẩm
        updateProductCount(displayedProducts.length, totalProducts);

        // Kiểm tra nếu không có sản phẩm
        if (displayedProducts.length === 0) {
            productsContainer.innerHTML = `<p class="text-gray-500">Không tìm thấy sản phẩm phù hợp.</p>`;
            return;
        }

        // Render từng sản phẩm
        displayedProducts.forEach((product) => {
            const productHTML = `
                <div class="p-4 rounded-lg bg-white border border-gray-200 shadow-sm hover:shadow-lg transition hover:text-blue-700">
                    <a href="/accessory/${product.accessory_id}" class="block">
                        <img src="${product.image_url}" 
                             alt="${product.name}" 
                             class="aspect-square w-full rounded-lg object-cover border border-black">
                        <h3 class="mt-4 text-sm text-gray-700">${product.name}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">${new Intl.NumberFormat().format(product.price)} VND</p>
                    </a>
                </div>
            `;
            productsContainer.insertAdjacentHTML("beforeend", productHTML);
        });

        // Hiển thị hoặc ẩn nút "Xem thêm"
        if (productsToShow >= totalProducts) {
            loadMoreButton.style.display = "none"; // Ẩn nút nếu đã hiển thị tất cả sản phẩm
        } else {
            loadMoreButton.style.display = "block"; // Hiện nút nếu còn sản phẩm chưa hiển thị
        }
    }

    // Sự kiện cho nút "Xem thêm"
    loadMoreButton.addEventListener("click", function () {
        productsToShow += 8; // Hiển thị thêm 8 sản phẩm
        renderProducts(filteredProducts); // Cập nhật hiển thị chỉ với danh sách đã lọc
    });

    // Lọc sản phẩm theo danh mục khi nhấn nút
    categoryButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const selectedCategory = button.getAttribute('data-category'); // Lấy danh mục được chọn
            filteredProducts = allProducts.filter(product => product.category === selectedCategory); // Lọc sản phẩm
            productsToShow = 8; // Reset số sản phẩm hiển thị
            renderProducts(filteredProducts); // Hiển thị sản phẩm đã lọc
        });
    });

    // Tìm kiếm sản phẩm theo tên
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.trim().toLowerCase(); // Lấy giá trị nhập vào
        filteredProducts = allProducts.filter(product =>
            product.name.toLowerCase().includes(searchTerm)); // Lọc sản phẩm theo từ khóa
        productsToShow = 8; // Reset số sản phẩm hiển thị
        renderProducts(filteredProducts); // Hiển thị sản phẩm đã lọc
    });

    // Xử lý khi nhấn nút tìm kiếm
    searchButton.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định
        const searchTerm = searchInput.value.trim().toLowerCase();
        filteredProducts = allProducts.filter(product =>
            product.name.toLowerCase().includes(searchTerm)); // Lọc sản phẩm
        productsToShow = 8; // Reset số sản phẩm hiển thị
        renderProducts(filteredProducts); // Hiển thị sản phẩm đã lọc
    });

    // Sắp xếp sản phẩm
    sortButtons.forEach((button) => {
        button.addEventListener("click", async function () {
            const sortType = this.getAttribute("data-sort"); // Lấy loại sắp xếp
            try {
                const response = await fetch(`${defaultUrl}?sort=${sortType}`);
                if (response.ok) {
                    filteredProducts = await response.json();
                    productsToShow = 8; // Reset số sản phẩm hiển thị
                    renderProducts(filteredProducts); // Render sản phẩm đã sắp xếp
                } else {
                    console.error("Lỗi khi gọi API sắp xếp sản phẩm.");
                }
            } catch (error) {
                console.error("Lỗi kết nối API:", error);
            }
        });
    });
});

