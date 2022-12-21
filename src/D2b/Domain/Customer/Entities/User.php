<?php

namespace D2b\Domain\Customer\Entities;

use D2b\Domain\Common\Validation\DomainBaseValidation;
use D2b\Domain\Customer\Entities\Traits\MagicMethodsTrait;
use D2b\Domain\Customer\Entities\Traits\PasswordTrait;
use D2b\Domain\Customer\ValueObjects\PasswordHash;
use D2b\Domain\Customer\ValueObjects\Uuid;
use DateTime;

class User {
    use MagicMethodsTrait, PasswordTrait;

    public function __construct(
        protected PasswordHash|string $password,
        protected int $roleId,
        protected Uuid|string $id = '',
        protected string $email = '',
        protected string $name = '',
        protected Account $account,
        protected DateTime|string $createdAt = '',
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt()) : new DateTime();

        if ($this->password) {
            $this->password = PasswordHash::needsReHash($this->password)
                ? PasswordHash::hashPassword($this->password)
                : $this->password;
        }

        $this->validate();
    }

    private function validate()
    {
        DomainBaseValidation::notNull($this->name);
        DomainBaseValidation::strMaxLength($this->name);
        DomainBaseValidation::strMinLength($this->name);

        DomainBaseValidation::notNull($this->email);
        DomainBaseValidation::strMaxLength($this->email);
        DomainBaseValidation::strMinLength($this->email, 6);

        DomainBaseValidation::notNull($this->roleId);
    }

    public function changePassword(string $newPassword = null)
    {
        $this->password = $newPassword ? PasswordHash::hashPassword($newPassword) : $this->password;
    }

    public function update(string $name = null, string $email = null, string $password = null)
    {
        $this->name = $name ?? $this->name;
        $this->email = $email?? $this->email;
        $this->password = $password ? PasswordHash::hashPassword($password) : $this->password;
    }
}
