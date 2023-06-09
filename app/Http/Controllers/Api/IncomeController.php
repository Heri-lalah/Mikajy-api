<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\IncomeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreEventRequest;


class IncomeController extends Controller
{

    protected $incomeRepository;

    protected $user;

    public function __construct()
    {
        $this->incomeRepository = IncomeRepository::getInstance();

        $this->user = User::find(Auth::user()->id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = $this->incomeRepository->getIncomes()->get();

        return response()->json(['incomes' => $incomes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = [
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
        ];

        $this->incomeRepository->storeIncome($data);

        return response()->json($this->incomeRepository->getIncomes(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->incomeRepository->showIncome($id);

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEventRequest $request, string $id)
    {
        $data = [
            'name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
        ];

        $updatedData = $this->incomeRepository->updateIncome($data, $id);

        return response()->json($updatedData, 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->incomeRepository->deleteIncome($id);

        return response()->json(['message', 'success'], 202);
    }

    /**
     * Remove all resources from storage.
     */
    public function clear(Request $request)
    {

        if(!Hash::check($request->password, $this->user->password)){
            return response()->json(['message' => 'incorrect password'], 403);
        }

        $this->incomeRepository->getIncomes()->each(function($item){
            $item->delete();
        });

        return response()->json(['message' => 'success'], 202);
    }
}
