<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->formatPrice($this->price),
            'schedule' => $this->schedule,
            'location' => $this->location,
            'location_description' => $this->location_description,
            'rules' => $this->rules,
            'organization' => new OrganizationResource($this->organization),
        ];
    }

    public function formatPrice($value) 
    {
        return 'Rp. ' . number_format($value, 0, '', '.');
    }
}
