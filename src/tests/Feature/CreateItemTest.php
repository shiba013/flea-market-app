<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Category;

class CreateItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCreateNewItemWithValidData()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);
        $categoryIds = $item->categories->pluck('id')->toArray();

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'description' => $item->description,
            'price' => $item->price,
            'condition_id' => $condition->id,
            'category_ids' => $categoryIds,
            'image' => $item->image,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => $item->description,
            'price' => $item->price,
            'condition_id' => $condition->id,
            'image' => $item->image,
            'user_id' => $user->id,
        ]);

        $itemId = Item::where('name', 'テスト商品')->value('id');
        foreach ($categoryIds as $categoryId) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $itemId,
                'category_id' => $categoryId,
            ]);
        }
        $response->assertRedirect('/');
    }
}
