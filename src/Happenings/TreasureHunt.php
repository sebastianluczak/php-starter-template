<?php

declare(strict_types=1);

namespace App\Happenings;

use App\State\GameState;
use Random\Randomizer;

final readonly class TreasureHunt extends RandomHappening
{
    public function __construct(
        private GameState $gameState,
    ) {}

    public function applies(): bool
    {
        return $this->fivePercentChance();
    }

    public function apply(): void
    {
        $this->gameState->gold->baseAmount += (new Randomizer())->getInt(1, 5);
        $this->gameState->treasureHunts[] = ['name' => 'New treasure hunt'];
    }
}
