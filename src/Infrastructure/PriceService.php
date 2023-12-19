<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\Price\PriceServiceInterface;
use App\Domain\Product\Product;
use Random\Randomizer;

final class PriceService implements PriceServiceInterface
{
    public function getCurrentPriceForProduct(Product $product): float
    {
        if ($product->warehouse === 'default') {
            syslog(0, 'Using default warehouse');
        }

        return (new Randomizer())->getFloat(10, 200);
    }
}
