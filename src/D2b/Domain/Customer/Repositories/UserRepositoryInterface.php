<?php

namespace D2b\Domain\Customer\Repositories;

use D2b\Domain\Customer\Entities\User;

interface UserRepositoryInterface
{
    public function insert(User $user): User;
    public function findById(string $id): User;
    /*public function update(User $user): User;
    public function delete(string $id): bool;
    public function toUser(object $data): User; */
}
