<?php

namespace App\Services;

use App\Classes\AccountClass;
use App\Interfaces\AccountInterface;
use App\Models\Events;
use App\Repository\AccountRepository;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountService implements AccountInterface {

    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function reset()
    {
        $this->accountRepository->delete();

        $this->accountRepository->save("300", 0);
    }
    
    /**
     * @param  int $account_id
     * @return int $balance
     */
    public function getBalance($account_id)
    {
        if (!is_numeric($account_id)) {
            return false;
        }

        $model = $this->accountRepository->find($account_id);

        if (!$model) {
            return false;
        }

        $account = new AccountClass($model);

        return round($account->getBalance());
    }

    /**
     * @param int $account_id
     * @param float $amount
     * @return \App\Models\Account $model
     */
    public function createAccount($account_id, $amount)
    {
        $account = $this->accountRepository->find($account_id);

        if ($account) {
            return $account;
        }

        if($this->accountRepository->save($account_id, 0)) {
            return $this->accountRepository->find($account_id);
        }

        return false;
    }

    /**
     * @param  int  $account_id
     * @return \App\Models\Account $model
     */
    public function findAccount($account_id)
    {
        return $this->accountRepository->find($account_id);
    }
     
}