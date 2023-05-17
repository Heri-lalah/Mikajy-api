<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_register()
    {

        //Create
        $user = [
            'name' => fake()->name,
            'pseudo' => fake()->firstName(),
            'phone_number' => Str::random(10),
            'password' => Hash::make('password')
        ];

        //Action
        $response = $this->post('/api/register', $user);

        //Assertion
        $response->assertStatus(201);
    }
}
