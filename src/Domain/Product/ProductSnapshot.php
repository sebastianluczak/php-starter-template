<?php

declare(strict_types=1);

namespace App\Domain\Product;

use Exception;

final readonly class ProductSnapshot
{
    public function __construct(
        public Product $product,
        public float $currentPrice,
        public int $amount = 1,
        public int $stock = 0,
    ) {
        if ($this->amount === 0) {
            throw new Exception('Cannot request zero amount of ' . $this->product->name);
        }
        if ($this->amount > $this->stock) {
            throw new Exception('Out of stock for ' . $this->product->name);
        }
    }
}
