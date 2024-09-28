<?php

namespace Abn\ArmenianPayments\Payments;

use App\Models\AbnArmenianPayments;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Ameria
{

    public $payment_method_slug = 'ameria';

    public function __construct()
    {
        //
    }

    public function createPayment($amount, $currency)
    {
        if (!is_numeric($amount) || $amount <= 0) {
            return [
                'status' => 'error',
                'message' => 'Invalid amount. Amount should be numeric and greater than 0.'
            ];
        }

        if (!in_array($currency, ['AMD', 'EUR', 'USD', 'RUB'])) {
            return [
                'status' => 'error',
                'message' => 'Invalid currency. Currency should be one of the following: AMD, EUR, USD, RUB.'
            ];
        }

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

        $order = AbnArmenianPayments::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_method' => $this->payment_method_slug,
        ]);

        $data = [
            'ClientID' => env('AMERIA_CLIENT_ID'),
            'Username' => env('AMERIA_USERNAME'),
            'Password' => env('AMERIA_PASSWORD'),
            'Currency' => $currency,
            'Description' => 'Visa,Mastercard,ArCA',
            'OrderID' => $order->id,
            'Amount' => $amount,
            'BackURL' => route('abn-armenian-payments.ameria.callback'),
        ];

        try {
            // Send POST request with headers and timeout
            $req = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://services.ameriabank.am/VPOS/api/VPOS/InitPayment', $data);

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

                $order->status = 'pending';
                $order->save();

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

    public function callback(Request $request)
    {
        $error = false;

        $order = AbnArmenianPayments::findOrFail($request->orderID);

        if ($request->paymentID) {
            $req = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://services.ameriabank.am/VPOS/api/VPOS/GetPaymentDetails', [

                "PaymentID" => $request->paymentID,
                "Username" => env("AMERIA_USERNAME"),
                "Password" => env("AMERIA_PASSWORD"),
            ]);
            $response = $req->json();
            $order->payment_details = json_encode($response);
            switch ($response->resposneCode) {
                case '00':
                    $order->status = 'success';
                    break;
                default:
                    $error = true;
                    $order->status = 'failed';
            }
            $order->save();

            if ($error) {
                return redirect()->route('abn-armenian-payments.success');
            } else {
                return redirect()->route('abn-armenian-payments.fail');
            }
        }

        $order->status = 'failed';
        $order->save();

        return redirect()->route('abn-armenian-payments.fail');
    }
}