function showTab(car) {
  // Show the selected tab content and add underline to the active tab
  if (car === "car1") {
      document.getElementById("contentCar1").classList.remove("hidden");
      document.getElementById("contentCar2").classList.add("hidden");
      document.getElementById("tabCar1").classList.add("custom-underline", "text-black", "border-blue-500");
      document.getElementById("tabCar2").classList.remove("custom-underline")
  } else if (car === "car2") {
      document.getElementById("contentCar2").classList.remove("hidden");
      document.getElementById("contentCar1").classList.add("hidden");
      document.getElementById("tabCar2").classList.add("custom-underline", "text-black", "border-blue-500");
      document.getElementById("tabCar1").classList.remove("custom-underline")
  }
}


// ----------------------------------

function getSelectedCars() {
const selectedCars = []; // Mảng để lưu thông tin các xe đã chọn
const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Chọn tất cả các checkbox
let maxValues = {
  speed: 0,
  seat: 0,
  power: 0,
  trunk: 0,
  price: 0
};

checkboxes.forEach(checkbox => {
const speed = parseInt(checkbox.getAttribute('speed') || '0'); // Nếu null, dùng '0'
const seat = parseInt(checkbox.getAttribute('seat') || '0');
const power = checkbox.getAttribute('power') 
              ? parseInt(checkbox.getAttribute('power').replace(' HP', '')) 
              : 0; // Xử lý khi null
const trunk = checkbox.getAttribute('trunk') 
              ? parseInt(checkbox.getAttribute('trunk').replace(' cubic feet', '')) 
              : 0; // Xử lý khi null
const price = parseInt(checkbox.getAttribute('price') || '0');

    maxValues.speed = Math.max(maxValues.speed, speed);
    maxValues.seat = Math.max(maxValues.seat, seat);
    maxValues.power = Math.max(maxValues.power, power);
    maxValues.trunk = Math.max(maxValues.trunk, trunk);
    maxValues.price = Math.max(maxValues.price, price);
});





checkboxes.forEach(checkbox => {
    const span = checkbox.nextElementSibling; // Lấy phần tử <span> liền sau checkbox

    // Nếu checkbox được chọn, thêm nội dung vào mảng selectedCars
    if (checkbox.checked) {
      const speed = parseInt(checkbox.getAttribute('speed')) || 0;
      const seat = parseInt(checkbox.getAttribute('seat')) || 0;
      const power = parseInt(checkbox.getAttribute('power').replace(' HP', '')) || 0;
      const trunk = parseInt(checkbox.getAttribute('trunk').replace(' cubic feet', '')) || 0;
      const length = parseInt(checkbox.getAttribute('length')) || 0;
      const width = parseInt(checkbox.getAttribute('width')) || 0;
      const height = parseInt(checkbox.getAttribute('height')) || 0;
      const price = parseInt(checkbox.getAttribute('price')) || 0;
      const accelerationTime = parseFloat(checkbox.getAttribute('acceleration_time')) || 0;
      const fuelEfficiency = parseFloat(checkbox.getAttribute('fuel_efficiency')) || 0;
      const torque = parseInt(checkbox.getAttribute('torque')) || 0;

      const speedPercent = ((speed / maxValues.speed) * 100).toFixed(2); // Chuyển thành %
      const seatPercent = ((seat / maxValues.seat) * 100).toFixed(2);
      const powerPercent = ((power / maxValues.power) * 100).toFixed(2);
      const trunkPercent = ((trunk / maxValues.trunk) * 100).toFixed(2);
      const pricePercent = ((price / maxValues.price) * 100).toFixed(2); // Tính % của giá xe
      
      selectedCars.push({
          name: span.textContent.trim(),
          image: checkbox.getAttribute('data-image'), // Lấy URL ảnh
          speedp: speedPercent, // Lưu giá trị %
          seatp: seatPercent,
          powerp: powerPercent,
          trunkp: trunkPercent,
          pricep: pricePercent,
          speed: speed, // Lưu giá trị thực
          seat: seat,
          power: power,
          trunk: trunk,
          length: length,
          width: width,
          height: height,
          price: price,
          acceleration_time: accelerationTime, // Thêm acceleration_time
          fuel_efficiency: fuelEfficiency,    // Thêm fuel_efficiency
          torque: torque        
      });
    }
});

// Nếu số lượng xe đã chọn vượt quá 2, hủy chọn checkbox vừa nhấp và thông báo
if (selectedCars.length > 2) {
    Swal.fire({
        title: 'Thông báo',
        text: 'Bạn chỉ được chọn tối đa 2 xe.',
        icon: 'warning',
        confirmButtonText: 'OK',
        timer: 1000, // Tự động đóng sau 1 giây
        timerProgressBar: true,
    });

    // Hủy chọn checkbox mới chọn
    const lastChecked = selectedCars.pop(); // Bỏ xe mới nhất ra khỏi mảng
    checkboxes.forEach(checkbox => {
        const span = checkbox.nextElementSibling;
        if (span.textContent.trim() === lastChecked.name) {
            checkbox.checked = false;
        }
    });
}

return selectedCars; // Trả về mảng các xe đã chọn
}

