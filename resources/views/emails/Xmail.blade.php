<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background: #007BFF;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 20px;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        Welcome, {{ $details['name'] }}!
    </div>

    <div class="content">
        <p>Dear {{ $details['name'] }},</p>
        <p>We are excited to welcome you to our platform. Below are your login details:</p>
        <p><strong>Email:</strong> {{ $details['email'] }}</p>
        <p><strong>Password:</strong> {{ $details['password'] }}</p>
        <p><strong>Student ID:</strong> {{ $details['students_id'] }}</p>

        <p>If you have any questions, feel free to contact our support team.</p>

        <p>Best Regards,<br> The Team</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Your Website | All Rights Reserved
    </div>
</div>

</body>
</html>
