<?php

namespace App\Repository;
use App\Models\User;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IncomeRepository
{

    protected static $instance;

    public $incomes;

    /**
     * get the instance of this repository
     */
    public static function getInstance()
    {

        if(self::$instance == null)
        {
            return self::$instance = new IncomeRepository();
        }

        return self::$instance;
    }

    /**
     * Get all incomes associated with this authenticated user
     */
    public function getIncomes()
    {
        return $this->incomes = User::find(Auth::user()->id)->incomes();
    }

    /**
     * Store a new income for this authenticated user
     */
    public function storeIncome($income)
    {

        return $this->getIncomes()->create($income);

    }

    /**
     * show the specified income of this authenticated user
     */
    public function showIncome($income)
    {
        return $this->getIncomes()->where('id', $income);
    }

    /**
     * update the specified income of this authenticated user
     */
    public function updateIncome($data, $id)
    {
        $income = $this->getIncomes()->where('id', $id);

        return $income->update($data);
    }

    /**
     * destroy the specified income of this authenticated user
     */
    public function deleteIncome($id)
    {
        $income = $this->getIncomes()->where('id', $id);

        return $income->delete($income);
    }
}
