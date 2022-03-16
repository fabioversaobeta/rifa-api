<?php

namespace App\Repository;

use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountRepositoryFake {
    private $model;
    private $db;

    public function __construct(Account $account)
    {
        $this->model = $account;

        // parent::__construct((object) $this->accounts);
    }

    public function delete()
    {
        $this->db = [];
    }

    public function find($id)
    {
        $account = null;

        foreach ($this->db as $key => $value) {
            if ($value->id == $id) {
                $account = $value;
            }
        }

        return $account;
    }

    public function save($account_id, $amount)
    {
        $model = new Account;

        $model->id = $account_id;
        $model->balance = $amount;

        $this->db[] = $model;
    }

    public function update($account)
    {
        $newDb = [];

        foreach ($this->db as $key => $value) {
            if ($value->id == $account->id) {
                $value = $account;
            }

            $newDb[] = $value;
        }

        $this->db = $newDb;      
    }
}