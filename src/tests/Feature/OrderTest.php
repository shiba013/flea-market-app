<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Stripe\StripeClient;
use Mockery;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsRedirectedToStripeCheckout()
{
    $user = User::factory()->create();
    $item = Item::factory()->create(['price' => 1000]);

    // セッションレスポンスのモック
    $mockSession = (object)['url' => 'https://checkout.stripe.com/test_session_url'];

    // checkout.sessions->create() のモック
    $mockCheckoutSession = Mockery::mock();
    $mockCheckoutSession->shouldReceive('create')->once()->andReturn($mockSession);

    $mockStripe = Mockery::mock(StripeClient::class);
    $mockStripe->checkout = (object)[
        'sessions' => $mockCheckoutSession
    ];

    $this->app->instance(StripeClient::class, $mockStripe);

    $response = $this->actingAs($user)->post("/item/{$item->id}/purchase");

    $response->assertRedirect('https://checkout.stripe.com/test_session_url');
}

    public function testPurchasedItemShowsSoldLabelInList()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);

        $response = $this->actingAs($user)->get('/items');

        $response->assertSee('sold');
    }

    public function testPurchasedItemAppearsInUserProfile()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee($item->name); // 商品名などで確認
    }
}
