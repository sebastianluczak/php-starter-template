<?php

declare(strict_types=1);

namespace App\Application\Order\Repository;

use App\Domain\Order;
use App\Domain\Product\Product;

interface OrderRepositoryInterface
{
    /**
     * @param Product[] $products
     * @param array<string, int> $amounts
     */
    public function create(array $products, array $amounts): Order;
}
