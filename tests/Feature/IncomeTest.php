<?php
namespace Tests\Feature;

use App\Models\Income;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

class IncomeTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
        Sanctum::actingAs(User::first(), ['*']);
    }

    public function test_user_can_get_his_incomes(): void
    {

        //Arrange
        $incomes = Income::factory(10)->create(["user_id" => User::first()]);

        //Act
        $response = $this->get(route('income.index'));

        //Assert
        $response->assertStatus(200)
                ->assertJson(function(AssertableJson $json){
                    $json->has('incomes', 10);
                });

    }

    public function test_user_can_add_a_new_Income()
    {

        //Arrange
        $income = Income::factory()->make(['user_id' => User::first()]);

        //Act
        $response = $this->post(route('income.store'), $income->toArray());

        //Assert
        $response->assertCreated()
                ->assertJsonPath('income.name', $income->name)
                ->assertJsonPath('income.amount', $income->amount)
                ->assertJsonPath('income.currency', $income->currency)
                ->assertJsonPath('income.remark', $income->remark)
                ->assertJsonPath('income.user_id', $income->user_id);

        $this->assertEquals(1, Income::count());
    }

    public function test_user_can_show_income()
    {

        //Arrange
        $income = Income::factory()->create(['user_id' => User::first()]);

        //Act
        $response = $this->get(route('income.show', ['income' => $income->id]));

        //Assert
        $response->assertOk()
                ->assertJsonPath('income.name', $income->name)
                ->assertJsonPath('income.amount', $income->amount)
                ->assertJsonPath('income.currency', $income->currency)
                ->assertJsonPath('income.remark', $income->remark)
                ->assertJsonPath('income.user_id', $income->user_id);

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

        $response =  $this->delete(route('income.clear'), ['password' => 'password']);

        $response->assertAccepted();
    }
}
