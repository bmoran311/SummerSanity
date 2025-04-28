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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .screenshot {
            width: 100%;
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Let’s Coordinate Summer Plans – Join Me on Summer Sanity!</h2>
        
        <p>Hey (Friend),</p>
        
        <p>I just set up my summer schedule on <strong>Summer Sanity</strong>, and I’d love for you to join me! This app makes it super easy to organize and share summer camp schedules with friends, so we can coordinate plans and make sure our kids get to spend time together.</p>
        
        <p><strong>Here’s a snapshot of our tentative summer schedule:</strong></p>
        <img src="{{ $message->embed(storage_path('app/public/' . $screenshotPath)) }}" class="screenshot" alt="Camp Calendar">
        
        <p>With <strong>Summer Sanity</strong>, you can:</p>
        <ul style="text-align: left; display: inline-block;">
            <li>Plan and manage summer camps and activities in one place</li>
            <li>See which friends are attending the same camps</li>
            <li>Share and compare schedules with ease</li>
        </ul>
        
        <p>Click below to sign up and start planning your summer with me!</p>
        <a href="http://www.summersanity.com/register" class="btn">Join Summer Sanity</a>
        
        <p>Let’s make this summer stress-free and fun for the kids!</p>
        <p><strong>See you in the app,<br>Brian Moran</strong></p>
    </div>
</body>
</html>
