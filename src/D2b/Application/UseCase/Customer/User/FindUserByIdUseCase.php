<?php

namespace D2b\Application\UseCase\Customer\User;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use D2b\Application\Dto\Customer\User\{
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
            name: $user->name,
            email: $user->email,
            roleId: $user->roleId,
            account: new CreateAccountOutputDto(
                id: $user->account->id,
                owner: $user->account->owner,
                balance: $user->account->balance,
                created_at: $user->account->createdAt(),
            ),
            created_at: $user->createdAt(),
        );
    }
}
