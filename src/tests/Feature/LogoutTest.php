<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanLogout()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
