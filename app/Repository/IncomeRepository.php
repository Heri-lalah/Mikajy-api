<?php

namespace App\Repository;
use App\Models\Income;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncomeRepository
{

    protected static $instance;
    public $incomes;

    public static function getInstance()
    {

        if(self::$instance == null)
        {
            return self::$instance = new IncomeRepository();
        }

        return self::$instance;
    }

    public function getIncomes()
    {
        return $this->incomes = User::find(Auth::user()->id)->incomes();
    }

    public function setIncome(array $income)
    {

        $this->incomes->create($income);

        return $this->incomes = $this->getIncomes();
    }
}
