<?php 

namespace App\Helpers;

use App\Enums\PaymentMethod;

class PaymentDataBuilder {
    public static function build($data) {
        $transactionData = [
            'transaction_details' => [
                'order_id' => $data->id,
                'gross_amount' => $data->total_price
            ],
            'item_details' => [
                'id' => $data->event_id,
                'price' => $data->event->price,
                'quantity' => $data->amount,
                'name' => $data->event->name
            ],
            'customer_details' => [
                'first_name' => $data->user->name,
                'email' => $data->user->email,
            ]
        ];

        $paymentMethod = null;

        switch($data->payment_method) {
            case PaymentMethod::INDOMARET: 
                $paymentMethod = [
                    'payment_type' => 'cstore',
                    'cstore' => [
                        "store" => PaymentMethod::INDOMARET,
                        "message" => 'Payment created'
                    ]
                ];

                break;
            case PaymentMethod::ALFAMART: 
                $paymentMethod = [
                    'payment_type' => 'cstore',
                    'cstore' => [
                        "store" => PaymentMethod::ALFAMART,
                        "message" => 'Payment created',
                        "alfamart_free_text_1" => "1st row of receipt,",
                        "alfamart_free_text_2" => "This is the 2nd row,",
                        "alfamart_free_text_3" => "3rd row. The end."
                    ]
                ];
                break;
            case PaymentMethod::BRI: 
                $paymentMethod = [
                    'payment_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'bank' => PaymentMethod::BRI
                    ]
                ];
                break;

            case PaymentMethod::BCA:
                $paymentMethod = [
                    'payment_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'bank' => PaymentMethod::BCA
                    ]
                ];
                break;
            
            case PaymentMethod::BNI:
                $paymentMethod = [
                    'payment_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'bank' => PaymentMethod::BNI
                    ]
                ];
                break;
        }

        $paymentData = array_merge($transactionData, $paymentMethod);

        return $paymentData;
    }
}