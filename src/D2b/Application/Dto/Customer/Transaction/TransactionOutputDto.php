<?php

namespace D2b\Application\Dto\Customer\Transaction;

use D2b\Application\Dto\Customer\Account\AccountOutputDto;

class TransactionOutputDto
{
    public function __construct(
        public string $id,
        public string $description,
        public string $type,
        public int $amount,
        public bool $approved,
        public bool $needs_review,
        public string $receipt_url,
        public string $created_at,
    ){}
}
