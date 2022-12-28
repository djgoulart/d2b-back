<?php

namespace D2b\Application\Dto\Customer\Transaction;

use D2b\Domain\Customer\Entities\Transaction;

class TransactionAnalysisInputDto
{
    public function __construct(
        public string $transactionId,
        public bool $approved
    ){}
}