function choose_car() {
const selectedCars = getSelectedCars(); // Lấy danh sách các xe đã chọn
const selectionBox1 = document.querySelector('#selectionBox1');
const selectionBox2 = document.querySelector('#selectionBox2');
const car1Span = document.querySelector('.Car1');
const car2Span = document.querySelector('.Car2');
// Xóa nội dung cũ của các ô hiển thị
selectionBox1.innerHTML = `
    <span class="text-4xl text-gray-500">+</span>
    <span class="mt-2 text-gray-700">Choose a car</span>
`;
selectionBox2.innerHTML = `
    <span class="text-4xl text-gray-500">+</span>
    <span class="mt-2 text-gray-700">Choose a car</span>
`;
car1Span.textContent = "";
car2Span.textContent = "";
// Cập nhật nội dung của các ô với tên và hình ảnh xe đã chọn
if (selectedCars[0]) {
    car1Span.textContent = selectedCars[0].name;
    selectionBox1.innerHTML = `
        <img src="${selectedCars[0].image}" class="w-[90%] h-full rounded-full"> `;
}
if (selectedCars[1]) {
    car2Span.textContent = selectedCars[1].name;
    selectionBox2.innerHTML = `
        <img src="${selectedCars[1].image}" class="w-[90%] h-full rounded-full">
    `;
}

const contentCar1 = document.getElementById('contentCar1');
const contentCar2 = document.getElementById('contentCar2');

  if (selectedCars.length === 2) {
      const diffSpeed = selectedCars[0].speed - selectedCars[1].speed;
      const diffSeat = selectedCars[0].seat - selectedCars[1].seat;
      const diffPower = selectedCars[0].power - selectedCars[1].power;
      const diffTrunk = selectedCars[0].trunk - selectedCars[1].trunk;
      const diffPrice = selectedCars[0].price - selectedCars[1].price;
      contentCar1.innerHTML = `
          <h2 class="text-2xl font-bold">Why is ${selectedCars[0].name} better than ${selectedCars[1].name}</h2>
          <ul class="list-none mt-4">

          ${diffPrice < 0 ? `
            <li class="flex items-center mb-2">
                <span class="text-green-600 font-bold">✔</span>
                <div class="ml-2">
                    <p><b>${Math.abs(diffPrice)} dollar</b> cheaper, making it a more budget-friendly option</p>
                    <small>${selectedCars[0].price} vs ${selectedCars[1].price}</small>
                </div>
            </li>` : ''}

      ${diffSeat > 0 ? `
      <li class="flex items-center mb-2">
          <span class="text-green-600 font-bold">✔</span>
          <div class="ml-2">
              <p><b>${diffSeat} seats</b> higher seating capacity</p>
              <small>${selectedCars[0].seat} vs ${selectedCars[1].seat}</small>
          </div>
      </li>` : ''}
      
      ${diffPower > 0 ? `
      <li class="flex items-center mb-2">
          <span class="text-green-600 font-bold">✔</span>
          <div class="ml-2">
              <p><b>${diffPower} HP</b> more engine power</p>
              <small>${selectedCars[0].power} HP vs ${selectedCars[1].power} HP</small>
          </div>
      </li>` : ''}
      
      ${diffSpeed > 0 ? `
      <li class="flex items-center mb-2">
          <span class="text-green-600 font-bold">✔</span>
          <div class="ml-2">
              <p><b>${diffSpeed} km/h</b> faster max speed</p>
              <small>${selectedCars[0].speed} km/h vs ${selectedCars[1].speed} km/h</small>
          </div>
      </li>` : ''}
      
      ${diffTrunk > 0 ? `
      <li class="flex items-center mb-2">
          <span class="text-green-600 font-bold">✔</span>
          <div class="ml-2">
              <p><b>${diffTrunk} cubic feet</b> larger trunk capacity</p>
              <small>${selectedCars[0].trunk} vs ${selectedCars[1].trunk}</small>
          </div>
      </li>` : ''}
  </ul>
      `;
//--------------------------------------------------------------------------
      contentCar2.innerHTML = `
      <h2 class="text-2xl font-bold">Why is ${selectedCars[1].name} better than ${selectedCars[0].name}</h2>
      <ul class="list-none mt-4">

       ${diffPrice > 0 ? `
            <li class="flex items-center mb-2">
                <span class="text-green-600 font-bold">✔</span>
                <div class="ml-2">
                    <p><b>${Math.abs(diffPrice)} dollar</b> cheaper, making it a more budget-friendly option</p>
                    <small>${selectedCars[1].price} vs ${selectedCars[0].price}</small>
                </div>
            </li>` : ''}

          ${diffSeat < 0 ? `
          <li class="flex items-center mb-2">
              <span class="text-green-600 font-bold">✔</span>
              <div class="ml-2">
                  <p><b>${Math.abs(diffSeat).toFixed(2)} seats</b> higher seating capacity</p>
                  <small>${selectedCars[1].seat} vs ${selectedCars[0].seat}</small>
              </div>
          </li>` : ''}
          
          ${diffPower < 0 ? `
          <li class="flex items-center mb-2">
              <span class="text-green-600 font-bold">✔</span>
              <div class="ml-2">
                  <p><b>${Math.abs(diffPower).toFixed(2)} HP</b> more engine power</p>
                  <small>${selectedCars[1].power} HP vs ${selectedCars[0].power} HP</small>
              </div>
          </li>` : ''}
          
          ${diffSpeed < 0 ? `
          <li class="flex items-center mb-2">
              <span class="text-green-600 font-bold">✔</span>
              <div class="ml-2">
                  <p><b>${Math.abs(diffSpeed).toFixed(2)} km/h</b> faster max speed</p>
                  <small>${selectedCars[1].speed} km/h vs ${selectedCars[0].speed} km/h</small>
              </div>
          </li>` : ''}
          
          ${diffTrunk < 0 ? `
          <li class="flex items-center mb-2">
              <span class="text-green-600 font-bold">✔</span>
              <div class="ml-2">
                  <p><b>${Math.abs(diffTrunk).toFixed(2)} cubic feet</b> larger trunk capacity</p>
                  <small>${selectedCars[1].trunk} vs ${selectedCars[0].trunk}</small>
              </div>
          </li>` : ''}
      </ul>
      `;

  } else {
      contentCar1.innerHTML = `<h2 class="text-2xl font-bold">No Car Selected</h2>`;
      contentCar2.innerHTML = `<h2 class="text-2xl font-bold">No Car Selected</h2>`;
  }

//-------------------------------------------------------------------------
//<!-- Specification Cards -->
    const lengthCard = document.getElementById('lengthCard');
    const widthCard = document.getElementById('widthCard');
    const totalLength = selectedCars[0].length + selectedCars[1].length;
    const car1LengthPercent = ((selectedCars[0].length / totalLength) * 100).toFixed(2);
    const car2LengthPercent = ((selectedCars[1].length / totalLength) * 100).toFixed(2);
    
    // Cập nhật giá trị và thanh tiến trình cho xe 1
    document.getElementById("car1-length-value").textContent = `${selectedCars[0].length} mm`;
    document.getElementById("car1-length-bar").style.width = `${car1LengthPercent}%`;

    // Cập nhật giá trị và thanh tiến trình cho xe 2
    document.getElementById("car2-length-value").textContent = `${selectedCars[1].length} mm`;
    document.getElementById("car2-length-bar").style.width = `${car2LengthPercent}%`;

    const totalWidth = selectedCars[0].width + selectedCars[1].width;
    const car1WidthPercent = ((selectedCars[0].width / totalWidth) * 100).toFixed(2);
    const car2WidthPercent = ((selectedCars[1].width / totalWidth) * 100).toFixed(2);

    // Cập nhật giá trị và thanh tiến trình cho xe 1
    document.getElementById("car1-width-value").textContent = `${selectedCars[0].width} mm`;
    document.getElementById("car1-width-bar").style.width = `${car1WidthPercent}%`;

    // Cập nhật giá trị và thanh tiến trình cho xe 2
    document.getElementById("car2-width-value").textContent = `${selectedCars[1].width} mm`;
    document.getElementById("car2-width-bar").style.width = `${car2WidthPercent}%`;

    const totalHeight = selectedCars[0].height + selectedCars[1].height;
    const car1HeightPercent = ((selectedCars[0].height / totalHeight) * 100).toFixed(2);
    const car2HeightPercent = ((selectedCars[1].height / totalHeight) * 100).toFixed(2);

    // Cập nhật giá trị và thanh tiến trình cho xe 1
    document.getElementById("car1-height-value").textContent = `${selectedCars[0].height} mm`;
    document.getElementById("car1-height-bar").style.width = `${car1HeightPercent}%`;

    // Cập nhật giá trị và thanh tiến trình cho xe 2
    document.getElementById("car2-height-value").textContent = `${selectedCars[1].height} mm`;
    document.getElementById("car2-height-bar").style.width = `${car2HeightPercent}%`;

//<!-- Performance Cards ---------------------------------------------------->
    // Tính tổng và phần trăm cho từng thuộc tính mới
      const totalAccelerationTime = selectedCars[0].acceleration_time + selectedCars[1].acceleration_time;
      const car1AccelerationPercent = ((selectedCars[0].acceleration_time / totalAccelerationTime) * 100).toFixed(2);
      const car2AccelerationPercent = ((selectedCars[1].acceleration_time / totalAccelerationTime) * 100).toFixed(2);

      const totalFuelEfficiency = selectedCars[0].fuel_efficiency + selectedCars[1].fuel_efficiency;
      const car1EfficiencyPercent = ((selectedCars[0].fuel_efficiency / totalFuelEfficiency) * 100).toFixed(2);
      const car2EfficiencyPercent = ((selectedCars[1].fuel_efficiency / totalFuelEfficiency) * 100).toFixed(2);

      const totalTorque = selectedCars[0].torque + selectedCars[1].torque;
      const car1TorquePercent = ((selectedCars[0].torque / totalTorque) * 100).toFixed(2);
      const car2TorquePercent = ((selectedCars[1].torque / totalTorque) * 100).toFixed(2);

      // Cập nhật giá trị và thanh tiến trình trên giao diện
      // Acceleration
      document.getElementById("car1-acceleration-value").textContent = `${selectedCars[0].acceleration_time} s`;
      document.getElementById("car1-acceleration-bar").style.width = `${car1AccelerationPercent}%`;

      document.getElementById("car2-acceleration-value").textContent = `${selectedCars[1].acceleration_time} s`;
      document.getElementById("car2-acceleration-bar").style.width = `${car2AccelerationPercent}%`;

      // Efficiency
      document.getElementById("car1-efficiency-value").textContent = `${selectedCars[0].fuel_efficiency} km/l`;
      document.getElementById("car1-efficiency-bar").style.width = `${car1EfficiencyPercent}%`;

      document.getElementById("car2-efficiency-value").textContent = `${selectedCars[1].fuel_efficiency} km/l`;
      document.getElementById("car2-efficiency-bar").style.width = `${car2EfficiencyPercent}%`;

      // Torque
      document.getElementById("car1-torque-value").textContent = `${selectedCars[0].torque} Nm`;
      document.getElementById("car1-torque-bar").style.width = `${car1TorquePercent}%`;

      document.getElementById("car2-torque-value").textContent = `${selectedCars[1].torque} Nm`;
      document.getElementById("car2-torque-bar").style.width = `${car2TorquePercent}%`;


//-------------------------------------------------------------------------
const legendItems = document.querySelectorAll('.radar-legend .legend-item span');
  if (selectedCars[0]) {
      legendItems[0].textContent = selectedCars[0].name;
  } else {
      legendItems[0].textContent = 'Car 1'; // Giá trị mặc định nếu không có xe nào được chọn
  }

  if (selectedCars[1]) {
      legendItems[1].textContent = selectedCars[1].name;
  } else {
      legendItems[1].textContent = 'Car 2'; // Giá trị mặc định nếu không có xe nào được chọn
  }

const chartData = {
  labels: ['Speed', 'Seat', 'Engine Power', 'Trunk', 'Price'], // Cập nhật các nhãn
  car1: selectedCars[0] 
        ? [selectedCars[0].speedp, selectedCars[0].seatp, selectedCars[0].powerp, selectedCars[0].trunkp, selectedCars[0].pricep]
        : [0, 0, 0, 0, 0],
  car2: selectedCars[1] 
        ? [selectedCars[1].speedp, selectedCars[1].seatp, selectedCars[1].powerp, selectedCars[1].trunkp, selectedCars[1].pricep]
        : [0, 0, 0, 0, 0]
};

// Vẽ lại biểu đồ
new RadarChart('#radarChart', chartData);

// Đóng modal
toggleModal(false);
}

