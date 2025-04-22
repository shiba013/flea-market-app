<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Webhook;


class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid webhook'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $itemId = $session->metadata->item_id ?? null;
            $userId = $session->metadata->user_id ?? null;

            $item = Item::find($itemId);
            $user = User::find($userId);

            if (isset($session->metadata->pay) && $session->metadata->pay == 'konbini') {
                $payMethod = 1;
            } else {
                $payMethod = 2;
            }

            if (!$item->is_sold) {
                Order::create([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                    'shipping_post_code' => $session->metadata->shipping_post_code,
                    'shipping_address' => $session->metadata->shipping_address,
                    'shipping_building' => $session->metadata->shipping_building,
                    'pay' => $payMethod,
                ]);
                $item->update(['is_sold' => true]);
            }
        }
        return response()->json(['status' => 'received']);
    }
}
