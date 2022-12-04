<?php

namespace Tests\Feature\D2b\Application\Customer\User;

use App\Models\User as Model;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use D2b\Application\Dto\Customer\User\CreateUserInputDto;
use D2b\Application\Dto\Customer\User\CreateUserOutputDto;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use Tests\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    public function test_it_should_persist_a_user()
    {
        $model = new Model();
        $roleId = 1;

        $sut = new CreateUserUseCase(new UserRepositoryEloquent($model));

        $input = new CreateUserInputDto(
            password: '123456',
            roleId: $roleId,
            email: 'email@test.com',
            name: 'test user'
        );

        $response = $sut->execute($input);

        $this->assertInstanceOf(CreateUserOutputDto::class, $response);
        $this->assertDatabaseHas('users', [
            'id' => $response->id,
            'name' => $response->name,
            'email' => $response->email,
            'roleId' => $response->roleId,
        ]);
    }
}
