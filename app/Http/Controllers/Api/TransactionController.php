<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionResource;
use D2b\Application\Dto\Customer\Transaction\CreateTransactionInputDto;
use D2b\Application\Dto\Customer\Transaction\ListTransactionsInputDto;
use D2b\Application\UseCase\Customer\Transaction\CreateTransactionUseCase;
use D2b\Application\UseCase\Customer\Transaction\ListsTransactionsUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function index(Request $request, ListsTransactionsUseCase $useCase) {
        $params = $request->query();

        $response = $useCase->execute(
            new ListTransactionsInputDto(
                account: $params['account'] ? $params['account'] : null,
                approved: $params['approved'] ? $params['approved'] : null,
                type: $params['type'] ? $params['type'] : null,
                needs_review: $params['needs_review'] ? $params['needs_review'] : null,
            )
        );

        dd($response);

    }

    public function store(CreateTransactionRequest $request, CreateTransactionUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new CreateTransactionInputDto(
                account: $request->account,
                description: $request->description,
                type: $request->type,
                amount: $request->amount,
                approved: $request->type === 'expense' ? true : false,
                needs_review: $request->type === 'deposit' ? true : false
            )
        );

        return (new TransactionResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
