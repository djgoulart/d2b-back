<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Account extends Model
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
        'balance',
        'owner',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string>
     */
    protected $casts = [
        'id' => 'string',
        'balance' => 'integer',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
