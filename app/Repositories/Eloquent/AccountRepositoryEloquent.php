<?php

namespace App\Repositories\Eloquent;

use App\Models\Account as Model;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AccountRepositoryEloquent implements AccountRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function insert(Account $account): Account
    {
        try {
            DB::beginTransaction();

            $data = [
                'id' => $account->id(),
                'owner' => $account->owner(),
                'balance' => (int) $account->balance,
            ];

            $accountModel = Model::create($data);

            DB::commit();
            return $this->toAccount($accountModel);
        } catch (QueryException $th) {
            DB::rollBack();

            throw $th;
        }


        return $this->toAccount($account);
    }

    public function incrementBalance(Account $account, int $amount): Account
    {
        try {
            DB::beginTransaction();

            $accountModel = Model::findOrFail($account->id());
            $accountModel->balance = $accountModel->balance + $amount;
            $accountModel->save();

            DB::commit();
            return $this->toAccount($accountModel);
        } catch (QueryException $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function findById(string $accountId): Account
    {
        try {
            $accountModel = Model::findOrFail($accountId);
            return $this->toAccount($accountModel);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    private function toAccount(object $object): Account
    {
        return new Account(
            id: $object->id,
            owner: $object->owner,
            balance: $object->balance,
            createdAt: $object->created_at,
        );
    }
}
