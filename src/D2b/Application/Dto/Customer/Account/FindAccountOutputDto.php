<?php

namespace D2b\Application\Dto\Customer\Account;

use D2b\Application\Dto\Customer\User\UserOutputDto;
use D2b\Domain\Customer\Entities\User;

class FindAccountOutputDto
{
    public function __construct(
        public string $id,
        public UserOutputDto $user,
        public string $balance,
        public string $createdAt,
    ){}
}
