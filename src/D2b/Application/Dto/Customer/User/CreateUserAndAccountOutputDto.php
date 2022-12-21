<?php

namespace D2b\Application\Dto\Customer\User;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use DateTime;

class CreateUserAndAccountOutputDto
{
    public function __construct(
        public CreateUserOutputDto $user,
        public CreateAccountOutputDto $account,
    ){}
}
