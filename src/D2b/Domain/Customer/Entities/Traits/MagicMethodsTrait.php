<?php

namespace D2b\Domain\Customer\Entities\Traits;

use D2b\Domain\Customer\Entities\Account;
use Exception;

trait MagicMethodsTrait {
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function owner(): string
    {
        return (string) $this->owner;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
