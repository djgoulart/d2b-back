<?php

namespace D2b\Application\Dto\Customer\Transaction;

class ListTransactionsInputDto
{
    public function __construct(
        public string|null $account,
        public string|null $type,
        public bool|null $approved,
        public bool|null $needs_review,
    ){}
}
