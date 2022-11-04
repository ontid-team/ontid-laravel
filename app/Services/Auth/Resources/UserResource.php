<?php

namespace App\Services\Auth\Resources;

use App\Services\Auth\Resources\Profile\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property $id
 * @property $type
 * @property $name
 * @property $email
 * @property $profile
 */
class UserResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'email' => $this->email,
            'profile' => ProfileResource::make($this->whenLoaded('profile'))
        ];
    }
}
