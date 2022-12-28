<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\TransactionResource;
use D2b\Application\Dto\Customer\Transaction\CreateTransactionInputDto;
use D2b\Application\Dto\Customer\Transaction\FindTransactionByIdInputDto;
use D2b\Application\Dto\Customer\Transaction\ListTransactionsInputDto;
use D2b\Application\Dto\Customer\Transaction\TransactionAnalysisInputDto;
use D2b\Application\UseCase\Customer\Transaction\CreateTransactionUseCase;
use D2b\Application\UseCase\Customer\Transaction\FindTransactionUseCase;
use D2b\Application\UseCase\Customer\Transaction\ListsTransactionsUseCase;
use D2b\Application\UseCase\Customer\Transaction\TransactionAnalysisUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function index(Request $request, ListsTransactionsUseCase $useCase) {
        $response = $useCase->execute(
            new ListTransactionsInputDto(
                account: $request->query('account'),
                approved: $request->query('approved'),
                type: $request->query('type'),
                needs_review: $request->query('needs_review'),
            )
        );

        return TransactionResource::collection($response);

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

    public function show(Request $request, FindTransactionUseCase $useCase) {
        $transactionId = $request->transaction;

        $transaction = $useCase->execute(
            new FindTransactionByIdInputDto(
                transactionId: $transactionId
            )
        );

        return (new TransactionResource($transaction))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function sendForAnalysis(Request $request, TransactionAnalysisUseCase $useCase) {
        $transactionId = $request->transaction;
        $approved = $request->approved;

        $transaction = $useCase->execute(
            new TransactionAnalysisInputDto(
                transactionId: $transactionId,
                approved: $approved
            )
        );

        return (new TransactionResource($transaction))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
