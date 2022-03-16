<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AccountInterface
{
    public function reset();
    public function getBalance(int $account_id);
    public function createAccount(int $account_id, float $amount);
    public function findAccount(int $account_id);
}