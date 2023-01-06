<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Resources\FindTransactionResource;
use App\Http\Resources\TransactionResource;
use D2b\Application\Dto\Customer\Account\DecrementBalanceInputDto;
use D2b\Application\Dto\Customer\Account\FindAccountInputDto;
use D2b\Application\Dto\Customer\Account\IncrementBalanceInputDto;
use D2b\Application\Dto\Customer\Transaction\CreateTransactionInputDto;
use D2b\Application\Dto\Customer\Transaction\FindTransactionByIdInputDto;
use D2b\Application\Dto\Customer\Transaction\ListTransactionsInputDto;
use D2b\Application\Dto\Customer\Transaction\TransactionAnalysisInputDto;
use D2b\Application\UseCase\Customer\Account\DecrementBalanceUseCase;
use D2b\Application\UseCase\Customer\Account\FindAccountUseCase;
use D2b\Application\UseCase\Customer\Account\IncrementBalanceUseCase;
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

    public function store(
        CreateTransactionRequest $request,
        CreateTransactionUseCase $useCase,
        DecrementBalanceUseCase $decrementBalanceUseCase,
        FindAccountUseCase $findAccountUseCase
        )
    {
        try {

            $account = $findAccountUseCase->execute(
                input: new FindAccountInputDto(
                    accountId: $request->account
                )
            );

            if(!$account) {
                return response()
                    ->json(
                        ["error" => 'account not found'],
                        Response::HTTP_PRECONDITION_FAILED
                    );
            }

            if($request->type === 'expense'&& $request->amount > $account->balance) {
                return response()
                    ->json(
                        ["error" => 'insufficient funds'],
                        Response::HTTP_PRECONDITION_FAILED
                    );
            }

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

            if($request->type === 'expense') {
                $decrementBalanceUseCase->execute(
                    input: new DecrementBalanceInputDto(
                        account: $response->account->id,
                        value: $response->amount,
                    )
                );
            }

            return (new TransactionResource($response))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()
            ->json([
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ], Response::HTTP_PRECONDITION_FAILED);
        }
    }

    public function show(Request $request, FindTransactionUseCase $useCase) {
        $transactionId = $request->transaction;

        $transaction = $useCase->execute(
            new FindTransactionByIdInputDto(
                transactionId: $transactionId
            )
        );

        return (new FindTransactionResource($transaction))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function sendForAnalysis(
        Request $request,
        TransactionAnalysisUseCase $useCase,
        FindTransactionUseCase $findTransactionUseCase,
        IncrementBalanceUseCase $incrementBalanceUseCase
        ) {
        $transactionId = $request->transaction;
        $approved = $request->approved;

        $transaction = $findTransactionUseCase->execute(
            new FindTransactionByIdInputDto(
                transactionId: $transactionId
            )
        );

        if(!$transaction->needs_review) {
            return response()
                ->json(
                    ["error" => 'transaction already reviewed'],
                    Response::HTTP_PRECONDITION_FAILED
                );
        }

        $response = $useCase->execute(
            new TransactionAnalysisInputDto(
                transactionId: $transactionId,
                approved: $approved
            )
        );

        if($approved) {
            $incrementBalanceUseCase->execute(
                input: new IncrementBalanceInputDto(
                    account: $transaction->account->id,
                    value: $transaction->amount,
                )
            );
        }

        return (new TransactionResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
