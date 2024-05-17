<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f0f4f8;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="padding: 20px 0; text-align: center;">
                <h1 style="font-weight: bold; color: #1a365d; font-size: 1.25rem; margin: 0;">AsTee</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                <h2 style="font-weight: bold; color: #1a365d; font-size: 1rem; margin-bottom: 10px;">Hello</h2>
                <p style="margin: 0;">You are receiving this email because we received a password reset request for your account.</p>
                <p style="margin: 20px 0 10px 0;"><a href="{{$url}}" style="cursor: pointer; text-decoration: none; color: #ffffff;"><button style="padding: 10px 20px; font-size: 0.875rem; color: #ffffff; background-color: #1c3d5a; border: none; border-radius: 4px; cursor: pointer;">Reset Password</button></a></p>
                <p style="margin: 10px 0 0 0;">This password reset link will expire in 60 minutes.</p>
                <p style="margin: 10px 0 0 0;">If you did not request a password reset, no further action is required.</p>
                <p style="margin: 20px 0 0 0;">Regards,<br>AsTee</p>
            </td>
        </tr>   
        <tr>
            <td style="padding: 20px;">
                <hr style="border: none; border-top: 1px solid #cbd5e0;">
                <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
                <p>{{$url}}</p>
            </td>
        </tr>
    </table>
</body>
</html>
