<?php

namespace Tests\Unit\D2b\Domain\Customer\Entities;

use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Exceptions\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TransactionTest extends TestCase
{

    public function test_it_can_create_and_access_attributes()
    {
        $accountId = Uuid::uuid4()->toString();

        $transaction = new Transaction(
            account: $accountId,
            description: 'deposit description',
            amount: 1000,
            type: 'deposit'
        );

        $this->assertNotEmpty($transaction->id());
        $this->assertNotEmpty($transaction->description);
        $this->assertEquals('deposit description', $transaction->description);
        $this->assertEquals(1000, $transaction->amount);
        $this->assertEquals('deposit', $transaction->type);
        $this->assertNotEmpty($transaction->account);
        $this->assertEquals($accountId, $transaction->account);
    }

    public function test_it_can_create_withdrawal()
    {
        $accountId = Uuid::uuid4()->toString();

        $transaction = new Transaction(
            account: $accountId,
            description: 'withdrawal description',
            amount: 1000,
            type: 'withdrawal'
        );

        $this->assertNotEmpty($transaction->id);
        $this->assertEquals(1000, $transaction->amount);
        $this->assertEquals('withdrawal', $transaction->type);
        $this->assertNotEmpty($transaction->account);
        $this->assertEquals($accountId, $transaction->account);
    }

    public function test_it_cant_create_zero_value_transactions()
    {
        try {

            $accountId = Uuid::uuid4()->toString();

            new Transaction(
                account: $accountId,
                description: 'test with zero value',
                amount: 0,
                type: 'withdrawal'
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Can't create transactions with zero value.", $th->getMessage());
        }
    }

    public function test_it_cant_create_transactions_without_an_account()
    {
        try {
            $accountId = '';

            new Transaction(
                account: $accountId,
                description: 'test without account',
                amount: 100,
                type: 'withdrawal'
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals("Can't create transactions without a account.", $th->getMessage());
        }
    }
}
