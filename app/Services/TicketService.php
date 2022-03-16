<?php

namespace App\Services;

use App\Classes\TicketClass;
use App\Interfaces\TicketInterface;
use App\Models\Events;
use App\Repository\TicketRepository;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketService implements TicketInterface {

    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @param string $name
     * @param int $phone
     * @param int $quantity
     * @return \App\Models\Account $model
     */
    public function createTicket($name, $phone, $quantity)
    {
        $ticketClass = new TicketClass($name, $phone, $quantity);

        $tickets = $ticketClass->getTickets();

        if ($this->ticketRepository->save($tickets)) {
            return true;
        }

        return false;
    }

    public function getQuantities()
    {
        $quantities = $this->ticketRepository->quantity();

        if (!$quantities) {
            return false;
        }

        return $quantities;
    }

    public function getRandomTicket()
    {
        $randomTicket = $this->ticketRepository->random();

        if (!$randomTicket) {
            return false;
        }

        return $randomTicket;
    }
}