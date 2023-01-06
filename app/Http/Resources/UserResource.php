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
        $user = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roleId' => $this->roleId,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];

        return $user;
    }
}
