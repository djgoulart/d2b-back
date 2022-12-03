<?php

namespace Tests\Unit\D2b\Domain\Account\ValueObjects;

use D2b\Domain\Customer\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function test_it_should_be_instance_of_correct_class()
    {
        $id = '123';

        $userId = Uuid::random($id);

        $this->assertInstanceOf(Uuid::class, $userId);
    }
}
