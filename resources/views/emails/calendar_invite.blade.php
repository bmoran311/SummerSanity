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
    <h3 class="subject">Let’s Coordinate Summer Plans - Join Me on Summer Sanity!</h3>
    <div class="description">
        <p>Hello,</p>
        <p>
            I just joined this awesome parenting site called <span class="bold">Summer Sanity</span> to help plan my kid's summer schedule, and I think
            you'll love it too!
        </p>
        <p>It's completely free and makes it easy for parents like us to organize summer schedules and share plans with friends.</p>
        <p>
            Here’s the best part: if we connect our calendars, we can swap ideas for camps and activities and make sure the kids get plenty of time together
            this summer—it’s a win-win!
        </p>
        <p class="bold">Take a look at how easy it is to use:</p>
        <img src="https://staging.summersanity.com/assets/calendar.png" alt="Summer Calendar" />
        <p class="bold">Click below to join me and start planning:</p>
        <a href="{{ url('/') }}?inviter_id={{ Auth::guard('guardian')->id() }}&email={{ urlencode($email) }}#cta"><button class="btn btn--sm">Join Summer Sanity!</button></a>
        <div class="email-footer">
            <p>Can't wait to see what we come up with!</p>
            <p class="bold">Megan Petrik</p>
        </div>
    </div>
</body>
</html>
