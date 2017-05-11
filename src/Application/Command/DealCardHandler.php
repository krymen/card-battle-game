<?php

namespace CardBattleGame\Application\Command;

use CardBattleGame\Domain\Card;
use CardBattleGame\Domain\GameRepository;

final class DealCardHandler
{
    private $games;

    public function __construct(GameRepository $games)
    {
        $this->games = $games;
    }

    public function handle(DealCard $command): void
    {
        $game = $this->games->get($command->gameId());

        $game->dealCardForPlayerOnTurn(new Card($command->type(), $command->value(), $command->cost()));

        $this->games->save($game);
    }
}