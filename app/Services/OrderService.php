<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderAddresses;
use App\Models\Cart;
use App\Models\Address;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class OrderService
{
    /**
     * Save order to database
     */
    public static function saveOrder($subtotal, $shippingCost, $total, string $status='pending', string $shippingType='standard'): Order
    {
        $order = Order::create([
            'order_number' => self::generateOrderNumber(),
            'customer_id' => Auth::user()->id,
            'status' => $status,
            'subtotal' => $subtotal,
            'shipping' => $shippingCost,
            'total' => $total,
            'shipping_type' => $shippingType,
        ]);

        return $order;
    }

    /**
     * Save order products to database
     */
    public static function saveOrderProducts(int $orderId, Collection $cartItems): void
    {
        foreach ($cartItems as $item) {
            OrderProduct::create([
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'color_id' => $item->color_id,
                'size_id' => $item->size_id,
                'nb_of_items' => 1, //for now, number of items is always 1. Could be changed later if needed
                'org_price' => number_format($item->product->price, 2),
                'percentage_off' => $item->product->bestDeal()->first()->percentage_off ?? 0,
                'price' => number_format($item->product->getPriceAfterDeal(), 2),
                'quantity' => $item->quantity,
            ]);
        }
    }

    /**
     * Save order address to database
     */
    public static function saveOrderAddress(int $orderId, array $addressData): void
    {
        $streetInfo['street'] = $addressData['street'] ?? '';
        $streetInfo['city'] = $addressData['city'] ?? '';
        $streetInfo['province'] = $addressData['province'] ?? '';
        $streetInfo['postal_code'] = $addressData['postal_code'] ?? '';
        $streetInfo['country'] = $addressData['country'] ?? 'Canada';

        if (!empty($addressData['address_id'])) {
            // Fetch address from user's saved addresses
            $address = Address::where('id', $addressData['address_id'])->first();
            
            if ($address) {
                $streetInfo['street'] = $address->street;
                $streetInfo['city'] = $address->city;
                $streetInfo['province'] = $address->province;
                $streetInfo['postal_code'] = $address->postal_code;
                $streetInfo['country'] = $address->country;
            } else {
                // Address ID provided but not found
                throw new \Exception('Address not found.');
            }
            
        }

        OrderAddresses::create([
            'order_id' => $orderId,
            'first_name' => $addressData['first_name'],
            'last_name' => $addressData['last_name'],
            'type' => $addressData['type'] ?? 'mailing',
            'street' => $streetInfo['street'],
            'city' => $streetInfo['city'],
            'province' => $streetInfo['province'],
            'postal_code' => $streetInfo['postal_code'],
            'country' => $streetInfo['country'],
            'phone_number' => $addressData['phone_number'],
        ]);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber(): string
    {
        $year = now()->year;

        return 'LR-' . $year . '-' . strtoupper(uniqid());
    }
}
