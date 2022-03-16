<?php

namespace App\Services;

use App\Classes\AccountClass;
use App\Interfaces\EventInterface;
use App\Models\Events;
use App\Repository\AccountRepository;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventService implements EventInterface {
    private $accountModel;
    private $accountRepository;
    private $accountService;

    public function __construct()
    {
        $this->accountModel = new Account();
        $this->accountRepository = new AccountRepository($this->accountModel);
        $this->accountService = new AccountService($this->accountRepository);
    }

    /**
     * destination, amount
     */
    public function deposit($request)
    {
        $account = $this->accountRepository->find($request->destination);

        if (!$account) {
            $account = $this->accountService->createAccount(
                $request->destination, 0
            );
        }

        if (!$account) {
            return false;
        }

        $account->balance += $request->amount;

        $this->accountRepository->update($account);

        $accountClass = new AccountClass($account);

        return [
            "destination" => $accountClass->getResponse()
        ];
    }    
    
    /**
     * origin, amount
     */
    public function withdraw($request)
    {
        $account = $this->accountRepository->find($request->origin);

        if (!$account) {
            return false;
        }

        if ($account->balance < $request->amount) {
            return false;
        }

        $account->balance -= $request->amount;

        $this->accountRepository->update($account);

        $accountClass = new AccountClass($account);

        return [
            "origin" => $accountClass->getResponse()
        ];
    }

    /**
     * origin, amount, destination
     */
    public function transfer($request)
    {
        $amount = $request->amount;

        $originAccount = $this->accountRepository->find($request->origin);
        if (!$originAccount) {
            return false;
        }

        $destinationAccount = $this->accountRepository->find(
            $request->destination
        );
        if (!$destinationAccount) {
            return false;
        }

        if ($originAccount->balance < $amount) {
            return false;
        }

        $originAccount->balance -= $amount;
        $destinationAccount->balance += $amount;

        try {
            DB::transaction(function () use (
                $originAccount,
                $destinationAccount
            ) {
                $this->accountRepository->update($originAccount);
                $this->accountRepository->update($destinationAccount);
            });

            $accountClassOrigin = new AccountClass($originAccount);
            $accountClassDestination = new AccountClass($destinationAccount);

            return [
                "origin" => $accountClassOrigin->getResponse(),
                "destination" => $accountClassDestination->getResponse(),
            ];
        } catch (\Throwable $th) {
            return false;
        }
    }
}