<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Classes\AccountClass;
use App\Models\Account;

class AccountClassTest extends TestCase
{
    public function verify_account_id_of_account()
    {
        $model = new Account;
        $model->id = 1234;
        $model->balance = 0;

        $account = new AccountClass($model);

        $this->assertEquals($account->getId(), 1234);
    }

    /** @test */
    public function verify_balance_in_account()
    {
        $model = new Account;
        $model->id = 100;
        $model->balance = 200;

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 200);
    }

    /** @test  */
    public function deposit_amount_in_account()
    {
        $model = new Account;
        $model->id = 100;
        $model->balance = 0;

        $account = new AccountClass($model);

        $account->deposit(10);

        $this->assertEquals($account->getBalance(), 10);
    }

    /** @test */
    public function withdraw_amount_of_account()
    {
        $model = new Account;
        $model->id = 100;
        $model->balance = 500;

        $account = new AccountClass($model);

        $account->withdraw(500);

        $this->assertEquals($account->getBalance(), 0);
    }
}
