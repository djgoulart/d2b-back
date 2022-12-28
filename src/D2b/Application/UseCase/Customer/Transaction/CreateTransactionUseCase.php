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

        $persistedTransaction = $this->repository->insert($transaction);
        //dd($persistedTransaction);

        return new CreateTransactionOutputDto(
            id: $persistedTransaction->id,
            account: $persistedTransaction->user_account,
            description: $persistedTransaction->description,
            type: $persistedTransaction->type,
            amount: $persistedTransaction->amount,
            approved: $persistedTransaction->approved,
            needs_review: $persistedTransaction->needs_review,
            created_at: $persistedTransaction->createdAt(),
        );
    }
}
