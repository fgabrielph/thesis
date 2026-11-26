<?php

namespace App\Services;

use App\Item;
use App\Order;
use Illuminate\Support\Facades\DB;

class OrderStockService
{
    /**
     * Deduct stock for an order exactly once.
     */
    public function deductOnce(Order $order): bool
    {
        return DB::transaction(function () use ($order): bool {
            $locked = Order::whereKey($order->getKey())->lockForUpdate()->first();

            if (! $locked || $locked->stock_deducted_at) {
                return false;
            }

            foreach ($locked->suborder as $suborder) {
                Item::whereKey($suborder->item_id)->decrement('stocks', $suborder->quantity);
            }

            $locked->forceFill(['stock_deducted_at' => now()])->save();

            return true;
        });
    }
}
