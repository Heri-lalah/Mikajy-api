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
    public $user;

    public $fakeData;

    public $firstincomeId;

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
            'currency' => 'Euro',
            'user_id' => $this->user->id
        ];

        $this->firstincomeId = User::find(Auth::user()->id)->incomes()->first()->id;

    }

    public function test_user_can_get_his_incomes(): void
    {

        $response = $this->get(route('income.index'));

        $response->assertStatus(200);

    }

    public function test_user_can_add_a_new_Income()
    {

        $response = $this->post(route('income.store'), $this->fakeData);

        $response->assertCreated();
    }

    public function test_user_can_show_income()
    {

        $response =$this->get(route('income.show', ['income' => $this->firstincomeId]));

        $response->assertOk();

    }

    public function test_user_can_update_income()
    {

        $response = $this->put(route('income.update', ['income' => $this->firstincomeId]), [
            'name' => $this->fakeData['name'],
            'amount' => $this->fakeData['amount'],
            'remark' => $this->fakeData['remark'],
            'currency' => $this->fakeData['currency'],
            'user_id' => $this->fakeData['user_id'],
        ]);

        $response->assertAccepted();
    }

    public function test_user_can_destroy_income()
    {
        $response = $this->delete(route('income.destroy', ['income' => $this->firstincomeId]));

        $response->assertAccepted();

    }

    public function test_user_can_clear_all_income()
    {

        $response =  $this->delete(route('income.clear'), ['password' => 'passwor']);

        $response->assertAccepted();
    }
}
