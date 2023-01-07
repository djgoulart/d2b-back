<?php

namespace D2b\Application\Dto\Customer\Transaction;

class CreateDepositInputDto
{
    public function __construct(
        public string $account,
        public string $description,
        public string $type,
        public int $amount,
        public bool $approved,
        public bool $needs_review,
        public string $receipt_url,
    ){}
}
