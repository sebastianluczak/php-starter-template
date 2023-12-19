<?php

declare(strict_types=1);

namespace App\Infrastructure\Warehouse;

use App\Application\Warehouse\StockServiceInterface;
use App\Domain\Product\Product;
use Random\Randomizer;

final class CurrentStockService implements StockServiceInterface
{
    private const int MAX_STOCK = 50;

    private const int MIN_STOCK = 10;

    public function getCurrentStockForProduct(Product $product): int
    {
        return (new Randomizer())->getInt(self::MIN_STOCK, self::MAX_STOCK);
    }
}
