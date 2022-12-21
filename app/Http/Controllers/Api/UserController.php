<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use D2b\Application\Dto\Customer\User\{
    CreateUserInputDto,
};
use D2b\Application\UseCase\Customer\User\FindUserByIdUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function store(StoreUserRequest $request, CreateUserUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new CreateUserInputDto(
                name: $request->name,
                email: $request->email,
                password: $request->password,
                roleId: 1,
            )
        );

        return (new UserResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Request $request, FindUserByIdUseCase $useCase)
    {
        $id = $request->user;
        $response = $useCase->execute(input: $id);

        return (new UserResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
