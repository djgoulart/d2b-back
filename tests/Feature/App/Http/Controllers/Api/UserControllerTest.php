<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\UserController;
use App\Models\User as Model;
use App\Models\Account as AccountModel;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\Eloquent\AccountRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected $repository;
    protected $accountRepository;
    protected $controller;

    public function setUp(): void
    {
        $this->repository = new UserRepositoryEloquent(
            new Model()
        );

        $this->accountRepository = new AccountRepositoryEloquent(
            new AccountModel()
        );

        $this->controller = new UserController();

        parent::setUp();
    }

    public function test_it_should_persist_a_new_User_on_database()
    {
        $useCase = new CreateUserUseCase($this->repository);
        $accountUseCase = new CreateAccountUseCase($this->accountRepository);

        $request = new StoreUserRequest();
        $request->headers->set('Content-Type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => '123456',
            'roleId' => 1,
        ]));

        $response = $this->controller->store($request, $useCase, $accountUseCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'roleId' => 1,
        ]);
    }
}
