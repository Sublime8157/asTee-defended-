<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      padding: 20px 0;
    }
    .header img {
      width: 100px;
    }
    .content {
      padding: 20px;
      text-align: center;
    }
    .content h1 {
      color: #333333;
      font-size: 24px;
      margin: 0 0 20px;
    }
    .content p {
      color: #666666;
      line-height: 1.5;
      font-size: 16px;
      margin: 0 0 20px;
    }
    .button {
      display: inline-block;
      padding: 15px 25px;
      font-size: 18px;
      color: #ffffff;
      background-color: #28a745;
      text-decoration: none;
      border-radius: 5px;
      margin: 20px 0;
    }
    .footer {
      text-align: center;
      padding: 20px;
      color: #aaaaaa;
      font-size: 12px;
    }

    /* Responsive styles */
    @media screen and (max-width: 600px) {
      .content h1 {
        font-size: 20px;
      }
      .content p {
        font-size: 14px;
      }
      .button {
        padding: 10px 20px;
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="{{asset('images/logo.png')}}" alt="Company Logo">
    </div>
    <div class="content">
      <h1>New Registration Attempt Detected</h1>
      <p>Hello Admin,</p>
      <p>A new account has tried to register to the system. Please confirm if you are aware of this registration attempt by clicking the button below.</p>
      <a href="{{route('verifyAdminRegistration', ['email' => $email])}}" class="button">Verify Registration</a>
      <p>If you did not authorize this registration attempt, please ignore this email or take necessary actions to secure the account.</p>
    </div>
    <div class="footer">
      <p>&copy; {{date('Y')}} A'sTee. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
