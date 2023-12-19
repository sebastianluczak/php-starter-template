<?php

declare(strict_types=1);

namespace App\Domain\Product;

final readonly class Product
{
    public function __construct(
        public string $name,
        public string $warehouse,
    ) {}
}
