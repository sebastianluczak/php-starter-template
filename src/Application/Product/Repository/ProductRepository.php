<?php

declare(strict_types=1);

namespace App\Application\Product\Repository;

use App\Domain\Product\Product;

final class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @param array<int, array{name: string, amount: int}> $properties
     * @return Product[]
     */
    public function getByProperties(array $properties): array
    {
        return array_map(
            callback: fn(array $property): Product => new Product($property['name']),
            array: $properties,
        );
    }
}
