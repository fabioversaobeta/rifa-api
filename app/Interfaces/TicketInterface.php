<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface TicketInterface
{
    public function createTicket(string $name, int $phone, int $quantity);
    public function getQuantities();
    public function getRandomTicket();
}