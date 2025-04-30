<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItemDetailDisplaysAllRequiredInformation()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'description' => '商品の詳細説明です',
            'price' => 5000,
            'image' => 'dummy.jpg',
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);
        $categories = Category::inRandomOrder()->limit(3)->get();
        $item->categories()->attach($categories);

        $likeUser = User::factory()->create();
        Like::create(['user_id' => $likeUser->id, 'item_id' => $item->id]);

        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);
        Comment::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'コメント内容です',
        ]);
        $response = $this->get("/item/{$item->id}");


        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee($item->description);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->comments->first()->comment);
        $response->assertSee($item->comments->first()->user->name);
        $response->assertSee($categories[0]->name);
        $response->assertSee($categories[1]->name);
        $response->assertSee($categories[2]->name);
        $response->assertSee($condition->name);
        $response->assertSee($item->likes->count());
    }

    public function testItemDetailDisplaysMultipleCategories()
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'description' => '商品の詳細説明です',
            'price' => 5000,
            'condition_id' => $condition->id,
            'user_id' => $user->id,
        ]);

        $categories = Category::inRandomOrder()->limit(3)->get();
        $item->categories()->attach($categories);

        $response = $this->get("/item/{$item->id}");

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
