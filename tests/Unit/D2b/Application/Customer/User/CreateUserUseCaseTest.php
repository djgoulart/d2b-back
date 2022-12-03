<?php

namespace Tests\Unit\D2b\Application\Customer\User;

use D2b\Application\Dto\Customer\User\CreateUserInputDto;
use D2b\Application\Dto\Customer\User\CreateUserOutputDto;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;
use Tests\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    public function test_it_should_create_a_new_user()
    {
        $id = Uuid::uuid4()->toString();
        $name = 'User Test';
        $email = 'user@test.com';
        $password = 'user_password';
        $roleId = 10;

        $this->mockEntity = Mockery::mock(User::class, [
            $password, $roleId, $id, $email, $name
        ]);

        $this->mockInputDto = Mockery::mock(CreateUserInputDto::class, [
            $password, $roleId, $email, $name
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, UserRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateUserUseCase($this->mockRepo);
        $result = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CreateUserOutputDto::class, $result);
        $this->assertEquals($id, $result->id);
        $this->assertEquals($name, $result->name);
        $this->assertEquals($email, $result->email);
        $this->assertEquals($roleId, $result->roleId);

        /**
         * Spies
         */
        $this->spyRepo = Mockery::spy(stdClass::class, UserRepositoryInterface::class);
        $this->spyRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $useCase = new CreateUserUseCase($this->spyRepo);
        $result = $useCase->execute($this->mockInputDto);

        $this->spyRepo->shouldHaveReceived('insert');

        Mockery::close();
    }
}
