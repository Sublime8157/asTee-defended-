<!DOCTYPE html>
<html>
<head>
    <title>Your Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
            background-color: #fff;
            overflow: hidden;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        /* Responsive layout */
        @media only screen and (max-width: 600px) {
            .invoice-box {
                padding: 10px;
            }
            .invoice-box table tr.top table td {
                padding-bottom: 10px;
            }
            .invoice-box table tr.information table td {
                padding-bottom: 20px;
            }
            .invoice-box table tr.item td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title flex">
                                <h2><img src="{{asset('images/logo.png')}}" alt="" style="width: 50px; height: 50px;"> AsTee</h2>
                            </td>
                            <td>
                                Order No: {{$invoiceData['orderNo']}}<br> 
                                Date: {{ $invoiceData['orderDate'] }} 
                            </td> 
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <p>Dear Customer,</p>
                                <p>This email serves as an invoice from A's Tee, displaying your order details below. To complete your order, kindly proceed with payment of the total amount using your preferred online payment method and email us the receipt for processing.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Product ID:</b> {{$invoiceData['processing']}} <br>
                                <b>User ID:</b> {{$invoiceData['userId']}} <br>
                                <b>Address:</b> {{$invoiceData['address']}} <br>
                                <b>Contact:</b> {{$invoiceData['contact']}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Method of Payment
                </td>
                <td>
                    {{$invoiceData['mop']}}  
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td style="font-size: 25px">
                   Total: {{$invoiceData['total']}} 
                </td>
            </tr>
             <tr>
                <td>GCASH <br> Number: 09154403873 <br> Name: Aira Mae Meran</td>
                <td>BPI <br> Number: 3809185108 <br> Name: Aira Mae Meran </td>
            </tr>
        </table>
    </div>
</body>
</html>
