<?php

namespace D2b\Application\UseCase\Customer\Account;

use D2b\Domain\Customer\Entities\Account;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Application\Dto\Customer\Account\IncrementBalanceInputDto;
use D2b\Application\Dto\Customer\Account\IncrementBalanceOutputDto;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;

class IncrementBalanceUseCase {
    protected $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(IncrementBalanceInputDto $input): IncrementBalanceOutputDto
    {
        $result = $this->repository->incrementBalance(account: $input->account, amount: $input->value);

        return new IncrementBalanceOutputDto(
            id: $result->id,
            owner: $result->owner,
            balance: $result->balance,
            created_at: $result->createdAt(),
        );
    }
}
