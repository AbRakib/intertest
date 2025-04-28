<!DOCTYPE html>
<html>
<head>
    <title>Account Credentials</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4a6ee0;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4a6ee0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .credentials-box p {
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            background-color: #4a6ee0;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            font-size: 12px;
            color: #777777;
        }
        .login-button-container {
            text-align: center;
            margin: 25px 0;
        }
        .security-note {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Welcome to {{ config('app.name') }}!</h1>
        </div>
        
        <div class="email-body">
            <p>Hello,</p>
            <p>Your account has been successfully created. Below are your login credentials:</p>
            
            <div class="credentials-box">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            
            <div class="security-note">
                <strong>Security Note:</strong> For your protection, please change your password after first login and do not share these credentials with anyone.
            </div>
            
            <div class="login-button-container">
                <a href="{{ route('login') }}" class="button">Login to Your Account</a>
            </div>
            
            <p>If you did not request this account, please contact our support team immediately.</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>
                <a href="javascript:void(0)" style="color: #4a6ee0; text-decoration: none;">Visit our website</a> | 
                <a href="javascript:void(0)" style="color: #4a6ee0; text-decoration: none;">Contact Support</a>
            </p>
        </div>
    </div>
</body>
</html>