function toggleModal(show) {
const modal = document.getElementById('carModal');
modal.classList.toggle('hidden', !show); // Hiển thị hoặc ẩn modal dựa trên tham số `show`
}


// Chart Script--------------------------------------------------------------------------

class RadarChart {
  constructor(selector, data) {
    this.svg = document.querySelector(selector);
    this.svg.innerHTML = '';
    this.data = data;
    this.centerX = 200;
    this.centerY = 200;
    this.radius = 150;
    this.levels = 5;
    
    this.init();
  }

  init() {
    this.drawGrid();
    this.drawAxis();
    this.drawData();
  }

  getPathCoordinates(values) {
    return values.map((value, i) => {
      const angle = (Math.PI * 2 * i) / values.length - Math.PI / 2;
      const r = (value / 100) * this.radius;
      return {
        x: this.centerX + r * Math.cos(angle),
        y: this.centerY + r * Math.sin(angle)
      };
    });
  }

  createPath(points) {
    return points.map((point, i) => 
      (i === 0 ? 'M' : 'L') + point.x + ',' + point.y
    ).join(' ') + 'Z';
  }

  drawGrid() {
    for(let i = 1; i <= this.levels; i++) {
      const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
      circle.setAttribute("cx", this.centerX);
      circle.setAttribute("cy", this.centerY);
      circle.setAttribute("r", this.radius * (i / this.levels));
      circle.setAttribute("fill", "none");
      circle.setAttribute("stroke", "#ddd");
      circle.setAttribute("stroke-width", "1");
      this.svg.appendChild(circle);
    }
  }

