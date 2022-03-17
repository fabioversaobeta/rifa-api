<?php

namespace App\Repository;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketRepository {
    private $model;

    public function __construct(Ticket $ticket)
    {
        $this->model = $ticket;

        // parent::__construct((object) $this->tickets);
    }

    public function save($tickets)
    {
        $return = true;
        foreach ($tickets as $key => $ticket) {
            $model = new Ticket();

            $model->fill($ticket);
    
            if (!$model->save()) {
                $return = false;
            }
        }

        return $return;
    }

    public function quantity()
    {
        $response = DB::select('
            SELECT 
                count(1) as total, 
                (
                    SELECT COUNT(DISTINCT t.name) FROM tickets as t GROUP BY t.name
                ) as peoples  
            FROM tickets
        ');

        if (!$response) {
            return false;
        }

        return $response[0];
    }

    public function random()
    {
        $response = $this->model->inRandomOrder()->limit(1)->get();

        if (!$response) {
            return false;
        }

        return $response[0];
    }
}