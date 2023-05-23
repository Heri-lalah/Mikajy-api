<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Repository\IncomeRepository;
use Illuminate\Support\Facades\Auth;


class IncomeController extends Controller
{
    private $incomeRepository;
    public $user;

    public function __construct()
    {
     //   $this->incomeRepository = IncomeRepository::getInstance();

       // $this->user = User::find(Auth::user());
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
        dd('eto');
        $data = ['name' => $request->name,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'currency' => $request->currency,
        ];


    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
