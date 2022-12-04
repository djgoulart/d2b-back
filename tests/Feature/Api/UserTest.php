<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $endpoint = '/api/users';

    public function test_it_cant_store_users_without_data()
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'email',
                'password',
            ]
        ]);
    }

    public function test_it_cant_store_users_with_duplicated_email()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'roleId' => 1,
        ];

        $this->postJson($this->endpoint, $data);
        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
            ]
        ]);
    }

    public function test_is_should_store_an_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'roleId' => 1,
        ];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'roleId',
                'created_at',
            ]
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'roleId' => 1,
        ]);
    }
}
