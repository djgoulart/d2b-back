<?php

namespace D2b\Domain\Customer\Entities;

use D2b\Domain\Common\Validation\DomainBaseValidation;
use D2b\Domain\Customer\Entities\Traits\MagicMethodsTrait;
use D2b\Domain\Customer\ValueObjects\TransactionStatus;
use D2b\Domain\Customer\ValueObjects\Uuid;
use D2b\Domain\Customer\ValueObjects\TransactionType;
use DateTime;

class Transaction {
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = '',
        protected Uuid|string $account = '',
        protected string $description = '',
        protected TransactionType|string $type = '',
        protected int $value = 0,
        protected TransactionStatus|string $status = 'need_approval',
        protected DateTime|string $createdAt = '',
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->account = $this->account ? new Uuid($this->account) : '';
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt()) : new DateTime();

        if ($this->value) {
            $this->value = $this->value
                ? $this->value
                : 0;
        }

        $this->validate();
    }

    private function validate()
    {
        DomainBaseValidation::intVal($this->value);
        DomainBaseValidation::greaterThenZero($this->value, "Can't create transactions with zero value.");
        DomainBaseValidation::notNull($this->account, "Can't create transactions without a account.");
    }
}
