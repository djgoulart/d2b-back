<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\FindAccountResource;
use D2b\Application\Dto\Customer\Account\CreateAccountInputDto;
use D2b\Application\Dto\Customer\Account\FindAccountByOwnerInputDto;
use D2b\Application\Dto\Customer\Account\FindAccountInputDto;
use D2b\Application\UseCase\Customer\Account\CreateAccountUseCase;
use D2b\Application\UseCase\Customer\Account\FindAccountByOwnerUseCase;
use D2b\Application\UseCase\Customer\Account\FindAccountUseCase;
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

    public function show(Request $request, FindAccountUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new FindAccountInputDto(
                accountId: $request->accountId
            )
        );

        //dd($response);

        return (new FindAccountResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
