<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction as Model;
use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Repositories\TransactionRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TransactionRepositoryEloquent implements TransactionRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function list(
        ?string $account = null,
        ?string $type = null,
        ?bool $approved = null,
        ?bool $needs_review = null): array
    {
        //dd($needs_review);
        $where = [];
        if($account) {
            array_push($where, ['account_id', $account]);
        }
        if($type) {
            array_push($where, ['type', $type]);
        }
        if($approved) {
            array_push($where, ['approved', $approved]);
        }
        if($needs_review) {
            array_push($where, ['needs_review', $needs_review]);
        }

        $transactions = Model::with(['account', 'account.user'])
        ->where($where)
        ->get();

        $entityList = $transactions->map(function ($item, $key) {
            return $this->toTransaction($item);
        });

        return $entityList->toArray();
    }

    public function insert(Transaction $transaction): Transaction
    {

        try {
            DB::beginTransaction();

            $data = [
                'id' => $transaction->id(),
                'account_id' => $transaction->account,
                'description' => $transaction->description,
                'type' => $transaction->type,
                'amount' => (int) $transaction->amount,
                'approved' => $transaction->approved,
                'needs_review' => $transaction->needs_review,
                'receipt_url' => $transaction->receipt_url,
            ];

            $transactionModel = Model::create($data);


            DB::commit();
            return $this->toTransaction($transactionModel);
        } catch (QueryException $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function update(Transaction $transaction): Transaction
    {
        try {
            DB::beginTransaction();

            $transactionModel = Model::findOrFail($transaction->id());
            $transactionModel->update([
                'approved' => $transaction->approved,
                'needs_review' => $transaction->needs_review
            ]);

            $transactionModel->save();

            DB::commit();
            return $this->toTransaction($transactionModel);
        } catch (QueryException $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function findById(string $transactionId): Transaction
    {
        try {
            $transactionModel = Model::with(['account', 'account.user'])->findOrFail($transactionId);
            return $this->toTransaction($transactionModel);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    private function toTransaction(Model $object): Transaction
    {

        $user = new User(
            id: $object->account->user->id,
            name: $object->account->user->name,
            email: $object->account->user->email,
            roleId: $object->account->user->roleId,
            createdAt: $object->account->user->created_at,
            password: null
        );

        $account = new Account(
            id: $object->account->id,
            owner: $object->account->user_id,
            balance: $object->account->balance,
            createdAt: $object->account->created_at,
            user: $user
        );

        return new Transaction(
            id: $object->id,
            account: $object->account_id,
            description: $object->description,
            type: $object->type,
            amount: $object->amount,
            approved: $object->approved,
            needs_review: $object->needs_review,
            receipt_url: $object->receipt_url ?? '',
            createdAt: $object->created_at,
            user_account: $account
        );
    }
}
