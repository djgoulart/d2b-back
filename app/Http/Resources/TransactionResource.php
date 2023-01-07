<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'description' => $this->description,
            'type' => $this->type,
            'amount' => $this->amount,
            'approved' => $this->approved,
            'needs_review' => $this->needs_review,
            'receipt_url' => $this->receipt_url ? Storage::temporaryUrl($this->receipt_url, now()->addMinutes(60)): '',
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
