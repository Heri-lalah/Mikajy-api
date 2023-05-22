<?php

namespace Tests\Feature;

use App\Models\Expense;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class ExpenseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $user;

    protected $fakeData;

    protected $firstExpenseId;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);

        $this->withHeaders(['Accept' => 'application/json']);

        Sanctum::actingAs($this->user, ['*']);

        $this->fakeData =  [
            'name' => fake()->word(),
            'amount' => rand(1,20) * 100,
            'remark' => fake()->paragraph(1),
            'user_id' => Auth::user()->id
        ];

        $this->firstExpenseId = Expense::first()->id;

    }

    public function test_user_can_get_his_expenses(): void
    {

        $response = $this->get(route('expense.index'));

        $response->assertStatus(200);

    }

    public function test_user_can_add_a_new_expense()
    {

        $response = $this->post(route('expense.store', $this->fakeData));

        $response->assertStatus(201);
    }

    public function test_user_can_destroy_expense()
    {
        $response = $this->delete(route('expense.destroy', ['id' => Expense::first()->id]));

        $response->assertStatus(202);

    }

    public function test_user_can_update_expense()
    {

        $response = $this->put(route('expense.update', [
            'expense' => $this->firstExpenseId,
            'name' => $this->fakeData['name'],
            'amount' => $this->fakeData['amount'],
            'remark' => $this->fakeData['remark'],
            'user_id' => $this->fakeData['user_id'],
        ]));

        $response->assertStatus(202);
    }
}
