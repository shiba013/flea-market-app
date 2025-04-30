<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItemsCanBeSearchedByPartialName()
    {
        $user = User::factory()->create();

        Item::factory()->create(['name' => 'おしゃれなバッグ']);
        Item::factory()->create(['name' => '高級時計']);

        $response = $this->actingAs($user)->get('/search?keyword=バッグ');

        $response->assertSee('おしゃれなバッグ');
        $response->assertDontSee('高級時計');
    }

    public function testSearchKeywordIsRetainedInMyListTab()
    {
        $user = User::factory()->create();

        $matchingItem = Item::factory()->create(['name' => 'デジタルカメラ']);
        $nonMatchingItem = Item::factory()->create(['name' => 'ノートパソコン']);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $matchingItem->id,
        ]);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $nonMatchingItem->id,
        ]);

        $response = $this->actingAs($user)->get('/search?tab=mylist&keyword=カメラ');

        $response->assertSee('デジタルカメラ');
        $response->assertDontSee('ノートパソコン');
        $response->assertSee('value="カメラ"', false);
    }
}
