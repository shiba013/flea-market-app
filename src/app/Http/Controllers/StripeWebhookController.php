<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid webhook'], 400);
        }
        if ($event->type === 'checkout.session.completed')
        {
            $session = $event->data->object;

            $itemId = $session->metadata->item_id ?? null;
            $userId = $session->metadata->user_id ?? null;

            if (!$itemId || !$userId) {
                return response()->json(['status' => 'missing metadata'], 400);
            }

            $item = Item::find($itemId);
            $user = User::find($userId);

            if (!$item || !$user) {
                return response()->json(['status' => 'item or user not found'], 404);
            }

            $payMethod = (isset($session->metadata->pay) && $session->metadata->pay == 'konbini') ? 1 : 2;

            if (!$item->is_sold) {
                $order = Order::create([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                    'shipping_post_code' => $session->metadata->shipping_post_code,
                    'shipping_address' => $session->metadata->shipping_address,
                    'shipping_building' => $session->metadata->shipping_building,
                    'pay' => $payMethod,
                ]);

                if ($order) {
                    $item->update(['is_sold' => true]);
                }
            }
        }
        return response()->json(['status' => 'received']);
    }
}