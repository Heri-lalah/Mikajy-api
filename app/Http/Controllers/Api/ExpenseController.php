<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\User;
use App\Repository\ExpenseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExpenseController extends Controller
{

    protected $expenseRepository;

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->expenseRepository = ExpenseRepository::getInstance();
    }


    public function index()
    {

        $expenses = $this->expenseRepository->getExpenses();

        return response()->json(['expense' => $expenses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {

        $expense = $this->expenseRepository->storeExpense($request);

        return response()->json(['expense' => $expense, 'message' => 'Success'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return response()->json(['expense' => $expense], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEventRequest $request, string $id)
    {

        $updatedExpense = $this->expenseRepository->updateExpense($request, $id);

        return response()->json(['expense' => $updatedExpense, 'message' => 'success'], 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($expense)
    {

        $this->expenseRepository->destroyExpense($expense);

        return response()->json(['message' => 'success'], 202);
    }

    /**
     * Remove all resources from storage.
     */
    public function clear(Request $request)
    {

        if(!Hash::check($request->password, Auth::user()->password)){
            return response()->json(['message' => 'incorrect password'], 403);
        }

        $this->expenseRepository->getExpenses()->each(function($item){
            $item->delete();
        });

        return response()->json(['message' => "success"], 202);
    }
}
