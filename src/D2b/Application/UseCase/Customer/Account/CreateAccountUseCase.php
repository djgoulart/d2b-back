<?php

namespace D2b\Application\UseCase\Customer\Account;

use D2b\Domain\Customer\Entities\Account;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;

class CreateAccountUseCase {
    protected $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateAccountInputDto $input): CreateAccountOutputDto
    {

        $account = new Account(
            owner: $input->owner,
            balance: (int) 0,
        );

        $persistedAccount = $this->repository->insert($account);

        return new CreateAccountOutputDto(
            id: $persistedAccount->id,
            owner: $persistedAccount->owner,
            balance: $persistedAccount->balance,
            created_at: $persistedAccount->createdAt(),
        );

    }
}
