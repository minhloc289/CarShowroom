@extends('frontend.profilepage.viewprofile')
@section('main')
    <div style="background-color: #f3f4f6">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div class="container mt-4">
                <div class="d-flex border-bottom mb-3">
                    <button class="tablinks active px-4 py-2" onclick="openTab(event, 'carsContainer')"
                        style="border: none; font-size: 18px; color: #007bff; font-weight: bold; border-bottom: 3px solid #007bff; background-color: transparent;">
                        Xe ô tô - Xe máy điện
                    </button>
                    <button class="tablinks px-4 py-2" onclick="openTab(event, 'rentalContainer')"
                        style="border: none; font-size: 18px; color: #6c757d; background-color: transparent; font-weight: normal; border-bottom: 3px solid transparent;">
                        Xe thuê
                    </button>
                </div>
                

                <!-- Danh sách giao dịch Xe ô tô -->
                <div id="carsContainer" class="tabcontent d-flex flex-column">
                    @foreach ($transactions as $transaction)
                        @if ($transaction->order && $transaction->order->salesCar)
                            @php
                                $statusText = '';
                                $statusColor = '#e3e3e3'; // Default color
                                $colorText = '#1e1e1e';

                                switch ($transaction->status_deposit) {
                                    case 0:
                                        $statusText = 'Chờ thanh toán';
                                        $statusColor = '#e3e3e3'; // Gray
                                        $colorText = '#1e1e1e';

                                        break;
                                    case 1:
                                        $statusText = 'Đã thanh toán';
                                        $statusColor = '#28a745'; // Green
                                        $colorText = '#fff';

                                        break;
                                    case 2:
                                        $statusText = 'Đã hủy';
                                        $statusColor = '#dc3545'; // Red
                                        $colorText = '#fff';
                                        break;
                                }
                            @endphp

                            <div
                                style="display: flex; justify-content: space-between; align-items: center; border: 1px solid #ddd; padding: 16px; border-radius: 12px; margin-bottom: 16px; background-color: #ffffff; width: 95%; margin-left: auto; margin-right: auto;">
                                <!-- Ảnh và thông tin xe -->
                                <a
                                    href="{{ route('transactionHistory.details', ['orderId' => $transaction->order->order_id]) }}">
                                    <div style="display: flex; align-items: center;">
                                        <!-- Ảnh xe -->
                                        <img src="{{ $transaction->order->salesCar->carDetails->image_url ?? 'default-image.jpg' }}"
                                            alt="Car Image"
                                            style="width: 70px; height: auto; border-radius: 8px; margin-right: 15px;">
                                        <!-- Thông tin xe -->
                                        <div>
                                            <h4 style="margin: 0; font-weight: bold;">
                                                {{ $transaction->order->salesCar->carDetails->name ?? 'Không xác định' }}
                                            </h4>
                                            <p style="margin: 0; color: #6c757d;">Mã đơn hàng:
                                                {{ $transaction->order->order_id }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <!-- Trạng thái đơn hàng -->
                                <span
                                    style="font-size: 14px; background-color: {{ $statusColor }}; color: {{ $colorText }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                                    {{ $statusText }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Danh sách giao dịch Xe thuê -->
                <div id="rentalContainer" class="tabcontent d-flex flex-column" style="display: none;">
                    @foreach ($rentalTransactions as $rentalTransaction)
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; border: 1px solid #ddd; padding: 16px; border-radius: 12px; margin-bottom: 16px; background-color: #ffffff; width: 95%; margin-left: auto; margin-right: auto;">
                            <!-- Ảnh và thông tin xe thuê -->
                            <a href="{{route('rentalHistory.details', ['orderId' => $rentalTransaction->order_id])}}">
                                <div style="display: flex; align-items: center;">
                                    <!-- Ảnh xe -->
                                    <img src="{{ $rentalTransaction->rentalCar->carDetails->image_url ?? 'default-image.jpg' }}"
                                        alt="Rental Car Image"
                                        style="width: 70px; height: auto; border-radius: 8px; margin-right: 15px;">
                                    <!-- Thông tin xe -->
                                    <div>
                                        <h4 style="margin: 0; font-weight: bold;">
                                            {{ $rentalTransaction->rentalCar->carDetails->name ?? 'Không xác định' }}
                                        </h4>
                                        <p style="margin: 0; color: #6c757d;">Mã đơn hàng:
                                            {{ $rentalTransaction->order_id }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <!-- Trạng thái đơn hàng -->
                            @php
                                $statusText = '';
                                $statusColor = '#e3e3e3'; // Default color
                                $colorText = '#1e1e1e';

                                switch ($rentalTransaction->status) {
                                    case 'Pending':
                                        $statusText = 'Chờ xử lý';
                                        $statusColor = '#e3e3e3'; // Gray
                                        $colorText = '#1e1e1e';
                                        break;
                                    case 'Deposit Paid':
                                        $statusText = 'Đã đặt cọc';
                                        $statusColor = '#ffc107'; // Yellow
                                        $colorText = '#1e1e1e';
                                        break;
                                    case 'Paid':
                                        $statusText = 'Đã thanh toán';
                                        $statusColor = '#28a745'; // Green
                                        $colorText = '#fff';
                                        break;
                                    case 'Canceled':
                                        $statusText = 'Đã hủy';
                                        $statusColor = '#dc3545'; // Red
                                        $colorText = '#fff';
                                        break;
                                }
                            @endphp
                            <span
                                style="font-size: 14px; background-color: {{ $statusColor }}; color: {{ $colorText }}; padding: 8px 12px; border-radius: 12px; text-align: center;">
                                {{ $statusText }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            // Lấy tất cả các tab và nội dung tab
            var i, tabcontent, tablinks;
    
            // Ẩn tất cả nội dung tab
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
    
            // Loại bỏ class 'active' khỏi tất cả các tab
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
                tablinks[i].style.color = "#6c757d"; // Màu xám mặc định
                tablinks[i].style.borderBottom = "3px solid transparent"; // Không có gạch dưới
                tablinks[i].style.fontWeight = "normal"; // Chữ thường
            }
    
            // Hiển thị nội dung tab được chọn
            document.getElementById(tabName).style.display = "block";
    
            // Thêm class 'active' vào tab được chọn
            evt.currentTarget.className += " active";
            evt.currentTarget.style.color = "#007bff"; // Màu xanh
            evt.currentTarget.style.borderBottom = "3px solid #007bff"; // Gạch dưới màu xanh
            evt.currentTarget.style.fontWeight = "bold"; // Chữ đậm
        }
    
        // Hiển thị tab mặc định khi tải trang
        document.getElementById("carsContainer").style.display = "block";
    </script>    
@endsection


