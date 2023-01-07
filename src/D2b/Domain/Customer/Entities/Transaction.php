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
        protected int $amount = 0,
        protected bool $approved = false,
        protected bool $needs_review = true,
        protected string $receipt_url = '',
        protected Account|null $user_account = null,
        protected DateTime|string $createdAt = '',
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->account = $this->account ? new Uuid($this->account) : '';
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt()) : new DateTime();

        if ($this->amount) {
            $this->amount = $this->amount
                ? $this->amount
                : 0;
        }

        $this->receipt_url = $this->receipt_url ? $this->receipt_url : '';

        $this->validate();
    }

    public function dennyTransaction() {
        $this->approved = false;
        $this->needs_review = false;
    }

    public function approveTransaction() {
        $this->approved = true;
        $this->needs_review = false;
    }

    private function validate()
    {
        DomainBaseValidation::intVal($this->amount);
        DomainBaseValidation::greaterThenZero($this->amount, "Can't create transactions with zero value.");
        DomainBaseValidation::notNull($this->account, "Can't create transactions without a account.");
    }
}
