<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Mockery;
use Stripe\Checkout\Session as StripeSession;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testKonbiniPaymentIsReflectedInMetadata()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'stripe_price_id' => 'price_test_123',
        ]);

        $mock = Mockery::mock('overload:' . StripeSession::class);
        $mock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg)
            {
                return isset($arg['metadata']['pay']) && $arg['metadata']['pay'] === 'konbini';
            }))
            ->andReturn((object)[
                'url' => 'https://checkout.stripe.com/test-session',
            ]);

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'pay' => 1,
        ]);

        $response->assertRedirect('https://checkout.stripe.com/test-session');
    }

    public function testCardPaymentIsReflectedInMetadata()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'stripe_price_id' => 'price_test_123',
        ]);

        $mock = Mockery::mock('overload:' . StripeSession::class);
        $mock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg)
            {
                return isset($arg['metadata']['pay']) && $arg['metadata']['pay'] === 'card';
            }))
            ->andReturn((object)[
                'url' => 'https://checkout.stripe.com/test-session',
            ]);

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'pay' => 2,
        ]);

        $response->assertRedirect('https://checkout.stripe.com/test-session');
    }
}
