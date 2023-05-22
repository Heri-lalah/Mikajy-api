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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
