<?php

namespace D2b\Application\Dto\Customer\User;

use DateTime;

class CreateUserOutputDto
{
    public function __construct(
        public string $id,
        public int $roleId,
        public string $email,
        public string $name,
        public DateTime $created_at,
    ){}
}
