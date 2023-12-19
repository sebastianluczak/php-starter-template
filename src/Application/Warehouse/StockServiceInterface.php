<?php

declare(strict_types=1);

namespace App\Application\Warehouse;

use App\Domain\Product\Product;

interface StockServiceInterface
{
    public function getCurrentStockForProduct(Product $product): int;
}
