<?php

namespace App\Repositories\Eloquent;

use App\Models\User as Model;
use D2b\Domain\Customer\Entities\Account;
use D2b\Domain\Customer\Entities\User;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function insert(User $user): User
    {
        try {
            DB::beginTransaction();

            $data = [
                'id' => $user->id(),
                'name' => $user->name,
                'email' => $user->email,
                'roleId' => $user->roleId,
                'password' => $user->password(),
            ];

            $userModel = Model::create($data);

            DB::commit();
            return $this->toUser($userModel);
        } catch (QueryException $th) {
            DB::rollBack();

            throw $th;
        }


        return $this->toUser($user);
    }

    public function findById(string $id): User
    {
        $user = Model::find($id);
        return $this->toUser($user);
    }

    private function toUser(object $object): User
    {
        return new User(
            id: $object->id,
            name: $object->name,
            email: $object->email,
            password: $object->password,
            roleId: $object->roleId,
            account: $object->account ? $this->toAccount($object->account) : null,
            createdAt: $object->created_at,
        );
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
