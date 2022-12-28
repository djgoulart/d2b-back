<?php

namespace D2b\Application\Dto\Customer\Transaction;

class FindTransactionByIdInputDto
{
    public function __construct(
        public string $transactionId
    ){}
}
