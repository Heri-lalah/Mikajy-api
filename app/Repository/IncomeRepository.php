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

    public function storeIncome($income)
    {

        return $this->getIncomes()->create($income);

    }

    public function showIncome($income)
    {
        return $this->getIncomes()->where('id', $income);
    }

    public function updateIncome($data, $id)
    {
        $income = $this->getIncomes()->where('id', $id);

        return $income->update($data);
    }
}
