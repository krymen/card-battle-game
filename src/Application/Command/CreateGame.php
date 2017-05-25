<?php

declare(strict_types=1);

namespace CardBattleGame\Application\Command;

final class CreateGame
{
    private $playerOnTurnName;
    private $playerWaitingName;
    private $hitPointsPerPlayer;
    private $movePointsPerTurn;

    public function __construct(
        string $playerOnTurnName,
        string $playerWaitingName,
        int $hitPointsPerPlayer,
        int $movePointsPerTurn
    ) {
        $this->playerOnTurnName = $playerOnTurnName;
        $this->playerWaitingName = $playerWaitingName;
        $this->hitPointsPerPlayer = $hitPointsPerPlayer;
        $this->movePointsPerTurn = $movePointsPerTurn;
    }

    public function getPlayerOnTurnName(): string
    {
        return $this->playerOnTurnName;
    }

    public function getPlayerWaitingName(): string
    {
        return $this->playerWaitingName;
    }

    public function getHitPointsPerPlayer(): int
    {
        return $this->hitPointsPerPlayer;
    }

    public function getMovePointsPerTurn(): int
    {
        return $this->movePointsPerTurn;
    }
}
