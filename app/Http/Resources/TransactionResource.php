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
    {   //dd($this);
        return [
            'id' => $this->id,
            'account' => AccountResource::make($this->account),
            'description' => $this->description,
            'type' => $this->type,
            'amount' => $this->amount,
            'appoved' => $this->approved,
            'needs_review' => $this->needs_review,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
