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
            'account' => $this->account,
            'description' => $this->description,
            'type' => $this->type,
            'value' => $this->value,
            'status' => $this->status,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
