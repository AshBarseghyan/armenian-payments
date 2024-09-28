<?php

namespace Abn\ArmenianPayments;

class ArmenianPayments
{

    public $amount;
    public $currency;
    public $payment_method;

    public function __construct($amount, $currency, $payment_method)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->payment_method = $payment_method;
    }


    public function makePayment()
    {
        switch ($this->payment_method) {
            case 'ameria':
                $ameria = new Payments\Ameria();
                return $ameria->createPayment($this->amount, $this->currency);
            default:
                return [
                    'status' => 'error',
                    'message' => 'Payment method not found'
                ];
        }
    }
}
