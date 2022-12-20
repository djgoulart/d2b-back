<?php

namespace D2b\Domain\Customer\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;



class TransactionType
{
  public function __construct(protected string $value)
  {
    $this->selfValidate($value);
  }

  private function selfValidate(string $type): void
  {
    if ($type !== 'deposit' && $type !== 'withdrawal')
      throw new InvalidArgumentException(
        sprintf('<%s> does not allow the value <%s>.', static::class, $type)
      );
  }
}
