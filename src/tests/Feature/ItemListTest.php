<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;


class ItemListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAllItemsAreDisplayed()
    {
        Item::factory()->count(5)->create([
            'is_sold' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function testSoldItemsAreLabeled()
    {
        $soldItem = Item::factory()->create([
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    public function testUserOwnItemsAreNotDisplayed()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $visibleItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
