<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserAndAccountResource;
use App\Http\Resources\UserResource;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\UseCase\Customer\User\CreateUserUseCase;
use D2b\Application\Dto\Customer\User\{
    CreateUserAndAccountOutputDto,
    CreateUserInputDto,
    CreateUserOutputDto,
};
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Application\UseCase\Customer\User\FindUserByIdUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function store(
        StoreUserRequest $request,
        CreateUserUseCase $useCase,
        CreateAccountUseCase $createAccountUseCase)
    {
        $user = $useCase->execute(
            input: new CreateUserInputDto(
                name: $request->name,
                email: $request->email,
                password: $request->password,
                roleId: 1,
            )
        );

        $account = $createAccountUseCase->execute(
            input: new CreateAccountInputDto(
                owner: $user->id,
            )
        );

        $response = new CreateUserAndAccountOutputDto(
            user: $user,
            account: $account,
        );


        return (new UserAndAccountResource($response))
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
