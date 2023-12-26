<?php

declare(strict_types=1);

namespace App\Economy;

use App\State\GameState;

final class Gold
{
    public function __construct(
        public float $baseAmount,
    ) {}

    public static function createTimeAware(GameState $gameState, float $baseAmount = 1): self
    {
        if ($gameState->cycle > 4) {
            // gold is under inflation
            $baseAmount *= 0.99997;
        }

        return new self($baseAmount);
    }
}
