<?php

declare(strict_types=1);

namespace App\Happenings;

use App\State\GameState;
use Random\Randomizer;

final readonly class Raid extends RandomHappening
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
        $this->gameState->gold->baseAmount -= $this->gameState->gold->baseAmount *
            (new Randomizer())->getFloat(0.0001, 0.001);
        $this->gameState->raids[] = ['name' => 'New raid'];
    }
}
