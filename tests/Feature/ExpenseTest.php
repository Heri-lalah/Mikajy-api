<?php

namespace Tests\Feature;

use App\Models\Expense;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        Sanctum::actingAs($this->user, ['*']);
    }

    public function test_user_can_get_his_expenses(): void
    {

        $response = $this->get(route('expense.index'));

        $response->assertStatus(200);

    }


}
