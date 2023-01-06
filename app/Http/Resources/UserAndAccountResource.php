<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAndAccountResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'roleId' => $this->user->roleId,
                'account' => [
                    'id' => $this->account->id,
                    'balance' => (int)$this->account->balance,
                    'created_at' => Carbon::make($this->account->createdAt)->format('Y-m-d H:i:s'),
                ],
                'created_at' => Carbon::make($this->user->created_at)->format('Y-m-d H:i:s'),
            ]
        ];
    }
}
