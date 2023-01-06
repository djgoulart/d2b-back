<?php

namespace D2b\Application\Dto\Customer\Account;

use D2b\Domain\Customer\Entities\Account;

class DecrementBalanceInputDto
{
    public function __construct(
        public string $account,
        public int $value,
    ){}
}
