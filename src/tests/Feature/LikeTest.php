<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanAddLike()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function testUserCanRemoveLike()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function testItemDetailDisplaysLikeCount()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $item->likes()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");

        $response->assertSee($item->likes->count());
    }

    public function testLikeIconChangesBasedOnState()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('like-icon');

        $this->actingAs($user)->post("/item/{$item->id}/like");

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('liked');

        $this->actingAs($user)->post("/item/{$item->id}/like");

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertDontSee('liked');
    }

    public function testGuestCannotAddLike()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/like");

        $response->assertRedirect('/login');
    }
}
