<?php

declare(strict_types=1);

namespace App\Domain\Product;

use Random\Randomizer;

final readonly class Product
{
    public string $uuid;

    public function __construct(
        public string $name,
    ) {
        $this->uuid = $this->uuid();
    }

    private function uuid(): string
    {
        $randomizer = new Randomizer();

        return sprintf(
            '%s-%s-%s-%s',
            $randomizer->getInt(1000, 9999),
            $randomizer->getInt(1000, 9999),
            $randomizer->getInt(1000, 9999),
            $randomizer->getInt(1000, 9999),
        );
    }
}
