<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExpenseRepository
{

    protected static $instance;

    /**
     * get the instance of this repository
     */
    public static function getInstance()
    {

        if(!self::$instance){
            return self::$instance = new ExpenseRepository();
        }

        return self::$instance;
    }

    /**
     * get all expenses associated of this authenticated user
     */
    public function getExpenses()
    {
        return User::find(Auth::user()->id)->expenses();
    }

    /**
     * store a new expense for this authenticated user
     */
    public function storeExpense($expense)
    {
        $data = [
            'name' => $expense->name,
            'amount' => $expense->amount,
            'remark' => $expense->remark,
            'currency' => $expense->currency,
        ];

        return $this->getExpenses()->create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateExpense($request, $id)
    {

        $expense = $this->getExpenses()->where('id', $id);

        return $expense->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
        ]);

    }

    /**
     * destroy the specified resource in storage
     */
    public function destroyExpense($id)
    {
        return $this->getExpenses()->where('id', $id)->delete();
    }
}
