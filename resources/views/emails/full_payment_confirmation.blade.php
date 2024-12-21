<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; margin: 0; padding: 0; background-color: #f5f5f5;">
    <div style="width: 100%; max-width: 700px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #1a237e; padding: 20px; text-align: center;">
            <img src="https://raw.githubusercontent.com/cotda/image/refs/heads/main/logo%20(2).png" alt="Merus Auto Showroom Logo" style="width: 120px; height: auto; margin-bottom: 10px;">
            <h1 style="font-size: 20px; color: #ffffff; margin: 10px 0 0; text-transform: uppercase;">Xác nhận Thanh Toán Toàn Bộ Thành Công</h1>
        </div>
        
        <div style="padding: 20px;">
            <div style="font-size: 16px; margin-bottom: 20px; color: #333333;">
                Kính gửi Quý khách <strong>{{ $name }}</strong>,
            </div>
            
            <div style="font-size: 14px; line-height: 1.5; margin-bottom: 20px; color: #333333;">
                Trân trọng cảm ơn Quý khách đã tin tưởng và lựa chọn dịch vụ thuê xe tại <strong>Merus Auto Showroom</strong>. 
                Chúng tôi xin xác nhận thông tin thanh toán toàn bộ của Quý khách như sau:
            </div>
            
            <div style="background-color: #f8f9fc; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Mã Đơn Hàng:</span>
                    <span style="font-weight: bold; color: #1a237e;">{{ $order_id }}</span>
                </div>
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Thời Gian Bắt Đầu:</span>
                    <span style="font-weight: bold; color: #1a237e;">{{ $start_date }}</span>
                </div>
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Thời Gian Kết Thúc:</span>
                    <span style="font-weight: bold; color: #1a237e;">{{ $end_date }}</span>
                </div>
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Tổng Chi Phí Thuê:</span>
                    <span style="font-weight: bold; color: #1a237e;">{{ number_format($total_cost, 0, ',', '.') }} VNĐ</span>
                </div>
            </div>
            
            <div style="background-color: #f8f9fc; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
                <div style="font-weight: bold; color: #1a237e; margin-bottom: 10px; font-size: 16px;">Thông Tin Liên Hệ</div>
                <div><strong>Điện thoại:</strong> 0708985088</div>
                <div><strong>Email:</strong> 22520561@gm.uit.edu.vn</div>
                <p>Đội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng phục vụ Quý khách 24/7.</p>
            </div>
        </div>
        
        <div style="background-color: #f8f9fc; padding: 20px; text-align: center; font-size: 14px; border-top: 1px solid #e0e0e0;">
            <p>Trân trọng,</p>
            <div style="font-weight: bold; color: #1a237e; margin: 10px 0;">CEO CÁI NGỌC MINH LỘC</div>
            <div style="color: #4a4a4a; margin: 5px 0;">Merus Auto Showroom</div>
            <div>
                <a href="https://www.facebook.com/minhloc.caingoc" style="color: #1a237e; text-decoration: none; margin: 0 10px;">Facebook</a> |
                <a href="https://www.instagram.com/cnml_2809/" style="color: #1a237e; text-decoration: none; margin: 0 10px;">Instagram</a> |
                <a href="https://www.linkedin.com/in/l%E1%BB%99c-c%C3%A1i-b5b9b9259/" style="color: #1a237e; text-decoration: none; margin: 0 10px;">LinkedIn</a>
            </div>
        </div>
    </div>
</body>
</html>
