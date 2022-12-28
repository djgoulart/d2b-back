<?php

namespace D2b\Application\Dto\Customer\Transaction;

class ListTransactionsInputDto
{
    public function __construct(
        public array  $transactions = [],
    ){}
}
