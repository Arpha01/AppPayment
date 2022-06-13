<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'amount' => $this->amount,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'expired_at' => Carbon::parse($this->expired_at)->format('d-m-Y H:i'),
            'event' => new EventResource($this->event),
        ];
    }
}
