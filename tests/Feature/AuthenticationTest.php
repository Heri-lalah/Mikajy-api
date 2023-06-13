<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_register()
    {

        //Arrange
        $password = Hash::make('password');

        $user = [
            'name' => fake()->name(),
            'pseudo' => fake()->firstName(),
            'phone_number' => Str::random(10),
            'password' => $password,
            'password_confirmation' => $password
        ];

        //Act
        $response = $this->post('api/register', $user);


        //Assert
        $response->assertStatus(201);
        $this->assertAuthenticatedAs(Auth::user($user));
        $this->assertEquals($user['name'], Auth::user()->name);
        $this->assertEquals($user['pseudo'], Auth::user()->pseudo);
    }

    public function test_user_can_login()
    {
        //Arrange
        $userFactory = User::factory()->create();
        $user = User::first()->only(['pseudo']);
        $user['password'] = 'password';

        //Act
        $response = $this->post('api/login', $user);

        //Assert
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($userFactory);
        $this->assertEquals($userFactory->name, Auth::user()->name);
        $this->assertEquals($userFactory->pseudo, Auth::user()->pseudo);
    }
}
