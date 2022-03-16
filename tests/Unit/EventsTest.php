<?php

namespace Tests\Unit;

use App\Classes\AccountClass;
use App\Http\Requests\EventRequest;
use App\Models\Account;
use App\Repository\AccountRepository;
use App\Services\AccountService;
use App\Services\EventService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use DatabaseMigrations;
    
    private $accountModel;
    private $accountRepository;
    private $accountService;

    private $eventService;

    public function __construct()
    {
        parent::__construct();

        $this->accountModel = new Account();
        $this->accountRepository = new AccountRepository($this->accountModel);
        $this->accountService = new AccountService($this->accountRepository);

        $this->eventService = new EventService();
    }

    /** @test */
    public function create_new_account_with_initial_amount()
    {
        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "100",
            'amount' => 10,
        ]);

        $this->accountService->reset();

        $this->eventService->deposit($eventRequest);

        $model = $this->accountService->findAccount(
            $eventRequest->destination
        );

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 10);
    }

    /** @test */
    public function deposit_amount_in_account()
    {
        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "100",
            'amount' => 10,
        ]);

        $this->eventService->deposit($eventRequest);
        
        $model = $this->accountService->findAccount(
            $eventRequest->destination
        );

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 10);
    }

    /** @test */
    public function deposit_amount_in_a_secound_account()
    {
        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "150",
            'amount' => 10,
        ]);

        $this->eventService->deposit($eventRequest);
        
        $model = $this->accountService->findAccount(
            $eventRequest->destination
        );

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 10);
    }

    /** @test */
    public function withdraw_amount_of_exists_account()
    {
        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "500",
            'amount' => 1000,
        ]);

        $this->eventService->deposit($eventRequest);

        $eventRequest = new EventRequest([
            'type' => 'withdraw',
            'origin' => "500",
            'amount' => 1000,
        ]);

        $this->eventService->withdraw($eventRequest);

        $model = $this->accountService->findAccount(
            $eventRequest->origin
        );

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 0);
    }

    /** @test */
    public function withdraw_amount_of_non_exists_account()
    {
        $eventRequest = new EventRequest([
            'type' => 'withdraw',
            'origin' => "600",
            'amount' => 1000,
        ]);

        $hasWithdraw = $this->eventService->withdraw($eventRequest);

        $this->assertFalse($hasWithdraw);
    }

    /** @test */
    public function transfer_amount_of_non_exists_account()
    {
        $eventRequest = new EventRequest([
            'type' => 'transfer',
            'origin' => "100",
            'destination' => 200,
            'amount' => 10,
        ]);

        $transfered = $this->eventService->transfer($eventRequest);

        $this->assertFalse($transfered);
    }

    /** @test */
    public function transfer_amount_of_exists_accounts()
    {
        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "100",
            'amount' => 10,
        ]);

        $this->eventService->deposit($eventRequest);

        $eventRequest = new EventRequest([
            'type' => 'deposit',
            'destination' => "150",
            'amount' => 10,
        ]);

        $this->eventService->deposit($eventRequest);

        $eventRequest = new EventRequest([
            'type' => 'transfer',
            'origin' => "100",
            'destination' => "150",
            'amount' => 10,
        ]);

        $transfered = $this->eventService->transfer($eventRequest);

        $this->assertNotFalse($transfered);

        $model = $this->accountService->findAccount(
            $eventRequest->destination
        );

        $account = new AccountClass($model);

        $this->assertEquals($account->getBalance(), 20);
    }
}
