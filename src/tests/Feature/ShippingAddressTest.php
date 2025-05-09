<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Mockery;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook as StripeWebhook;

class ShippingAddressTest extends TestCase
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

    public function testShippingAddressIsReflectedInPurchaseSession()
    {
        $user = User::factory()->create([
            'post_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => '新宿ビル 101',
        ]);

        $item = Item::factory()->create([
            'stripe_price_id' => 'price_test_123',
        ]);

        $mock = Mockery::mock('overload:' . StripeSession::class);
        $mock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user)
            {
                return $arg['metadata']['shipping_post_code'] === $user->post_code &&
                $arg['metadata']['shipping_address'] === $user->address &&
                $arg['metadata']['shipping_building'] === $user->building;
            }))
            ->andReturn((object)['url' => 'https://checkout.stripe.com/test-session']);

        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'pay' => 1,
        ]);

        $response->assertRedirect('https://checkout.stripe.com/test-session');
    }

    public function testOrderSavesShippingAddress()
    {
        $user = User::factory()->create([
            'post_code' => '987-6543',
            'address' => '大阪市中央区',
            'building' => '大阪ビル 202',
        ]);

        $item = Item::factory()->create([
            'stripe_price_id' => 'price_test_456',
            'is_sold' => false,
        ]);

        session([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'shipping_post_code' => $user->post_code,
            'shipping_address' => $user->address,
            'shipping_building' => $user->building,
            'pay' => 1,
        ]);

        $payload = [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'metadata' => [
                        'user_id' => $user->id,
                        'item_id' => $item->id,
                        'shipping_post_code' => $user->post_code,
                        'shipping_address' => $user->address,
                        'shipping_building' => $user->building,
                        'pay' => 'konbini',
                    ],
                ],
            ],
        ];

        $mockEvent = (object) $payload;

        Mockery::mock('alias:' . StripeWebhook::class)
            ->shouldReceive('constructEvent')
            ->once()
            ->andReturn((object)[
                'type' => 'checkout.session.completed',
                'data' => (object)[
                    'object' => (object)[
                        'metadata' => (object)[
                            'user_id' => $user->id,
                            'item_id' => $item->id,
                            'shipping_post_code' => $user->post_code,
                            'shipping_address' => $user->address,
                            'shipping_building' => $user->building,
                            'pay' => 'konbini',
                        ],
                    ],
                ],
            ]);

        $response = $this->post('/stripe/webhook', [], [
            'Stripe-Signature' => 'test_signature',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_post_code' => $user->post_code,
            'shipping_address' => $user->address,
            'shipping_building' => $user->building,
            'pay' => 1,
        ]);
    }
}
