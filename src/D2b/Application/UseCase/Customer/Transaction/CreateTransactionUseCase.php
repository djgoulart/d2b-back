<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\AccountOutputDto;
use D2b\Application\Dto\Customer\Account\DecrementBalanceInputDto;
use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionInputDto,
    CreateTransactionOutputDto,
};
use D2b\Application\UseCase\Customer\Account\DecrementBalanceUseCase;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;

class CreateTransactionUseCase
{
    protected $repository;
    protected $accountRepository;

    public function __construct(
        TransactionRepositoryInterface $repository,
        AccountRepositoryInterface $accountRepository
    )
    {
        $this->repository = $repository;
        $this->accountRepository = $accountRepository;
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

        $account = new AccountOutputDto(
            id: $persistedTransaction->user_account->id(),
            owner: $persistedTransaction->user_account->owner(),
            balance: $persistedTransaction->user_account->balance,
            created_at: $persistedTransaction->user_account->createdAt()
        );

        return new CreateTransactionOutputDto(
            id: $persistedTransaction->id,
            account: $account,
            description: $persistedTransaction->description,
            type: $persistedTransaction->type,
            amount: $persistedTransaction->amount,
            approved: $persistedTransaction->approved,
            needs_review: $persistedTransaction->needs_review,
            created_at: $persistedTransaction->createdAt(),
        );
    }
}
