<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Income;
use App\Repository\IncomeRepository;
use Illuminate\Support\Facades\Auth;


class IncomeController extends Controller
{

    protected $incomeRepository;

    public function __construct()
    {
        $this->incomeRepository = IncomeRepository::getInstance();

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = $this->incomeRepository->getIncomes();

        return response()->json($incomes, 200);
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
        //
    }
}
