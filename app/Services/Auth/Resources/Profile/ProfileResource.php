<?php

namespace App\Services\Auth\Resources\Profile;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Salon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    private $resources = [
        Salon::class => SalonResource::class,
        Customer::class => CustomerResource::class,
        Admin::class => AdminResource::class,
    ];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resources[get_class($this->resource)]::make($this->resource);
    }
}
