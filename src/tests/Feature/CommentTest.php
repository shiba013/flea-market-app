<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoggedInUserCanSendComment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);
        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'これはテストコメントです。'
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'これはテストコメントです。'
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('これはテストコメントです。');
        $response->assertSee($item->comments->count());
    }

    public function testGuestCannotSendComment()
    {
        $item = Item::factory()->create();
        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'これはログインしていないユーザーのコメントです。'
        ]);

        $this->assertDatabaseMissing('comments', [
            'comment' => 'これはログインしていないユーザーのコメントです。'
        ]);

        $response->assertRedirect('/login');
    }

    public function testValidationErrorWhenCommentIsEmpty()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function testValidationErrorWhenCommentExceeds255Characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => str_repeat('a', 256)
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function testCommentIconChangesWhenCommented()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'comment' => 'This is a comment.',
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");
        $response->assertSee('comment-icon');
    }
}
