<?php

declare(strict_types=1);

namespace App\State;

use App\Economy\Gold;

final class GameState
{
    /**
     * @param array<int, array{name: string}>|null $raids
     * @param array<int, array{name: string}>|null $treasureHunts
     * @param array<int, array{name: string}>|null $goldenShowers
     */
    public function __construct(
        public int $tick = 0,
        public int $cycle = 0,
        public Gold $gold = new Gold(
            1,
        ),
        public ?array $raids = null,
        public ?array $treasureHunts = null,
        public ?array $goldenShowers = null,
    ) {}
}
