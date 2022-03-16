<?php

namespace App\Interfaces;

use App\Http\Requests\EventRequest;

interface EventInterface
{
    public function deposit(EventRequest $request);
    public function withdraw(EventRequest $request);
    public function transfer(EventRequest $request);
}