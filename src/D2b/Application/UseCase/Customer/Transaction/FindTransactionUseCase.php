<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionOutputDto,
    FindTransactionByIdInputDto,
};

class FindTransactionUseCase
{
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FindTransactionByIdInputDto $input)
    {
        $transaction = $this->repository->findById(
            transactionId: $input->transactionId
        );

        $output = $this->toTransactionOutput($transaction);

        return $output;
    }

    public function toTransactionOutput($transaction) {
        return new CreateTransactionOutputDto(
            id: $transaction->id,
            account: $transaction->user_account,
            description: $transaction->description,
            type: $transaction->type,
            amount: $transaction->amount,
            approved: $transaction->approved,
            needs_review: $transaction->needs_review,
            created_at: $transaction->createdAt(),
        );
    }
}
