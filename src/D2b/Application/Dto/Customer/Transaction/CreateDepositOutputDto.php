<?php

namespace D2b\Application\Dto\Customer\Transaction;

class CreateDepositOutputDto
{
    public function __construct(
        public string $id,
        public string $account,
        public string $description,
        public string $type,
        public int $value,
        public string $status,
        public string $created_at,
    ){}
}
