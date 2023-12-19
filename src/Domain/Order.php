<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Product\ProductSnapshot;

final readonly class Order
{
    /**
     * @param ProductSnapshot[] $products
     */
    public function __construct(
        public array $products,
        public \DateTimeImmutable $createdAt,
    ) {}

    public function numberOfCoins(): int
    {
        return array_sum(array_map(
            callback: fn(ProductSnapshot $productSnapshot)
                => $productSnapshot->goldValue()->numberOfCoins(),
            array: $this->products,
        ));
    }
}
