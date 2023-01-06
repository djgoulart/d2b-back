<?php

namespace D2b\Application\UseCase\Customer\Account;

use D2b\Application\Dto\Customer\Account\DecrementBalanceInputDto;
use D2b\Application\Dto\Customer\Account\DecrementBalanceOutputDto;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;

class DecrementBalanceUseCase {
    protected $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DecrementBalanceInputDto $input): DecrementBalanceOutputDto
    {
        $account = $this->repository->findById($input->account);

        $decrement = $account->decreaseBalance($input->value);

        if($decrement) {
            $result = $this->repository->update(account:  $account);
            return new DecrementBalanceOutputDto(
                id: $result->id,
                owner: $result->owner,
                balance: $result->balance,
                created_at: $result->createdAt(),
            );
        }

        return false;

    }
}
