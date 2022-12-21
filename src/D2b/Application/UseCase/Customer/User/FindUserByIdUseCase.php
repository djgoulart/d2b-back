<?php

namespace D2b\Application\UseCase\Customer\User;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use D2b\Application\Dto\Customer\User\{
    CreateUserAndAccountOutputDto,
    CreateUserInputDto,
    CreateUserOutputDto,
};

class FindUserByIdUseCase
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $input): CreateUserOutputDto
    {
        $user = $this->repository->findById($input);

        return new CreateUserOutputDto(
            id: $user->id,
            roleId: $user->roleId,
            email: $user->email,
            name: $user->name,
            account: $user->account,
            created_at: $user->createdAt(),
        );
    }
}
