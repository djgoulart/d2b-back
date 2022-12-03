<?php

namespace D2b\Application\Dto\Customer\User;

class CreateUserInputDto
{
    public function __construct(
        public string $password,
        public int $roleId,
        public string $email,
        public string $name,
    ){}
}
