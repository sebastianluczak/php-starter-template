<?php

declare(strict_types=1);

namespace App\Happenings;

use App\State\GameState;
use Random\Randomizer;

final readonly class GoldShower extends RandomHappening
{
    public function __construct(
        private GameState $gameState,
    ) {}

    public function applies(): bool
    {
        return $this->gameState->treasureHunts === null
            && $this->gameState->raids === null
            && $this->fiftyFiftyChance();
    }

    public function apply(): void
    {
        $this->gameState->gold->baseAmount *= (new Randomizer())->getFloat(1.01, 1.1);
        $this->gameState->goldenShowers[] = ['name' => 'golden shower!'];
    }
}
