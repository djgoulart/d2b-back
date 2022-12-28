<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionOutputDto,
    ListTransactionsInputDto,
};

class ListsTransactionsUseCase
{
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListTransactionsInputDto $input)
    {
        $persistedTransactions = $this->repository->list(
            account: $input->account ? $input->account : null,
            type: $input->type ? $input->type : null,
            approved: $input->approved ? $input->approved : null,
            needs_review: $input->needs_review ? $input->needs_review : null,
        );

        $outputArray = array_map('toTransactionOutput', $persistedTransactions);

        return $outputArray;
    }

    public function toTransactionOutput($transaction) {
        return new CreateTransactionOutputDto(
            id: $transaction->id,
            account: $transaction->account,
            description: $transaction->description,
            type: $transaction->type,
            amount: $transaction->amount,
            approved: $transaction->approved,
            needs_review: $transaction->needs_review,
            created_at: $transaction->createdAt(),
        );
    }
}
