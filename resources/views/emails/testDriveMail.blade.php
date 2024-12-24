<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Drive Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .email-header {
            width: 100%;
            border-bottom: 2px solid #00b140; /* Thanh ngang */
            margin-bottom: 20px;
            border-right:none;
            border-left:none;
            border-top: none;
        }
        .email-header td {
            text-align: center; /* Căn giữa theo chiều ngang */
            vertical-align: middle; /* Căn giữa theo chiều dọc */
            border: none;
        }
        .email-header tr {
            border: none;
        }
        
        .email-header .contact-info {
            font-size: 14px;
            line-height: 1.5;
        }
        .email-header img {
            height: 100px;
            display: block; /* Đảm bảo hình ảnh là block-level để căn giữa dễ dàng */
            margin: 0 auto; /* Căn giữa theo chiều ngang */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .car-image {
            text-align: center;
            margin-top: 20px;
        }
        .car-image img {
            max-width: 100%;
            height: auto;
        }
        .email-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #00b140;
            text-align: center;
        }
        .email-footer img {
            height: 40px;
            margin-bottom: 10px;
        }
        .email-footer a {
            text-decoration: none;
            color: #00b140;
        }
        .email-inf{
            text-align: center;
            
        }
        .email-inf h1{
            margin: 0;
            padding: 0;
            color: #033e19;
        }
        .email-inf p{
            margin: 0;
            padding: 0;
        }
      
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <table class="email-header">
            <tr>
                <!-- Left: Contact Info -->
                <td class="contact-info" style="text-align: left;">
                    <p>Hotline: <a href="tel:0377892859" style="color: #00b140; text-decoration: none;">0377 829 859</a></p>
                    <p>Website: <a href="https://www.facebook.com/anvanket1402" style="color: #00b140; text-decoration: none;" target="_blank">https://www.facebook.com/anvanket1402</a></p>
                </td>
                <!-- Right: Logo -->
                <td style="text-align: right;">
                    <img src="https://github.com/cotda/image/blob/main/logo%20(2).png?raw=true" alt="Merus Logo">
                </td>
            </tr>
        </table>

        <!-- Body Content -->
        <div class="email-inf">
            <h1>Test Drive Notice</h1>
            <p>Thank you for registering for a test drive with Merus.</p>
        </div>

        <!-- Table -->
        <table>
            <tr>
                <th>Customer Name</th>
                <td>{{ $data['customer_name'] }}</td>
            </tr>
            <tr>
                <th>Car Name</th>
                <td>{{ $data['car_type'] }} {{ $data['car_model'] }}</td>
            </tr>
            <tr>
                <th>Test Drive Date</th>
                <td>{{ $data['test_drive_date'] }}</td>
            </tr>
            <tr>
                <th>Other Request</th>
                <td>{{ $data['other_request'] }}</td>
            </tr>
        </table>

        <!-- Car Image -->
        <div class="car-image">
            <h2>Car You Have Chosen</h2>
            <img src="{{ $data['car_url'] }}" alt="Selected Car">
        </div>
        <!-- Footer -->
        <div class="email-footer">
            <div class="thank-you-message">
                <p style="font-weight: bold; color:#033e19">Thank you for registering for a test drive with Merus!</p>
                <p>We are excited to provide you with the best driving experience possible. If you have any questions or need assistance, feel free to contact us anytime.</p>
            </div>
        </div>
        
    </div>
</body>
</html>
