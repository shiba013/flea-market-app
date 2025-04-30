<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;
use App\Models\Category;

class ItemFactory extends Factory
{

    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        $categories = [
            'ファッション', '家電', 'インテリア', 'レディース', 'メンズ',
            'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン',
            'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'
        ];
        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }

        return [
            'name' => Str::limit($this->faker->word(), 50),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 10000),
            'image' => 'dummy.jpg',
            'is_sold' => false,
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            $categoryIds = Category::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id');

            $item->categories()->attach($categoryIds);
        });
    }
}
