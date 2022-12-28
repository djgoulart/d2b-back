<?php

namespace D2b\Domain\Customer\Repositories;

use D2b\Domain\Customer\Entities\Account;

interface AccountRepositoryInterface {
    /**
     * @param Account $account
     * @return Account
     */
    public function insert(Account $account): Account;

    /**
     * @param Account $account
     * @param Int $amount
     * @return Account
     */
    public function update(Account $account): Account;

    /**
     * @param Account $accountId
     * @return Account
     */
    public function findById(string $accountId): Account;

}
