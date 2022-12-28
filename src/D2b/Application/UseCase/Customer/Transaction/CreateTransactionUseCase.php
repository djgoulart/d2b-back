<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionInputDto,
    CreateTransactionOutputDto,
};

class CreateTransactionUseCase
{
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateTransactionInputDto $input): CreateTransactionOutputDto
    {
        $transaction = new Transaction(
            account: $input->account,
            description: $input->description,
            type: $input->type,
            amount: (int) $input->amount,
            approved: $input->approved,
            needs_review: $input->needs_review,
        );

        $persistedDeposit = $this->repository->insert($transaction);

        return new CreateTransactionOutputDto(
            id: $persistedDeposit->id,
            account: $persistedDeposit->account,
            description: $persistedDeposit->description,
            type: $persistedDeposit->type,
            amount: $persistedDeposit->amount,
            approved: $persistedDeposit->approved,
            needs_review: $persistedDeposit->needs_review,
            created_at: $persistedDeposit->createdAt(),
        );
    }
}
