<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }
        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Summer Sanity – Just One Quick Step!</h2>
        <p>Hi there,</p>
        <p>
            You're almost ready to start planning a simpler, more connected summer. <br>
            Just click the button below to confirm your email and activate your account.
        </p>
        <a class="btn" href="{{ $signedUrl }}">Confirm My Email</a>
        <p>If the button doesn't work, copy and paste this link into your browser:</p>
        <p><a href="{{ $signedUrl }}">{{ $signedUrl }}</a></p>
        <div class="footer">
            &copy; {{ date('Y') }} Summer Sanity. All rights reserved.
        </div>
    </div>
</body>
</html>
