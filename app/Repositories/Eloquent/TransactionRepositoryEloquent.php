<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction as Model;
use D2b\Domain\Customer\Entities\Transaction;
use D2b\Domain\Customer\Entities\User;
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

    public function list(?string $account = null, ?string $type = null, ?bool $approved = null, ?bool $needs_review = null): array
    {
        $transactions = Model::with('account', 'account.owner')->where('account', $account)->get();

        $entityList = $transactions->map(function ($item, $key) {
            dd($item->account());
            return $this->toTransaction($item);
        });


        return [];
    }

    public function insert(Transaction $transaction): Transaction
    {
        try {
            DB::beginTransaction();

            $data = [
                'id' => $transaction->id(),
                'account' => $transaction->account,
                'description' => $transaction->description,
                'type' => $transaction->type,
                'amount' => (int) $transaction->amount,
                'approved' => $transaction->approved,
                'needs_review' => $transaction->needs_review,
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
                'status' => $transaction->status
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
            $transactionModel = Model::findOrFail($transactionId);
            return $this->toAccount($transactionModel);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    private function toTransaction(object $object): Transaction
    {
        dd($object);

        return new Transaction(
            id: $object->id,
            account: $object->account,
            description: $object->description,
            type: $object->type,
            amount: $object->amount,
            approved: $object->approved,
            needs_review: $object->needs_review,
            createdAt: $object->created_at,
            user_account: new Account(
                id: $account->id,
                owner: $account->owner,
                balance: $account->balance,
                createdAt: $account->created_at,
                user: new User(
                    id: $owner->id,
                    name: $owner->name,
                    email: $owner->email,
                    roleId: $owner->role_id,
                    createdAt: $owner->created_at,
                    password: null
                )
            )
        );
    }
}
