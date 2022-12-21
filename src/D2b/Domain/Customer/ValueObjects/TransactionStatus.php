<?php

namespace D2b\Domain\Customer\ValueObjects;

use InvalidArgumentException;

class TransactionStatus
{
  public function __construct(protected string $value)
  {
    $this->selfValidate($value);
  }

  private function selfValidate(string $type): void
  {
    if ($type !== 'need_approval' && $type !== 'approved')
      throw new InvalidArgumentException(
        sprintf('<%s> does not allow the value <%s>.', static::class, $type)
      );
  }
}
