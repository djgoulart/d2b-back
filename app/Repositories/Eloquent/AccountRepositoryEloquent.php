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
