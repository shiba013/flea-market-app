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
    protected $description = 'LaravelのitemsとStripeの商品情報を同期する';

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
        Stripe::setApiKey(config('services.stripe.secret'));
        $items = Item::whereNull('stripe_item_id')->get();

        foreach ($items as $item) {
            $stripeItem = StripeProduct::create([
                'name' => $item->name,
                'description' => $item->description ?? '',
            ]);

            $stripePrice = StripePrice::create([
                'unit_amount' => $item->price,
                'currency' => 'jpy',
                'product' => $stripeItem->id,
            ]);

            $item->update([
                'stripe_item_id' => $stripeItem->id,
                'stripe_price_id' => $stripePrice->id,
            ]);

            $this->info("Synced: {$item->name}");
        }
        $this->info('全商品をStripeと同期しました');
    }
}