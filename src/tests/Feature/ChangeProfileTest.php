<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ChangeProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProfileEditFormShowsInitialValues()
    {
        $user = User::factory()->create([
            'name' => 'ユーザー名',
            'image' => 'initial_image.jpg',
            'post_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => '渋谷ビル',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSee('initial_image.jpg');
        $response->assertSee('value="ユーザー名"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都渋谷区"', false);
        $response->assertSee('value="渋谷ビル"', false);
    }
}
