<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceAccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Reset all data
     */
    public function reset()
    {
        $this->accountService->reset();

        return response('OK', 200);
    }

    /**
     * Get Balance of user
     * 
     * @param  \App\Http\Requests\BalanceAccountRequest
     * @return \Illuminate\Http\Response
     */
    public function balance(BalanceAccountRequest $request)
    {
        $balance = $this->accountService->getBalance($request->account_id);
        
        if ($balance === false) {
            return response(0, 404);
        }

        return response($balance, 200);
    }
}
