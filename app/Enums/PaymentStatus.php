<?php 

namespace App\Enums;

abstract class PaymentStatus {
    const PENDING = 'pending';
    const PAID = 'paid';
    const CANCELLED = 'cancelled';
}