<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id(),
            'name' => $this->name,
            'email' => $this->email,
            'roleId' => $this->roleId,
            'account' => $this->account,
            'created_at' => Carbon::make($this->createdAt)->format('Y-m-d H:i:s'),
        ];
    }
}
