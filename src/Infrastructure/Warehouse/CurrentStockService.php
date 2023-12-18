<?php

declare(strict_types=1);

namespace App\Infrastructure\Warehouse;

use App\Application\Warehouse\StockServiceInterface;
use App\Domain\Product\Product;
use Random\Randomizer;

final class CurrentStockService implements StockServiceInterface
{
    public function getCurrentStockForProduct(Product $product): int
    {
        return (new Randomizer())->getInt(10, 50);
    }
}
