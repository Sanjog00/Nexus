<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background: #11101d;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        h2 {
            color: #11101d;
            text-align: center;
            margin-bottom: 20px;
        }

        .verification-code {
            text-align: center;
            font-size: 32px;
            letter-spacing: 5px;
            color: #11101d;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="cid:logo.png" alt="Nexus Logo" class="logo">
        </div>
        <div class="content">
            <h2>Password Reset Verification</h2>
            <p style="text-align: center;">We received a request to reset your password. Use this verification code to complete the process:</p>
            <div class="verification-code">
                <strong><?= $verificationCode ?></strong>
            </div>
            <p style="text-align: center;">This code will expire in 10 minutes.</p>
        </div>
        <div class="footer">
            <p>If you didn't request this reset, please ignore this email.</p>
            <p>&copy; <?= date('Y') ?> Nexus. All rights reserved.</p>
        </div>
    </div>
</body>

</html>