<?php

declare(strict_types=1);

namespace App\Renderer;

use App\State\GameState;

final readonly class GameRender
{
    public function __construct(
        private GameState $gameState,
    ) {}

    public function render(): string
    {
        // clear screen
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';   //^[H^[J
        $this->gameState->tick = 0;
        $this->gameState->cycle++;

        $message = sprintf(
            'Current cycle: %d. Gold amount: %f. Raiders found: %d, Treasure hunts: %d. Golden showers %d' . PHP_EOL,
            $this->gameState->cycle,
            $this->gameState->gold->baseAmount,
            count($this->gameState->raids ?? []),
            count($this->gameState->treasureHunts ?? []),
            count($this->gameState->goldenShowers ?? []),
        );

        $this->gameState->raids = null;
        $this->gameState->treasureHunts = null;
        $this->gameState->goldenShowers = null;

        $message .= PHP_EOL . $this->drawGraph();

        return $message;
    }

    private function drawGraph(): string
    {
        $msg = str_repeat('-', 80) . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= '|'.str_repeat(' ', 78).'|' . PHP_EOL;
        $msg .= str_repeat('-', 80) . PHP_EOL;

        return $msg;
    }

    public function endgameResults(): void
    {
        echo "Endgame!" . PHP_EOL;
    }
}
