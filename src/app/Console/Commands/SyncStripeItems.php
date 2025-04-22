<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;

class SyncStripeItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:stripe-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LaravelのproductsとStripeの商品情報を同期する';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $items = Item::whereNull('stripe_item_id')->get();

        foreach ($items as $item) {
            // Stripeに商品を作成
            $stripeItem = StripeProduct::create([
                'name' => $item->name,
                'description' => $item->description ?? '',
            ]);

            // Stripeに価格を作成（単位は「最小単位」＝円なら1円単位）
            $stripePrice = StripePrice::create([
                'unit_amount' => $item->price,
                'currency' => 'jpy',
                'product' => $stripeItem->id,
            ]);

            // 保存
            $item->update([
                'stripe_item_id' => $stripeItem->id,
                'stripe_price_id' => $stripePrice->id,
            ]);

            $this->info("Synced: {$item->name}");
        }
        $this->info('全商品をStripeと同期しました');
    }
}