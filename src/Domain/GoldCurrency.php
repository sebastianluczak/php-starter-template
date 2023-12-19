<?php

declare(strict_types=1);

namespace App\Domain;

final readonly class GoldCurrency
{
    private const float DOLLAR_TO_GOLD_MULTIPLIER = 0.08;

    public function __construct(
        private float $dollarsWithCents,
    ) {}

    public function numberOfCoins(): int
    {
        return (int)($this->dollarsWithCents * self::DOLLAR_TO_GOLD_MULTIPLIER);
    }
}
