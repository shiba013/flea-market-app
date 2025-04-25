<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session;


class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        Log::info('Received Webhook', ['payload' => $payload]);

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid webhook'], 400);
        }

        if ($event->type === 'checkout.session.completed')
        {
            $session = $event->data->object;

            $itemId = $session->metadata->item_id ?? null;
            $userId = $session->metadata->user_id ?? null;

            Log::info('Received event data', [
                'item_id' => $itemId,
                'user_id' => $userId,
                'session_metadata' => $session->metadata
            ]);

            if (!$itemId || !$userId) {
                Log::error("Missing item_id or user_id in session metadata");
                return response()->json(['status' => 'missing metadata'], 400);
            }

            $item = Item::find($itemId);
            $user = User::find($userId);

            if (!$item) {
                Log::error("Item not found: {$itemId}");
                return response()->json(['status' => 'item not found'], 404);
            }

            if (!$user) {
                Log::error("User not found: {$userId}");
                return response()->json(['status' => 'user not found'], 404);
            }

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
                Log::info("Order completed: item_id={$itemId}");
            } else {
                Log::info("Item already sold: item_id={$itemId}");
            }
        }
        return response()->json(['status' => 'received']);
    }
}