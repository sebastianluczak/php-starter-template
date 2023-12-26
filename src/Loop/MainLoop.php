<?php

declare(strict_types=1);

namespace App\Loop;

use App\Economy\Gold;
use App\Happenings\GoldShower;
use App\Happenings\Raid;
use App\Happenings\TreasureHunt;
use App\Renderer\GameRender;
use App\State\GameState;

final readonly class MainLoop
{
    public function __construct(
        private GameState $gameState,
    ) {}

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function run(): void
    {
        // @phpstan-ignore-next-line
        while (!$this->winCondition()) {
            // Render every second
            if ($this->gameState->tick >= 5000) {
                print (new GameRender($this->gameState))->render();
            }
            $this->runRandomEvents();

            usleep(100);
            $this->gameState->tick++;
            // Game loop goes on its own
            $this->gameState->gold = Gold::createTimeAware(
                $this->gameState,
                $this->gameState->gold->baseAmount,
            );
        }

        (new GameRender($this->gameState))->endgameResults();
    }

    public function runRandomEvents(): void
    {
        $events = [
            new Raid($this->gameState),
            new TreasureHunt($this->gameState),
            new GoldShower($this->gameState)
        ];
        foreach ($events as $event) {
            $event->applies()
                ? $event->apply()
                : syslog(0, 'Not applied.');
        }
    }

    private function winCondition(): bool
    {
        return $this->gameState->gold->baseAmount >= 10000;
    }
}
