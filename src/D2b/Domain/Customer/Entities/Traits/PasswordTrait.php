<?php

namespace D2b\Domain\Customer\Entities\Traits;

use Exception;

trait PasswordTrait
{
    public function password(): string
    {
        if (isset($this->password))
            return (string) $this->password->toString();

        $className = get_class($this);
        throw new Exception("Property password not found in {$className}");
    }
}
