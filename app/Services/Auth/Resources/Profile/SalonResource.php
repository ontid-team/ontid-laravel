<?php

namespace App\Services\Auth\Resources\Profile;

use App\Http\Resources\ImageResource;
use App\Http\Resources\PhoneResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TimeResource;
use App\Models\Salon;
use Illuminate\Http\Resources\Json\JsonResource;

class SalonResource extends JsonResource
{

    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_URL = 'url';
    const FIELD_REVIEWS = 'reviews';
    const FIELD_IS_CONFIRMED = 'is_confirmed';
    const FIELD_IS_FAVORITE = 'is_favorite';
    const FIELD_ABOUT = 'about';
    const FIELD_EMAIL = 'email';
    const FIELD_LOGO = 'logo';
    const FIELD_ADDRESS = 'address';
    const FIELD_TIMES = 'times';
    const FIELD_SERVICES = 'services';
    const FIELD_PHONES = 'phones';
    const FIELD_IMAGES = 'images';

    /**
     * Transform the resource into an array.
     *
     * @param Salon $this
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $count = $this->reviews()->count();
        return [
            'id' => $this->id,
            'name' => $this->name,
            self::FIELD_URL => $this->url,
            self::FIELD_REVIEWS => [
                 'rating' => $count > 0 ? (float) bcdiv($this->rating, $count, 1) : 0,
                 'count' => $count,
                 'data' => ReviewResource::collection($this->whenLoaded('reviews')),
            ],
            self::FIELD_IS_CONFIRMED => false,
            self::FIELD_IS_FAVORITE => $this->is_favorite,
            self::FIELD_ABOUT => $this->about,
            self::FIELD_EMAIL => $this->email,
            self::FIELD_LOGO => ImageResource::make($this->logo),
            self::FIELD_ADDRESS => $this->address,
            self::FIELD_TIMES => TimeResource::collection($this->whenLoaded('times')),
            self::FIELD_SERVICES => ServiceResource::collection($this->whenLoaded('services')),
            self::FIELD_PHONES => PhoneResource::collection($this->whenLoaded('phones')),
            self::FIELD_IMAGES => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}

