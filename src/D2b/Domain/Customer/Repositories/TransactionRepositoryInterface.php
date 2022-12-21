<?php

namespace D2b\Domain\Customer\Repositories;

use D2b\Domain\Customer\Entities\Transaction;

interface TransactionRepositoryInterface {
    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function insert(Transaction $transaction): Transaction;

    /**
     * @param Transaction $transaction
     * @return Transaction
     */
    public function update(Transaction $transaction): Transaction;

    /**
     * @param string $transactionId
     * @return Transaction
     */
    public function findById(string $transactionId): Transaction;
}
