<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Mockery;
use Stripe\Checkout\Session as StripeSession;

class OrderTest extends TestCase
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

    public function testStoreCreatesStripeCheckoutSessionAndRedirects()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'stripe_price_id' => 'price_test_123',
        ]);

        $mock = Mockery::mock('alias:' . StripeSession::class);
        $mock->shouldReceive('create')
            ->once()
            ->andReturn((object)[
                'url' => 'https://checkout.stripe.com/test-session',
            ]);
        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'pay' => 1,
        ]);
        $response->assertRedirect('https://checkout.stripe.com/test-session');
    }

    public function testPurchasedItemShowsSoldLabelInList()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);

        $response = $this->actingAs($user)->get('/?status=success');

        $response->assertSee('sold');
    }

    public function testPurchasedItemAppearsInUserProfile()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);
        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_post_code' => '123-4567',
            'shipping_address' => '東京都渋谷区',
            'shipping_building' => '渋谷ビル',
            'pay' => 1,
        ]);

        $response = $this->actingAs($user)->get('/mypage?tab=buy');

        $response->assertSee($item->name);
    }
}
