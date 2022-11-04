<?php

namespace App\Http\Resources;

use App\Services\Auth\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'from' => $this->from,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'client' => UserResource::make($this->whenLoaded('client')),
            'contact' => AppointmentContactResource::make($this->whenLoaded('contact')),
            'staff' => StaffResource::make($this->whenLoaded('staff')),
            'service' => ServiceResource::make($this->whenLoaded('service')),
        ];
    }
}
