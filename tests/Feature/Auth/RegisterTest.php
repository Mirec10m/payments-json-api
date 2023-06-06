<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if User can be registered
     *
     * @return void
     */
    public function test_new_user_can_be_registered(): void
    {
        $response = $this->post('/api/auth/register', [
            'name' => 'Test user',
            'email' => 'test.user@test.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'name' => 'Test user',
                'email' => 'test.user@test.com',
            ]
        ]);
    }
}
