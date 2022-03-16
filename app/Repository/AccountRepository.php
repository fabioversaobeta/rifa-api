<?php

namespace App\Repository;

use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountRepository {
    private $model;

    public function __construct(Account $account)
    {
        $this->model = $account;

        // parent::__construct((object) $this->accounts);
    }

    public function delete()
    {
        DB::delete('delete from accounts');
    }

    public function find($id)
    {
        return $this->model->select(['id', 'balance'])->find($id);
    }

    public function save($account_id, $amount)
    {
        $model = new Account;

        $model->id = $account_id;
        $model->balance = $amount;

        return $model->save();
    }

    public function update($account)
    {
        $model = Account::find($account->id);

        $model->balance = $account->balance;

        return $model->update();
    }
}