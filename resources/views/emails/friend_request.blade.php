<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Let’s Be Friends on Summer Sanity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h3 {
            color: #333;
            font-size: 22px;
            margin-bottom: 20px;
        }
        p {
            color: #555;
            line-height: 1.6;
            margin: 10px 0;
        }
        .bold {
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            margin-top: 25px;
        }
        .email-footer {
            margin-top: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Hey! I saw you’re on Summer Sanity too...</h3>

        <p>Want to be friends and swap calendars?</p>
        <p>
            I’ve been using <span class="bold">Summer Sanity</span> to map out our camp plans, and thought it'd be great to connect.
        </p>
        <p>
            If we’re friends, we can share calendars and steal inspiration from each other’s summer setups—makes the whole planning thing way easier.
        </p>
        <p class="bold">Click below if you're in:</p>

        <a href="{{ $acceptUrl }}" class="btn">Yep, Let’s Be Friends</a>

        <div class="email-footer">
            <p>Excited to compare calendars!</p>
            <p class="bold">{{ $fromGuardian->first_name }} {{ $fromGuardian->last_name }}</p>
        </div>
    </div>
</body>
</html>
