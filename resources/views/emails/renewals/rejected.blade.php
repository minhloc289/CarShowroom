<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #1a1a1a; margin: 0; padding: 0; background-color: #f5f5f5;">
    <div style="width: 100%; max-width: 700px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #b71c1c; padding: 20px; text-align: center;">
            <h1 style="font-size: 20px; color: #ffffff; margin: 10px 0 0;">Yêu cầu gia hạn đã bị từ chối</h1>
        </div>
        
        <div style="padding: 20px;">
            <div style="font-size: 16px; margin-bottom: 20px;">
                Kính gửi Quý khách <strong>{{ $name }}</strong>,
            </div>
            
            <div style="font-size: 14px; line-height: 1.5; margin-bottom: 20px;">
                Chúng tôi xin thông báo rằng yêu cầu gia hạn của Quý khách với mã yêu cầu <strong>#{{ $renewal_id }}</strong> đã bị từ chối.
            </div>
            
            <div style="background-color: #f8f9fc; padding: 15px; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px;">
                <div style="margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #4a4a4a; font-weight: bold;">Ngày kết thúc thuê:</span>
                    <span style="font-weight: bold; color: #b71c1c;">{{ $rental_end_date }}</span>
                </div>
            </div>
        </div>
        
        <div style="background-color: #f8f9fc; padding: 20px; text-align: center; font-size: 14px; border-top: 1px solid #e0e0e0;">
            <p>Trân trọng,</p>
            <div style="font-weight: bold; color: #b71c1c;">Merus Auto Showroom</div>
        </div>
    </div>
</body>
</html>
