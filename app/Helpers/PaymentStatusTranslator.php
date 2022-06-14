<?php 

namespace App\Helpers;

use App\Enums\PaymentStatus;

class PaymentStatusTranslator {
    public static function translate($status) {
        switch($status) {
            case 'capture':
                return PaymentStatus::PAID;
            case 'settlement':
                return PaymentStatus::PAID;
            case 'pending':
                return PaymentStatus::PENDING;
            case 'deny':
                return PaymentStatus::CANCELLED;
            case 'cancel':
                return PaymentStatus::CANCELLED;
            case 'expire':
                return PaymentStatus::CANCELLED;
        }
    }
}