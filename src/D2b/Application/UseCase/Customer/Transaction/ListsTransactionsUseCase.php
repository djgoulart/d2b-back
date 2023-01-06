<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\AccountOutputDto;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionOutputDto,
    ListTransactionsInputDto,
    TransactionOutputDto,
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

        $output = [];
        foreach($persistedTransactions as $transaction) {
            array_push($output, $this->toTransactionOutput($transaction));
        }

        return $output;
    }

    public function toTransactionOutput($transaction) {
        $account = new AccountOutputDto(
            id: $transaction->user_account->id(),
            owner: $transaction->user_account->owner(),
            balance: $transaction->user_account->balance,
            created_at: $transaction->user_account->createdAt()
        );

        return new CreateTransactionOutputDto(
            id: $transaction->id,
            account: $account,
            description: $transaction->description,
            type: $transaction->type,
            amount: $transaction->amount,
            approved: $transaction->approved,
            needs_review: $transaction->needs_review,
            created_at: $transaction->createdAt(),
        );
    }
}
