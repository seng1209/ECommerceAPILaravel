<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            padding: 10px;
            border: 2px dashed #007bff;
            display: inline-block;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Verification Code</h2>
    <p>Use the following code to verify your account:</p>
    <div class="code">{{ $code }}</div>
    <p>If you did not request this, please ignore this email.</p>
    <div class="footer">Thank you for using our service!</div>
</div>
</body>
</html>
