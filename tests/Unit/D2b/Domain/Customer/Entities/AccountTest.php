<?php

namespace Tests\Unit\D2b\Domain\Customer\Entities;

use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Exceptions\EntityValidationException;
use D2b\Domain\Exceptions\InsufficientFundsException;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{

    public function test_it_can_create_and_access_attributes()
    {
        $user = new User(
            name: 'John',
            email: 'john@example.com',
            password: '123456',
            roleId: 1
        );

        $account = new Account(
            owner: $user->id,
        );

        $this->assertNotEmpty($account->id());
        $this->assertEquals(0, $account->balance);
        $this->assertNotEmpty($account->owner);
        $this->assertEquals($user->id(), $account->owner);
    }

    public function test_it_can_increase_balance()
    {
        $user = new User(
            name: 'John',
            email: 'john@example.com',
            password: '123456',
            roleId: 1
        );

        $account = new Account(
            owner: $user->id
        );

        $account->increaseBalance(10);
        $this->assertEquals(10, $account->balance);
    }

    public function test_it_can_decrease_balance()
    {
        $user = new User(
            name: 'John',
            email: 'john@example.com',
            password: '123456',
            roleId: 1
        );

        $account = new Account(
            owner: $user->id
        );

        $account->increaseBalance(15);
        $account->decreaseBalance(10);
        $this->assertEquals(5, $account->balance);
    }

    public function test_it_throws_exception_for_insuficient_balance()
    {
        try {
            $user = new User(
                name: 'John',
                email: 'john@example.com',
                password: '123456',
                roleId: 1
            );

            $account = new Account(
                owner: $user->id
            );

            $account->decreaseBalance(10);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(InsufficientFundsException::class, $th);
            $this->assertEquals('Insufficient funds', $th->getMessage());
        }
    }
}
