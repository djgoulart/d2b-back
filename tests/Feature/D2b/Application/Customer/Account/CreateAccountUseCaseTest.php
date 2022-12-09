<?php

namespace Tests\Feature\D2b\Application\Customer\Account;

use App\Models\Account as Model;
use App\Models\User as UserModel;
use App\Repositories\Eloquent\AccountRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Application\Dto\Customer\User\CreateUserInputDto;
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use Tests\TestCase;

class CreateAccountUseCaseTest extends TestCase
{
    public function test_it_should_persist_an_Account()
    {
        $model = new Model();
        $userModel = new UserModel();

        $userInput = new CreateUserInputDto(
            password: '123456',
            roleId: 1,
            email: 'email@test.com',
            name: 'test user'
        );

        $createUser = new CreateUserUseCase(new UserRepositoryEloquent($userModel));
        $user = $createUser->execute($userInput);

        $sutInput = new CreateAccountInputDto(
            owner: $user->id,
        );

        $sut = new CreateAccountUseCase(new AccountRepositoryEloquent($model));


        $response = $sut->execute($sutInput);

        $this->assertInstanceOf(CreateAccountOutputDto::class, $response);
        $this->assertDatabaseHas('accounts', [
            'id' => $response->id,
            'owner' => $response->owner,
            'balance' => $response->balance,
        ]);
        $this->assertEquals($response->balance, 0);
    }
}
