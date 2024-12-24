<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; margin: 0; padding: 0; background-color: #f5f5f5;">
    <div style="width: 100%; max-width: 700px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #d32f2f; padding: 20px; text-align: center;">
            <img src="https://raw.githubusercontent.com/cotda/image/refs/heads/main/logo%20(2).png" alt="Merus Auto Showroom Logo" style="width: 120px; height: auto; margin-bottom: 10px;">
            <h1 style="font-size: 20px; color: #ffffff; margin: 10px 0 0; text-transform: uppercase;">Gia Hạn Bị Hủy</h1>
        </div>
        
        <div style="padding: 20px;">
            <div style="font-size: 16px; margin-bottom: 20px; color: #333333;">
                Kính gửi Quý khách <strong>{{ $name }}</strong>,
            </div>
            
            <div style="font-size: 14px; line-height: 1.5; margin-bottom: 20px; color: #333333;">
                Chúng tôi rất tiếc thông báo rằng yêu cầu gia hạn của Quý khách đã bị hủy vì lý do quá hạn thanh toán. Thông tin chi tiết:
            </div>
            
            <div style="background-color: #f8f9fc; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Mã Đơn Hàng:</span>
                    <span style="font-weight: bold; color: #d32f2f;">{{ $order_id }}</span>
                </div>
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold; display: inline-block; width: 150px;">Hạn Thanh Toán:</span>
                    <span style="font-weight: bold; color: #d32f2f;">{{ $due_date }}</span>
                </div>
            </div>
            
            <div style="font-size: 14px; color: #333333; margin-bottom: 20px;">
                Quý khách vui lòng liên hệ với chúng tôi để biết thêm chi tiết hoặc để hỗ trợ đặt lịch thuê xe mới.
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
