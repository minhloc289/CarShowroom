const carInfoData = [
    {
        model: "Porsche 911 Carrera",
        seats: "4 chỗ",
        range: "~ 350 km",
        price: "2,500,000,000 VNĐ"
    },
    {
        model: "Porsche 911 Sport Classic",
        seats: "2 chỗ",
        range: "~ 400 km",
        price: "3,200,000,000 VNĐ"
    },
    {
        model: "Porsche 911 Targa 4S",
        seats: "2 chỗ",
        range: "~ 320 km",
        price: "2,900,000,000 VNĐ"
    },
    {
        model: "Porsche 911 Carrera S",
        seats: "4 chỗ",
        range: "~ 380 km",
        price: "2,700,000,000 VNĐ"
    },
    {
        model: "Porsche 911 GTS",
        seats: "2 chỗ",
        range: "~ 420 km",
        price: "3,100,000,000 VNĐ"
    },
    {
        model: "Porsche 911 Carrera 4",
        seats: "4 chỗ",
        range: "~ 360 km",
        price: "2,600,000,000 VNĐ"
    }
];

let currentIndex = 0;

// Function to update car info
function updateInfo(direction) {
    if (direction === "next") {
        currentIndex = (currentIndex + 1) % carInfoData.length;
    } else if (direction === "prev") {
        currentIndex = (currentIndex - 1 + carInfoData.length) % carInfoData.length;
    }

    const carInfo = carInfoData[currentIndex];
    document.getElementById("car-info").innerHTML = `
        <p><strong>Dòng xe</strong>: ${carInfo.model}</p>
        <p><strong>Số chỗ ngồi</strong>: ${carInfo.seats}</p>
        <p><strong>Quãng đường lên tới</strong>: ${carInfo.range}</p>
        <p><strong>Giá từ</strong>: ${carInfo.price}</p>
        
    `;
}
