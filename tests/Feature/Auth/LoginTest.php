<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if User can be logged in
     *
     * @return void
     */
    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    /**
     * Test that User can not be logged in using wrong password
     *
     * @return void
     */
    public function test_user_can_not_login_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);
        
        $this->assertGuest();
    }
}
