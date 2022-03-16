<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventDepositRequest;
use App\Http\Requests\EventRequest;
use App\Http\Requests\EventTransferRequest;
use App\Http\Requests\EventWithdrawRequest;
use App\Services\AccountService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    protected $eventService;
    protected $accountService;
    
    public function __construct(
        EventService $eventService,
        AccountService $accountService
    )
    {
        $this->eventService = $eventService;
        $this->accountService = $accountService;
    }

    /**
     * Events of Accounts
     *
     * @param  \App\Http\Requests\EventRequest $request
     * @return \Illuminate\Http\Response
     */
    public function event(EventRequest $request)
    {
        switch ($request->type) {
            case 'deposit':
                $return = $this->deposit($request);
                break;

            case 'withdraw':
                $return = $this->withdraw($request);
                break;    
            
            case 'transfer':
                $return = $this->transfer($request);
                break;          
    
            default:
                $return = false;
                break;
        }

        if (!$return) {
            return response(0, 404);
        }

        $headers = ['Content-type'=> 'application/json; charset=utf-8'];
        $strJson = $this->formatJson($return);

        return response($strJson, 201, $headers);
    }

    /**
     * type, destination, amount
     */
    private function deposit(EventRequest $request)
    {
        return $this->eventService->deposit($request);
    }

    /**
     * type, origin, amount
     */
    private function withdraw(EventRequest $request)
    {
        return $this->eventService->withdraw($request);
    }

    /**
     * type, origin, amount, destination
     */
    private function transfer(EventRequest $request)
    {
        return $this->eventService->transfer($request);
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
