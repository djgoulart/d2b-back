<?php

namespace Tests\Unit\D2b\Application\Customer\Account;

use D2b\Application\Dto\Customer\Account\IncrementBalanceInputDto;
use D2b\Application\Dto\Customer\Account\IncrementBalanceOutputDto;
use D2b\Application\UseCase\Customer\Account\IncrementBalanceUseCase;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Tests\TestCase;

class IncrementBalanceUseCaseTest extends TestCase
{
    public function test_it_should_increment_an_account_balance()
    {
        $userId = Uuid::uuid4()->toString();
        $name = 'User Test';
        $email = 'user@test.com';
        $password = 'user_password';
        $roleId = 10;

        $id = Uuid::uuid4()->toString();
        $owner = $userId;

        $value = 100;

        $this->mockUser = Mockery::mock(User::class, [
            $password, $roleId, $userId, $email, $name
        ]);

        $this->mockEntity = Mockery::mock(Account::class, [
            $owner, $id,
        ]);

        $this->mockInputDto = Mockery::mock(IncrementBalanceInputDto::class, [
            $this->mockEntity,
            $value
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $this->mockEntity->shouldReceive('increaseBalance');

        $this->mockRepo = Mockery::mock(stdClass::class, AccountRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->times(1)->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->times(1)->andReturn($this->mockEntity);

        $useCase = new IncrementBalanceUseCase($this->mockRepo);
        $result = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(IncrementBalanceOutputDto::class, $result);

        Mockery::close();
    }
}
