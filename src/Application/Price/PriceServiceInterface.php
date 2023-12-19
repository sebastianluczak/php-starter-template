<?php

declare(strict_types=1);

namespace App\Application\Price;

use App\Domain\Product\Product;

interface PriceServiceInterface
{
    public function getCurrentPriceForProduct(Product $product): float;
}
