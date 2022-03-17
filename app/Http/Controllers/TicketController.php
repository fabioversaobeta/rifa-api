<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $quantity = $request->quantity;

        $created = $this->ticketService->createTicket($name, $phone, $quantity);

        if ($created) {
            return response('success', 201);
        }

        return response('error', 400);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function randomTicket()
    {
        $ticket = $this->ticketService->getRandomTicket();

        if ($ticket) {
            $headers = ['Content-type'=> 'application/json; charset=utf-8'];
            $json = $this->formatJson($ticket);

            return response($json, 200, $headers);
        }

        return response('error', 404);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quantities()
    {
        $quantities = $this->ticketService->getQuantities();

        if ($quantities) {
            $headers = ['Content-type'=> 'application/json; charset=utf-8'];
            $json = $this->formatJson($quantities);

            return response($json, 200, $headers);
        }

        return response('error', 404);
    }

    private function formatJson($str)
    {
        $strJson = json_encode($str, JSON_PRETTY_PRINT);
        $strJson = preg_replace( "/\r|\n/", "", $strJson);
        $strJson = str_replace("       ", "", $strJson);
        $strJson = str_replace("    ", "", $strJson);
        $strJson = str_replace("{ ", "{", $strJson);

        return $strJson;
    }
}
