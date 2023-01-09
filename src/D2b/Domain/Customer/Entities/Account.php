<?php

namespace D2b\Domain\Customer\Entities;

use D2b\Domain\Common\Validation\DomainBaseValidation;
use D2b\Domain\Customer\Entities\Traits\MagicMethodsTrait;
use D2b\Domain\Customer\ValueObjects\Uuid;
use D2b\Domain\Exceptions\EntityValidationException;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Exceptions\InsufficientBalanceException;
use D2b\Domain\Exceptions\InsufficientFundsException;
use DateTime;

class Account {
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $owner = '',
        protected Uuid|string $id = '',
        protected int $balance = 0,
        protected User|null $user = null,
        protected DateTime|string $createdAt = '',
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->owner = $this->owner ? new Uuid($this->owner) : '';
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt()) : new DateTime();

        if ($this->balance) {
            $this->balance = $this->balance
                ? $this->balance
                : 0;
        }

        $this->validate();
    }

    private function validate()
    {
        DomainBaseValidation::intVal($this->balance);
        DomainBaseValidation::notNull($this->owner);
    }

    public function increaseBalance(int $amount)
    {
        $this->balance = $this->balance + $amount;
    }

    public function decreaseBalance(int $amount)
    {
        if($this->balance < $amount) {
            throw new InsufficientFundsException('Insufficient funds');
        }

        $this->balance = $this->balance - $amount;

        return $this;
    }
}
