<?php

namespace Tests\Unit\D2b\Domain\Customer\Entities;

use D2b\Domain\Exceptions\EntityValidationException;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\ValueObjects\PasswordHash;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function test_it_should_create_and_access_attributes()
    {
        $userPassword = 'user_password';
        $roleId = 10;
        $email = 'user@test.com';
        $name = 'User Test';

        $user = new User(
            password: $userPassword,
            roleId: $roleId,
            email: $email,
            name: $name
        );

        $this->assertNotEmpty($user->id());

        $this->assertIsInt($user->roleId);
        $this->assertEquals($roleId, $user->roleId);

        $this->assertIsString($user->name);
        $this->assertEquals($name, $user->name);

        $this->assertIsString($user->email);
        $this->assertEquals($email, $user->email);
    }

    public function test_it_should_update_an_user()
    {
        $id = Uuid::uuid4()->toString();
        $newPassword = "new-password";
        $newName = 'User name updated';
        $newEmail= 'new@email.com';

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->changePassword($newPassword);

        $user->update(
            name: $newName,
            email: $newEmail,
        );

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        $this->assertInstanceOf(PasswordHash::class, $user->password);
        $this->assertTrue(password_verify($newPassword, $user->password()));
    }

    public function test_it_should_update_an_email()
    {
        $id = Uuid::uuid4()->toString();
        $newEmail= 'new@email.com';

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->update(
            email: $newEmail,
        );

        $this->assertEquals($newEmail, $user->email);
    }

    public function test_it_should_update_an_user_name()
    {
        $id = Uuid::uuid4()->toString();
        $newName = 'User name updated';

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->update(
            name: $newName,
        );

        $this->assertEquals($newName, $user->name);
    }


    public function test_it_should_change_an_user_password()
    {
        $id = Uuid::uuid4()->toString();
        $newPassword = "new-password";

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->changePassword($newPassword);

        $this->assertInstanceOf(PasswordHash::class, $user->password);
        $this->assertTrue(password_verify($newPassword, $user->password()));
    }

    public function test_it_should_not_update_password_by_passing_null_or_empty_string()
    {
        $id = Uuid::uuid4()->toString();

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->changePassword('');
        $user->changePassword(null);

        $this->assertInstanceOf(PasswordHash::class, $user->password);
        $this->assertTrue(password_verify('user-password', $user->password()));
    }

    public function test_it_should_not_update_by_passing_no_parameters()
    {
        $id = Uuid::uuid4()->toString();

        $user = new User(
            id: $id,
            password: 'user-password',
            roleId: 10,
            email: 'user@test.com',
            name: 'User Test'
        );

        $user->update();

        $this->assertEquals('User Test', $user->name);
        $this->assertEquals('user@test.com', $user->email);
        $this->assertTrue(password_verify('user-password', $user->password()));
    }

    public function test_it_should_throw_validation_errors_for_name()
    {
        try {
            $user = new User(
                name: '',
                email: 'user@example.com',
                password: '123123',
                roleId: 10,
            );

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
