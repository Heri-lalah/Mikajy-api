<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $expenses;

    public function __construct()
    {
        $this->expenses = User::with('expenses')->find(Auth::user());
    }


    public function index()
    {
        return response()->json(['expense' => $this->expenses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {

        $expense = Expense::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'expense' => $expense,
            'message' => 'Success'
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreExpenseRequest $request, string $id)
    {

        $expense = Expense::findOrFail($id);

        $expense->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['message' => 'success'], 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($expense)
    {

        $expense = Expense::findOrFail($expense);

        $expense->delete();

        return response()->json(['message' => 'success'], 202);
    }
}
