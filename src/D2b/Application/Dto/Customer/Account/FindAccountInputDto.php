<?php

namespace D2b\Application\Dto\Customer\Account;

class FindAccountInputDto
{
    public function __construct(
        public string $accountId,
    ){}
}
