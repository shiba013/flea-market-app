<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOnlyLikedItemsAreDisplayed()
    {
        $user = User::factory()->create();
        $likedItem = Item::factory()->create(['name' => 'ユーザーがいいねした商品']);
        $otherItem = Item::factory()->create(['name' => '他のユーザーの商品']);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);
        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertSee('ユーザーがいいねした商品');
        $response->assertDontSee('他のユーザーの商品');
    }

    public function testSoldItemsAreLabeled()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertSee('Sold');
    }

    public function testUserOwnItemsAreNotDisplayed()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の出品',
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertDontSee('自分の出品');
    }

    public function testGuestCannotAccessMyList()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('テスト商品');
    }
}
