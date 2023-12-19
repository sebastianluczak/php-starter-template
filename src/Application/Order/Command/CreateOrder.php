<?php

declare(strict_types=1);

namespace App\Application\Order\Command;

final readonly class CreateOrder
{
    /**
     * @param array<int, array{
     *      name: string,
     *      amount: int
     *  }> $products
     */
    public function __construct(
        public array $products,
    ) {}
}
