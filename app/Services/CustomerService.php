<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stall;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    /**
     * Retrieves the authenticated user's orders with related products and stall,
     * sorted from most recent to oldest.
     */
    public function getOrdersCustomer()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['products', 'stall'])
            ->orderBy('order_date', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->numberProducts = $order->products->count();
            $order->stallName = $order->stall->name;
            $order->totalPriceProducts = $order->products->sum(
                fn($product) => $product->pivot->quantity * $product->pivot->price_per_unit
            );
        }

        return $orders;
    }

    /**
     * Retrieves cart product data grouped by stall.
     */
    public function getCartProducts(array $cartItems): array
    {
        $productIds = array_column($cartItems, 'product_id');
        $stallIds = array_column($cartItems, 'stall_id');

        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $stalls = Stall::with(['products' => fn($q) => $q->whereIn('product_id', $productIds)])
            ->whereIn('id', $stallIds)
            ->get()
            ->keyBy('id');

        $groupedByStall = [];

        foreach ($cartItems as $item) {
            $product = $products->get($item['product_id']);
            $stall = $stalls->get($item['stall_id']);

            if (!$product || !$stall) {
                continue;
            }

            $pivot = $stall->products->firstWhere('id', $product->id);

            if (!$pivot) {
                continue;
            }

            $stallId = $stall->id;
            $groupedByStall[$stallId] ??= [
                'stall' => ['id' => $stall->id, 'name' => $stall->name],
                'products' => [],
            ];

            $groupedByStall[$stallId]['products'][] = [
                'product' => ['id' => $product->id, 'name' => $product->name, 'unit' => $product->unit],
                'price_per_unit' => $pivot->pivot->price_per_unit,
                'quantity' => $item['quantity'] ?? 1,
                'stock_quantity' => $pivot->pivot->quantity,
            ];
        }

        return array_values($groupedByStall);
    }

    /**
     * Creates orders grouped by stall after validating stock availability.
     * Validate all stock first, then create all orders.
     */
    public function createOrder(array $cartItems): array
    {
        $user = Auth::user();
        $insufficientProducts = [];
        $ordersCreated = [];

        $groupedItems = collect($cartItems)->groupBy('stall_id');

        // Pre-load all products to avoid repeated queries
        $productIds = collect($cartItems)->pluck('product_id')->unique()->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        DB::transaction(function () use ($groupedItems, $user, $products, &$insufficientProducts, &$ordersCreated) {

            // ── Pass 1: Validate all stock across all stalls before creating anything ──
            foreach ($groupedItems as $stallId => $items) {
                $stall = Stall::find($stallId);

                if (!$stall) {
                    throw new \Exception("Puesto no encontrado: {$stallId}");
                }

                $stallProductIds = $items->pluck('product_id')->all();

                $pivots = $stall->products()
                    ->whereIn('product_id', $stallProductIds)
                    ->get()
                    ->keyBy('id');

                foreach ($items as $item) {
                    $product = $products->get($item['product_id']);

                    if (!$product) {
                        throw new \Exception("Producto no encontrado: {$item['product_id']}");
                    }

                    $pivot = $pivots->get($product->id);

                    if (!$pivot) {
                        throw new \Exception("Producto {$product->name} no disponible en este puesto");
                    }

                    $available = $pivot->pivot->quantity;
                    $requested = $item['quantity'] ?? 1;

                    if ($requested > $available) {
                        $insufficientProducts[] = [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'stall_id' => $stall->id,
                            'stall_name' => $stall->name,
                            'requested' => $requested,
                            'available' => $available,
                        ];
                    }
                }
            }

            // Bail out early if any product has insufficient stock —
            // before a single order is created.
            if (!empty($insufficientProducts)) {
                throw new \Exception('Insufficient stock');
            }

            // ── Pass 2: All stock is confirmed — create orders and decrement stock ──
            foreach ($groupedItems as $stallId => $items) {
                $stall = Stall::find($stallId);

                $stallProductIds = $items->pluck('product_id')->all();

                // Lock rows for update to prevent race conditions
                $pivots = $stall->products()
                    ->whereIn('product_id', $stallProductIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $order = Order::create([
                    'user_id' => $user->id,
                    'stall_id' => $stallId,
                    'order_date' => now(),
                    'completed' => false,
                ]);

                foreach ($items as $item) {
                    $product = $products->get($item['product_id']);
                    $pivot = $pivots->get($product->id);
                    $quantity = $item['quantity'] ?? 1;

                    $order->products()->attach($product->id, [
                        'quantity' => $quantity,
                        'price_per_unit' => $pivot->pivot->price_per_unit,
                        'status' => 'Pendiente',
                    ]);

                    $stall->products()->updateExistingPivot($product->id, [
                        'quantity' => $pivot->pivot->quantity - $quantity,
                    ]);
                }

                $ordersCreated[] = $order;
            }
        });

        if (!empty($insufficientProducts)) {
            return [
                'success' => false,
                'message' => 'Not enough stock for some products',
                'insufficient_products' => $insufficientProducts,
            ];
        }

        return [
            'success' => true,
            'message' => 'Orders created succesfully',
            'orders' => $ordersCreated,
        ];
    }
}