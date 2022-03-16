<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Repository\AccountRepository;
use App\Services\AccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseMigrations;
    
    private $accountModel;
    private $accountRepository;
    private $accountService;

    public function __construct()
    {
        parent::__construct();

        $this->accountModel = new Account();
        $this->accountRepository = new AccountRepository($this->accountModel);
        $this->accountService = new AccountService($this->accountRepository);
    }
    /** @test */
    public function create_new_account()
    {
        $this->accountService->reset();

        $createdAccount = $this->accountService
            ->createAccount("125", 0) ? true : false;

        $this->assertTrue($createdAccount);
    }

    /** @test */
    public function get_balance_account()
    {
        $accountService = new AccountService(new AccountRepository(new Account()));
        $accountService->reset();

        $balance = $accountService->getBalance(300);

        $this->assertEquals($balance, 0);
    }
}
