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
        // $response = DB::select('
        //     SELECT 
        //         count(1) as total, 
        //         COALESCE(
        //             (SELECT COUNT(DISTINCT t.name) FROM tickets as t GROUP BY t.name), 0
        //         ) as peoples  
        //     FROM tickets
        // ');

        $responseTotal = DB::select('SELECT COUNT(1) as total FROM tickets');

        $responsePeoples = DB::select('SELECT COUNT(DISTINCT name) as peoples FROM tickets');

        $total = isset($responseTotal[0]) ? $responseTotal[0] : 0; 
        $peoples = isset($responsePeoples[0]) ? $responsePeoples[0] : 0;

        $response = [
            'total' => $total ? $total->total : 0,
            'peoples' => $peoples ? $peoples->peoples : 0
        ];

        if (!$response) {
            return false;
        }

        return $response;
    }

    public function random()
    {
        $list = $this->model->all();
        $listCount = $list->count();

        if ($listCount == 0) {
            return false;
        }

        $response = $this->model->inRandomOrder()->limit(1)->get();

        if (!isset($response[0])) {
            return false;
        }

        return $response[0];
    }

    public function reset()
    {
        return $this->model::truncate();
    }
}