<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'id',
        'account_id',
        'description',
        'amount',
        'type',
        'approved',
        'needs_review',
        'receipt_url',
    ];
    protected $with =["account"];

    public function account() {
        return $this->belongsTo(Account::class);
    }
}
