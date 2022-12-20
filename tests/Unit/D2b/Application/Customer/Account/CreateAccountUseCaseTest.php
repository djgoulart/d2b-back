<?php

namespace Tests\Unit\D2b\Application\Customer\Account;

use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Tests\TestCase;

class CreateAccountUseCaseTest extends TestCase
{
    public function test_it_should_create_a_new_account()
    {
        $userId = Uuid::uuid4()->toString();
        $name = 'User Test';
        $email = 'user@test.com';
        $password = 'user_password';
        $roleId = 10;

        $id = Uuid::uuid4()->toString();
        $owner = $userId;

        $this->mockUser = Mockery::mock(User::class, [
            $password, $roleId, $userId, $email, $name
        ]);

        $this->mockEntity = Mockery::mock(Account::class, [
            $owner, $id,
        ]);

        $this->mockInputDto = Mockery::mock(CreateAccountInputDto::class, [
            $owner
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, AccountRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->times(1)->andReturn($this->mockEntity);

        $useCase = new CreateAccountUseCase($this->mockRepo);
        $result = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CreateAccountOutputDto::class, $result);
        $this->assertEquals($owner, $result->owner);

        Mockery::close();
    }
}
