<?php

namespace Tests\Feature;

use App\Models\Income;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class IncomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $user;

    protected $fakeData;

    protected $firstIncomeId;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::first();

        $this->withHeaders(['Accept' => 'application/json']);

        Sanctum::actingAs($this->user, ['*']);

        $this->fakeData =  [
            'name' => fake()->word(),
            'amount' => rand(1,20) * 100,
            'remark' => fake()->paragraph(1),
            'user_id' => $this->user->id
        ];

        $this->firstIncomeId = 1;

    }

    public function test_user_can_get_his_incomes(): void
    {

        $response = $this->get(route('income.index'));

        $response->assertStatus(200);

    }

    public function test_user_can_add_a_new_Income()
    {

        $response = $this->post(route('income.store', $this->fakeData));

        $response->assertCreated();
    }

    public function test_user_can_update_Income()
    {

        $response = $this->put(route('income.update', [
            'Income' => $this->firstIncomeId,
            'name' => $this->fakeData['name'],
            'amount' => $this->fakeData['amount'],
            'remark' => $this->fakeData['remark'],
            'user_id' => $this->fakeData['user_id'],
        ]));

        $response->assertAccepted();
    }

    public function test_user_can_show_Income()
    {

        $response =$this->get(route('income.show', ['Income' => $this->firstIncomeId]));

        $response->assertOk();

    }

    public function test_user_can_destroy_Income()
    {
        $response = $this->delete(route('income.destroy', ['Income' => Income::first()->id]));

        $response->assertAccepted();

    }

    public function test_user_can_clear_all_Income()
    {

        $response =  $this->delete(route('income.clear', ['password' => 'password']));

        $response->assertAccepted();
    }
}
