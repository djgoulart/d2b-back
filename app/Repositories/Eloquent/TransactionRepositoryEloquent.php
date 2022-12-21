<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaction as Model;
use D2b\Domain\Customer\Entities\Transaction;
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

    public function insert(Transaction $transaction): Transaction
    {
        try {
            DB::beginTransaction();

            $data = [
                'id' => $transaction->id(),
                'account' => $transaction->account,
                'description' => $transaction->description,
                'type' => $transaction->type,
                'value' => (int) $transaction->value,
                'status' => $transaction->status,
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
        return new Transaction(
            id: $object->id,
            account: $object->account,
            description: $object->description,
            type: $object->type,
            value: $object->value,
            status: $object->status,
            createdAt: $object->created_at,
        );
    }
}
