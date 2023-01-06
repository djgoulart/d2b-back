<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FindTransactionResource extends JsonResource
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
            'account' => [
                'id' => $this->account->id,
                'user' => [
                    'id' => $this->account->user->id,
                    'name' => $this->account->user->name,
                    'email' => $this->account->user->email,
                    'roleId' => $this->account->user->roleId,
                    'created_at' => Carbon::make($this->account->user->created_at)->format('Y-m-d H:i:s'),
                ],
                'balance' => (int) $this->account->balance,
                'created_at' => Carbon::make($this->account->createdAt)->format('Y-m-d H:i:s'),
            ],
            'description' => $this->description,
            'type' => $this->type,
            'amount' => $this->amount,
            'approved' => $this->approved,
            'needs_review' => $this->needs_review,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
