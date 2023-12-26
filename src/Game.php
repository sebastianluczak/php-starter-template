<?php

declare(strict_types=1);

namespace App;

use App\Loop\MainLoop;
use App\State\GameState;

final class Game
{
    public function run(): void
    {
        $mainLoop = new MainLoop(
            gameState: new GameState(),
        );

        $mainLoop->run();
    }
}
