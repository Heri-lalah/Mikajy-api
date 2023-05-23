<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExpenseController extends Controller
{
    private $expenses;

    private $user;
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {

        //$this->expenses = User::find(Auth::user()->id)->expenses();

        //$this->user = User::find(Auth::user()->id);

    }


    public function index()
    {
        return response()->json(['expense' => $this->expenses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {

        $expense = Expense::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
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
    public function show(Expense $expense)
    {
        return response()->json(['expense' => $expense], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEventRequest $request, string $id)
    {

        $expense = Expense::findOrFail($id);

        $expense->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
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

    /**
     * Remove all resources from storage.
     */
    public function clear(Request $request) {

        if(!Hash::check($request->password, $this->user->password)){
            return response()->json(['message' => 'incorrect password'], 403);
        }

        $this->expenses->each(function($item){
            $item->delete();
        });
        return response()->json(['message' => "success"], 202);
    }
}
