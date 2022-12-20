<?php

namespace Tests\Unit\D2b\Application\Customer\Account;

use D2b\Application\Dto\Customer\Account\DecrementBalanceInputDto;
use D2b\Application\Dto\Customer\Account\DecrementBalanceOutputDto;
use D2b\Application\UseCase\Customer\Account\DecrementBalanceUseCase;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Tests\TestCase;

class DecrementBalanceUseCaseTest extends TestCase
{
    public function test_it_should_decrement_an_account_balance()
    {
        $userId = Uuid::uuid4()->toString();
        $name = 'User Test';
        $email = 'user@test.com';
        $password = 'user_password';
        $roleId = 10;

        $id = Uuid::uuid4()->toString();
        $owner = $userId;

        $balance = 100;
        $value = 90;

        $this->mockUser = Mockery::mock(User::class, [
            $password, $roleId, $userId, $email, $name
        ]);

        $this->mockEntity = Mockery::mock(Account::class, [
            $owner, $id, $balance
        ]);

        $this->mockInputDto = Mockery::mock(DecrementBalanceInputDto::class, [
            $this->mockEntity,
            $value
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('decreaseBalance');

        $this->mockRepo = Mockery::mock(stdClass::class, AccountRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->times(1)->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->times(1)->andReturn($this->mockEntity);

        $useCase = new DecrementBalanceUseCase($this->mockRepo);
        $result = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(DecrementBalanceOutputDto::class, $result);

        Mockery::close();
    }
}
