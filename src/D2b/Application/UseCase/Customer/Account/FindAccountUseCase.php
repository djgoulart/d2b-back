<?php

namespace D2b\Application\UseCase\Customer\Account;

use D2b\Domain\Customer\Entities\Account;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Application\Dto\Customer\Account\FindAccountInputDto;
use D2b\Application\Dto\Customer\Account\FindAccountOutputDto;
use D2b\Application\Dto\Customer\User\UserOutputDto;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;

class FindAccountUseCase {
    protected $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FindAccountInputDto $input): FindAccountOutputDto
    {
        $account = $this->repository->findById($input->accountId);

        $user = new UserOutputDto(
            id: $account->user->id(),
            roleId: $account->user->roleId,
            email: $account->user->email,
            name: $account->user->name,
            created_at: $account->user->createdAt()
        );

        return new FindAccountOutputDto(
            id: $account->id(),
            user: $user,
            balance: $account->balance,
            createdAt: $account->createdAt(),
        );

    }
}
