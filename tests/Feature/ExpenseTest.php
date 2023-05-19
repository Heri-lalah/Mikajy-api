<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_get_expense(): void
    {
        $response = $this->get('api/expense');

        $response->assertStatus(200);
    }
}
