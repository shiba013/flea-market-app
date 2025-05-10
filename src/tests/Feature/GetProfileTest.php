<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class GetProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
{
    parent::setUp();

    $this->user = User::factory()->create([
        'name' => 'テストユーザー',
        'image' => 'profile_image.jpg',
    ]);

    $this->sellingItem = Item::factory()->create([
        'name' => '出品商品1',
        'user_id' => $this->user->id,
        'is_sold' => false,
    ]);

    $seller = User::factory()->create();
    $this->boughtItem = Item::factory()->create([
        'name' => '購入商品1',
        'user_id' => $seller->id,
        'is_sold' => true,
    ]);

    Order::create([
        'user_id' => $this->user->id,
        'item_id' => $this->boughtItem->id,
        'shipping_post_code' => '123-4567',
        'shipping_address' => '東京都新宿区',
        'shipping_building' => '新宿ビル 101',
        'pay' => 1,
    ]);
}

    public function testUserProfileDisplaysCorrectInfo()
    {
        $response = $this->actingAs($this->user)->get('/mypage');

        $response->assertSee('テストユーザー');
        $response->assertSee('profile_image.jpg');

        $response = $this->actingAs($this->user)->get('/mypage/?tab=sell');
        $response->assertSee('出品商品1');

        $response = $this->actingAs($this->user)->get('/mypage/?tab=buy');
        $response->assertSee('購入商品1');
    }
}
