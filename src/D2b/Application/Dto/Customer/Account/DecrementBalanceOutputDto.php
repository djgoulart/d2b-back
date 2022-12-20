<?php

namespace D2b\Application\Dto\Customer\Account;

class DecrementBalanceOutputDto
{
    public function __construct(
        public string $id,
        public string $owner,
        public string $balance,
        public string $created_at,
    ){}
}
