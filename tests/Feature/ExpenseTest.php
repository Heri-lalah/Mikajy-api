<?php

namespace Tests\Feature;

use App\Models\Expense;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ExpenseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
        Sanctum::actingAs(User::first(), ['*']);
    }

    public function test_user_can_get_his_expenses(): void
    {
        // Arrange
        Expense::factory(10)->create(['user_id' => User::first()]);

        // Act
        $response = $this->get(route('expense.index'));

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(10, 'expense');
    }

    public function test_user_can_add_a_new_expense()
    {
        // Arrange
        $expense = Expense::factory()->make(['user_id' => User::first()]);

        // Act
        $response = $this->post(route('expense.store'), $expense->toArray());

        // Assert
        $response->assertCreated()
            ->assertJsonPath('expense.name', $expense->name)
            ->assertJsonPath('expense.amount', $expense->amount)
            ->assertJsonPath('expense.currency', $expense->currency)
            ->assertJsonPath('expense.remark', $expense->remark)
            ->assertJsonPath('expense.user_id', $expense->user_id);
        $this->assertEquals(1, Expense::count());
    }

    public function test_user_can_update_expense()
    {
        // Arrange
        $expense = Expense::factory()->create(['user_id' => User::first()]);

        // Act
        $response = $this->put(route('expense.update', ['expense' => $expense->id,]), [
            'name' => 'Car',
            'amount' => 1000,
            'currency' => $expense->currency,
            'user_id' => $expense->user_id
        ]);

        // Assert
        $response->assertAccepted();

        $expense->refresh();

        $this->assertEquals($expense->name, 'Car');
        $this->assertEquals($expense->amount, 1000);
    }

    public function test_user_can_show_expense()
    {
        // Arrange
        $expense = Expense::factory()->create(['user_id' => User::first()]);

        // Act
        $response = $this->get(route('expense.show', ['expense' => $expense->id]));

        // Assert
        $response->assertOk()
            ->assertJsonPath('expense.name', $expense->name)
            ->assertJsonPath('expense.amount', $expense->amount)
            ->assertJsonPath('expense.currency', $expense->currency)
            ->assertJsonPath('expense.remark', $expense->remark)
            ->assertJsonPath('expense.user_id', $expense->user_id);
    }

    public function test_user_can_destroy_expense()
    {
        // Arrange
        $expense = Expense::factory()->create(['user_id' => User::first()]);

        // Act
        $response = $this->delete(route('expense.destroy', ['expense' => $expense->id]));

        // Assert
        $response->assertAccepted();
        $this->assertEquals(0, Expense::count());
    }


    public function test_user_can_clear_all_expense()
    {
        // Arrange
        Expense::factory(10)->create(['user_id' => User::first()]);

        // Act
        $response =  $this->delete(route('expense.clear', ['password' => 'password']));

        // Assert
        $response->assertAccepted();
        $this->assertEquals(0, Expense::count());
    }
}
