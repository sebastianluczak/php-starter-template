<?php

declare(strict_types=1);

namespace App\Application\Product\Repository;

use App\Domain\Product\Product;

interface ProductRepositoryInterface
{
    /**
     * @param array<int, array{name: string, amount: int}> $properties
     * @return Product[]
     */
    public function getByProperties(array $properties): array;
}
