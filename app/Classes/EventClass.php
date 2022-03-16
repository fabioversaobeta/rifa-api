<?php

namespace App\Classes;

use App\Models\Account;

class EventClass {

    public function __construct()
    {
        
    }

    public function deposit($destination, $amount)
    {
        
    }

    public function withdraw($amount)
    {
        $this->balance = $this->balance - $amount;
    }
}