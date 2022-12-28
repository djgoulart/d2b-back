<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\FindAccountByOwnerInputDto;
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Application\UseCase\Customer\Account\FindAccountByOwnerUseCase;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function store(StoreAccountRequest $request, CreateAccountUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new CreateAccountInputDto(
                owner: $request->owner
            )
        );

        return (new AccountResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
