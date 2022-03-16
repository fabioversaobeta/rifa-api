<?php

namespace App\Classes;

use App\Models\Ticket;

class TicketClass {
    private $name;
    private $phone;
    private $quantity;

    public function __construct($name, $phone, $quantity)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->quantity = $quantity;
    }

    public function getTickets()
    {
        $tickets = [];

        for ($i=0; $i < $this->quantity; $i++) { 
            $tickets[] = [
                "name" => $this->name,
                "phone" => $this->phone
            ];
        }

        return $tickets;
    }
}