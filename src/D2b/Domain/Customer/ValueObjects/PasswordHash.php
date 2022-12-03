<?php

namespace D2b\Domain\Customer\ValueObjects;

use InvalidArgumentException;

class PasswordHash
{
    public function __construct(protected string $value)
    {
        $this->selfValidate($value);
    }

    public static function hashPassword(string $value): self
    {
        $password = password_hash($value, PASSWORD_BCRYPT, [
            'cost' => 10
        ]);

        return new self($password);
    }

    public static function needsReHash(string $value): bool
    {
        return password_needs_rehash($value, PASSWORD_BCRYPT, [
            'cost' => 10,
        ]);
    }

    public function toString(): string
    {
        return $this->value;
    }


    private function selfValidate(string $password): void
    {
        $needsReHash = password_needs_rehash($password, PASSWORD_BCRYPT, [
            'cost' => 10,
        ]);

        if ($needsReHash) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>.', static::class, $password)
            );
        }
    }
}
