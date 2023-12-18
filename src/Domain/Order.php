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
        public array $products
    ) {}
}
