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
   const selectedCars = []; // Mảng để lưu tên các xe đã chọn
  const checkboxes = document.querySelectorAll('input[type="checkbox"]'); // Chọn tất cả các checkbox

checkboxes.forEach(checkbox => {
    const span = checkbox.nextElementSibling; // Lấy phần tử <span> liền sau checkbox

// Nếu checkbox được chọn, thêm nội dung của span vào mảng selectedCars
if (checkbox.checked) {
    selectedCars.push(span.textContent);
  }
     });

// Nếu số lượng xe đã chọn vượt quá 2, hủy chọn checkbox vừa nhấp và thông báo
 if (selectedCars.length > 2) {
  const lastChecked = selectedCars.pop(); // Bỏ xe mới nhất ra khỏi mảng
    alert("Bạn chỉ được chọn tối đa 2 xe.");

    // Hủy chọn checkbox vừa chọn
    checkboxes.forEach(checkbox => {
    if (checkbox.nextElementSibling.textContent === lastChecked) {
        checkbox.checked = false;
      }
 });
 }

    return selectedCars; // Trả về mảng các xe đã chọn
}
// -----------------------------------------------------------------------------------------

function choose_car(){
    const selectedCars = getSelectedCars()
    const car1Span = document.querySelector('.Car1');
    const car2Span = document.querySelector('.Car2');

    // Xóa nội dung cũ
    car1Span.textContent = "";
    car2Span.textContent = "";

    // Cập nhật nội dung của các span với tên xe đã chọn
    if (selectedCars[0]) {
        car1Span.textContent = selectedCars[0];
    }
    if (selectedCars[1]) {
        car2Span.textContent = selectedCars[1];
    }
}


function toggleModal(show) {
    const modal = document.getElementById('carModal');
    modal.classList.toggle('hidden', !show);
}


// Chart Script--------------------------------------------------------------------------

class RadarChart {
    constructor(selector, data) {
      this.svg = document.querySelector(selector);
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
        text.setAttribute("font-size", "12");
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
      path1.setAttribute("fill", "rgba(59, 130, 246, 0.5)");
      path1.setAttribute("stroke", "#3b82f6");
      path1.setAttribute("stroke-width", "2");
  
      // Draw Car 2 data
      const points2 = this.getPathCoordinates(this.data.car2);
      const path2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
      path2.setAttribute("d", this.createPath(points2));
      path2.setAttribute("fill", "rgba(239, 68, 68, 0.5)");
      path2.setAttribute("stroke", "#ef4444");
      path2.setAttribute("stroke-width", "2");
  
      this.svg.appendChild(path1);
      this.svg.appendChild(path2);
    }
  }
  
  // Initialize the chart when the page loads
  document.addEventListener('DOMContentLoaded', () => {
    const chartData = {
      labels: ['Speed', 'Comfort', 'Safety', 'Fuel Economy', 'Price', 'Performance'],
      car1: [80, 90, 85, 70, 65, 75],
      car2: [70, 85, 90, 100, 75, 65]
    };
  
    new RadarChart('#radarChart', chartData);
  });
