<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['event_id', 'payment_method'];

    public function event() 
    {
        return $this->belongsTo(Event::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGenerateOrderId($query, $eventID) 
    {
        $lastOrder = $query->count()+1;

        return "order-{$lastOrder}-{$eventID}-".Carbon::now()->timestamp;
    } 
    
}
