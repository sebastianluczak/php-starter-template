<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Order;
use App\Domain\Product\ProductSnapshot;

final readonly class OrderCreated
{
    public function __construct(
        public Order $order
    ) {}

    public function getTotalPrice(): float
    {
        return array_sum(
            array_map(
                callback: fn(ProductSnapshot $productSnapshot)
                    => $productSnapshot->currentPrice * $productSnapshot->amount,
                array: $this->order->products
            )
        );
    }
}
