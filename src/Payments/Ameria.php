<?php

namespace Abn\ArmenianPayments\Payments;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Ameria
{
    public function __construct()
    {
        //
    }

    public function createPayment()
    {

        //check env variables
        if (!env('AMERIA_CLIENT_ID')) {
            return [
                'status' => 'error',
                'message' => 'AMERIA_CLIENT_ID in .env is not set. Please set it.'
            ];
        }
        if (!env('AMERIA_USERNAME')) {
            return [
                'status' => 'error',
                'message' => 'AMERIA_USERNAME in .env is not set. Please set it.'
            ];
        }
        if (!env('AMERIA_PASSWORD')) {
            return [
                'status' => 'error',
                'message' => 'AMERIA_PASSWORD in .env is not set. Please set it.'
            ];
        }

        $data = [
            'ClientID' => env('AMERIA_CLIENT_ID'),
            'Username' => env('AMERIA_USERNAME'),
            'Password' => env('AMERIA_PASSWORD'),
            'Currency' => 'AMD',
            'Description' => 'Visa,Mastercard,ArCA',
            'OrderID' => 1, #TODO: add OrderID
            'Amount' => 100, #TODO: add Amount
            'BackURL' => '', #TODO: add BackURL
            'Opaque' => '' #TODO: add Opaque
        ];

        try {
            // Send POST request with headers and timeout
            $req = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(10) // Set a 10-second timeout
            ->retry(3, 200) // Retry 3 times with a 200ms delay between attempts
            ->post('https://services.ameriabank.am/VPOS/api/VPOS/InitPayment', $data);

            // Check for request failure
            if ($req->failed()) {
                Log::error('Payment request failed', [
                    'status' => $req->status(),
                    'body' => $req->body(),
                ]);

                return [
                    'status' => 'error',
                    'message' => 'Failed to create payment. Server returned: ' . $req->status(),
                ];
            }

            // Get the JSON response
            $response = $req->json();

            // Handle response based on 'ResponseCode'
            if (isset($response['ResponseCode']) && $response['ResponseCode'] === 1) {
                return [
                    'status' => 'success',
                    'redirect_url' => "https://services.ameriabank.am/VPOS/Payments/Pay?id={$response['PaymentID']}&lang=en",
                ];
            } else {
                Log::error('Payment initialization failed', [
                    'response' => $response,
                ]);

                return [
                    'status' => 'error',
                    'message' => 'Payment initialization failed. Error: ' . ($response['Description'] ?? 'Unknown error'),
                ];
            }
        } catch (Exception $e) {
            // Handle any exceptions during the request
            Log::error('Exception during payment initialization', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 'error',
                'message' => 'An error occurred while processing the payment: ' . $e->getMessage(),
            ];
        }
    }
}