  drawAxis() {
    this.data.labels.forEach((label, i) => {
      const angle = (Math.PI * 2 * i) / this.data.labels.length - Math.PI / 2;
      const lineEndX = this.centerX + this.radius * Math.cos(angle);
      const lineEndY = this.centerY + this.radius * Math.sin(angle);
      const labelX = this.centerX + (this.radius + 30) * Math.cos(angle);
      const labelY = this.centerY + (this.radius + 30) * Math.sin(angle);

      // Draw axis line
      const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
      line.setAttribute("x1", this.centerX);
      line.setAttribute("y1", this.centerY);
      line.setAttribute("x2", lineEndX);
      line.setAttribute("y2", lineEndY);
      line.setAttribute("stroke", "#ddd");
      line.setAttribute("stroke-width", "1");

      // Draw label
      const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
      text.setAttribute("x", labelX);
      text.setAttribute("y", labelY);
      text.setAttribute("text-anchor", "middle");
      text.setAttribute("dominant-baseline", "middle");
      text.setAttribute("font-size", "16");
      text.setAttribute("fill", "#666");
      text.textContent = label;

      this.svg.appendChild(line);
      this.svg.appendChild(text);
    });
  }

  drawData() {
    // Draw Car 1 data
    const points1 = this.getPathCoordinates(this.data.car1);
    const path1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path1.setAttribute("d", this.createPath(points1));
    path1.setAttribute("fill", "rgba(231, 97, 19, 0.5)");
    path1.setAttribute("stroke", "#3b82f6");
    path1.setAttribute("stroke-width", "2");

    // Draw Car 2 data
    const points2 = this.getPathCoordinates(this.data.car2);
    const path2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path2.setAttribute("d", this.createPath(points2));
    path2.setAttribute("fill", "rgba(68, 239, 191, 0.5)");
    path2.setAttribute("stroke", "#001d1580");
    path2.setAttribute("stroke-width", "2");

    this.svg.appendChild(path1);
    this.svg.appendChild(path2);
  }
}

// Initialize the chart when the page loads
document.addEventListener('DOMContentLoaded', () => {
  const chartData = {
      labels: ['Speed', 'Seat', 'Engine Power', 'Trunk', 'Price'],
      car1: [0, 0, 0, 0, 0], // Dữ liệu mặc định cho xe 1
      car2: [0, 0, 0, 0, 0]  // Dữ liệu mặc định cho xe 2
  };

  new RadarChart('#radarChart', chartData);
});


