<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   //dd($this);
        return [
            'id' => $this->id(),
            'owner' => UserResource::make($this->user),
            'balance' => $this->balance,
            'created_at' => Carbon::make($this->createdAt)->format('Y-m-d H:i:s'),
        ];
    }
}
