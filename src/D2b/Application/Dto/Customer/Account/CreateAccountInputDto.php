<?php

namespace D2b\Application\Dto\Customer\Account;

class CreateAccountInputDto
{
    public function __construct(
        public string $owner,
    ){}
}
