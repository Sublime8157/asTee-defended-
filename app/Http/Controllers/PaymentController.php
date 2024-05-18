<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $client = new Client();
        $response = $client->post('https://pg-sandbox.paymaya.com/checkout/v1/checkouts', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('YOUR_PUBLIC_KEY:YOUR_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'totalAmount' => [
                    'value' => 100,
                    'currency' => 'PHP'
                ],
                'buyer' => [
                    'contact' => [
                        'email' => 'johndoe@gmail.com'
                    ],
                    'firstName' => 'john',
                    'lastName' => 'doe'
                ],
                'redirectUrl' => [
                    'success' => route('confirmCheckout'),
                    // 'failure' => route('checkout.failure'),
                    // 'cancel' => route('checkout.cancel'),
                ],
                'requestReferenceNumber' => uniqid(),
            ],
        ]);

        $body = json_decode($response->getBody(), true);

        return redirect($body['redirectUrl']);
    }

    public function success(Request $request)
    {
        // Handle successful payment
        return redirect()->route('confirmCheckout');
    }

    public function failure(Request $request)
    {
        // Handle failed payment
        return view('checkout.failure');
    }

    public function cancel(Request $request)
    {
        // Handle canceled payment
        return view('checkout.cancel');
    }
}
