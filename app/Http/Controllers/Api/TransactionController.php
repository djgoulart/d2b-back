<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDepositRequest;
use App\Http\Resources\TransactionResource;
use D2b\Application\Dto\Customer\Transaction\CreateDepositInputDto;
use D2b\Application\UseCase\Customer\Transaction\CreateDepositUseCase;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function storeDeposit(CreateDepositRequest $request, CreateDepositUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new CreateDepositInputDto(
                account: $request->account,
                description: $request->description,
                type: 'deposit',
                value: $request->value,
                status: 'need_approval'
            )
        );

        return (new TransactionResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
