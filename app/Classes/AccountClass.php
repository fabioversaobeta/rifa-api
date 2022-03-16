<?php

namespace App\Classes;

use App\Models\Account;

class AccountClass {
    private $account_id;
    private $balance;

    public function __construct(Account $account)
    {
        $this->account_id = $account->id;
        $this->balance = $account->balance;
    }

    public function getId()
    {
        return $this->account_id;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getResponse()
    {
        return [
            "id" => "".$this->account_id."",
            "balance" => $this->balance
        ];
    }

    public function deposit($amount)
    {
        $this->balance = $this->balance + $amount;
    }

    public function withdraw($amount)
    {
        if ($this->balance < $amount) {
            return false;
        }

        $this->balance = $this->balance - $amount;

        return true;
    }
}