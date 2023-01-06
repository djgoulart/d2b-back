<?php

namespace D2b\Application\Dto\Customer\User;

class FindUserOutputDto
{
    public function __construct(
        public string $id,
        public int $roleId,
        public string $email,
        public string $name,
        public string $account,
        public string $created_at,
    ){}
}
