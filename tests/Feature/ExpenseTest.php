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

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);

        $this->withHeaders(['Accept' => 'application/json']);

        Sanctum::actingAs($this->user, ['*']);
    }

    public function test_user_can_get_his_expenses(): void
    {

        $response = $this->get(route('expense.index'));

        $response->assertStatus(200);

    }

    public function test_user_can_add_a_new_expense()
    {

        $data = [
            'name' => fake()->word(),
            'amount' => 1000,
            'remark' => fake()->paragraph(1),
            'user_id' => Auth::user()->id
        ];

        $response = $this->post(route('expense.store', $data));

        $response->assertStatus(201);
    }
}
