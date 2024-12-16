<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            padding: 20px 10px;
        }
        .email-body {
            padding: 20px;
            text-align: center;
        }
        .email-footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
        }
        .verify-button {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            background-color: #007BFF;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .verify-button:hover {
            background-color: #0056b3;
        }
        .footer-link {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Welcome to Merus</h1>
            <p>Your Account Verification</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello,</h2>
            <p>Thank you for registering with us! To complete your registration, please click the button below to verify your email address:</p>
            <a href="{{ route('verify.email', ['token' => $token]) }}" class="verify-button">Verify Account</a>
            <p style="margin-top: 20px;">If you did not create this account, please ignore this email or contact our support team.</p>
            <p>Thank you,<br><strong>The Merus Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>If you need any help, contact us at <a href="mailto:support@merus.com" class="footer-link">support@merus.com</a></p>
            <p>&copy; 2024 Merus. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
