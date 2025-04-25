<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;

class HelloTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //vendor/bin/phpunit tests/Feature/HelloTest.php
/*
    public function testValue()
    {
        $this->assertTrue(true);

        $arr = [];
        $this->assertEmpty($arr);

        $txt = "Hello World";
        $this->assertEquals('Hello World', $txt);

        $n = random_int(0, 100);
        $this->assertLessThan(100, $n);
    }

    public function testResponse()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/no_route');
        $response->assertStatus(404);
    }
*/
    public function testDatabase()
    {
        Comment::factory()->create([
            'item_id'=>1,
            'user_id'=>1,
            'comment'=>'commentTest12345',
        ]);

        $this->assertDatabaseHas('comments',[
            'name'=>1,
            'email'=>1,
            'password'=>'commentTest12345',
        ]);

        User::factory()->create([
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345'
        ]);

        $this->assertDatabaseHas('users',[
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345',
        ]);
    }

}
