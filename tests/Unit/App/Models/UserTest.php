<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use PHPUnit\Framework\TestCase;

class UserTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new User();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class,
            Notifiable::class,
            SoftDeletes::class
        ];
    }

    protected function fillables(): array
    {
        return [
            'id',
            'name',
            'email',
            'password',
            'roleId',
        ];
    }
    protected function hidden(): array
    {
        return [
            'password',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'deleted_at' => 'datetime',
        ];
    }

    protected function incrementing(): bool
    {
        return false;
    }

}
