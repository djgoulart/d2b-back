<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateDepositInputDto,
    CreateDepositOutputDto,
};

class CreateDepositUseCase
{
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateDepositInputDto $input): CreateDepositOutputDto
    {
        $deposit = new Transaction(
            account: $input->account,
            description: $input->description,
            type: $input->type,
            value: (int) $input->value,
            status: $input->status,
        );

        $persistedDeposit = $this->repository->insert($deposit);

        return new CreateDepositOutputDto(
            id: $persistedDeposit->id,
            account: $persistedDeposit->account,
            description: $persistedDeposit->description,
            type: $persistedDeposit->type,
            value: $persistedDeposit->value,
            status: $persistedDeposit->status,
            created_at: $persistedDeposit->createdAt(),
        );
    }
}
