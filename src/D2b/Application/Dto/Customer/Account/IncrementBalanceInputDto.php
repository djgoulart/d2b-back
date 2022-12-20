<?php

namespace D2b\Application\Dto\Customer\Account;

use D2b\Domain\Customer\Entities\Account;

class IncrementBalanceInputDto
{
    public function __construct(
        public Account $account,
        public int $value,
    ){}
}
