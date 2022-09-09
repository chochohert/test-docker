<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "id" => $this->id,
            "status" => empty($this->status) ? "processed" : $this->status,
            "totalPrice" => $this->total_price,
            "confirmedAt" => empty($this->confirmed_at) ? "" : Carbon::parse($this->confirmed_at)->toDateTimeString(),
            "refundedAt" => empty($this->refunded_at) ? "" : Carbon::parse($this->refunded_at)->toDateTimeString(),
            "createdAt" => Carbon::parse($this->created_at)->toDateTimeString(),
            "orderGoods" => OrderGoodsResource::collection($this->orderGoods),
        ];
    }
}
