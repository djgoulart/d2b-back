<?php

namespace D2b\Application\UseCase\Customer\User;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
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
            password: $input->password,
            roleId: $input->roleId,
            email: $input->email,
            name: $input->name,
            account: '',
        );

        $persistedUser = $this->repository->insert($user);

        return new CreateUserOutputDto(
            id: $persistedUser->id,
            name: $persistedUser->name,
            email: $persistedUser->email,
            roleId: $persistedUser->roleId,
            account: $persistedUser->account ? $persistedUser->account->id : '',
            created_at: $persistedUser->createdAt(),
        );
    }
}
