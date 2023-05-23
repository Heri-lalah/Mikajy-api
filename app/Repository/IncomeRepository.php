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

    public $user;

    public function __construct()
    {
        $this->user = User::find(Auth::user()->id);
    }

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
        return $this->incomes = $this->user->incomes();
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

    public function deleteIncome($id)
    {
        $income = $this->getIncomes()->where('id', $id);

        return $income->delete($income);
    }

    public function clearHisIncomes($request)
    {
        if(!Hash::check($request->password, $this->user->password)){
            return response()->json(['message' => 'incorrect password'], 403);
        }

        return $this->getIncomes()->each(function($item){
            $item->delete();
        });

    }
}
