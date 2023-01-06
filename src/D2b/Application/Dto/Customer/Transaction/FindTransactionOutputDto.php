<?php

namespace D2b\Application\Dto\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\FindAccountOutputDto;

class FindTransactionOutputDto
{
    public function __construct(
        public string $id,
        public FindAccountOutputDto $account,
        public string $description,
        public string $type,
        public int $amount,
        public bool $approved,
        public bool $needs_review,
        public string $created_at,
    ){}
}
