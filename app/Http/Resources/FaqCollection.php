<?php

namespace App\Http\Resources;

use App\Enums\FaqType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FaqCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'business' => $this->collection->filter(function ($item) {
                return $item->type == FaqType::Business->value;
            })->toArray(),
            'customer' => $this->collection->filter(function ($item) {
                return $item->type == FaqType::Customer->value;
            })
        ];
    }
}
