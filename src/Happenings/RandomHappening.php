<?php

declare(strict_types=1);

namespace App\Happenings;

use Random\Randomizer;

abstract readonly class RandomHappening
{
    protected function fiftyFiftyChance(): bool {
        return (bool)(new Randomizer())->getInt(0, 1);
    }

    protected function thirtyPercentChance(): bool {
        return (new Randomizer())->getInt(0, 100) <= 30;
    }

    protected function fivePercentChance(): bool {
        return (new Randomizer())->getInt(0, 100) <= 5;
    }
}