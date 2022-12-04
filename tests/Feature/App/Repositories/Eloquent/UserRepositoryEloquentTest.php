<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\User as Model;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use D2b\Domain\Customer\Entities\User as UserEntity;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRepositoryEloquentTest extends TestCase
{
    protected $repository;

    protected function setup():void
    {
        parent::setUp();
        $this->repository = new UserRepositoryEloquent(new Model());
    }

    public function test_it_should_persist_an_user()
    {
        $userEntity = new UserEntity(
            password: '123456',
            roleId: 1,
            email: 'user@test.com',
            name: 'Test User',
        );


        $persistedUser = $this->repository->insert($userEntity);

        $this->assertInstanceOf(UserRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(UserEntity::class,  $persistedUser);
        $this->assertDatabaseHas('users', [
            'id' => $userEntity->id,
            'name' => $userEntity->name,
            'email' => $userEntity->email,
        ]);
    }
}
