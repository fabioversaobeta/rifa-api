<?php

namespace Tests\Unit;

use App\Http\Requests\TicketRequest;
use App\Classes\TicketClass;
use App\Services\TicketService;
use App\Repository\TicketRepository;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

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

        $this->accountModel = new Ticket();
        $this->accountRepository = new TicketRepository($this->accountModel);
        $this->accountService = new TicketService($this->accountRepository);
    }

    /** @test */
    public function create_new_account_with_initial_amount()
    {
        $eventRequest = new TicketRequest([
            'name' => 'Fabio Bandacheski',
            'phone' => "41984395789",
            'quantity' => 1,
        ]);

        $name = $eventRequest->name;
        $phone = $eventRequest->phone;
        $quantity = $eventRequest->quantity;

        $response = $this->ticketService->createTicket($name, $phone, $quantity);

        $this->assertTrue($response);

        // $this->assertEquals($account->getBalance(), 10);
    }
}