<?php

namespace Tests\Unit\D2b\Domain\Validation;

use D2b\Domain\Common\Validation\DomainBaseValidation;
use D2b\Domain\Exceptions\EntityValidationException;
use Tests\TestCase;

class DomainBaseValidationTest extends TestCase
{
    public function test_notNull_validation()
    {
        try {
            $value = '';
            DomainBaseValidation::notNull($value);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function test_notNull_validation_message()
    {
        try {
            $value = '';
            DomainBaseValidation::notNull($value, 'validation message');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('validation message', $th->getMessage());
        }
    }

    public function test_it_should_throw_for_strMaxLength_gt_255()
    {
        try {
            $value = $this->generateRandomString(256);

            DomainBaseValidation::strMaxLength($value);
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function test_it_should_throw_for_strMaxLength_gt_specified()
    {
        try {
            $value = 'this is a test';

            DomainBaseValidation::strMaxLength($value, 5);
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function test_it_strMaxLength_validation_message()
    {
        try {
            $value = 'this is a test';

            DomainBaseValidation::strMaxLength($value, 5, 'validation message');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('validation message', $th->getMessage());
        }
    }

    public function test_it_should_throw_for_strMinLength_lt_3()
    {
        try {
            $value = 'ab';

            DomainBaseValidation::strMinLength($value);
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function test_it_should_throw_for_strMinLength_lt_specified()
    {
        try {
            $value = '123456789';

            DomainBaseValidation::strMinLength($value,10);
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function test_strMinLength_validation_message()
    {
        try {
            $value = '123456789';

            DomainBaseValidation::strMinLength($value, 10 , 'validation message');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
            $this->assertEquals('validation message', $th->getMessage());
        }
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
