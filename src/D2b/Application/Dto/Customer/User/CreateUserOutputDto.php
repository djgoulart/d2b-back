<?php

namespace D2b\Application\Dto\Customer\User;

use D2b\Application\Dto\Customer\Account\CreateAccountOutputDto;
use DateTime;

class CreateUserOutputDto
{
    public function __construct(
        public string $id,
        public int $roleId,
        public string $email,
        public string $name,
        public CreateAccountOutputDto $account,
        public string $created_at,
    ){}
}
