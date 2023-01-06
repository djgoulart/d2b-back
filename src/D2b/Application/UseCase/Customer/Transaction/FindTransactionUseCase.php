<?php

namespace D2b\Application\UseCase\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use D2b\Application\Dto\Customer\Account\FindAccountOutputDto;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use D2b\Application\Dto\Customer\Transaction\{
    CreateTransactionOutputDto,
    FindTransactionByIdInputDto,
    FindTransactionOutputDto,
};
use D2b\Application\Dto\Customer\User\UserOutputDto;

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

        //dd($transaction->user_account);

        $output = $this->toTransactionOutput($transaction);

        return $output;
    }

    public function toTransactionOutput($transaction) {

        $user = new UserOutputDto(
            id: $transaction->user_account->user->id(),
            roleId: $transaction->user_account->user->roleId,
            email: $transaction->user_account->user->email,
            name: $transaction->user_account->user->name,
            created_at: $transaction->user_account->user->createdAt()
        );

        $account = new FindAccountOutputDto(
            id: $transaction->user_account->id(),
            balance: $transaction->user_account->balance,
            user: $user,
            createdAt: $transaction->user_account->createdAt()
        );

        return new FindTransactionOutputDto(
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
