<?php

namespace D2b\Application\UseCase\Customer\User;

use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use D2b\Application\Dto\Customer\User\{
    CreateUserInputDto,
    CreateUserOutputDto,
};

class CreateUserUseCase
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateUserInputDto $input): CreateUserOutputDto
    {
        $user = new User(
            name: $input->name,
            email: $input->email,
            password: $input->password,
            roleId: $input->roleId,
        );

        $persistedUser = $this->repository->insert($user);

        return new CreateUserOutputDto(
            id: $persistedUser->id,
            name: $persistedUser->name,
            email: $persistedUser->email,
            roleId: $persistedUser->roleId,
            created_at: $persistedUser->createdAt(),
        );
    }
}
