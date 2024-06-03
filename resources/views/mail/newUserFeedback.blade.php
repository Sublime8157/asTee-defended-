<!DOCTYPE html>
<html>
<head>
    <title>New User Feedback Received</title>
    <style>
        /* Reset styles for a consistent baseline */
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse !important;
        }
        a {
            color: #1a82e2;
            text-decoration: none;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            .wrapper {
                width: 100% !important;
            }
            .responsive-table {
                width: 100% !important;
            }
            .padding {
                padding: 10px 5% 15px 5% !important;
            }
            .padding-meta {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#f7f7f7" align="center" style="padding: 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" class="wrapper" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.15);">
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px; text-align: center; background-color: #4CAF50;">
                            <h1 style="margin: 0; color: #ffffff;">New User Feedback Received</h1>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px;">
                          
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="responsive-table" style="border-collapse: collapse; margin: 20px 0;">
                                <tr>
                                    <td style="padding: 10px;"><strong></strong></td>
                                    <td style="padding: 10px; text-align: right;">{{ date('d-m-y') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        Dear Team, 
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; padding-top: 10px;">{{$validated['message']}} </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border:"></td>
                                    <td style="padding: 10px; padding-right: 10%; text-align: right; ">From:{{$validated['name']}} <br> {{$validated['email']}}</td>
                                </tr>
                            </table>
                            <p style="margin: 20px 0; font-size: 16px;">Please review the feedback and take necessary actions.</p>
                            <p style="margin: 0; font-size: 16px;">Thank you!</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#f7f7f7" style="padding: 10px 30px; text-align: center; color: #888888; font-size: 12px;">
                            &copy; {{ date('Y') }} A'sTee. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
