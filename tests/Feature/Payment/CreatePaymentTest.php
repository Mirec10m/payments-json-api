<?php

namespace Tests\Feature\Payment;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if Payment can be created.
     */
    public function test_payment_can_be_created(): void
    {
        $user = User::factory()->create();
        $data = Payment::factory()->raw();

        Sanctum::actingAs($user);

        $response = $this->post('/api/payments', $data);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'amount' => $data['amount'],
                'currency' => $data['currency'],
            ],
        ]);
    }
}
